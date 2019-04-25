<?php
/**
* 
*/
class SeatController extends Controller
{
	
	public function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Seat'); 

	}


public function getTableByHall()
{
 
		$data = [];
	$out = array('error' => false); 
	$shopId= $_GET['shopId'];
	$hid= $_GET['hid'];
		$params  = ['conditions'=> ['shopId = ? ', 'hid = ?'], 'bind' => [$shopId,$hid] ];
		
			$Table = new HTable('htables');
			
			//find all tables with shopId
			
			$tables = $Table->find($params);
		 
			
			$out['data'] = $tables;

	   echo json_encode($out);

  	die();
	 
}
  
public function list()
{
	$data = [];
	$out = array('error' => false); 
		$shopId= $_GET['shopId'];
		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];
	$seats  = $this->Seat->find($params);

	$tables = new HTable('htables');
	
	foreach($seats as $seat):
	 
	$row = array(
		'tid'=> $tables->findById($seat->tid)->name, 
		'name'=>$seat->name,
		'id'=>$seat->id
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
	  
			$fields = [
										'name' => $data['seat'],
										'shopId' => $data['shopId'], 
										'tid' => $data['tid'],
							];


						$send = $this->Seat->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Seat has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Seat was not added. Please try again later";
							endif;
		
  echo json_encode($result);

	
}
 





}