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
 public function update()
{


//$query = $this->_db->query(" ALTER TABLE `orderdetails` ADD `approved_by` INT NULL AFTER `accepted`, ADD INDEX (`approved_by`)");
//
//$query = $this->_db->query("ALTER TABLE `orderdetails` ADD FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
//
//$query = $this->_db->query("ALTER TABLE `orderdetails` ADD `accepted` ENUM('Yes','No') NULL DEFAULT 'No' AFTER `accept`;
//");
$query = $this->_db->query("ALTER TABLE `orderdetails` ADD `edited` ENUM('Yes','No') NULL DEFAULT
																											'No' AFTER `approved_by`");

																											if($query): "DB updated"; endif;

}



}