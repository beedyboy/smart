<?php

/**
*
*/
class LoginController extends Controller
{

	public function __construct($controller, $action)
	{
		// dnd("i have been called");
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Staff');

		//$this->view->setLayout('default');

	}

	 public function authenticate()
 	{

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	$username = $data['username'];
	$password = $data['acc_password'];

						$Staff = $this->Staff->findByUsername($data['username']);

				if($Staff && password_verify($password, $Staff->acc_password) && $Staff->acc_status === "Active")
				{

					$remember = (isset($data['remember_me']) && $data['remember_me']) ? true : false;


				//$Staff->login($Staff->id,$remember);
							$id = $Staff->id;
							$token = $Staff->token;

							if($token === "" || $token === NULL):

							$hash = md5(uniqid() . rand(0, 100));
							$fields = ['token'=>$hash];
							$send = $this->Staff->update($fields, $id);


							$result['error'] = false;
							$result['status'] = "green";
							$result['msg'] = "Login Successful";
							$result['record'] = $this->Staff->findByUsername($data['username']);
							//$result['token'] = $hash; $area_privilege= explode(",", $loadPermit);

							else:

							$result['error'] = true;
							$result['status'] = "red";
							$result['msg'] = "Multiple logins: Shutdown other logins ";
							endif;

				}
				else
				{
					$result['error'] = true;
					$result['status'] = "yellow";
				 $result['msg'] = "Wrong username or password";
					$result['errorList'] = 	$this->validate->displayErrors();
				}


	echo json_encode($result);


 }


public function logout(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $fullname = $data['fullname'];

	$User = new User('users');
 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;

 					$Existing = $this->Staff->findById((int)$userId);


		   		if($Existing->token === $token || $Existing->fullname === $fullname  )
							{

								$fields = [				'token' => "" ];
									$send = $this->Staff->update($fields, (int)$userId);
							if($send):

								$result['status'] = "success";

							else:

								$result['status'] = "error";
								$result['msg'] = "Error: Logout was not successful. Please try again later";
							endif;

							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'Token mismatched. Please try again later';
							}


  echo json_encode($result);


}


}