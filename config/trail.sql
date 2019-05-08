

CREATE TABLE `salesTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `waiter` int(11) NOT NULL,
  `cashier` int(11) DEFAULT NULL,
  `amount` varchar(100) NOT NULL,
  `period` varchar(22) DEFAULT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `status` enum('PAID','PENDING') DEFAULT 'PENDING',
  `tid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `hall` int(11) DEFAULT NULL,
  `ord_type` varchar(30) DEFAULT NULL,
  `nhil` varchar(30) DEFAULT NULL,
  `fund` varchar(30) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `kitchen` varchar(20) NOT NULL DEFAULT 'Bar',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `salesTrails`
  ADD KEY `shopId` (`shopId`),
  ADD KEY `waiter` (`waiter`),
  ADD KEY `cashier` (`cashier`),
  ADD KEY `tid` (`tid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `hall` (`hall`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

ALTER TABLE `salesTrails`
  ADD CONSTRAINT `salesTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_2` FOREIGN KEY (`waiter`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_3` FOREIGN KEY (`cashier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_4` FOREIGN KEY (`tid`) REFERENCES `htables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_5` FOREIGN KEY (`sid`) REFERENCES `seats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_6` FOREIGN KEY (`hall`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_7` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesTrails_ibfk_8` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



	DELIMITER $$
CREATE TRIGGER `spyTrigger`
BEFORE UPDATE ON `sales` FOR EACH ROW
BEGIN
   INSERT INTO salesTrails (id, shopId, invoice_number, cashier, waiter, amount, discount, balance, ord_type, period, status, tid, sid, hall, kitchen, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.invoice_number,  OLD.cashier, OLD.waiter, OLD.amount,  OLD.discount, OLD.balance, OLD.ord_type, OLD.period, OLD.status, OLD.tid, OLD.sid, OLD.hall,   OLD.kitchen,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at )
;
END;

$$




CREATE TABLE `acquisitionsTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `kitchen` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `acquisitionsTrails`
  ADD KEY `shopId` (`shopId`),
  ADD KEY `itemId` (`itemId`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);


ALTER TABLE `acquisitionsTrails`
  ADD CONSTRAINT `acquisitionsTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitionsTrails_ibfk_2` FOREIGN KEY (`itemId`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitionsTrails_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acquisitionsTrails_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


  	DELIMITER $$
CREATE TRIGGER `spyAcqTrigger`
BEFORE UPDATE ON `acquisitions` FOR EACH ROW
BEGIN
   INSERT INTO acquisitionsTrails (id, shopId, itemId, qty, kitchen, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.itemId,  OLD.qty,   OLD.kitchen,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at )
;
END;

$$




CREATE TABLE `productsTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `kitchen` varchar(30) DEFAULT NULL,
  `price` varchar(30) DEFAULT '0',
  `added_qty` varchar(30) DEFAULT '0',
  `qty` varchar(30) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `productsTrails`
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `shopId` (`shopId`);

ALTER TABLE `productsTrails`
  ADD CONSTRAINT `productsTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productsTrails_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productsTrails_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



  	DELIMITER $$
CREATE TRIGGER `spyProdTrigger`
BEFORE UPDATE ON `products` FOR EACH ROW
BEGIN
   INSERT INTO productsTrails (id, shopId, product_name,  kitchen, price, added_qty, qty, created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.product_name,   OLD.kitchen, OLD.price, OLD.added_qty,  OLD.qty,  OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at )
;
END;

$$




CREATE TABLE `purchasesTrails` (
  `id` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `item_name` varchar(70) NOT NULL,
  `cost_price` varchar(20) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `added_qty` varchar(30) DEFAULT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `purchased_date` varchar(10) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `purchasesTrails`
  ADD KEY `shopId` (`shopId`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `supplierId` (`supplierId`),
  ADD KEY `supplierId_2` (`supplierId`);

 ALTER TABLE `purchasesTrails`
  ADD CONSTRAINT `purchasesTrails_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasesTrails_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasesTrails_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasesTrails_ibfk_4` FOREIGN KEY (`supplierId`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



  	DELIMITER $$
CREATE TRIGGER `spyPurchasesTrigger`
BEFORE UPDATE ON `purchases` FOR EACH ROW
BEGIN
   INSERT INTO purchasesTrails (id, shopId, item_name, cost_price, qty, added_qty, transaction_type, supplierId, purchased_date,  created_by, created_at, updated_by, updated_at)
    VALUES (OLD.id, OLD.shopId, OLD.item_name, OLD.cost_price, OLD.qty, OLD.added_qty, OLD.transaction_type, OLD.supplierId, OLD.purchased_date, OLD.created_by,  OLD.created_at,  OLD.updated_by,  OLD.updated_at );
END;

$$