<?php
/**
*
*/
class ShopController extends Controller
{

	public function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Shop');

	}

 public function list()
{
	$data = [];
	$out = array('error' => false);
	$shops  = $this->Shop->find();

  	$out['data'] = $shops;

	   echo json_encode($out);

  	die();

}



public function getShopDetails()
{
$data  = [];
	$out = array('error' => false);
	  $shopId = $_GET['shopId'];
			$params = [	'conditions'=> ['id = ?'], 'bind' => [$shopId] ];
					$LIST = $this->Shop->find($params);

	 	$out['data'] = $LIST;
    echo json_encode($out);

  	die();
}

public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

$Beedy = new Beedy();
$User = new User('users');
$Application = new Application('applications');
$total = $Beedy->	totalShop();
if($total < 3)
{

			$fields = [
										'shopName' => $data['shopName'],
										'shopPhoneNum' => $data['shopPhoneNum'],
										'shopEmail' => $data['shopEmail'],
										'address' => $data['address']
							];


  $ary = [];

	  $UserList  = $User->find();
			foreach ($UserList as $key => $value) {
					$ary[] = $value->username;
			}

			if(!in_array( $data['username'], $ary)):


						$send = $this->Shop->insert($fields);
							if($send):

$role = "addSales,editSales,delSales, addUser,editUser,delUser,addMenu,editMenu,delMenu,
editSupplier,addSupplier,delSupplier,addHall,editHall,delHall, addSeat,editSeat,delSeat,
addTable,editTable,delTable,addPurchases,editPurchases,delPurchases,addFinished,
editAllocation,addToKitchen";
 $role=preg_replace('#\s+#','',trim($role));
					$fields2 = [
										'fullname' => $data['fullname'],
										'shopId' => $this->Shop->lastId(),
										'username' => $data['username'],
										'role' => $role,
										'position' => 'Super Admin',
										'acc_password' => password_hash($data['acc_password'], PASSWORD_DEFAULT),
										'created_at' => '',
										'updated_at' => '',
							];

					$settings= [
										'shopId' => $this->Shop->lastId()
							];

						  $User->insert($fields2);
								$send2 = $Application->insert($settings);
								if($send2):
								$result['status'] = "success";
								$result['msg']  =   'New Shop has been created successfully';

							else:

								$result['status'] = "error";
								$result['msg'] = "Error: Shop was not created. Please try again later";
							endif;
							endif;
 	else:
				  			$result['status'] = "error";
								$result['msg'] = "Error: This username may already exist. Please try again with a different one";
				 endif;
}

else {

								$result['status'] = "error";
								$result['msg'] = "Error: Maximum number of shops reached";

	}

  echo json_encode($result);


}






}