<?php
/**
* 
*/
class HallController extends Controller
{
	
	public function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Hall');

		//$this->view->setLayout('app'); 

	}

	 
  
public function list()
{
	$data = [];
	$out = array('error' => false);
		$shopId = json_decode(file_get_contents("php://input"), TRUE);
	$hall  = $this->Hall->find();

  	$out['data'] = $hall;

	   echo json_encode($out);

  	die();

}


public function save(){ 
					
	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	 
		//$out['data'] = $data['position'];
			$fields = [

										'name' => $data['name'],
										'shopId' => $data['shopId'], 
										'created_at' => '',
										'updated_at' => '',
							];


						$send = $this->Hall->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Hall has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Hall was not added. Please try again later";
							endif;
		
  echo json_encode($result);

	
}
 





}