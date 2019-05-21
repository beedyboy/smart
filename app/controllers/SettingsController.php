<?php
/**
*
*/
class SettingsController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Application');

		 // if(!Auth::check()): Router::redirect('auth/login'); endif;

	}



 public function getSystemSettings()
{

	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$User = new User('users');
		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];

	$Value =  $this->Application->find($params);

	foreach($Value as $Basket):

	$row = array(
		'id'=>$Basket->id,
		'currency'=>$Basket->currency,
		'updated_by'=>$User->findById($Basket->updated_by)->fullname,
		'updated_at'=>$Basket->updated_at
	);

	$data[]=$row;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();
}




public function update()
{

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	$User = new User('users');
		$currency = $data['currency'];
		$token = $data['token'];
		$id = $data['id'];

 	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;
	endif;

				$fields = [
										'currency' => $currency,
									 	'updated_by' => $userId,
									 	'updated_at' => '',
								];

	$send = $this->Application->update($fields, (int)$id);

		   			//check if updated
		   			if($send)
		   			{
							$result['status'] = "success";
							$result['msg']  =   'Settings has been updated successfully';

		   			}
		   			else
		   			{
		   				$result['status'] = "Menu";
		   				$result['msg'] = "Error: Settings was not saved. Please try again later";
		   			}

		   echo json_encode($result);


 //update ends down here
}


}