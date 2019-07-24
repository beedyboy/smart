<?php
/**
*
*/
class AcquisitionController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Acquisition');


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
	 'unit'=>($Acquisition->unit === null)? '':$Acquisition->unit,
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




public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $itemId = $data['itemId'];
	  $kitchen = $data['kitchen'];
	  $qty = $data['qty'];
	  $shopId = $data['shopId'];
	$User = new User('users');
 	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;
	endif;

//check whether quantity is lesser than stock quantity

	$Purchase = new Purchase('purchases');
	$item_quantity = $Purchase->findById((int)$itemId)->qty;

$params = [	 'conditions'=> ['shopId = ?', 'itemId = ?', 'kitchen = ?', 'qty = ?'],
											'bind' => [$shopId, $itemId, $kitchen, $qty] ];
	$exist  = $this->Acquisition->find($params);

if($qty <= $item_quantity) {

				if(count($exist) < 1):
	$newQuantity = $item_quantity - $qty;

			$fields = [
										'itemId' => $itemId,
										'qty' => $qty,
										'kitchen' => $kitchen,
										'unit' => $data['unit'],
										'shopId' => $shopId,
										'created_by' => $userId,
										'created_at' => '',
							];
			$field2 = [
										'qty' => $newQuantity
							];
						$send = $this->Acquisition->insert($fields);
							$send2 = $Purchase->update($field2, (int)$itemId);

							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Item has been allocated successfully';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Item was not allocated. Please try again later";
							endif;
		 else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This item already exist. If you wish to update, please click on record table to edit and update";
				  		endif;
}
else {
		$result['status'] = "error";
								$result['msg'] = "Error: Allocated quantity can not be more than item quantity in stock";

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
			$unit  = $data['unit'];

			$Allocation = $this->Acquisition->findById((int)$id);
		 $Purchase = new Purchase('purchases');
		 $item_quantity = $Purchase->findById((int)$itemId)->qty;
			//if i have 2 items before and wanna make it five
			//updated qty should be 3
			//get value from acquisition and substract from new value
$updQty =  (int)($qty) - (int)($Allocation->qty); // this means 5 - 2

		if($updQty <= $item_quantity) {


	$newQuantity = (int)$item_quantity - (int)$updQty;

				 		if($Allocation->itemId != $itemId || $Allocation->qty != $qty ||  $Allocation->unit != $unit || $Allocation->kitchen != $kitchen )
							{
									$fields = [
										'itemId' => $itemId,
										'qty' => $qty,
										'unit' => $unit,
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

								$result['status'] = "Menu";
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

								$result['status'] = "Menu";
								$result['msg'] = "Error: Finished product was not processed. Please try again later";
							endif;

  echo json_encode($result);


}






}