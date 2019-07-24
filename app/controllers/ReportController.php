<?php
/**
*
*/
class ReportController extends Controller
{
	function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		//$this->load_model('User');
	}


 public function salesReport()
{
	$data  = [];

	$out = array('error' =>  false);
	$Sale = new Sale('sales');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  //$startDate =  date_format(date_create($_GET['startDate']),"Y-m-d H:i:s") ;
	  //$endDate =  date_format(date_create($_GET['endDate']),"Y-m-d H:i:s");
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	//$Seat = new Seat('seats');
	$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'period >= ? ',  'period <= ? '],
														'bind' => [$shopId, $startDate, $endDate] ];
	$Reports = $Sale->find($params);

$i= 0;
$totalAmount =  0;
foreach($Reports as $Report):
$children = $Beedy->getInvoiceItems($Report->invoice_number,$shopId);
$totalAmount += round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2);
	$row = array(
		'key'=>'key'.$i,
		'id'=>$Report->id,
		'invoice_number'=>$Report->invoice_number,
		'order_number'=> $Report->order_number,
		'amount'=> round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2),
		'status'=> $Report->status,
		'period'=> $Report->period,
	'balance'=>$Report->balance,
		'table'=> $Table->findById($Report->tid)->name,
	'ord_type'=>$Report->ord_type,
	'waiter'=>	$User->findById($Report->waiter)->fullname,
	'cashier'=>	$User->findById($Report->cashier)->fullname,
		'created_at'=>$Report->created_at,
		'created_by'=>	$User->findById($Report->created_by)->fullname,
		'updated_by'=>$User->findById($Report->updated_by)->fullname,
		'updated_at'=>$Report->updated_at,
		//'children'=>$children
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
	 	$out['totalAmount'] = $totalAmount;
    echo json_encode($out);

   

}






 public function salesTrailReport()
{
	$data  = [];

	$out = array('error' =>  false);
	$Sale = new SalesTrail('salesTrails');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	$Seat = new Seat('seats');
	$User = new User('users');

		$params  = ['conditions'=> ['shopId = ? ',  'period >= ? ',  'period <= ? '],
														'bind' => [$shopId, $startDate, $endDate] ];
	$Reports = $Sale->find($params);

$i= 0;
foreach($Reports as $Report):

	$row = array(
		'key'=>'key'.$i,
		'id'=>$Report->id,
		'invoice_number'=>$Report->invoice_number,
		'order_number'=> $Report->order_number,
		'amount'=> round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2),
 	'status'=> $Report->status,
		'period'=> $Report->period,
	'balance'=>$Report->balance,
		'table'=> $Table->findById($Report->tid)->name,
	'ord_type'=>$Report->ord_type,
	'waiter'=>	$User->findById($Report->waiter)->fullname,
	'cashier'=>	$User->findById($Report->cashier)->fullname,
		'created_at'=>$Report->created_at,
		'created_by'=>	$User->findById($Report->created_by)->fullname,
		'updated_by'=>$User->findById($Report->updated_by)->fullname,
		'updated_at'=>$Report->updated_at
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	 

}









public function departmentReport()
{
	$data  = [];

	$out = array('error' =>  false);
	$Sale = new Sale('sales');
	$Menu = new Menu('menus');
	$Category = new Category('categories');
	$Kitchen = new Kitchen('kitchens');
	$Orderdetail = new Orderdetail('orderdetails');

	  $startDate = $_GET['startDate'];
	  $endDate = $_GET['endDate'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();
	$Table = new HTable('htables');
	$User = new User('users');


$sales_order = array();
  $price_order = array();
$nhil_price = array();
  $fund_price = array();
$vat_price = array();


		$params  = ['conditions'=> ['shopId = ? ',  'period >= ? ',  'period <= ? '],
														'bind' => [$shopId, $startDate, $endDate] ];
	$InvoiceList = $Sale->find($params);


		foreach($InvoiceList as $LIST):

			$invoice = $LIST->invoice_number;
		//get products under this invoice
		//count each product

				$OrderParams  = ['conditions'=> ['shopId = ?', 'invoice = ?'], 'bind' => [$shopId, $invoice] ];

				//check order details based on invoice
			$Orders =  $Orderdetail->find($OrderParams);

				//loop through the order
								foreach($Orders as $Order):
								//while($Order = $Orders->fetch()){

											if(array_key_exists(  $Order->menu_id , $sales_order) ):

															$sales_order[ $Order->menu_id] += $Order->qty;
															$price_order[  $Order->menu_id] += $Order->total;
															$nhil_price[  $Order->menu_id] += $Order->nhil;
															$fund_price[ $Order->menu_id] += $Order->fund;
															$vat_price[  $Order->menu_id] += $Order->vat;


										else:
														$sales_order[  $Order->menu_id]  = $Order->qty;
														$price_order[ $Order->menu_id]  = $Order->total;
														$nhil_price[  $Order->menu_id] = $Order->nhil;
															$fund_price[ $Order->menu_id] = $Order->fund;
															$vat_price[  $Order->menu_id] = $Order->vat;

											endif;
								//}
								endforeach;
	endforeach;



$total_qty = 0;
$total_amount = 0;

$i= 0;
foreach($sales_order as $key => $val){
$p =  $Beedy->getColById($Menu,   $key, 'item') ;
$main =  $Beedy->getColById($Kitchen, $Beedy->getColById($Category, $Beedy->getColById($Menu, $key, 'catId'), 'kitchenId'), 'name') ;
//$left =  $Beedy->getColById($Menu, $key, 'qty');

	$row = array(
		'key'=>'key'.$i,
		'menu_id'=> $Order->menu_id,
		'menu_name'=> $p,
	 'sold'=>$val,
	 'kitchen'=>$main,
		'normalPrice'=>round($price_order[$key],2),
		'price'=>round($nhil_price[$key] + $fund_price[$key] + $vat_price[$key] + $price_order[$key],2)
	);

	$data[]=$row;

	$i+=1;
}

 	$out['data'] = $data;

	 	$out['sales'] = $sales_order; //qty per products
	 	$out['price'] = $price_order;
    echo json_encode($out);

  	die();

}




 public function staffReport()
{
	 $data  = [];

	$out = array('error' =>  false);
	$Sale = new Sale('sales');

	  $staff = $_GET['staff'];
	  $shopId = $_GET['shopId'];

	$Beedy = new Beedy();

		$params  = ['conditions'=> ['shopId = ? ',  'created_by= ? '],
														'bind' => [$shopId, $staff] ];
	$Reports = $Sale->find($params);

$i= 0;
foreach($Reports as $Report):

	$row = array(
		'key'=>'key'.$i,
		'id'=>$Report->id,
		'invoice_number'=>$Report->invoice_number,
		'amount'=> round($Report->amount + $Report->nhil + $Report->fund + $Report->vat,2),
		'status'=> $Report->status,
		'period'=> $Report->period,
	'ord_type'=>$Report->ord_type,
		//'kitchen'=>$Report->kitchen
	);

	$data[]=$row;
	$i+=1;
	endforeach;

	 	$out['data'] = $data;
    echo json_encode($out);

  	die();

}








}
