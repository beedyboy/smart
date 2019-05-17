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
	 $hid = $data['hid'];
	 $name =  $data['name'];
  $Hall = new Hall('halls');
	$Beedy = new Beedy();
  $number = 	substr($Beedy->getColById($Hall, $hid, 'name'), 0,3)."-".$name;
			$fields = [
										'name' => $number,
										'shopId' => $data['shopId'],
										'hid' => $hid,
							];


$params = [	 'conditions'=> ['shopId = ?', 'name = ?', 'hid = ?'], 'bind' => [$data['shopId'],$number, $hid] ];
	$exist  = $this->HTable->find($params);

				if(count($exist) < 1):
						$send = $this->HTable->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Table has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Table was not added. Please try again later";
							endif;
	else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This table already exist under this zone. Please try again using different data";
				  		endif;

  echo json_encode($result);


}




public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	   $hid = $data['hid'];
	 $name =  $data['name'];
	  $id = $data['id'];
  $Hall = new Hall('halls');
	$Beedy = new Beedy();
  $number = 	substr($Beedy->getColById($Hall, $hid, 'name'), 0,3)."-".$name;


							$HTable = $this->HTable->findById((int)$id);

		   		if($HTable->name != $name || $HTable->hid != $hid)
							{
								$fields = [
										'name' => $number,
										'hid' => $hid
							];
									$send = $this->HTable->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Table has been updated successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Table was not updated. Please try again later";
							endif;
							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'No changes made';
							}


  echo json_encode($result);


}











}
//
//RewriteEngine On
//
//RewriteCond %{REQUEST_FILENAME} !-d
//RewriteCond %{REQUEST_FILENAME} !-f
//RewriteCond $1 !^(config|core|sms|resources|robots\.txt)
//
//
//RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]