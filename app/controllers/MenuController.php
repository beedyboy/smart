<?php
/**
*
*/
class MenuController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Menu');


	}


public function list()
{
	$data = [];
	$datas = [];
	$out = array('error' => false);

		$User = new User('users');
		$Category = new Category('categories');
		$shopId= $_GET['shopId'];

		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];

	$menus  = $this->Menu->find($params);

	foreach($menus as $menu)
	{
			//$compute = explode(',',$menu->food);
			$row = array(
				'id'=>$menu->id,
				//'food'=> array_map('intval', $compute),
				'item'=>$menu->item,
				'price'=>$menu->price,
				'catId'=>$menu->catId,
				'catName'=>	$Category->findById($menu->catId)->name,
				'created_by'=>	$User->findById($menu->created_by)->fullname,
				'created_at'=>$menu->created_at,
				'updated_by'=>$User->findById($menu->updated_by)->fullname,
				'updated_at'=>$menu->updated_at
			);

				////print_r($compute);
				//	foreach($compute as $key=>$item):
				//
				//				$row['options'][] = $Product->findById((int)$item)->product_name ;
				//				$row['price'][] = $Product->findById((int)$item)->price ;
				//

					//endforeach;
					$data[]=$row;
	}

$out['data'] = $data;

	   echo json_encode($out);

  	die();

}





public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $shopId = $data['shopId'];
	  $item = $data['item'];
	  $catId = $data['category'];
	  $price = $data['price'];

	$User = new User('users');
	$Category = new Category('categories');

$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;

 $params = [	 'conditions'=> ['shopId = ?', 'item = ?', 'price = ?', 'catId = ?'], 'bind' => [$shopId, $item, $price, $catId] ];
	$exist  = $this->Menu->find($params);



	if(count($exist) < 1):
$kitchenId = $Category->findById($catId)->kitchenId;
		$fields = [
										'shopId' => $shopId,
										'item'=>$item,
										'price' => $price,
										'catId' => $catId,
										'kitchen' => $kitchenId,
										'created_at' => '',
										'created_by' => $userId
							];
						$send = $this->Menu->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Menu has been added successfully';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Menu was not added. Please try again later";
							endif;
		else:
				$result['status'] = "error";
		$result['msg'] = "Error: This menu item already exist. Please try again using different data";
			endif;
  echo json_encode($result);


}




/**
 * [edit function]
 * @param  [type] $id [primary key to be edited]
 * @return [type]     [view]
 */


public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

$id = $data['id'];
 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	 $token = $data['token'];
	  $shopId = $data['shopId'];
	  $item = $data['item'];
	  $catId = $data['category'];
	  $price = $data['price'];

	$User = new User('users');
	$Category = new Category('categories');
$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;


	$ary = [];
	 		$params = [	 'conditions'=> ['shopId = ?', 'item <> ?', 'catId <> ?'], 'bind' => [$shopId, $item, $catId] ];

	  $MenuList  = $this->Menu->find($params);
			$Menu = $this->Menu->findById((int)$id);

			foreach ($MenuList as $key => $value) {
					$ary[] = $value->id;
			}

				if($Menu->item != $item || $Menu->price != $price ||  $Menu->catId != $catId):


				if(!in_array( $id, $ary)):
$kitchenId = $Category->findById($catId)->kitchenId;
								$fields = [
															'shopId' => $data['shopId'],
															'item'=>$item,
															'price' => $price,
															'catId' => $catId,
															'kitchen' => $kitchenId,
															'updated_at' => '',
															'updated_by' => $userId
												];

												$send = $this->Menu->update($fields, (int)$id);
												if($send):

													$result['status'] = "success";
													$result['msg']  =   'Menu\'s record has been updated successfully';

												else:

													$result['status'] = "error";
													$result['msg'] = "Error: Menu\'s record was not updated. Please try again later";
												endif;
					else:
						$result['status'] = "error";
					$result['msg'] = "Error: This menu item may already exist. Please try again with a different one";
		endif;
		else:
				$result['status'] = "same";
								$result['msg']  =   'No changes made';
	endif;
  echo json_encode($result);


//$role = implode(",", $roleArray);
//
//
//							///search for all users with this new name
//		  $ary = [];
//	 			$params = [  'conditions'=> ['id <> ? '], 'bind' => [$id] ];
//
//	  $MenuList  = $this->Menu->find($params);
//			$Menu = $this->Menu->findById((int)$id);
//
//			foreach ($MenuList as $key => $value) {
//					$ary[] = $value->username;
//			}
//
//	//if the name exist, check the id. if the id is mine continue, ellse, the user exist
//		if($Menu->fullname != $fullname || $Menu->username != $username || $Menu->role != $role || $Menu->position != $position):
//
//
//				if(!in_array( $username, $ary)):
//					$fields = [
//										'fullname' => $fullname,
//										'username' => $username,
//										'role' => $role,
//										'position' => $position,
//									 	'updated_at' => '',
//							];
//
//
//				else:
//				  			$result['status'] = "error";
//								$result['msg'] = "Error: This username may already exist. Please try again with a different one";
//				 endif;
//				endif;
//
//  echo json_encode($result);


}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Menu
     *
     */
    public function destroy()
    {

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);
	$id = $data['id'];
	$status = "Deleted";
  $fields = [
										'acc_status' => $status,
									 	'updated_at' => '',
							];

				$send = $this->Menu->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Menu\'s record has been deleted successfully';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Menu\'s record was not deleted. Please try again later";
							endif;

  echo json_encode($result);


    }

//
//public function save(){
//
//	 $result = array();
//	$data = json_decode(file_get_contents("php://input"), TRUE);
//
//	  $token = $data['token'];
//
//	$User = new User('users');
//		$Product = new Product('products');
//$Query  = $User->findByToken($token);
//
//	if($Query):
//	$userId = $Query->id;
//
//	endif;
//$food = (empty($data['food'])) ? [] : $data['food'];
//
//$name= "";
//	foreach($data['food'] as $key=>$item):
//								$name.=$Product->findById((int)$item)->product_name.' with ';
//
// endforeach;
//
//array_walk($food, 'trim_value');
//$name = rtrim($name,' with');
//$food = implode(",", $food);
//
//			$fields = [
//										'shopId' => $data['shopId'],
//										'name' => $name,
//										'food' => $food,
//										'created_at' => '',
//										'created_by' => $userId
//							];
//
//						$send = $this->Menu->insert($fields);
//							if($send):
//
//								$result['status'] = "success";
//								$result['msg']  =   'New Menu has been added successfully';
//
//							else:
//
//								$result['status'] = "Menu";
//								$result['msg'] = "Error: Menu was not added. Please try again later";
//							endif;
//  echo json_encode($result);
//
//
//}
//
//

}
