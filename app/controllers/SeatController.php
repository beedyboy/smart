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


public function getSeatByTable()
{

		$data = [];
	$out = array('error' => false);
	$shopId= $_GET['shopId'];
	$tid= $_GET['tid'];
		$params  = ['conditions'=> ['shopId = ? ', 'tid = ?'], 'bind' => [$shopId,$tid] ];

			//find all tables with shopId

			$seats = $this->Seat->find($params);


			$out['data'] = $seats;

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
		'hid'=> $tables->findById($seat->tid)->hid,
		'tname'=> $tables->findById($seat->tid)->name,
		'tid'=>$seat->tid,
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


$params = [	 'conditions'=> ['shopId = ?', 'name = ?', 'tid = ?'], 'bind' => [$data['shopId'], $data['seat'],$data['tid']] ];
	$exist  = $this->Seat->find($params);

				if(count($exist) < 1):
						$send = $this->Seat->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Seat has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Seat was not added. Please try again later";
							endif;
	else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This seat already exist under this table. Please try again using different data";
				  		endif;

  echo json_encode($result);


}



public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	   $tid = $data['tid'];
	 $name =  $data['name'];
	  $id = $data['id'];
	$Beedy = new Beedy();

 $Seat = $this->Seat->findById((int)$id);

	 if($Seat->name != $name || $Seat->tid != $tid)
 	{
			$fields = [
					'name' => $name,
					'tid' => $tid
		];
					$send = $this->Seat->update($fields, (int)$id);
			if($send):

				$result['status'] = "success";
				$result['msg']  =   'Seat has been updated successfully';

			else:

				$result['status'] = "db_error";
				$result['msg'] = "Error: Seat was not updated. Please try again later";
			endif;
		}
		else{
				$result['status'] = "same";
			$result['msg']  =   'No changes made';
		}


  echo json_encode($result);


}





}