<?php
/**
*
*/
class PosController extends Controller
{
	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		//$this->load_model('User');
	}


 public function fetchWaiters()
{
	$User = new User('users');

	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$position = "Waiter";
		$params  = ['conditions'=> ['shopId = ?', 'position = ?'], 'bind' => [$shopId, $position] ];
	$Waiters = $User->find($params);

  	$out['data'] = $Waiters;

	   echo json_encode($out);

  	die();

}



 public function fetchMenu()
{
	$Product = new Product('products');

	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$value= $_GET['value'];
		$params  = ['conditions'=> ['shopId = ?', 'product_name LIKE ?'], 'bind' => [$shopId, "%$value%"] ];
	$Waiters = $Product->find($params);

$out['data'] = $Waiters;

	   echo json_encode($out);

  	die();

}


















 public function getCartItem()
{


	$Orderdetail = new Orderdetail('orderdetails');
	$Product = new Product('products');
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$invoice= $_GET['invoice'];
		$params  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];

 $Orders =  $Orderdetail->find($params);

	foreach($Orders as $Order):

	$row = array(
		'id'=>$Order->id,
		'product_name'=> $Product->findById($Order->product_id)->product_name,
	 'qty'=>$Order->qty,
		'price'=>$Order->price,
		'discount'=>$Order->discount,
		'total'=>$Order->total,
		'created_at'=>$Order->created_at,
		'updated_at'=>$Order->updated_at
	);

	$data[]=$row;


	endforeach;
 	$out['data'] = $data;
	   echo json_encode($out);

  	die();

}




 public function getCartTotal()
{
$Beedy = new Beedy();
$productCount = 0;
$sumTotal = 0;
$sumDiscount = 0;

	$Orderdetail = new Orderdetail('orderdetails');
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$invoice= $_GET['invoice'];
		$params  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];

 $Orders =  $Orderdetail->find($params);

	foreach($Orders as $Order):
$productCount +=1;
$sumTotal +=$Order->total;
$sumDiscount +$Order->discount;

	endforeach;

	$row = array(
		'id'=>$Beedy->PasswordDecider(),
		'productCount'=>$productCount,
		'discount'=>$sumDiscount,
		'total'=>$sumTotal
	);

	$data[]=$row;

 	$out['data'] = $data;
	   echo json_encode($out);

  	die();

}











public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $product_id = $data['productId'];
	  $invoice = $data['invoice'];
	  //$qty = $data['qty'];
	  $qty = 1;
	  $shopId = $data['shopId'];

	$Orderdetail = new Orderdetail('orderdetails');

	//first check if product already exists in the table for current session
	//if yes check products quantity in store	//update otherwise create
$Beedy = new Beedy();
	$exist  =  $Beedy->orderExist($shopId, $product_id, $invoice);
//productDetails

$price  =  $Beedy->productDetails($product_id, "price");
$pQty  =  $Beedy->productDetails($product_id, "qty");
//$price = $productDetails->price;
	if($pQty >= $qty){

	$total = $price * $qty;

	if($exist == 'true'):
		//update
						$orders =   $Beedy->OrderDetail($shopId, $product_id, $invoice);
$id = 0;
$newQty = 0;
$newTotal=0;
foreach($orders as $ord):
$id = $ord->id;
$newQty = $ord->qty + $qty;
$newTotal = $ord->total + $price;

endforeach;


									$fields = [
																					'qty' => $newQty,
																					'price' => $price,//incase of discount, use this valu for total calc
																					'total' => $newTotal,
																					'updated_at' => '',
																		];
											//send menu
												$send = $Orderdetail->update($fields, (int)$id);
										$send2 = $Beedy->minusProduct((int)$product_id, $qty);
												if($send):

											$result['status'] = "success";
											$result['msg']  =   'Menu Item has been updated successfully';
												else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Menu Item  was not updated. Please try again later";
							endif;
 else:
	//create
								$fields = [
																		'product_id' => $product_id,
																		'qty' => $qty,
																		'invoice' => $invoice,
																		'price' => $price,//incase of discount, use this valu for total calc
																		'total' => $total,
																		'shopId' => $shopId,
																		'created_at' => '',
															];
								//send menu
									$send = $Orderdetail->insert($fields);
										$send2 = $Beedy->minusProduct((int)$product_id, $qty);
												if($send):

																$result['status'] = "success";
																$result['msg']  =   'Menu item has been added to cart';

															else:

																$result['status'] = "db_error";
																$result['msg'] = "Error: Item was not allocated. Please try again later";
															endif;
 endif;
	}
else {
	$result['status'] = "error";
			$result['msg'] = "Error: Menu is out of stock. please contact kitchen to update product quantity";

}


  echo json_encode($result);


}











public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	$User = new User('users');
 $Query  = $User->findByToken($data['token']);

	if($Query):
	$userId = $Query->id;

	endif;

	  $itemId = $data['itemId'];
	  $kitchen = $data['kitchen'];
	  $qty = $data['qty'];
	  $id = $data['id'];

			$Allocation = $this->Acquisition->findById((int)$id);
		 $Purchase = new Purchase('purchases');
		 $item_quantity = $Purchase->findById((int)$itemId)->qty;
			//if i have 2 items before and wanna make it five
			//updated qty should be 3
			//get value from acquisition and substract from new value
$updQty =  (int)($qty) - (int)($Allocation->qty); // this means 5 - 2

		if($updQty <= $item_quantity) {


	$newQuantity = (int)$item_quantity - (int)$updQty;

				 		if($Allocation->itemId != $itemId || $Allocation->qty != $qty || $Allocation->kitchen != $kitchen )
							{
									$fields = [
										'itemId' => $itemId,
										'qty' => $qty,
										'kitchen' => $kitchen,
										'updated_by' => $userId,
										'updated_at' => '',
							];
											$field2 = ['qty' => $newQuantity ];

							$send2 = $Purchase->update(['qty' => $newQuantity], (int)$itemId);

									$send = $this->Acquisition->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Item allocation has been updated successfully';
								//$result['msg']  =   $item_quantity.'-'.$updQty.'='.$newQuantity;

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Item allocation was not updated. Please try again later";
							endif;
							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'No changes made';
							}
		}

else {
		$result['status'] = "error";
								$result['msg'] = "Error: Allocated quantity can not be more than item quantity in stock";

}
  echo json_encode($result);


}






public function updateFinishedProduct(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	   $token = $data['token'];

	$User = new User('users');
 	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;
	endif;

	  $qty = $data['qty'];
	  $id = $data['id'];

			//$Allocation = $this->Acquisition->findById((int)$id);
		 $Product = new Product('products');
		 $old_quantity = $Product->findById((int)$id)->qty;
			//if i have 2 items before and wanna make it five
			//updated qty should be 3
			//get value from acquisition and substract from new value

	$newQuantity = $old_quantity + $qty;

									$fields = [
										'qty' => $newQuantity,
										'added_qty' => $qty,
										'updated_by' => $userId,
										'updated_at' => '',
							];

									$send = $Product->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Finished product processed successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Finished product was not processed. Please try again later";
							endif;

  echo json_encode($result);


}







	public function list()
{
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];
	$Acquisitions = $this->Acquisition->find($params);

	$Purchase = new Purchase('purchases');
		$User = new User('users');
	foreach($Acquisitions as $Acquisition):

	$row = array(
		'itemId'=>$Acquisition->itemId,
		'item_name'=> $Purchase->findById($Acquisition->itemId)->item_name,
	 'qty'=>$Acquisition->qty,
		'kitchen'=>$Acquisition->kitchen,
		'id'=>$Acquisition->id,
		'created_by'=>	$User->findById($Acquisition->created_by)->fullname,
		'created_at'=>$Acquisition->created_at,
		'updated_by'=>$User->findById($Acquisition->updated_by)->fullname,
		'updated_at'=>$Acquisition->updated_at
	);

	$data[]=$row;


	endforeach;
  	$out['data'] = $data;

	   echo json_encode($out);

  	die();

}




}