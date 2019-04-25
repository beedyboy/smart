<?php
/**
*
*/
class UserController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('User');


	}

public function list()
{
	$data = [];
	$out = array('error' => false);
	$user  = $this->User->find();

  	$out['data'] = $user;

  	header('Access-Control-Allow-Origin: *');
  	header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
  	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
 	   header("Content-type: application/json");
	   echo json_encode($out);

  	die();

}




public function save(){
//	header('Access-Control-Allow-Origin: *');
//  	header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
//  	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// 	   header("Content-type: application/json");
					
	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	
$sales = (empty($data['sales'])) ? [] : $data['sales'];
$user = (empty($data['user'])) ? [] :$data['user'] ;
$menu = (empty($data['menu'])) ? [] : $data['menu'];
$supplier = (empty($data['supplier'])) ? [] : $data['supplier'];
$hall = (empty($data['hall'])) ? [] : $data['hall'];
$seat = (empty($data['seat'])) ? [] : $data['seat'];


$roleArray = array_merge($sales,$user, $menu,$supplier,$hall,$seat);

$role = implode(",", $roleArray);
		//$out['data'] = $data['position'];
			$fields = [

										'fullname' => $data['fullname'],
										'shopId' => $data['shopId'],
										'acc_email' => Input::get('acc_email'),
										'username' => $data['username'],
										'role' => $role,
										'position' => $data['position'],
										'acc_password' => password_hash($data['acc_password'], PASSWORD_DEFAULT),
										'created_at' => '',
										'updated_at' => '',
							];


						$send = $this->User->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New User has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: User was not added. Please try again later";
							endif;
		
  echo json_encode($result);

	
}
 
#endregion

 
/**
 * [edit function]
 * @param  [type] $id [primary key to be edited]
 * @return [type]     [view]
 */
public function edit($id)
{
	$this->view->data = $this->User->findById($id);
	 $this->view->displayErrors = $this->validate->displayErrors();
		$this->view->extra('client/edit');
}

    public function update()
    {
       if($_POST)
        {

					$data = array();
					$validation = new validate();

										$validation->check($_POST, [

																							'acc_first_name'=> [
																							'display'=> 'First Name',
																							'max' => 30,
																							'required'=> true
																									],

																							'acc_last_name'=> [
																							'display'=> 'Last Name',
																							'max' => 30,
																							'required'=> true
																							],

																							'acc_email'=> [
																							'display'=> 'Email',
																							'required'=> true,
																							'max' => 50,
																							'valid_email' => true
																							],

																							'acc_phone'=> [
																							'display'=> 'Phone Number',
																							'required'=> true,
																							'max'=> 20
																							],


																					]);


								if($validation->passed())
								{

									$fields = [

									'acc_first_name' => Input::get('acc_first_name'),
									'acc_last_name' => Input::get('acc_last_name'),
									'acc_email' => Input::get('acc_email'),
									'gender' => Input::get('gender'),
									'acc_phone' => Input::get('acc_phone'),
									'updated_at' => ''
													];

					 				 $ary = [];
										$params = [  'conditions'=> ['id <> ? '], 'bind' => [Input::get('id')] ];

										$existing = $this->User->find($params);
							    	$User = $this->User->findById((int)Input::get('id'));

										foreach ($existing as $key => $value)
										 {
												$ary[] = $value->acc_email;
										 }


								if($User->acc_first_name != Input::get('acc_first_name') || $User->gender != Input::get('gender') || $User->acc_email != Input::get('acc_email') || $User->acc_last_name != Input::get('acc_last_name')):

										if(!in_array( Input::get('acc_email'), $ary)):
												$send = $this->User->update($fields, (int)Input::get('id'));

												if($send):
														$data['status'] = "success";
														$data['msg']  =   'User record updated successfully';
												else:
												$data['status'] = "db_error";
												$data['msg'] = "Error: User was not updated. Please try again later";
												endif;

										else:
														$data['status'] = "error";
														$data['msg'] = "Error: This User email may already exist. Please try again with a different one";
										endif;
								endif;
						 	}
							else
							{
									$data['status'] = "val_error";
									$data['msg'] = $validation->displayErrors();
							}


								unset($_POST);
								echo json_encode($data);

	  }
  }
 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return User
     *
     */
    public function destroy($id)
    {
       $del = $this->User->delete($id);
      if($del): echo "User Deleted Successfully"; else: "Error deleting this data... Please try again later"; endif;


    }


}
