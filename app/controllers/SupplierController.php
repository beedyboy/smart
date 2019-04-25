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

								$result['status'] = "db_error";
								$result['msg'] = "Error: Supplier was not added. Please try again later";
							endif;
		
  echo json_encode($result);

	
}
 





}