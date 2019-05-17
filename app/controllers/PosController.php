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
	$status = "Active";
		$params  = ['conditions'=> ['shopId = ?', 'acc_status =?', 'position = ?'], 'bind' => [$shopId, $status, $position] ];
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
	$data = [];
	$out = array('error' => false);
	$Orderdetail = new Orderdetail('orderdetails');
	$Product = new Product('products');
		$shopId= $_GET['shopId'];
		$invoice= $_GET['invoice'];
		$params  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];

 $Orders =  $Orderdetail->find($params);
$i = 1;
	foreach($Orders as $Order):

	$row = array(
		'key'=>'key'.$i,
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

	$i+=1;

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




public function fetchSavedInvoice()
{
$data  = [];
	$out = array('error' => false);
		$Sale = new Sale('sales');
	$User = new User('users');
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');
	  $invoice = $_GET['invoice'];
	  $shopId = $_GET['shopId'];
			$params = [	 'conditions'=> ['shopId = ?', 'invoice_number = ?'], 'bind' => [$shopId, $invoice] ];
					$LIST = $Sale->find($params);

		foreach($LIST as $DATA):

	$row = array(
				'id'=>$DATA->id,
				'invoice_number'=>$DATA->invoice_number,
				'amount'=> $DATA->amount,
			'balance'=>$DATA->balance,
				'table'=> $Table->findById($DATA->tid)->name,
				'seat'=> $Seat->findById($DATA->sid)->name,
			'ord_type'=>$DATA->ord_type,
				'kitchen'=>$DATA->kitchen,
				'vat'=>$DATA->vat,
			'waiter'=>	$User->findById($DATA->waiter)->fullname,
			'cashier'=>	$User->findById($DATA->cashier)->fullname,
				'created_at'=>$DATA->created_at,
				'created_by'=>	$User->findById($DATA->created_by)->fullname,
				'updated_by'=>$User->findById($DATA->updated_by)->fullname,
				'updated_at'=>$DATA->updated_at
	);

	$data[]=$row;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();
}

public function saveOrder(){
	$data = json_decode(file_get_contents("php://input"), TRUE);
$date = date("Y-m-d");
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
	//calc vat
	$per = 0.175;
	$vat =  $per * $amount ;
	$vat = round($vat,2);
//productDetails
if($type == 'Dine-In'):
									$fields = [
																					'shopId' => $shopId,
																					'invoice_number' => $invoice,
																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'tid' => $table,
																					'sid' => $seat,
																					'period' => $date,
																					'waiter' => $waiter,
																					'balance' => $balance,
																					'vat' => $vat,
																					'ord_type' => $type,
																					'kitchen' => $kitchen,
																					'created_at' => '',
																					'created_by' => $userId,
																		];
									$fields2 = [

																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'tid' => $table,
																					'sid' => $seat,
																					'period' => $date,
																					'waiter' => $waiter,
																					'balance' => $balance,
																					'vat' => $vat,
																					'ord_type' => $type,
																					'kitchen' => $kitchen,
																					'updated_at' => '',
																					'updated_by' => $userId,
																		];
						else:

								$fields = [
																					'shopId' => $shopId,
																					'invoice_number' => $invoice,
																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'balance' => $balance,
																					'period' => $date,
																					'ord_type' => $type,
																					'vat' => $vat,
																					'kitchen' => $kitchen,
																					'created_at' => '',
																					'created_by' => $userId,
																		];
	$fields2 = [

																					'invoice_number' => $invoice,
																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'balance' => $balance,
																					'period' => $date,
																					'ord_type' => $type,
																					'vat' => $vat,
																					'kitchen' => $kitchen,
																					'updated_at' => '',
																					'updated_by' => $userId,
																		];
						endif;
						//check whether order existed before
						$params = [	 'conditions'=> ['shopId = ?', 'invoice_number = ?'], 'bind' => [$shopId, $invoice] ];
				$exist  = $Sale->find($params);

											//send menu
	if(count($exist) < 1):
		return 	$this->saveNewOrder($fields);
			else:
			//foreach ($exist as $Value):
			//$id=$Value->id;
			//
			//endforeach;
			$id = $data['id'];
		return	$this->saveOldOrder($fields2, $id);

			endif;

}

public function saveNewOrder($fields){
	 $result = array();
	$Sale = new Sale('sales');
			$send = $Sale->insert($fields);
												if($send):

																$result['status'] = "success";
																$result['msg']  =   'Order sent successfully';

															else:

																$result['status'] = "db_error";
																$result['msg'] = "Error: Order not sent. Please try again later";
															endif;



  echo json_encode($result);
}


public function saveOldOrder($fields, $id){
$result = array();
	$Sale = new Sale('sales');
			$send = $Sale->update($fields, (int)$id);
												if($send):

																$result['status'] = "success";
																$result['msg']  =   'Order updated successfully';

															else:

																$result['status'] = "db_error";
																$result['msg'] = "Error: Order not updated. Please try again later";
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

	  $shopId = $_GET['shopId'];
$d = "PENDING";
	$User = new User('users');
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'status = ? '],	'bind' => [$shopId, $d] ];
	$Baskets = $Sale->find($params);

$i= 0;
foreach($Baskets as $Basket):

	$row = array(
		'key'=>'key'.$i,
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
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}



public  function payNow(){
			$data  = [];

				$out = array('error' => false);
				$Sale = new Sale('sales');
   	$User = new User('users');

			$d = "PENDING";
	  $token = $_GET['token'];
	  $id = $_GET['id'];
		 $status ="PAID";

					$Query  = $User->findByToken($token);

					if($Query):
					$userId = $Query->id;

						endif;

					$fields = [
													'status' => $status,
										 		'cashier' => $userId,
										];

								$send = $Sale->update($fields, (int)$id);
					if($send):

							$result['status'] = "success";
							$result['msg']  =   'Transaction Completed';

						else:

							$result['status'] = "db_error";
							$result['msg'] = "Error:Please try again later";
						endif;

}









public  function payAllBalances(){

	 $result = array('error' => false);

				$Sale = new Sale('sales');
   	$User = new User('users');

			$d = "PENDING";
	  $token = $_GET['token'];
	  $shopId = $_GET['shopId'];
	  $kitchen = $_GET['kitchen'];

 $status ="PAID";
 $pend ="PENDING";

				 $Query  = $User->findByToken($token);

					if($Query):
					$userId = $Query->id;

						endif;

					$fields = [
													'status' => $status,
										 		'cashier' => $userId,
										];
					$params = '';
					if($kitchen === "All"){
							$params = ['conditions'=> ['shopId = ?', 'status = ?'], 'bind' => [$shopId,  $pend]  ];

					}
					else{
							$params = ['conditions'=> ['shopId = ?', 'kitchen = ?'], 'bind' => [$shopId,  $kitchen]  ];

					}

								$send = $Sale->updateMore($fields, $params);
					if($send):

							$result['status'] = "success";
							$result['msg']  =   'Transaction Completed';

						else:

							$result['status'] = "error";
							$result['msg'] = "Error:Please try again later";
						endif;
  echo json_encode($result);
}





public function mergeInvoice(){
	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $shopId = $data['shopId'];
	  $invoice = $data['invoice'];
	  $token = $data['token'];
	  $id = $data['id'];

	$User = new User('users');
			$Sale = new Sale('sales');
	$Orderdetail = new Orderdetail('orderdetails');

 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;

$A = $Sale->findById((int)$id);
$invoiceA = $A->invoice_number;
$amountA=  $A->amount;
$balanceA =  $A->balance;
$discountA =  $A->discount;
//change invoice b to a
		$Bfields = [
			'invoice' => $invoiceA
		];
		//$updateB = $Orderdetail->update($Bfields,);
		$params = ['conditions'=> ['invoice = ?'], 'bind' => [$invoice]  ];
  $sendB = $Orderdetail->updateMore($Bfields, $params);
		if($sendB):

			$amountB= 0; $balanceB = 0; $discountB = 0; $Bid = 0;

		//fetch sum of B and add to A
		$BParams = [	 'conditions'=> ['shopId = ?', 'invoice_number = ?'], 'bind' => [$shopId, $invoice] ];
					$LIST = $Sale->find($BParams);
		foreach($LIST as $B):
				$amountB=  $B->amount;
				$balanceB = $B->balance;
				$discountB = $B->discount;
				$Bid = $B->id;
		endforeach;


			 $amount = $amountA + $amountB;
			 $balance = $balanceA + $balanceB;
			 $discount = $discountA + $discountB;

									$fields = [
																					'shopId' => $shopId,
																					'amount' => $amount,
																					'discount' => $discount,
																					'balance' => $balance,
																					'updated_at' => '',
																					'updated_by' => $userId,
																		];
					$sendA = $Sale->update($fields, (int)$id);

					if($sendA):
			//delete B
							$send = $Sale->delete($Bid);

						if($send):

									$result['status'] = "success";
									$result['msg']  =   'Invoice merged successfully';

								else:

									$result['status'] = "error";
									$result['msg'] = "Error:Please try again later";
								endif;
						else:

							$result['status'] = "error";
							$result['msg'] = "Error:Please try again later";
						endif;
		endif;
		  echo json_encode($result);
}


 public function salesReport()
{
	$data  = [];

	$out = array('error' =>  false);
	$Sale = new Sale('sales');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  //$startDate =  date_format(date_create($_GET['startDate']),"Y-m-d H:i:s") ;
	  //$endDate =  date_format(date_create($_GET['endDate']),"Y-m-d H:i:s");
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'period >= ? ',  'period <= ? '],
														'bind' => [$shopId, $startDate, $endDate] ];
	$Reports = $Sale->find($params);

$i= 0;
foreach($Reports as $Report):

	$row = array(
		'key'=>'key'.$i,
		'id'=>$Report->id,
		'invoice_number'=>$Report->invoice_number,
		'amount'=> $Report->amount,
		'status'=> $Report->status,
		'period'=> $Report->period,
	'balance'=>$Report->balance,
		'table'=> $Table->findById($Report->tid)->name,
		'seat'=> $Seat->findById($Report->sid)->name,
	'ord_type'=>$Report->ord_type,
		'kitchen'=>$Report->kitchen,
	'waiter'=>	$User->findById($Report->waiter)->fullname,
	'cashier'=>	$User->findById($Report->cashier)->fullname,
		'created_at'=>$Report->created_at,
		'created_by'=>	$User->findById($Report->created_by)->fullname,
		'updated_by'=>$User->findById($Report->updated_by)->fullname,
		'updated_at'=>$Report->updated_at
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}






 public function salesTrailReport()
{
	$data  = [];

	$out = array('error' =>  false);
	$Sale = new SalesTrail('salesTrails');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'period >= ? ',  'period <= ? '],
														'bind' => [$shopId, $startDate, $endDate] ];
	$Reports = $Sale->find($params);

$i= 0;
foreach($Reports as $Report):

	$row = array(
		'key'=>'key'.$i,
		'id'=>$Report->id,
		'invoice_number'=>$Report->invoice_number,
		'amount'=> $Report->amount,
		'status'=> $Report->status,
		'period'=> $Report->period,
	'balance'=>$Report->balance,
		'table'=> $Table->findById($Report->tid)->name,
		'seat'=> $Seat->findById($Report->sid)->name,
	'ord_type'=>$Report->ord_type,
		'kitchen'=>$Report->kitchen,
	'waiter'=>	$User->findById($Report->waiter)->fullname,
	'cashier'=>	$User->findById($Report->cashier)->fullname,
		'created_at'=>$Report->created_at,
		'created_by'=>	$User->findById($Report->created_by)->fullname,
		'updated_by'=>$User->findById($Report->updated_by)->fullname,
		'updated_at'=>$Report->updated_at
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}









public function departmentReport()
{
	$data  = [];

	$out = array('error' =>  false);
	$Sale = new Sale('sales');
	$Orderdetail = new Orderdetail('orderdetails');
	$Product = new Product('products');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');


$sales_order = array();
  $price_order = array();


		$params  = ['conditions'=> ['shopId = ? ',  'period >= ? ',  'period <= ? '],
														'bind' => [$shopId, $startDate, $endDate] ];
	$InvoiceList = $Sale->find($params);


		foreach($InvoiceList as $LIST):

			$invoice = $LIST->invoice_number;
		//get products under this invoice
		//count each product

				$OrderParams  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];

				//check order details based on invoice
			$Orders =  $Orderdetail->find($OrderParams);

				//loop through the order
								foreach($Orders as $Order):
								//while($Order = $Orders->fetch()){

											if(array_key_exists(  $Order->product_id , $sales_order) ):

															$sales_order[ $Order->product_id] += $Order->qty;
															$price_order[  $Order->product_id] += $Order->total;


										else:
														$sales_order[  $Order->product_id]  = $Order->qty;
														$price_order[ $Order->product_id]  = $Order->total;

											endif;
								//}
								endforeach;
	endforeach;



$total_qty = 0;
$total_amount = 0;

$i= 0;
foreach($sales_order as $key => $val){
$p =  $Beedy->getColById($Product,   $key, 'product_name') ;
$main =  $Beedy->getColById($Product, $key, 'kitchen');
$left =  $Beedy->getColById($Product, $key, 'qty');

	$row = array(
		'key'=>'key'.$i,
		'product_id'=> $Order->product_id,
		'product_name'=> $p,
	 'sold'=>$val,
	 'left'=>$left,
	 'kitchen'=>$main,
		'price'=>$price_order[$key]
	);

	$data[]=$row;

	$i+=1;
}

 	$out['data'] = $data;

	 	$out['sales'] = $sales_order; //qty per products
	 	$out['price'] = $price_order;
    echo json_encode($out);

  	die();

}




 public function staffReport()
{
	 $data  = [];

	$out = array('error' =>  false);
	$Sale = new Sale('sales');

	  $staff = $_GET['staff'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();

		$params  = ['conditions'=> ['shopId = ? ',  'created_by= ? '],
														'bind' => [$shopId, $staff] ];
	$Reports = $Sale->find($params);

$i= 0;
foreach($Reports as $Report):

	$row = array(
		'key'=>'key'.$i,
		'id'=>$Report->id,
		'invoice_number'=>$Report->invoice_number,
		'amount'=> $Report->amount,
		'status'=> $Report->status,
		'period'=> $Report->period,
	'ord_type'=>$Report->ord_type,
		'kitchen'=>$Report->kitchen
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}







 public function destroy($id)
    {
       $del = $this->Role->delete($id);
      if($del): echo "Role Deleted Successfully"; else: "Error deleting this data... Please try again later"; endif;


    }

}
