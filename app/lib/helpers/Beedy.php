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
$params = [	 'conditions'=> ['shopId = ?', 'menu_id = ?', 'invoice = ?'],
											'bind' => [$shopId, $product_id, $invoice] ];
	$exist  = $Order->find($params);

			if(count($exist) < 1):
			return 'false';
			else:
		return 'true';
	endif;

}
public function menuDetails($menu_id, $field)
{
			$Menu= new Menu('menus');
 return $Menu->findById($menu_id)->$field;

}


public function OrderDetail($shopId=0, $product_id=0, $invoice='')
{
	$Order= new Orderdetail('orderdetails');
$params = [	 'conditions'=> ['shopId = ?', 'menu_id = ?', 'invoice = ?'],
											'bind' => [$shopId, $product_id, $invoice] ];

		return $Order->find($params);

}



public function minusProduct($compute, $qty){

			$Product = new Product('products');
$Menu = new Menu('menus');
foreach($compute as $product_id):

				 //$Product->findById((int)$item)->product_name;
			  $pQty = $Product->findById((int)$product_id)->qty;

			$updQty =  $pQty - $qty; // this means 5 - 2

if($updQty >= 0) {

									$fields = [ 'qty' => $updQty ];

								$send = $Product->update($fields, (int)$product_id);

							}


//productDetails
			endforeach;

return	true;

}


public function plusProduct($compute, $qty){
//dnd($compute);
			$Product = new Product('products');
$Menu = new Menu('menus');
foreach($compute as $product_id):

				 //$Product->findById((int)$item)->product_name;
			  $pQty = $Product->findById((int)$product_id)->qty;

			$updQty =  $pQty + $qty; // this means 5 - 2

if($updQty >= 0) {

									$fields = [ 'qty' => $updQty ];

								$send = $Product->update($fields, (int)$product_id);

							}


//productDetails
			endforeach;

return	true;

}





public function getColById($obj,$id, $field)
{
 return $obj->findById($id)->$field;
}
public function loadTblCond2($obj,$params)
{
 return $obj->find($params);
}

//public function existOne($tbl, $col, $value){
//$conn = Database::getInstance();
//$select = $conn->db->prepare("SELECT * FROM $tbl WHERE $col LIKE ? Limit 1");
//$select->execute(array($value));
//return $select->rowCount();
//}

public function getColTotalByInvoice($obj,$invoice, $field)
{
	$total = 0;
	$discount = 0;
	$ary = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice]  ];
 return $obj->find($id);
}



public function getUserId($token)
{

	$User = new User('users');
 	$Query  = $User->findByToken($token);

				if($Query):
				return $userId = $Query->id;
			
				else:
				return '';
			
				endif;
}



public function getInvoiceItems($invoice,$shopId)
{
 
					   $result = array();
	$Orderdetail = new Orderdetail('orderdetails'); 
			$Menu = new Menu('menus');

		//DISTINCT plate//
					$orderParams  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];

	$data = [];
 $Orders =  $Orderdetail->find($orderParams);
	$uniquePlate = array_unique(array_column($Orders, 'plate'));

	foreach($uniquePlate as $plate):

		//do for others first
		if($plate > 1){

				$amount =0;
				$nhil =0;
				$fund =0;
				$vat =0;
				$total =0;
				$item ='';
				//select based on plate
		$plateParams  = ['conditions'=> ['shopId = ?', 'invoice = ?', 'plate = ?'], 'bind' => [$shopId, $invoice, (int)$plate] ];
					$plateOrders =  $Orderdetail->find($plateParams);
					//var_dump($plate);
						//iterate trhough products under the plate
						$numItems = count($plateOrders);
						$i = 0;
						foreach($plateOrders as $items){
								if(++$i === $numItems) {
										$item .=$Menu->findById($items->menu_id)->item;
								}else{
										$item .=$Menu->findById($items->menu_id)->item." & ";
								}

								$amount +=$Menu->findById($items->menu_id)->price;
								$nhil += $items->nhil;
								$fund += $items->fund;
								$vat += $items->vat;
								$total += $items->total; 
						}

							$row = array(
								'key'=>'key'.$plate,
								'base'=>'Yes',
								'id'=>$plate,
								'plate'=>$plate,
								'invoice' => $invoice,
								'menu_id'=> $plate,
								'menu_name'=> $item,
								'qty'=>1,
								'price'=>$amount,
								'total'=> round(($fund + $nhil+ $vat+ $total),2),
								'vat'=>$vat,
								'fund'=>$fund,
								'nhil'=>$nhil,

							);

							$data[]=$row;

	$i+=1;
		}
		else{
			$singlePlateParams  = ['conditions'=> ['shopId = ?', 'invoice = ?', 'plate = ?'], 'bind' => [$shopId, $invoice, (int)$plate] ];
					$singlePlateOrders =  $Orderdetail->find($singlePlateParams);
		$i = 0;
	foreach($singlePlateOrders as $Order):

	$row = array(
		'key'=>'key'.$i,
		'base'=>'No', 
		'id'=>$Order->id,
		'menu_id'=> $Order->menu_id,
		'menu_name'=> $Menu->findById($Order->menu_id)->item,
	 'qty'=>$Order->qty,
		'price'=>$Order->price,
		'total'=> round(($Order->fund + $Order->nhil+ $Order->vat+ $Order->total),2),
		'discount'=>$Order->discount,
		'vat'=>$Order->vat,
		'fund'=>$Order->fund,
		'nhil'=>$Order->nhil,
		'nfund'=> $Order->fund+$Order->nhil 
	);

	$data[]=$row;

	$i+=1;

	endforeach;
 	$result['children'] = $data;

		}
	$result['children'] = $data;
	endforeach;
	return json_encode($result);
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
$status = "Active";
		$ary  = ['conditions'=> ['shopId = ?','acc_status =?'], 'bind' => [$shopId,$status] ];

//$ary = [ 'conditions'=> 'shopId = ?', 'bind' => [$shopId]  ];
 		$qUser = $User->find($ary);
 return count( $qUser);
}
public function totalProduct($shopId)
{

$Menu = new Menu('menus');
$ary = [ 'conditions'=> 'shopId = ?', 'bind' => [$shopId]  ];
 		$qUser = $Menu->find($ary);
 return count( $qUser);
}
public function totalSupplier($shopId)
{
$Supplier = new Supplier('suppliers');
$ary = [ 'conditions'=> 'shopId = ?', 'bind' => [$shopId]  ];
 		$qUser = $Supplier->find($ary);
 return count($qUser);
}
public function totalShop()
{
$Shop = new Shop('shops');
 		$qUser = $Shop->find();
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