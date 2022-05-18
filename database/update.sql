ALTER TABLE `dr_express`.`permissions` 
ADD COLUMN `topic` VARCHAR(45) NULL AFTER `slug`;

ALTER TABLE `dr_express`.`districts` 
ADD COLUMN `cep` VARCHAR(10) NULL AFTER `name`;
ALTER TABLE `dr_express`.`cities` 
ADD COLUMN `cep` VARCHAR(10) NULL AFTER `ibge_code`;

--------

ALTER TABLE `dr_express`.`adresses` 
CHANGE COLUMN `type` `type` VARCHAR(45) NULL ;
