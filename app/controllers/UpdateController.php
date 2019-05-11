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
//	$query = $this->_db->query("
//		 CREATE TABLE `salesTrails` (
//  `id` int(11) NOT NULL,
//  `shopId` int(11) NOT NULL,
//  `invoice_number` varchar(100) NOT NULL,
//  `waiter` int(11) NOT NULL,
//  `cashier` int(11) DEFAULT NULL,
//  `amount` varchar(100) NOT NULL,
//  `period` varchar(22) DEFAULT NULL,
//  `discount` varchar(100) DEFAULT NULL,
//  `balance` varchar(20) DEFAULT NULL,
//  `status` enum('PAID','PENDING') DEFAULT 'PENDING',
//  `tid` int(11) DEFAULT NULL,
//  `sid` int(11) DEFAULT NULL,
//  `hall` int(11) DEFAULT NULL,
//  `ord_type` varchar(30) DEFAULT NULL,
//  `nhil` varchar(30) DEFAULT NULL,
//  `fund` varchar(30) DEFAULT NULL,
//  `vat` varchar(30) DEFAULT NULL,
//  `kitchen` varchar(20) NOT NULL DEFAULT 'Bar',
//  `created_at` timestamp NULL DEFAULT NULL,
//  `created_by` int(11) NOT NULL,
//  `updated_at` timestamp NULL DEFAULT NULL,
//  `updated_by` int(11) DEFAULT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=latin1
//");
//$query = $this->_db->query("ALTER TABLE `salesTrails`
//  ADD KEY `shopId` (`shopId`),
//  ADD KEY `waiter` (`waiter`),
//  ADD KEY `cashier` (`cashier`),
//  ADD KEY `tid` (`tid`),
//  ADD KEY `sid` (`sid`),
//  ADD KEY `hall` (`hall`),
//  ADD KEY `created_by` (`created_by`),
//  ADD KEY `updated_by` (`updated_by`),
//  ADD CONSTRAINT `salesTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_2` FOREIGN KEY (`waiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_3` FOREIGN KEY (`cashier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_4` FOREIGN KEY (`tid`) REFERENCES `htables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_5` FOREIGN KEY (`sid`) REFERENCES `seats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_6` FOREIGN KEY (`hall`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_7` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//  ADD CONSTRAINT `salesTrails_ibfk_8` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");


$query = $this->_db->query("
CREATE TRIGGER `spyTrigger`
BEFORE UPDATE ON `sales` FOR EACH ROW
BEGIN
   INSERT INTO salesTrails (id, shopId, invoice_number, cashier, waiter, amount, discount, balance, ord_type, period, status, tid, sid, hall, kitchen, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.invoice_number,  OLD.cashier, OLD.waiter, OLD.amount,  OLD.discount, OLD.balance, OLD.ord_type, OLD.period, OLD.status, OLD.tid, OLD.sid, OLD.hall,   OLD.kitchen,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at )
;
END;

");


}



}