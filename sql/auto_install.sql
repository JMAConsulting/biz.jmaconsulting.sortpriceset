CREATE TABLE IF NOT EXISTS `civicrm_price_set_weight` (
  `price_set_id` INT(10) NOT NULL ,
  `weight` INT(10) NOT NULL ) ENGINE = InnoDB;

  ALTER TABLE `civicrm_price_set_weight` ADD UNIQUE( `price_set_id`);
