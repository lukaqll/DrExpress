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
