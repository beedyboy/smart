<?php
/**
*
*/
class PurchaseController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Purchase');

		//if(!Auth::check()): Router::redirect('login'); endif;

	}

 public function list()
{
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];
	$purchases  = $this->Purchase->find($params);

	$Supplier = new Supplier('suppliers');
		$User = new User('users');
	foreach($purchases as $purchase):

	$row = array(
		'item_name'=>$purchase->item_name,
		'supplier_name'=> $Supplier->findById($purchase->supplierId)->supplier_name,
		'transaction_type'=> $purchase->transaction_type,
	'supplierId'=>$purchase->supplierId,
	'qty'=>$purchase->qty,
		'cost_price'=>$purchase->cost_price,
	'purchased_date'=>$purchase->purchased_date,
		'id'=>$purchase->id,
		'created_by'=>	$User->findById($purchase->created_by)->fullname,
		'created_at'=>$purchase->created_at,
		'updated_by'=>$User->findById($purchase->updated_by)->fullname,
		'updated_at'=>$purchase->updated_at
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
	  $cost_price = $data['cost_price'];
	  $supplierId = $data['supplierId'];
	  $item_name = $data['item_name'];
	  $note = $data['note'];
	  $shopId = $data['shopId'];

	$Beedy = new Beedy();
 	$userId  = $Beedy->getUserId($token);


			$fields = [
										'cost_price' => $cost_price,
										'item_name' => $item_name,
										'qty' => $data['qty'],
										'supplierId' => $supplierId,
										'transaction_type' => $data['transaction_type'],
										'purchased_date' => $data['purchased_date'],
										'note' => $note,
										'shopId' => $shopId,
										'created_by' => $userId,
										'created_at' => '',
							];

$params = [	 'conditions'=> ['shopId = ?', 'item_name = ?', 'supplierId = ?'], 'bind' => [$shopId, $item_name, $supplierId] ];
	$exist  = $this->Purchase->find($params);


				if(count($exist) < 1):
						$send = $this->Purchase->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Item has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Item was not added. Please try again later";
							endif;
		 else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This product already exist. Please try again using different data";
				  		endif;
  echo json_encode($result);


}




public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	 	$transaction_type = $data['transaction_type'];
	  $cost_price = $data['cost_price'];
	  $supplierId = $data['supplierId'];
	  $note = $data['note'];
	  $item_name = $data['item_name'];
	  $token = $data['token'];
	  $qty = $data['qty'];
	  $id = $data['id'];

	$User = new User('users');
 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;


							$Item = $this->Purchase->findById((int)$id);

		   		if($Item->item_name != $item_name || $Item->qty != $qty  || $Item->note != $note  || $Item->transaction_type != $transaction_type || $Item->cost_price != $cost_price || $Item->supplierId != $supplierId)
							{
								$fields = [
										'cost_price' => $cost_price,
										'item_name' => $item_name,
										'qty' => $qty,
										'supplierId' => $supplierId,
										'transaction_type' => $transaction_type,
										'purchased_date' => $data['purchased_date'],
										'note' => $note,
										'updated_by' => $userId,
										'updated_at' => '',
							];
									$send = $this->Purchase->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Item has been updated successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Item was not updated. Please try again later";
							endif;
							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'No changes made';
							}


  echo json_encode($result);


}




  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Item
     *
     */
    public function destroy($id)
    {
       $del = $this->Item->delete($id);
      if($del): echo "Item Deleted Successfully"; else: "Error deleting this data... Please try again later"; endif;


    }


}