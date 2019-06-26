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
	$Menu = new Menu('menus');

	$Kitchen = new Kitchen('kitchens');
	$Category = new Category('categories');
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$value= $_GET['value'];
		$params  = ['conditions'=> ['shopId = ?', 'item LIKE ?'], 'bind' => [$shopId, "%$value%"] ];
	$MenuList = $Menu->find($params);
foreach($MenuList as $Menu):
	$kitchenId = $Category->findById($Menu->catId)->kitchenId;
			$row = array(
				'id'=>$Menu->id,
				'price'=>$Menu->price,
				'item'=>$Menu->item,
				'kitchenId'=>$kitchenId,
				'base'=> $Kitchen->findById($kitchenId)->base,
				//'kitchen_name'=> $Kitchen->findById($cat->kitchenId)->name,
	);

	$data[]=$row;


	endforeach;
  	$out['data'] = $data;
//$out['data'] = $MenuList;

	   echo json_encode($out);

  	die();

}



 public function fetchOrder()
{

	$Sale = new Sale('sales');
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$value= $_GET['value'];
		$params  = ['conditions'=> ['shopId = ?', 'invoice_number LIKE ?'], 'bind' => [$shopId, "%$value%"] ];
	$SaleList = $Sale->find($params);
foreach($SaleList as $Order):
			$row = array(
				'id'=>$Order->id,
				'invoice_number'=>$Order->invoice_number,
				'total'=> ($Order->fund + $Order->nhil+ $Order->vat+ $Order->amount),
				//'item'=>$Order->item,
	);

	$data[]=$row;


	endforeach;
  	$out['data'] = $data;
//$out['data'] = $MenuList;
//$out['data'] =  $Sale->find($params);
	   echo json_encode($out);

  	die();

}



public function getCartItem()
{

	  $invoice = $_GET['invoice'];
	  $shopId = $_GET['shopId'];
	$Orderdetail = new Orderdetail('orderdetails');
$Beedy = new Beedy();
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
								'menu_id'=> $plate,
								'menu_name'=> $item,
								'qty'=>1,
								'price'=>$amount,
								'total'=> $fund + $nhil+ $vat+ $total,
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
		$i = 1;
	foreach($singlePlateOrders as $Order):

	$row = array(
		'key'=>'key'.$i,
		'base'=>'No',
		'id'=>$Order->id,
		'menu_id'=> $Order->menu_id,
		'menu_name'=> $Menu->findById($Order->menu_id)->item,
	 'qty'=>$Order->qty,
		'price'=>$Order->price,
		'total'=> ($Order->fund + $Order->nhil+ $Order->vat+ $Order->total),
		'discount'=>$Order->discount,
		'vat'=>$Order->vat,
		'fund'=>$Order->fund,
		'nhil'=>$Order->nhil,
		'nfund'=> $Order->fund+$Order->nhil,
		//'total'=>$Order->total,
		'created_at'=>$Order->created_at,
		'updated_at'=>$Order->updated_at
	);

	$data[]=$row;

	$i+=1;

	endforeach;
 	$result['data'] = $data;

		}
	$result['data'] = $data;
	endforeach;
	echo json_encode($result);
}




 public function getPlate(){
							$invoice = $_GET['invoice'];
							$shopId = $_GET['shopId'];
					$Orderdetail = new Orderdetail('orderdetails');
				$Beedy = new Beedy();
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
												'menu_id'=> $plate,
												'menu_name'=> $item,
												'qty'=>1,
												'price'=>$amount,
												'total'=> $fund + $nhil+ $vat+ $total,
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
						$i = 1;
					foreach($singlePlateOrders as $Order):

					$row = array(
						'key'=>'key'.$i,
						'base'=>'No',
						'id'=>$Order->id,
						'menu_id'=> $Order->menu_id,
						'menu_name'=> $Menu->findById($Order->menu_id)->item,
						'qty'=>$Order->qty,
						'price'=>$Order->price,
						'total'=> ($Order->fund + $Order->nhil+ $Order->vat+ $Order->total),
						'discount'=>$Order->discount,
						'vat'=>$Order->vat,
						'fund'=>$Order->fund,
						'nhil'=>$Order->nhil,
						'nfund'=> $Order->fund+$Order->nhil,
						//'total'=>$Order->total,
						'created_at'=>$Order->created_at,
						'updated_at'=>$Order->updated_at
					);

					$data[]=$row;

					$i+=1;

					endforeach;
						$result['data'] = $data;

						}
					$result['data'] = $data;
					endforeach;
					echo json_encode($result);
	}
	public function getCartTotal()
{
$Beedy = new Beedy();
$productCount = 0;
$nhil = 0;
$fund = 0;
$vat = 0;
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
$nhil +=$Order->nhil;
$fund +=$Order->fund;
$vat +=$Order->vat;
$sumTotal +=$Order->total;
$sumDiscount +$Order->discount;

	endforeach;
	$final = round($nhil + $fund + $vat + $sumTotal,2);

	$row = array(
		'id'=>$Beedy->PasswordDecider(),
		'productCount'=>$productCount,
		'discount'=>$sumDiscount,
		'total'=>$final
	);

	$data[]=$row;

 	$out['data'] = $data;
	   echo json_encode($out);

  	die();

}




public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
$Menu = new Menu('menus');
	$Orderdetail = new Orderdetail('orderdetails');
	$Kitchen = new Kitchen('kitchens');
	$Category = new Category('categories');
$Beedy = new Beedy();
	  $invoice = $data['invoice'];
	  $menuId = $data['menuId'];
	  $shopId = $data['shopId'];

			//get food under menu

			  $qty = 1;

					//first check if menu already exists in the table for current session
	//if yes check products quantity in store	//update otherwise create
	$exist  =  $Beedy->orderExist($shopId, $menuId, $invoice);


	$totalPrice = 0;
	$low = false;
	//check through each item

			$price  =  $Beedy->menuDetails((int)$menuId, "price");
   $catId  =  $Beedy->menuDetails((int)$menuId, "catId");

			$totalPrice = $price * $qty;
			//$totalPrice +=$add;


if($exist == 'false'):
$kitchenId = $Category->findById($catId)->kitchenId;
				$accept = $Kitchen->findById($kitchenId)->accept;
										//create
										//cal nhil
									$nhil =	tax($totalPrice,2.5,102.5);
									$nhilper =taxItem($totalPrice,$nhil); //deduction//new total


									$fund =tax($nhilper,2.5,102.5);
									$fundper =taxItem($nhilper,$fund);


									$vat =tax($fundper,12.5,112.5);
									$afterTax =taxItem($fundper,$vat);


	//calculate now
	// number_format(round(taxItem($totalProductPrice,0.024),2),2);
	//$fund =  number_format(round(taxItem($nhilper,0.024),2),2);
	//$vat =  number_format(round(taxItem($fundper,0.11),2),2);


								$fields = [
																		'menu_id' => $menuId,
																		'qty' => $qty,
																		'invoice' => $invoice,
																		'price' => $price,//incase of discount, use this valu for total calc
																		'total' => $afterTax,
																		'nhil' => $nhil,
																		'fund' => $fund,
																		'vat' => $vat,
																		'accept' => $accept,
																		'shopId' => $shopId,
																		'created_at' => ''
															];
								//send menu
									$send = $Orderdetail->insert($fields);
										//$send2 = $Beedy->minusProduct($compute, $qty);
												if($send):

																$result['status'] = "success";
																$result['msg']  =   'Menu item has been added to cart';

															else:

																$result['status'] = "Menu";
																$result['msg'] = "Error: Item was not added. Please try again later";
															endif;
											else:
											//dnd('existed');
											//update
													$orders =   $Beedy->OrderDetail($shopId, $menuId, $invoice);
													$id = 0;
													$j = 0;
													$newQty = 0;
													$newTotal=0;
													foreach($orders as $ord):
																$id = $ord->id;
																$newQty = $ord->qty + $qty;
																$newTotal = $ord->total +  $ord->nhil +  $ord->fund +  $ord->vat  + $totalPrice;

													endforeach;

$nhil =	tax($newTotal,2.5,102.5);
$nhilper =taxItem($newTotal,$nhil); //deduction//new total


$fund =tax($nhilper,2.5,102.5);
$fundper =taxItem($nhilper,$fund);


$vat =tax($fundper,12.5,112.5);
$afterTax =taxItem($fundper,$vat);


									$fields = [
																					'qty' => $newQty,
																					'price' => $price,//incase of discount, use this valu for total calc
																					'total' => $afterTax,
																					'nhil' => $nhil,
																					'fund' => $fund,
																					'vat' => $vat,
																					'updated_at' => '',
																		];
											//send menu
												$send = $Orderdetail->update($fields, (int)$id);
										//$send2 = $Beedy->minusProduct($compute, $qty);
												if($send):

											$result['status'] = "success";
											$result['msg']  =   'Menu Item has been updated successfully';
												else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Menu Item  was not updated. Please try again later";
							endif;
 endif;


//menuDetails

  echo json_encode($result);
}



public function saveBase(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	$Kitchen = new Kitchen('kitchens');
	$Category = new Category('categories');
	$Orderdetail = new Orderdetail('orderdetails');
$Beedy = new Beedy();

		$shopId= $data['shopId'];
		$invoice= $data['invoice'];
	   $localOrder = $data['localOrder'];
	   $localQty = $data['localQty'];



 	$params  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];
 	$array = $Orderdetail->find($params);
	//is there any existing order?
	$made =  count($array);
	$plate = 2;
	 if($made < 1){
		$plate = 2;
	 }
	 else{
		$plate  = $Orderdetail->max('plate') +1;
		}
$i = 1;
$length = is_array($localOrder)? count($localOrder):1 ;

	foreach($localOrder as $key=>$value){
						$qty =$localQty[$key];
						$menuId =$value;

					 	$totalPrice = 0;

						//check through each item
					$price  =  $Beedy->menuDetails((int)$menuId, "price");
				 $catId  =  $Beedy->menuDetails((int)$menuId, "catId");
					$totalPrice = $price * $qty;
					$kitchenId = $Category->findById($catId)->kitchenId;
					$accept = $Kitchen->findById($kitchenId)->accept;
									//create
									//cal nhil
								$nhil =	tax($totalPrice,2.5,102.5);
								$nhilper =taxItem($totalPrice,$nhil); //deduction//new total


								$fund =tax($nhilper,2.5,102.5);
								$fundper =taxItem($nhilper,$fund);


								$vat =tax($fundper,12.5,112.5);
								$afterTax =taxItem($fundper,$vat);

								$fields = [
																		'menu_id' => $menuId,
																		'qty' => $qty,
																		'invoice' => $invoice,
																		'price' => $price,//incase of discount, use this valu for total calc
																		'total' => $afterTax,
																		'nhil' => $nhil,
																		'fund' => $fund,
																		'vat' => $vat,
																		'plate' => $plate,
																		'accept' => $accept,
																		'shopId' => $shopId,
																		'created_at' => '',
															];
								//send menu
									$send = $Orderdetail->insert($fields);
										if($i === $length) {
												if($send):

																		$result['status'] = "success";
																		$result['msg']  =   'Order sent successfully';

																	else:

																		$result['status'] = "Menu";
																		$result['msg'] = "Error: Order not sent. Please try again later";
																	endif;
										}
$i+=1;
}
				 echo json_encode($result);
					//var_dump($localOrder);
					//var_dump('Quantity');
					//var_dump($localQty);


//echo json_encode($result);
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

								$result['status'] = "Menu";
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
	//$Seat = new Seat('seats');
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
				//'seat'=> $Seat->findById($DATA->sid)->name,
			'ord_type'=>$DATA->ord_type,
				//'kitchen'=>$DATA->kitchen,
				'vat'=>$DATA->vat,
				'fund'=>$DATA->fund,
				'nhil'=>$DATA->nhil,
				'nfund'=> ($DATA->fund + $DATA->nhil),
				'gtotal'=> ($DATA->fund + $DATA->nhil+ $DATA->vat+ $DATA->amount),
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
	  $token = $data['token'];
	  $invoice = $data['invoice'];
	  $shopId = $data['shopId'];
	  //$kitchen = ($data['kitchen'])? $data['kitchen']: 'Local';
	  $type = ($data['type']) ? 'Dine-In': 'Take Out';
	  $table =($data['table'])?  $data['table']: '';
	  //$seat = ($data['seat'])?  $data['seat']: '';
			$waiter = ($data['waiter'])?  $data['waiter']: '';



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
	$nhil = 0;
	$fund = 0;
	$vat = 0;
$ary = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice]  ];

$Query = $Orderdetail->find($ary);
//get who accepts
	$accepts = implode(',', array_unique(array_column($Query, 'accept')));

//foreach value
foreach($Query as $Details):
			$amount += $Details->total;
			$discount += $Details->discount;
			$nhil +=$Details->nhil;
			$fund +=$Details->fund;
			$vat +=$Details->vat;

endforeach;
	$balance = 	$amount;

//$nhil = round($nhil,2);
//$fund = round($fund,2);
//$vat = round($vat,2);

	$kitchen_status = "Pending";
	//if($kitchen ==="Bar"):
	//$kitchen_status = "Approved";
	//endif;
//menuDetails
if($type == 'Dine-In'):
									$fields = [
																					'shopId' => $shopId,
																					'invoice_number' => $invoice,
																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'tid' => $table,
																					//'sid' => $seat,
																					'period' => $date,
																					'waiter' => $waiter,
																					'balance' => $balance,
																					'nhil'=>$nhil,
																					'fund'=>$fund,
																					'vat' => $vat,
																					'ord_type' => $type,
																					'accept' => $accepts,
																					'kitchen_status'=>$kitchen_status,
																					'created_at' => '',
																					'created_by' => $userId,
																		];
									$fields2 = [

																					'amount' => $amount,//incase of discount, use this valu for total calc
																					'discount' => $discount,
																					'tid' => $table,
																					//'sid' => $seat,
																					'period' => $date,
																					'waiter' => $waiter,
																					'balance' => $balance,
																					'nhil'=>$nhil,
																					'fund'=>$fund,
																					'vat' => $vat,
																					'ord_type' => $type,
																					'accept' => $accepts,
																					'kitchen_status'=>$kitchen_status,
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
																					'nhil'=>$nhil,
																					'fund'=>$fund,
																					'vat' => $vat,
																					'accept' => $accepts,
																					'kitchen_status'=>$kitchen_status,
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
																					'nhil'=>$nhil,
																					'fund'=>$fund,
																					'vat' => $vat,
																					'accept' => $accepts,
																					'kitchen_status'=>$kitchen_status,
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

																$result['status'] = "Menu";
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

																$result['status'] = "Menu";
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
	'ord_type'=>$Basket->ord_type,
	'waiter'=>	$User->findById($Basket->waiter)->fullname,
	'cashier'=>	$User->findById($Basket->cashier)->fullname,
	'gtotal'=> ($Basket->fund + $Basket->nhil+ $Basket->vat+ $Basket->amount),
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
 		$Menu = new Menu('menus');
				$Beedy = new Beedy();
				$params = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId,  $invoice]  ];
						$data  = $Beedy->loadTblCond2($Orderdetail,$params);


$del  = $Orderdetail->bulkDelete($params);
	if($del):

								$result['status'] = "success";
								$result['msg']  =   'Cart emptied';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Cart was not emptied. Please try again later";
							endif;

	 	//$out['data'] = $data;
    echo json_encode($result);

  	//die();
	}



 public function deleteCartItem()
	{
		$result = array();
				$id = $_GET['id'];
				$shopId=$_GET['shopId'] ;
				$Menu = new Menu('menus');
	$Orderdetail = new Orderdetail('orderdetails');
$Beedy = new Beedy();

				$data  = $Orderdetail->findById($id);


		$params = ['conditions'=> ['shopId = ?', 'id = ?'], 'bind' => [$shopId,  $id]  ];

$del  = $Orderdetail->bulkDelete($params);
	if($del):
								$result['status'] = "success";
								$result['msg']  =   'Item deleted from cart';

							else:

								$result['status'] = "Menu";
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
				$menu_id = $_GET['menu_id'];
				$invoice = $_GET['invoice'];

				$qty=$_GET['qty'];
				$newQty=$_GET['newQty'];
				$shopId=$_GET['shopId'];


$Menu = new Menu('menus');

				$Orderdetail = new Orderdetail('orderdetails');
				$Beedy = new Beedy();
				$data  = $Orderdetail->findById($id);


$totalProductPrice=0;
			$price  =  $Beedy->menuDetails($menu_id, "price");
			$totalProductPrice = $price * $qty;

					if(empty($newQty)):
				//take old quantity and add to product, then delete from order
						//$Beedy->plusProduct($compute, $qty);
							$clearParams = ['conditions'=> ['shopId = ?', 'id = ?'], 'bind' => [$shopId,  $id]  ];

							echo	$this->clearCartItem($clearParams);
////
				elseif($newQty > $qty): //greater than initial cart qty
				//minus the difference and minus from product then add to order


							$diff = $newQty - $qty;
											//if($pQty >= $diff){

							$newTotal = $price * $newQty;

$nhil =	tax($newTotal,2.5,102.5);
$nhilper =taxItem($newTotal,$nhil); //deduction//new total

$fund =tax($nhilper,2.5,102.5);
$fundper =taxItem($nhilper,$fund);
$vat =tax($fundper,12.5,112.5);
$afterTax =taxItem($fundper,$vat);
												$fields = [
																								'qty' => $newQty,
																								'price' => $price,//incase of discount, use this valu for total calc
																								'total' => $afterTax,
																								'nhil' => $nhil,
																								'fund' => $fund,
																								'vat' => $vat,
																								'updated_at' => '',
																					];
														//send menu
															$send = $Orderdetail->update($fields, (int)$id);
													//$send2 = $Beedy->minusProduct($compute, $diff);
															if($send):

														$result['status'] = "success";
														$result['msg']  =   'Quantity updated successfully';
															else:

											$result['status'] = "Menu";
											$result['msg'] = "Error: Quantity  was not updated. Please try again later";
										endif;

			echo json_encode($result);

  return;
				elseif($newQty !== 0  && $newQty < $qty):
					//minus from order, add to difference to product
	$diff =  $qty - $newQty;

							$newTotal = $price * $newQty;

	 $nhil =	tax($newTotal,2.5,102.5);
$nhilper =taxItem($newTotal,$nhil); //deduction//new total


$fund =tax($nhilper,2.5,102.5);
$fundper =taxItem($nhilper,$fund);


$vat =tax($fundper,12.5,112.5);
$afterTax =taxItem($fundper,$vat);
												$fields = [
																								'qty' => $newQty,
																								'price' => $price,//incase of discount, use this valu for total calc
																								'total' => $afterTax,
																								'nhil' => $nhil,
																								'fund' => $fund,
																								'vat' => $vat,
																								'updated_at' => '',
																					];
														//send menu
															$send = $Orderdetail->update($fields, (int)$id);
															//$Beedy->plusProduct($compute, $diff);
														if($send):

														$result['status'] = "success";
														$result['msg']  =   'Qty updated successfully';
															else:

													$result['status'] = "Menu";
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

								$result['status'] = "Menu";
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
$kitchen_status ="Approved";
	$User = new User('users');
	$Table = new HTable('htables');
	$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'status = ? ', 'kitchen_status = ? '],	'bind' => [$shopId, $d, $kitchen_status] ];
	$Receivables = $Sale->find($params);

$i= 0;
foreach($Receivables as $Receivable):

	$row = array(
		'key'=>'key'.$i,
		'id'=>$Receivable->id,
		'invoice_number'=>$Receivable->invoice_number,
		'amount'=> $Receivable->amount,
	'balance'=>$Receivable->balance,
		'table'=> $Table->findById($Receivable->tid)->name,
	'ord_type'=>$Receivable->ord_type,
		'gtotal'=> ($Receivable->fund + $Receivable->nhil+ $Receivable->vat+ $Receivable->amount),
		'kitchen_status'=>$Receivable->kitchen_status,
		'approved_by'=>$User->findById($Receivable->approved_by)->fullname,
	'waiter'=>	$User->findById($Receivable->waiter)->fullname,
	'cashier'=>	$User->findById($Receivable->cashier)->fullname,
		'created_at'=>$Receivable->created_at,
		'created_by'=>	$User->findById($Receivable->created_by)->fullname,
		'updated_by'=>$User->findById($Receivable->updated_by)->fullname,
		'updated_at'=>$Receivable->updated_at
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}

public function fetchKitchenReceivable()
{
	$receivables  = [];

	$out = array('error' => false);
	$Sale = new Sale('sales');
$Beedy = new Beedy();
$Menu = new Menu('menus');
	$Kitchen = new Kitchen('kitchens');
	$Category = new Category('categories');
	$Orderdetail = new Orderdetail('orderdetails');

$shopId = $_GET['shopId'];
$position= $_GET['position'];
$d = "PENDING";
$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'status = ? '],	'bind' => [$shopId, $d] ];
	$Receivables = $Sale->find($params);


foreach($Receivables as $Receivable):
	$invoice = $Receivable->invoice_number;
	$orderNumber = $Receivable->id;
	$orderType = $Receivable->ord_type;
//var_dump($invoice);

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
						$acceptLog='';
						$accepted='Yes';
						$menu_id_log='';
						//select based on plate
				$plateParams  = ['conditions'=> ['shopId = ?', 'invoice = ?', 'plate = ?'], 'bind' => [$shopId, $invoice, (int)$plate] ];
							$plateOrders =  $Orderdetail->find($plateParams);
							//var_dump($plate);
								//iterate through products under the plate
								$numItems = count($plateOrders);
								$i = 0;
								foreach($plateOrders as $items){

										$catId  =  $Beedy->menuDetails((int)$items->menu_id, "catId");
										$kitchenId = $Category->findById($catId)->kitchenId;
										$accept = $Kitchen->findById($kitchenId)->accept;
										$accepted = $items->accepted;
if ($accepted !=="Yes" && ($position === $accept || $position === "SuperAdmin" || $position === "Admin" || $position === "Supervisor")):

														if(++$i === $numItems) {
																		//$item .=$Menu->findById($items->menu_id)->item;
																		//$acceptLog .=$accept;
																}else{
																	}
		$item .=$Menu->findById($items->menu_id)->item." & ";

																		$acceptLog .=$accept.",";
																		$menu_id_log .=$items->id.",";
																$amount +=$Menu->findById($items->menu_id)->price;
																$nhil += $items->nhil;
																$fund += $items->fund;
																$vat += $items->vat;
																$total += $items->total;
endif;
														}
if ($accepted !=="Yes" && ($position === $accept || $position === "SuperAdmin" || $position === "Admin" || $position === "Supervisor")):
//var_dump($menu_id_log);
															$row = array(
																'orderType' => $orderType,
																'orderNumber' => $orderNumber,
																'invoice' =>$invoice,
																'base'=>'Yes',
																'accept'=>array_unique(explode(',',substr(trim($acceptLog), 0, -1))),
																'id'=>$plate,
																'plate'=> $plate,
																'menu_id'=>array_unique(explode(',',substr(trim($menu_id_log), 0, -1))),
																'menu_name'=> substr(trim($item), 0, -1),
																'qty'=>1,
																'price'=>$amount,
																'total'=> $fund + $nhil+ $vat+ $total
															);

															$receivables[]=$row;

					endif;
									$i+=1;
				}
				else{
								$singlePlateParams  = ['conditions'=> ['shopId = ?', 'invoice = ?', 'plate = ?'], 'bind' => [$shopId, $invoice, (int)$plate] ];
										$singlePlateOrders =  $Orderdetail->find($singlePlateParams);
							$i = 1;
										foreach($singlePlateOrders as $Order):

										$catId  =  $Beedy->menuDetails((int)$Order->menu_id, "catId");
										$kitchenId = $Category->findById($catId)->kitchenId;
										$accept = $Kitchen->findById($kitchenId)->accept;
										$accepted = $Order->accepted;
if ($accepted !=="Yes" && ($position === $accept || $position === "SuperAdmin" || $position === "Admin" || $position === "Supervisor")):
													$row = array(
																'orderType' => $orderType,
														'orderNumber' => $orderNumber,
										'invoice' =>$invoice,
														'base'=>'No',
														'id'=>$Order->id,
														'menu_id'=> (int)trim($Order->id),
														'menu_name'=> $Menu->findById($Order->menu_id)->item,
														'accept' => $accept,
														'qty'=>$Order->qty,
														'price'=>$Order->price,
														'total'=> ($Order->fund + $Order->nhil+ $Order->vat+ $Order->total),
														'created_at'=>$Order->created_at,
														'updated_at'=>$Order->updated_at
													);

													$receivables[]=$row;

													$i+=1;
endif;
										endforeach;
			if ($position === $accept || $position === "SuperAdmin" || $position === "Admin" || $position === "Supervisor"):
								$out['data'] = $data;
endif;
				}

			endforeach;
//$receivables[]= $data;
endforeach;

	 	$out['data'] = $receivables;
    echo json_encode($out);

  	die();

}


public  function kitchenApprove(){
		 $result = array('error' => false);
				$Sale = new Sale('sales');
   	$User = new User('users');
	$Orderdetail = new Orderdetail('orderdetails');

		 $status ="Yes";
			$una = "Yes";
			$kitchen_status ="Approved";
	  $token = $_GET['token'];
		$shopId= $_GET['shopId'];
		$invoice= $_GET['invoice'];
	  $base = $_GET['base'];
	  $menu_id = $_GET['menu_id'];
	  $accept = $_GET['accept'];

					$fields = [	'accepted' => $status ];
						$params  = ['conditions'=> ['shopId = ?', 'invoice =?', 'accepted <> ?'], 'bind' => [$shopId,$invoice,$una] ];
			$salesParams  = ['conditions'=> ['shopId = ? ',  'invoice_number = ? '],	'bind' => [$shopId, $invoice] ];

			if($base === "Yes"):
					//var_dump($menu_id);
					//update each menu in order details
					foreach($menu_id as $id){
						 $Orderdetail->update($fields, (int)$id);
					}
							$data = $Orderdetail->find($params);
							$unCompleted = count($data);
										if(	$unCompleted === 0){
								//update sales
								$Receivables = $Sale->find($salesParams);

									$accepted= '';
										$sale_id= 0;
									foreach($Receivables as $Receivable):
											$accepted = $Receivable->accept;
											$sale_id = $Receivable->id;
									endforeach;
									$Salesfields = [	'accepted' => $accepted, 'kitchen_status' => $kitchen_status ];
								if($Sale->update($Salesfields, (int)$sale_id)):
										$result['status'] = "success";
											$result['msg']  =   'Menu Approved successfully';

										else:

											$result['status'] = "error";
											$result['msg'] = "Error:Please try again later";
								endif;
							}
							else{
								//send tank u message
								$result['status'] = "success";
											$result['msg']  =   'Menu Approved successfully';

							}



			else:
//ordinary order

								if($Orderdetail->update($fields, (int)$menu_id)):
									//check orderdetails using invoice
									//confirm if all is Yes

							$data = $Orderdetail->find($params);

							$unCompleted = count($data);
							if(	$unCompleted === 0){
								//update sales
							 	$Receivables = $Sale->find($salesParams);

									$accepted= '';
										$sale_id= 0;
									foreach($Receivables as $Receivable):
									$accepted = $Receivable->accept;
									$sale_id = $Receivable->id;
									endforeach;
									$Salesfields = [	'accepted' => $accepted, 'kitchen_status' => $kitchen_status];
								if($Sale->update($Salesfields, (int)$sale_id)):
										$result['status'] = "success";
											$result['msg']  =   'Menu Approved successfully';

										else:

											$result['status'] = "error";
											$result['msg'] = "Error:Please try again later";
								endif;
							}
							else{
								//send tank u message
								$result['status'] = "success";
											$result['msg']  =   'Menu Approved successfully';

							}

								endif;


			endif;


  echo json_encode($result);

}

//
//public  function kitchenApprove(){
//		 $result = array('error' => false);
//				$Sale = new Sale('sales');
//   	$User = new User('users');
//
//			$d = "PENDING";
//	  $token = $_GET['token'];
//	  $id = $_GET['id'];
//		 $status ="Approved";
//
//					$Query  = $User->findByToken($token);
//
//					if($Query):
//					$userId = $Query->id;
//
//						endif;
//
//					$fields = [
//													'kitchen_status' => $status,
//										 		'approved_by' => $userId,
//										];
//
//								$send = $Sale->update($fields, (int)$id);
//					if($send):
//
//							$result['status'] = "success";
//							$result['msg']  =   'Transaction Completed';
//
//						else:
//
//							$result['status'] = "error";
//							$result['msg'] = "Error:Please try again later";
//						endif;
// echo json_encode($result);
//
//}


public  function payNow(){
			 $result = array('error' => false);
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

							$result['status'] = "Menu";
							$result['msg'] = "Error:Please try again later";
						endif;
						echo json_encode($result);

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
	//$Seat = new Seat('seats');
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
		'amount'=> round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2),
		'status'=> $Report->status,
		'period'=> $Report->period,
	'balance'=>$Report->balance,
		'table'=> $Table->findById($Report->tid)->name,
	'ord_type'=>$Report->ord_type,
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
		'amount'=> round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2),
 	'status'=> $Report->status,
		'period'=> $Report->period,
	'balance'=>$Report->balance,
		'table'=> $Table->findById($Report->tid)->name,
	'ord_type'=>$Report->ord_type,
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
	$Menu = new Menu('menus');
	$Category = new Category('categories');
	$Kitchen = new Kitchen('kitchens');
	$Orderdetail = new Orderdetail('orderdetails');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	$User = new User('users');


$sales_order = array();
  $price_order = array();
$nhil_price = array();
  $fund_price = array();
$vat_price = array();


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

											if(array_key_exists(  $Order->menu_id , $sales_order) ):

															$sales_order[ $Order->menu_id] += $Order->qty;
															$price_order[  $Order->menu_id] += $Order->total;
															$nhil_price[  $Order->menu_id] += $Order->nhil;
															$fund_price[ $Order->menu_id] += $Order->fund;
															$vat_price[  $Order->menu_id] += $Order->vat;


										else:
														$sales_order[  $Order->menu_id]  = $Order->qty;
														$price_order[ $Order->menu_id]  = $Order->total;
														$nhil_price[  $Order->menu_id] = $Order->nhil;
															$fund_price[ $Order->menu_id] = $Order->fund;
															$vat_price[  $Order->menu_id] = $Order->vat;

											endif;
								//}
								endforeach;
	endforeach;



$total_qty = 0;
$total_amount = 0;

$i= 0;
foreach($sales_order as $key => $val){
$p =  $Beedy->getColById($Menu,   $key, 'item') ;
$main =  $Beedy->getColById($Kitchen, $Beedy->getColById($Category, $Beedy->getColById($Menu, $key, 'catId'), 'kitchenId'), 'name') ;
//$left =  $Beedy->getColById($Menu, $key, 'qty');

	$row = array(
		'key'=>'key'.$i,
		'menu_id'=> $Order->menu_id,
		'menu_name'=> $p,
	 'sold'=>$val,
	 'kitchen'=>$main,
		'normalPrice'=>$price_order[$key],
		'price'=>$nhil_price[$key] + $fund_price[$key] + $vat_price[$key] + $price_order[$key]
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
		'amount'=> round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2),
		'status'=> $Report->status,
		'period'=> $Report->period,
	'ord_type'=>$Report->ord_type,
		//'kitchen'=>$Report->kitchen
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}







 public function cancelOrder()
  {
					$result = array();
				$invoice=$_GET['invoice'];
				$shopId=$_GET['shopId'];
					 $id = $_GET['id'];

 		$Menu = new Menu('menus');
						$Sale = new Sale('sales');
				$Orderdetail = new Orderdetail('orderdetails');

       $del = $Sale->delete($id);
      if($del):
										$params = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId,  $invoice]  ];

									$send  = $Orderdetail->bulkDelete($params);
						if($send):

								$result['status'] = "success";
								$result['msg']  =   'Order Deleted Successfully';

							else:

								$result['status'] = "error";
								$result['msg'] = "Error: Order was not deleted. Please try again later";
							endif;

					endif;
					 echo json_encode($result);
    }

}
