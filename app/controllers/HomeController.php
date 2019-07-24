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
		'supplier'=>$Beedy->totalSupplier($shopId),
		'shop'=>$Beedy->totalShop()
	);

	$data[]=$row;

 	$out['data'] = $row;
	 echo json_encode($out);
}


public function topProduct()
{
	$data  = [];
	$data2  = [];
	$date = date("Y-m-d");
	$out = array('error' =>  false);
	$Sale = new Sale('sales');
	$Menu = new Menu('menus');
	$Orderdetail = new Orderdetail('orderdetails');


	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();


$sales_order = array();
  $price_order = array();

//get all orders
 //$params  = ['conditions'=> ['shopId = ? ',  'period = ? '], 'bind' => [$shopId, $date] ];
$params  = ['conditions'=> ['shopId = ? '], 'bind' => [$shopId] ];
 $InvoiceList = $Sale->find($params);

//for each other, extract menu
	foreach($InvoiceList as $LIST):
			$invoice = $LIST->invoice_number;

				//count each product
		$OrderParams  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];
		//check order details based on invoice
		$Orders =  $Orderdetail->find($OrderParams);
		//loop through the order
		 foreach($Orders as $Order):
		 //check whether menu already exist in the array
			if(array_key_exists(  $Order->menu_id , $sales_order) ):
				$sales_order[$Order->menu_id] += $Order->qty;

		   else:
				$sales_order[$Order->menu_id]  = $Order->qty;
		  endif;
			endforeach;
	endforeach;

arsort($sales_order);
$largest = array_slice($sales_order, 0, 10, true);
$topFour = array_slice($sales_order, 0, 4, true);
//dnd($topFour);

$total_qty = 0;
$total_amount = 0;

$labels = [];
$datasetsData = [];
$i= 1;
foreach($topFour as $key => $val){
$p =  $Beedy->getColById($Menu,   $key, 'item') ;

 array_push($datasetsData, $val );
array_push($labels, wrap($p) );
	$row = array( 
	  wrap($p) 
	  	);

	$data[]=$row;

	$i+=1;
}

$dataArr = array(
		'labels'=> $labels,
		'datasets'=> [array(
					 'label'=> 'Top Four Menu',
    'backgroundColor'=> 'rgba(255,99,132,0.2)',
    'borderColor'=> 'rgba(255,99,132,1)',
    'borderWidth'=> 1,
    'hoverBackgroundColor'=> 'rgba(255,99,132,0.4)',
    'hoverBorderColor'=> 'rgba(255,99,132,1)',
				'data'=>$datasetsData
		)]
);
 
//add top 10

$j= 1;
foreach($largest as $key => $val){
	//echo $key.' - '.$val."<br/>";
$p =  $Beedy->getColById($Menu,   $key, 'item') ;
 //$left =  $Beedy->getColById($Menu, $key, 'qty');

	$row = array(
		'key'=>$i,
		'menu_name'=> wrap($p),
		'sold'=>(int)$val,
	  	);

	$data2[]=$row;

	$j+=1;
}

//add the
 	$out['data'] = $dataArr;

	 	$out['top'] = $data2; //qty per products
    echo json_encode($out);

  	die();

}






public function topProducts()
{
	$data  = [];
	$data2  = [];
	$date = date("Y-m-d");
	$out = array('error' =>  false);
	$Sale = new Sale('sales');
	$Menu = new Menu('menus');
	$Orderdetail = new Orderdetail('orderdetails');


	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();


$sales_order = array();
  $price_order = array();

//get all orders
 //$params  = ['conditions'=> ['shopId = ? ',  'period = ? '], 'bind' => [$shopId, $date] ];
$params  = ['conditions'=> ['shopId = ? '], 'bind' => [$shopId] ];
 $InvoiceList = $Sale->find($params);

//for each other, extract menu
	foreach($InvoiceList as $LIST):
			$invoice = $LIST->invoice_number;

				//count each product
		$OrderParams  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];
		//check order details based on invoice
		$Orders =  $Orderdetail->find($OrderParams);
		//loop through the order
		 foreach($Orders as $Order):
		 //cehck whether menu already exist in the array
			if(array_key_exists(  $Order->menu_id , $sales_order) ):
				$sales_order[$Order->menu_id] += $Order->qty;

		   else:
				$sales_order[$Order->menu_id]  = $Order->qty;
		  endif;
			endforeach;
	endforeach;

arsort($sales_order);
$largest = array_slice($sales_order, 0, 10, true);
$topFour = array_slice($sales_order, 0, 4, true);
//var_dump($largest);

$total_qty = 0;
$total_amount = 0;

$i= 1;
foreach($topFour as $key => $val){
	//echo $key.' - '.$val."<br/>";
$p =  $Beedy->getColById($Menu,   $key, 'item') ;
 //$left =  $Beedy->getColById($Menu, $key, 'qty');

	$row = array(
		'key'=>$i,
		'label'=> wrap($p),
		'sold'=>(int)$val,
	  	);

	$data[]=$row;

	$i+=1;
}

//add top 10

$j= 1;
foreach($largest as $key => $val){
	//echo $key.' - '.$val."<br/>";
$p =  $Beedy->getColById($Menu,   $key, 'item') ;
 //$left =  $Beedy->getColById($Menu, $key, 'qty');

	$row = array(
		'key'=>$i,
		'menu_name'=> wrap($p),
		'sold'=>(int)$val,
	  	);

	$data2[]=$row;

	$j+=1;
}

//add the
 	$out['data'] = $data;

	 	$out['top'] = $data2; //qty per products
    echo json_encode($out);

  	die();

}






public function dashboard(){
	$this->view->render("home/dashboard");

}
}