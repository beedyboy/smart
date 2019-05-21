<?php
/**
*
*/
class SupplierController extends Controller
{

	public function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Supplier');

	}

 public function list()
{
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];
	$suppliers  = $this->Supplier->find($params);

  	$out['data'] = $suppliers;

	   echo json_encode($out);

  	die();

}
//
//beedy =(value) => {
//  value.persist();
//
//  console.log(value.target.value);
//}

public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

			$fields = [
										'supplier_name' => $data['supplier_name'],
										'supplier_address' => $data['supplier_address'],
										'supplier_contact' => $data['supplier_contact'],
										'contact_person' => $data['contact_person'],
										'note' => $data['note'],
										'shopId' => $data['shopId']
							];


						$send = $this->Supplier->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Supplier has been added successfully';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Supplier was not added. Please try again later";
							endif;

  echo json_encode($result);


}


public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	   $supplier_name = $data['supplier_name'];
				$supplier_address = $data['supplier_address'];
				$supplier_contact = $data['supplier_contact'];
			 $contact_person = $data['contact_person'];
	  $id = $data['id'];

 $Supplier = $this->Supplier->findById((int)$id);

	 if($Supplier->supplier_name != $supplier_name || $Supplier->supplier_contact != $supplier_contact
					|| $Supplier->supplier_address != $supplier_address || $Supplier->contact_person != $contact_person)
 	{
				$fields = [
										'supplier_name' => $supplier_name,
										'supplier_address' => $supplier_address,
										'supplier_contact' => $supplier_contact,
										'contact_person' =>$contact_person,
										'note' => $data['note']
							];

					$send = $this->Supplier->update($fields, (int)$id);
			if($send):

				$result['status'] = "success";
				$result['msg']  =   'Supplier has been updated successfully';

			else:

				$result['status'] = "Menu";
				$result['msg'] = "Error: Supplier was not updated. Please try again later";
			endif;
		}
		else{
				$result['status'] = "same";
			$result['msg']  =   'No changes made';
		}


  echo json_encode($result);


}






}