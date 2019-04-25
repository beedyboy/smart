<?php
/**
* 
*/
class TableController extends Controller
{
	
	public function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('HTable'); 

	}

	 
  
public function list()
{
	$data = [];
	$out = array('error' => false); 
		$shopId= $_GET['shopId'];
		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];
	$tables  = $this->HTable->find($params);

	$Hall = new Hall('halls');
	
	foreach($tables as $table):
	
	//$out['data'] =
	$row = array(
		'name'=> $Hall->findById($table->hid)->name,
		'hid'=> $table->hid,
		'tname'=>$table->name,
		'id'=>$table->id
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
	 
		//$out['data'] = $data['position'];
			$fields = [

										
										'name' => $data['name'],
										'shopId' => $data['shopId'], 
										'hid' => $data['hid'],
							];


						$send = $this->HTable->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Table has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Table was not added. Please try again later";
							endif;
		
  echo json_encode($result);

	
}
 





}