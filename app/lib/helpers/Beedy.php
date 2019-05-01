<?php
/**
*
*/
class Beedy
{
	protected $_Software, $_Setting, $_User, $_Orderdetail, $_ary=[];
	function __construct()
	{

	}
public function PasswordDecider() {
	$chars = "01012323453456456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 9) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}

public function orderExist($shopId=0, $product_id=0, $invoice='')
{
			$Order= new Orderdetail('orderdetails');
$params = [	 'conditions'=> ['shopId = ?', 'product_id = ?', 'invoice = ?'],
											'bind' => [$shopId, $product_id, $invoice] ];
	$exist  = $Order->find($params);

			if(count($exist) < 1):
			return 'false';
			else:
		return 'true';
	endif;

}
public function productDetails($product_id, $field)
{
			$Product= new Product('products');
 return $Product->findById($product_id)->$field;

}


public function OrderDetail($shopId=0, $product_id=0, $invoice='')
{
	$Order= new Orderdetail('orderdetails');
$params = [	 'conditions'=> ['shopId = ?', 'product_id = ?', 'invoice = ?'],
											'bind' => [$shopId, $product_id, $invoice] ];

		return $Order->find($params);

}



public function minusProduct($id, $qty){

			$Product = new Product('products');
		 $pQty = $Product->findById((int)$id)->qty;

			$updQty =  $pQty - $qty; // this means 5 - 2

		if($updQty >= 0) {

									$fields = [ 'qty' => $updQty ];

			return						$send = $Product->update($fields, (int)$id);

							}


}






public function getColById($obj,$id, $field)
{
 return $obj->findById($id)->$field;
}
public function loadTblCond2($obj,$params)
{
 return $obj->find($params);
}


public function plusProduct($id, $qty){

	 $result = array();
$Product = new Product('products');
		 $pQty = $Product->findById((int)$id)->qty;

$updQty =  $pQty + $qty; // this means 5 - 2

		if($updQty >= 0) {

									$fields = [ 'qty' => $updQty ];

			return						$send = $Product->update($fields, (int)$id);

							}


}

public function getColTotalByInvoice($obj,$invoice, $field)
{
	$total = 0;
	$discount = 0;
	$ary = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice]  ];
 return $obj->find($id);
}


public  function getCompanyId()
{
	return  $org_id = Auth::auth('org_id');

}

public  function getCompanySetting()
{
	return  $this->_Setting;

}



public  function getCompany()
{
	return  $this->_Software->org_name;

}




public  function TotalCount()
{
	return $this->_Software->count();
}


public function totalUser($shopId)
{

$User = new User('users');
$ary = [ 'conditions'=> 'shopId = ?', 'bind' => [$shopId]  ];
 		$qUser = $User->find($ary);
 return count( $qUser);
}
public function totalProduct($shopId)
{

$Product = new Product('products');
$ary = [ 'conditions'=> 'shopId = ?', 'bind' => [$shopId]  ];
 		$qUser = $Product->find($ary);
 return count( $qUser);
}
public function totalSupplier($shopId)
{
$Supplier = new Supplier('suppliers');
$ary = [ 'conditions'=> 'shopId = ?', 'bind' => [$shopId]  ];
 		$qUser = $Supplier->find($ary);
 return count($qUser);
}



public function totalRole()
{
  $Role = new Role('roles');
 $total = $Role->findWhere('roles',$this->_ary);
return count( $total);
}



public function totalCategory()
{
  $Category = new Category('categories');
 $total = $Category->findWhere('categories',$this->_ary);
return count( $total);
}




}


/*
DELIMITER $$
CREATE TRIGGER `spyTrigger`
BEFORE UPDATE ON `payments` FOR EACH ROW
BEGIN
    INSERT INTO log (pay_by, amount, phone)
    VALUES (NEW.pay_by, NEW.amount, NEW.phone );
END;

$$


 */



/*
BEGIN
    INSERT INTO log (pay_by, amount, phone)
    VALUES (OLD.pay_by, OLD.amount, OLD.phone );
END
 */