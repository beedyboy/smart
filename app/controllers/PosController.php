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
		'product_id'=> $Order->product_id,
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








public function getOrderByInvoice()
{

}
public function saveOrder(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $invoice = $data['invoice'];
	  $shopId = $data['shopId'];
	  $kitchen = $data['kitchen'];
	  $type = ($data['type']) ? 'Dine-In': 'Take Out';
	  $table = $data['table'];
	  $seat = $data['seat'];
			$token = $data['token'];
			$waiter = $data['waiter'];

	$User = new User('users');
 	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;

			//get orders by receipt
	$Orderdetail = new Orderdetail('orderdetails');
	$Sale = new Sale('sales');
	$amount = 0;
	$discount = 0;
$ary = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice]  ];

$Query = $Orderdetail->find($ary);
//foreach value
foreach($Query as $Details):
$amount += $Details->total;
$discount += $Details->discount;


endforeach;
	$balance = 	$amount;
//productDetails

									$fields = [
																					'shopId' => $shopId,
																					'invoice_number' => $invoice,
																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'tid' => $table,
																					'sid' => $seat,
																					'waiter' => $waiter,
																					'balance' => $balance,
																					'ord_type' => $type,
																					'kitchen' => $kitchen,
																					'created_at' => '',
																					'created_by' => $userId,
																		];
											//send menu

									$send = $Sale->insert($fields);
												if($send):

																$result['status'] = "success";
																$result['msg']  =   'Menu item has been added to cart';

															else:

																$result['status'] = "db_error";
																$result['msg'] = "Error: Item was not allocated. Please try again later";
															endif;



  echo json_encode($result);


}












 public function fetchBasket()
{
	$data  = [];

	$out = array('error' => false);
	$Sale = new Sale('sales');

	  $token = $_GET['token'];
	  $shopId = $_GET['shopId'];
$d = "PENDING";
	$User = new User('users');
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');
 	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;
	endif;

		$params  = ['conditions'=> ['shopId = ? ', 'created_by = ? ', 'status = ? '],	'bind' => [$shopId, $userId, $d] ];
	$Baskets = $Sale->find($params);

		foreach($Baskets as $Basket):

	$row = array(
		'id'=>$Basket->id,
		'invoice_number'=>$Basket->invoice_number,
		'amount'=> $Basket->amount,
	'balance'=>$Basket->balance,
		'table'=> $Table->findById($Basket->tid)->name,
		'seat'=> $Seat->findById($Basket->sid)->name,
	'ord_type'=>$Basket->ord_type,
		'kitchen'=>$Basket->kitchen,
	'waiter'=>	$User->findById($Basket->waiter)->fullname,
	'cashier'=>	$User->findById($Basket->cashier)->fullname,
		'created_at'=>$Basket->created_at,
		'created_by'=>	$User->findById($Basket->created_by)->fullname,
		'updated_by'=>$User->findById($Basket->updated_by)->fullname,
		'updated_at'=>$Basket->updated_at
	);

	$data[]=$row;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}

 public function emptyCart()
	{
		$result = array();
				$invoice=$_GET['invoice'];
				$shopId=$_GET['shopId'];

				$Orderdetail = new Orderdetail('orderdetails');
				$Beedy = new Beedy();
				$params = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId,  $invoice]  ];
						$data  = $Beedy->loadTblCond2($Orderdetail,$params);

						foreach($data as $dat):
						$qty = $dat->qty;
						$id = $dat->product_id;
						$Beedy->plusProduct($id, $qty);

						endforeach;

$del  = $Orderdetail->bulkDelete($params);
	if($del):

								$result['status'] = "success";
								$result['msg']  =   'Cart emptied';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Cart was not emptied. Please try again later";
							endif;

	 	//$out['data'] = $data;
    echo json_encode($result);

  	die();
	}



 public function deleteCartItem()
	{
		$result = array();
				$id = $_GET['id'];
				$shopId=$_GET['shopId'];

				$Orderdetail = new Orderdetail('orderdetails');
				$Beedy = new Beedy();
				$data  = $Orderdetail->findById($id);

						$qty = $data->qty;
						$pid = $data->product_id;
						$Beedy->plusProduct($pid, $qty);


		$params = ['conditions'=> ['shopId = ?', 'id = ?'], 'bind' => [$shopId,  $id]  ];

$del  = $Orderdetail->bulkDelete($params);
	if($del):
								$result['status'] = "success";
								$result['msg']  =   'Item deleted from cart';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Item was not deleted. Please try again later";
							endif;

	 	//$out['data'] = $data;
    echo json_encode($result);

  	die();
	}













 public function quantityChange()
	{
		$result = array();
				$id = $_GET['id'];
				$product_id = $_GET['productId'];
				$invoice = $_GET['invoice'];

				$qty=$_GET['qty'];
				$newQty=$_GET['newQty'];
				$shopId=$_GET['shopId'];


				$Orderdetail = new Orderdetail('orderdetails');
				$Beedy = new Beedy();
				$data  = $Orderdetail->findById($id);


				 $price  =  $Beedy->productDetails($product_id, "price");
					$pQty  =  $Beedy->productDetails($product_id, "qty");

				//check if qty changed is same
				//if($newQty === $qty):
				//do nothing

					if(empty($newQty)):
				//take old quantity and add to product, then delete from order
									$Beedy->plusProduct($product_id, $qty);
							$clearParams = ['conditions'=> ['shopId = ?', 'id = ?'], 'bind' => [$shopId,  $id]  ];

							echo	$this->clearCartItem($clearParams);
////
				elseif($newQty > $qty): //greater than initial cart qty
				//minus the difference and minus from product then add to order
							$diff = $newQty - $qty;
											if($pQty >= $diff){

							$newTotal = $price * $newQty;

												$fields = [
																								'qty' => $newQty,
																								'price' => $price,//incase of discount, use this valu for total calc
																								'total' => $newTotal,
																								'updated_at' => '',
																					];
														//send menu
															$send = $Orderdetail->update($fields, (int)$id);
													$send2 = $Beedy->minusProduct((int)$product_id, $diff);
															if($send2):

														$result['status'] = "success";
														$result['msg']  =   'Quantity updated successfully';
															else:

											$result['status'] = "db_error";
											$result['msg'] = "Error: Quantity  was not updated. Please try again later";
										endif;
				}
			else {
				$result['status'] = "error";
						$result['msg'] = "Error: Menu is out of stock. please contact kitchen to update product quantity";

			}
			echo json_encode($result);

  	die();
				elseif($newQty !== 0  && $newQty < $qty):
					//minus from order, add to difference to product
	$diff =  $qty - $newQty;

							$newTotal = $price * $newQty;

												$fields = [
																								'qty' => $newQty,
																								'price' => $price,//incase of discount, use this valu for total calc
																								'total' => $newTotal,
																								'updated_at' => '',
																					];
														//send menu
															$send = $Orderdetail->update($fields, (int)$id);
															$Beedy->plusProduct($product_id, $diff);
														if($send):

														$result['status'] = "success";
														$result['msg']  =   'Qty updated successfully';
															else:

													$result['status'] = "db_error";
													$result['msg'] = "Error: Qty  was not updated. Please try again later";
										endif;
				 echo json_encode($result);

  	die();
				endif;



	}




public function clearCartItem($params)
{
	$result = array();
			$Orderdetail = new Orderdetail('orderdetails');
$del  = $Orderdetail->bulkDelete($params);

	if($del):
								$result['status'] = "success";
								$result['msg']  =   'Item deleted from cart';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Item was not deleted. Please try again later";
 	endif;
 return json_encode($result);
}










 public function fetchReceivable()
{
	$data  = [];

	$out = array('error' => false);
	$Sale = new Sale('sales');

	  $token = $_GET['token'];
	  $shopId = $_GET['shopId'];
$d = "PENDING";
	$User = new User('users');
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');
 	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;
	endif;

		$params  = ['conditions'=> ['shopId = ? ', 'created_by = ? ', 'status = ? '],	'bind' => [$shopId, $userId, $d] ];
	$Baskets = $Sale->find($params);

		foreach($Baskets as $Basket):

	$row = array(
		'id'=>$Basket->id,
		'invoice_number'=>$Basket->invoice_number,
		'amount'=> $Basket->amount,
	'balance'=>$Basket->balance,
		'table'=> $Table->findById($Basket->tid)->name,
		'seat'=> $Seat->findById($Basket->sid)->name,
	'ord_type'=>$Basket->ord_type,
		'kitchen'=>$Basket->kitchen,
	'waiter'=>	$User->findById($Basket->waiter)->fullname,
	'cashier'=>	$User->findById($Basket->cashier)->fullname,
		'created_at'=>$Basket->created_at,
		'created_by'=>	$User->findById($Basket->created_by)->fullname,
		'updated_by'=>$User->findById($Basket->updated_by)->fullname,
		'updated_at'=>$Basket->updated_at
	);

	$data[]=$row;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}




}