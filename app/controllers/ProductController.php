<?php
/**
*
*/
class ProductController extends Controller
{

	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		$this->load_model('Product');

		//if(!Auth::check()): Router::redirect('login'); endif;

	}




public function getProductByKitchen()
{

		$data = [];
	$out = array('error' => false);
	$shopId= $_GET['shopId'];
	$kitchen= $_GET['kitchen'];
		$params  = ['conditions'=> ['shopId = ? ', 'kitchen = ?'], 'bind' => [$shopId,$kitchen] ];

			//find all tables with shopId

			$products = $this->Product->find($params);


			$out['data'] = $products;

	   echo json_encode($out);

  	die();

}

public function save(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $product_name = $data['product_name'];
	  $kitchen = $data['kitchen'];
	  $shopId = $data['shopId'];

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
										'product_name' => $product_name,
										'kitchen' => $kitchen,
										'price' => $data['price'],
										'shopId' => $shopId,
										'created_by' => $userId,
										'created_at' => '',
							];

$params = [	 'conditions'=> ['shopId = ?', 'product_name = ?', 'kitchen = ?'], 'bind' => [$shopId, $product_name, $kitchen] ];
	$exist  = $this->Product->find($params);


				if(count($exist) < 1):
						$send = $this->Product->insert($fields);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'New Product has been added successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Product was not added. Please try again later";
							endif;
		 else:
				  			$result['status'] = "error";
							$result['msg'] = "Error: This product already exist. Please try again using different data";
				  		endif;
  echo json_encode($result);


}




 public function getDepartmentProducts()
{
	$data = [];
	$out = array('error' => false);
		$shopId= $_GET['shopId'];
		$kitchen= $_GET['kitchen'];
		$params  = ['conditions'=> ['shopId = ?', 'kitchen = ?'], 'bind' => [$shopId, $kitchen] ];
	 $products  = $this->Product->find($params);

  	$out['data'] = $products;

	   echo json_encode($out);

  	die();

}





public function update(){

	 $result = array();
	$data = json_decode(file_get_contents("php://input"), TRUE);

	  $token = $data['token'];
	  $product_name = $data['product_name'];
	  $kitchen = $data['kitchen'];
	  $id = $data['id'];

	$User = new User('users');
 $Query  = $User->findByToken($token);

	if($Query):
	$userId = $Query->id;

	endif;



							$Product = $this->Product->findById((int)$id);

		   		if($Product->product_name != $product_name || $Product->price != $data['price'])
							{
								$fields = [
										'product_name' => $product_name,
										'kitchen' => $kitchen,
										'price' => $data['price'],
										'updated_by' => $userId,
										'updated_at' => '',
							];
									$send = $this->Product->update($fields, (int)$id);
							if($send):

								$result['status'] = "success";
								$result['msg']  =   'Product has been updated successfully';

							else:

								$result['status'] = "db_error";
								$result['msg'] = "Error: Product was not updated. Please try again later";
							endif;
							}
							else{
									$result['status'] = "same";
								$result['msg']  =   'No changes made';
							}


  echo json_encode($result);


}





public function minusProduct($id, $qty){

	 $result = array();

		 $pQty = $this->Product->findById((int)$id)->qty; //initial qty
			//if i have 2 items before and wanna make it five
			//updated qty should be 3

$updQty =  $pQty - $qty; // this means 5 - 2

		if($updQty >= 0) {

									$fields = [ 'qty' => $qty ];

									$send = $this->Product->update($fields, (int)$id);

							}


}








  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Product
     *
     */
    public function destroy($id)
    {
       $del = $this->Product->delete($id);
      if($del): echo "Product Deleted Successfully"; else: "Error deleting this data... Please try again later"; endif;


    }


}