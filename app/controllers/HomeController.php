<?php
/**
*
*/
class HomeController extends Controller
{

	public function __construct($controller, $action)
	{

		# code...
		parent::__construct($controller, $action);

		$this->view->setLayout('app');

 		//Auth::isLoggedIn();
	}

public function getSystemStat()
{
	$data = [];
	$out = array('error' => false);
	$Beedy = new Beedy();
	$shopId= $_GET['shopId'];

	$row = array(
		'user'=>$Beedy->totalUser($shopId),
		'product'=>$Beedy->totalProduct($shopId),
		'supplier'=>$Beedy->totalSupplier($shopId)
	);

	$data[]=$row;

 	$out['data'] = $row;
	 echo json_encode($out);
}

public function dashboard(){
	$this->view->render("home/dashboard");

}
}