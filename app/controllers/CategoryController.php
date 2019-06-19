<?php
/**
*
*/
class CategoryController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Category');

		//if(!Auth::check()): Router::redirect('login'); endif;

	}

public function list()
{
	$data = [];
	$out = array('error' => false);
	$Kitchen = new Kitchen('kitchens');

		$shopId= $_GET['shopId'];

		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];

  	$Data =  $this->Category->find($params);

	foreach($Data as $cat):
			$row = array(
				'kitchenId'=> $cat->kitchenId,
				'kitchen_name'=> $Kitchen->findById($cat->kitchenId)->name,
				'name'=>$cat->name,
				'date'=>$cat->created_at,
				'id'=>$cat->id
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

	  $token = $data['token'];
	  $kitchenId = $data['kitchenId'];
	  $name = $data['name'];
	  $shopId = $data['shopId'];

	$User = new User('users');
	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;
	$result['token'] = $token;
 $result['userid'] = $userId;

			$fields = [
										'name' => $name,
										'kitchenId' => $kitchenId,
										'shopId' => $shopId,
										'created_by' => $userId,
										'created_at' => '',
							];

$params = [	 'conditions'=> ['shopId = ?', 'name = ?', 'kitchenId = ?'], 'bind' => [$shopId, $name, $kitchenId] ];
	$exist  = $this->Category->find($params);


				if(count($exist) < 1):
						$send = $this->Category->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Category has been added successfully';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Category was not added. Please try again later";
							endif;
		 else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This Category already exist. Please try again using different data";
				  		endif;
  echo json_encode($result);


}



public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $kitchenId = $data['kitchenId'];
	  $name = $data['name'];
	  $id = $data['id'];

	$User = new User('users');
 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;

 					$Category = $this->Category->findById((int)$id);


		   		if($Category->name != $name )
							{

								$fields = [
										'name' => $name,
										'kitchenId' => $kitchenId,
										'updated_by' => $userId,
										'updated_at' => '',
							];
									$send = $this->Category->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Category has been updated successfully';

							else:

								$result['status'] = "error";
								$result['msg'] = "Error: Category was not updated. Please try again later";
							endif;

							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'No changes made';
							}


  echo json_encode($result);


}



  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Category
     *
     */
    public function destroy($id)
    {
       $del = $this->Category->delete($id);
      if($del): echo "Category Deleted Successfully"; else: "Error deleting this data... Please try again later"; endif;


    }


}