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

$params = [	 'conditions'=> ['shopId = ?', 'name = ?'], 'bind' => [$data['shopId'], $data['name']] ];
	$exist  = $this->Hall->find($params);

				if(count($exist) < 1):
						$send = $this->Hall->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Hall has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Hall was not added. Please try again later";
							endif;
	else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This zone already exist. Please try again using different data";
				  		endif;
  echo json_encode($result);


}





public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $name = $data['name'];
	  $id = $data['id'];

	$User = new User('users');
 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;
	endif;
$ary = [];
	$params = [  'conditions'=> ['id <> ? '], 'bind' => [$id] ];

	  $HallList  = $this->Hall->find($params);
			foreach ($HallList as $key => $value) {
					$ary[] = $value->name;
			}
							$Hall = $this->Hall->findById((int)$id);

		   		if($Hall->name != $name)
							{
									if(!in_array( $name, $ary)):
										$fields = [
												'name' => $name,
												//'updated_by' => $userId,
												'updated_at' => '',
									];
													$send = $this->Hall->update($fields, (int)$id);
											if($send):

												$result['status'] = "success";
												$result['msg']  =   'Hall has been updated successfully';

											else:

												$result['status'] = "db_error";
												$result['msg'] = "Error: Hall was not updated. Please try again later";
											endif;
									else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This zone already exist. Please try again using different data";
				  		endif;
							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'No changes made';
							}


  echo json_encode($result);


}







}