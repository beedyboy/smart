<?php
/**
*
*/
class KitchenController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Kitchen');

		//if(!Auth::check()): Router::redirect('login'); endif;

	}

public function list()
{
	$data = [];
	$out = array('error' => false);

		$shopId= $_GET['shopId'];

		$params  = ['conditions'=> ['shopId = ?'], 'bind' => [$shopId] ];

  	$out['data'] =  $this->Kitchen->find($params);

	   echo json_encode($out);

  	die();

}





public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $name = $data['name'];
	  $shopId = $data['shopId'];
		 $type = $data['type'];

	$User = new User('users');

			//$loggedParams = [	 'conditions'=> ['shopId = ?', 'token = ?'], 'bind' => [$shopId, $token] ];
	$Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;
	$result['token'] = $token;
 $result['userid'] = $userId;
//  echo json_encode($result);
//	die();

			$fields = [
										'name' => $name,
										'base' => $type,
										'shopId' => $shopId,
										'created_by' => $userId,
										'created_at' => '',
							];

$params = [	 'conditions'=> ['shopId = ?', 'name = ?'], 'bind' => [$shopId, $name] ];
	$exist  = $this->Kitchen->find($params);


				if(count($exist) < 1):
						$send = $this->Kitchen->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Kitchen has been added successfully';

							else:

								$result['status'] = "Menu";
								$result['msg'] = "Error: Kitchen was not added. Please try again later";
							endif;
		 else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This Kitchen already exist. Please try again using different data";
				  		endif;
  echo json_encode($result);


}





 public function getDepartmentKitchens()
{
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$kitchen= $_GET['kitchen'];
		$params  = ['conditions'=> ['shopId = ?', 'kitchen = ?'], 'bind' => [$shopId, $kitchen] ];
	 $products  = $this->Kitchen->find($params);

  	$out['data'] = $products;

	   echo json_encode($out);

  	die();

}





public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $id = $data['id'];
	  $name = $data['name'];
	  $token = $data['token'];
		 $type = $data['type'];

	$User = new User('users');
 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;

 					$Kitchen = $this->Kitchen->findById((int)$id);


		   		if($Kitchen->name != $name || $Kitchen->base != $type )
							{

								$fields = [
										'name' => $name,
										'base' => $type,
										'updated_by' => $userId,
										'updated_at' => '',
							];
									$send = $this->Kitchen->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Kitchen has been updated successfully';

							else:

								$result['status'] = "error";
								$result['msg'] = "Error: Kitchen was not updated. Please try again later";
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
     * @return Kitchen
     *
     */
    public function destroy($id)
    {
       $del = $this->Kitchen->delete($id);
      if($del): echo "Kitchen Deleted Successfully"; else: "Error deleting this data... Please try again later"; endif;


    }


}