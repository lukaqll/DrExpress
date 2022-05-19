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

