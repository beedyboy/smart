<?php
/**
*
*/
class UpdateController extends Controller
{

	public function __construct($controller, $action)
	{
		# code...
		parent::__construct($controller, $action);
		//$this->load_model('Shop');
		$this->_db = DB::getInstance();

	}

	public function list(){

	$Orderdetail = new Orderdetail('orderdetails');
	dnd($Orderdetail->get_columns());
	}



 public function update()
{
 

$query = $this->_db->query("ALTER TABLE `smartrestaurant`.`sales` 
ADD COLUMN `order_number` INT NULL DEFAULT 0 AFTER `invoice_number`");

//$query = $this->_db->query("ALTER TABLE `menus` ADD FOREIGN KEY (`kitchen`) REFERENCES `kitchens`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");


//$query = $this->_db->query("ALTER TABLE `orderdetails` ADD FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
//
//$query = $this->_db->query("ALTER TABLE `orderdetails` ADD `edited` ENUM('Yes','No') NULL DEFAULT
//																											'No' AFTER `approved_by`");

																											if($query): "DB updated"; endif;

}



}