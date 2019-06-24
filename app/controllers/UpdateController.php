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
 public function list()
{
ALTER TABLE `sales` ADD `accept` TEXT NULL AFTER `updated_by`, ADD `accepted` TEXT NULL AFTER `accept`;

$query = $this->_db->query(" ALTER TABLE `kitchens` ADD `accept` VARCHAR(50) NULL DEFAULT 'KitchenAttendant' AFTER `base`");

$query = $this->_db->query(" ALTER TABLE `orderdetails` ADD `accept` VARCHAR(50) NULL DEFAULT 'KitchenAttendant' AFTER `plate`");

$query = $this->_db->query("ALTER TABLE `orderdetails` ADD `accepted` ENUM('Yes','No') NULL DEFAULT 'No' AFTER `accept`;
");


}



}