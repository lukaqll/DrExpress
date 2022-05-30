ALTER TABLE `dr_express`.`permissions` 
ADD COLUMN `topic` VARCHAR(45) NULL AFTER `slug`;

ALTER TABLE `dr_express`.`districts` 
ADD COLUMN `cep` VARCHAR(10) NULL AFTER `name`;
ALTER TABLE `dr_express`.`cities` 
ADD COLUMN `cep` VARCHAR(10) NULL AFTER `ibge_code`;

--------

ALTER TABLE `dr_express`.`adresses` 
CHANGE COLUMN `type` `type` VARCHAR(45) NULL ;

--------

ALTER TABLE `dr_express`.`products` 
DROP FOREIGN KEY `fk_products_brands1`;
ALTER TABLE `dr_express`.`products` 
DROP COLUMN `id_brand`,
ADD COLUMN `brand` VARCHAR(45) NULL AFTER `description`,
ADD COLUMN `color` VARCHAR(45) NULL AFTER `brand`,
DROP INDEX `fk_products_brands1_idx` ;
;

------

ALTER TABLE `dr_express`.`specs` 
ADD COLUMN `is_multiple` TINYINT(1) NULL DEFAULT 0 AFTER `is_required`;

-----

ALTER TABLE `dr_express`.`product_specs` 
DROP FOREIGN KEY `fk_product_specs_spec_items1`;
ALTER TABLE `dr_express`.`product_specs` 
DROP COLUMN `id_spec_item`,
ADD COLUMN `id_spec` INT NOT NULL AFTER `id_product`,
ADD INDEX `fk_product_specs_1_idx` (`id_spec` ASC),
DROP INDEX `fk_product_specs_spec_items1_idx` ;
;
ALTER TABLE `dr_express`.`product_specs` 
ADD CONSTRAINT `fk_product_specs_1`
  FOREIGN KEY (`id_spec`)
  REFERENCES `dr_express`.`specs` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

CREATE TABLE `dr_express`.`product_spec_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product_spec` INT NOT NULL,
  `id_spec_item` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_product_spec_items_1_idx` (`id_product_spec` ASC),
  INDEX `fk_product_spec_items_2_idx` (`id_spec_item` ASC),
  CONSTRAINT `fk_product_spec_items_1`
    FOREIGN KEY (`id_product_spec`)
    REFERENCES `dr_express`.`product_specs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_spec_items_2`
    FOREIGN KEY (`id_spec_item`)
    REFERENCES `dr_express`.`spec_items` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

ALTER TABLE `dr_express`.`product_spec_items` 
DROP FOREIGN KEY `fk_product_spec_items_2`;
ALTER TABLE `dr_express`.`product_spec_items` 
DROP COLUMN `id_spec_item`,
ADD COLUMN `name` VARCHAR(60) NOT NULL AFTER `id_product_spec`,
DROP INDEX `fk_product_spec_items_2_idx` ;
;

------

ALTER TABLE `dr_express`.`products` 
ADD COLUMN `id_category` INT NOT NULL AFTER `id_user`,
ADD INDEX `fk_products_1_idx` (`id_category` ASC);
;
ALTER TABLE `dr_express`.`products` 
ADD CONSTRAINT `fk_products_1`
  FOREIGN KEY (`id_category`)
  REFERENCES `dr_express`.`categories` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


------

ALTER TABLE `dr_express`.`products` 
ADD COLUMN `status` VARCHAR(45) NOT NULL AFTER `slug`,
ADD COLUMN `deleted` TINYINT(1) NULL DEFAULT 0 AFTER `status`;


CREATE TABLE `dr_express`.`seller_config` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `is_open` TINYINT(1) NULL DEFAULT 0,
  `is_delivery` TINYINT(1) NULL DEFAULT 0,
  `is_physical` TINYINT(1) NULL DEFAULT 0,
  `visibility` VARCHAR(1) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_seller_config_1_idx` (`id_user` ASC),
  CONSTRAINT `fk_seller_config_1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-------

ALTER TABLE `dr_express`.`served_districts` 
ADD COLUMN `time_type` VARCHAR(1) NULL AFTER `max_delivery_time`;


------

CREATE TABLE `dr_express`.`favorite_products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_product` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_favorite_products_1_idx` (`id_user` ASC) VISIBLE,
  INDEX `fk_favorite_products_2_idx` (`id_product` ASC) VISIBLE,
  CONSTRAINT `fk_favorite_products_1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favorite_products_2`
    FOREIGN KEY (`id_product`)
    REFERENCES `dr_express`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

ALTER TABLE `dr_express`.`cart_items` 
ADD COLUMN `amount` DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER `id_product`;
ALTER TABLE `dr_express`.`cart_items` 
DROP COLUMN `price`;

CREATE TABLE `dr_express`.`cart_item_specs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_cart_item` INT NOT NULL,
  `id_spec` INT NOT NULL,
  `data` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cart_item_specs_1_idx` (`id_cart_item` ASC) VISIBLE,
  INDEX `fk_cart_item_specs_2_idx` (`id_spec` ASC) VISIBLE,
  CONSTRAINT `fk_cart_item_specs_1`
    FOREIGN KEY (`id_cart_item`)
    REFERENCES `dr_express`.`cart_items` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_item_specs_2`
    FOREIGN KEY (`id_spec`)
    REFERENCES `dr_express`.`specs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

