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

		$shopId= $_GET['shopId'];

		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];

	$user  = $this->User->find($params);

  	$out['data'] = $user;

	   echo json_encode($out);

  	die();

}




public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

$sales = (empty($data['sales'])) ? [] : $data['sales'];
$user = (empty($data['user'])) ? [] :$data['user'] ;
$menu = (empty($data['menu'])) ? [] : $data['menu'];
$supplier = (empty($data['supplier'])) ? [] : $data['supplier'];
$hall = (empty($data['hall'])) ? [] : $data['hall'];
$seat = (empty($data['seat'])) ? [] : $data['seat'];

$table = (empty($data['table'])) ? [] : $data['table'];
$purchases = (empty($data['purchases'])) ? [] : $data['purchases'];
$acquisition = (empty($data['acquisition'])) ? [] : $data['acquisition'];


$roleArray = array_merge($sales,$user, $menu,$supplier,$hall,$seat, $table, $purchases, $acquisition);
$ary = [];

	  $UserList  = $this->User->find();

			foreach ($UserList as $key => $value) {
					$ary[] = $value->username;
			}
				if(!in_array( $data['username'], $ary)):

$role = implode(",", $roleArray);

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
else:
				  			$result['status'] = "error";
								$result['msg'] = "Error: This username may already exist. Please try again with a different one";
				 endif;
  echo json_encode($result);


}

#endregion


/**
 * [edit function]
 * @param  [type] $id [primary key to be edited]
 * @return [type]     [view]
 */


public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

$sales = (empty($data['sales'])) ? [] : $data['sales'];
$user = (empty($data['user'])) ? [] :$data['user'] ;
$menu = (empty($data['menu'])) ? [] : $data['menu'];
$supplier = (empty($data['supplier'])) ? [] : $data['supplier'];
$hall = (empty($data['hall'])) ? [] : $data['hall'];
$seat = (empty($data['seat'])) ? [] : $data['seat'];

$table = (empty($data['table'])) ? [] : $data['table'];
$purchases = (empty($data['purchases'])) ? [] : $data['purchases'];
$acquisition = (empty($data['acquisition'])) ? [] : $data['acquisition'];
$username = $data['username'];
$fullname = $data['fullname'];
$position = $data['position'];
$id = $data['id'];


$roleArray = array_merge($sales,$user, $menu,$supplier,$hall,$seat, $table, $purchases, $acquisition);

$role = implode(",", $roleArray);
		//$out['data'] = $data['position'];


							///search for all users with this new name
		  $ary = [];
	 			$params = [  'conditions'=> ['id <> ? '], 'bind' => [$id] ];

	  $UserList  = $this->User->find($params);
			$User = $this->User->findById((int)$id);

			foreach ($UserList as $key => $value) {
					$ary[] = $value->username;
			}

	//if the name exist, check the id. if the id is mine continue, ellse, the user exist
		if($User->fullname != $fullname || $User->username != $username || $User->role != $role || $User->position != $position):


				if(!in_array( $username, $ary)):
					$fields = [
										'fullname' => $fullname,
										'username' => $username,
										'role' => $role,
										'position' => $position,
									 	'updated_at' => '',
							];

						$send = $this->User->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'User\'s record has been updated successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: User\'s record was not updated. Please try again later";
							endif;
				else:
				  			$result['status'] = "error";
								$result['msg'] = "Error: This username may already exist. Please try again with a different one";
				 endif;
				endif;

  echo json_encode($result);


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
