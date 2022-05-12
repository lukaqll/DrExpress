-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dr_express
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dr_express
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dr_express` ;
USE `dr_express` ;

-- -----------------------------------------------------
-- Table `dr_express`.`ufs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`ufs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `initials` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`cities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`cities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_uf` INT NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `ibge_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cities_ufs1_idx` (`id_uf` ASC),
  CONSTRAINT `fk_cities_ufs1`
    FOREIGN KEY (`id_uf`)
    REFERENCES `dr_express`.`ufs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`districts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`districts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_city` INT NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_districts_cities1_idx` (`id_city` ASC),
  CONSTRAINT `fk_districts_cities1`
    FOREIGN KEY (`id_city`)
    REFERENCES `dr_express`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`adresses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`adresses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_district` INT NOT NULL,
  `id_user` INT NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  `street` VARCHAR(60) NOT NULL,
  `number` VARCHAR(45) NULL,
  `complement` VARCHAR(255) NULL,
  `reference` VARCHAR(60) NULL,
  `cep` VARCHAR(45) NULL,
  `deleted` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_adresses_districts1_idx` (`id_district` ASC),
  INDEX `fk_adresses_users1_idx` (`id_user` ASC),
  CONSTRAINT `fk_adresses_districts1`
    FOREIGN KEY (`id_district`)
    REFERENCES `dr_express`.`districts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_adresses_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_city` INT NULL,
  `id_address` INT NULL,
  `name` VARCHAR(60) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `doc_number` VARCHAR(20) NULL,
  `phone` VARCHAR(45) NULL,
  `birthdate` DATE NULL,
  `cro` VARCHAR(45) NULL,
  `status` VARCHAR(2) NOT NULL,
  `picture` VARCHAR(255) NULL,
  `banner` VARCHAR(255) NULL,
  `is_delivery` TINYINT(1) NULL DEFAULT 0,
  `is_physical` TINYINT(1) NULL DEFAULT 0,
  `is_student` TINYINT(1) NULL DEFAULT 0,
  `notification_token` VARCHAR(255) NULL,
  `cro_validated_at` DATETIME NULL,
  `email_verified_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_cities1_idx` (`id_city` ASC),
  INDEX `fk_users_adresses1_idx` (`id_address` ASC),
  CONSTRAINT `fk_users_cities1`
    FOREIGN KEY (`id_city`)
    REFERENCES `dr_express`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_adresses1`
    FOREIGN KEY (`id_address`)
    REFERENCES `dr_express`.`adresses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_category` INT NULL,
  `name` VARCHAR(45) NOT NULL,
  `required_cro` TINYINT(1) NULL DEFAULT 0,
  `linkable` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_categories_categories1_idx` (`id_category` ASC),
  CONSTRAINT `fk_categories_categories1`
    FOREIGN KEY (`id_category`)
    REFERENCES `dr_express`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`specs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`specs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_category` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `is_required` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_table1_sub_categories1_idx` (`id_category` ASC),
  CONSTRAINT `fk_table1_sub_categories1`
    FOREIGN KEY (`id_category`)
    REFERENCES `dr_express`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`spec_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`spec_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_spec` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_spec_items_specs1_idx` (`id_spec` ASC),
  CONSTRAINT `fk_spec_items_specs1`
    FOREIGN KEY (`id_spec`)
    REFERENCES `dr_express`.`specs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`brands`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`brands` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_brand` INT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `model` VARCHAR(60) NULL,
  `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `slug` VARCHAR(255) NULL,
  `guarantee` INT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_products_users1_idx` (`id_user` ASC),
  INDEX `fk_products_brands1_idx` (`id_brand` ASC),
  CONSTRAINT `fk_products_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_brands1`
    FOREIGN KEY (`id_brand`)
    REFERENCES `dr_express`.`brands` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`product_specs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`product_specs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `id_spec_item` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_product_specs_products1_idx` (`id_product` ASC),
  INDEX `fk_product_specs_spec_items1_idx` (`id_spec_item` ASC),
  CONSTRAINT `fk_product_specs_products1`
    FOREIGN KEY (`id_product`)
    REFERENCES `dr_express`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_specs_spec_items1`
    FOREIGN KEY (`id_spec_item`)
    REFERENCES `dr_express`.`spec_items` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`carts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_seller` INT NOT NULL,
  `status` VARCHAR(2) NOT NULL,
  `deleted` TINYINT(1) NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_carts_users1_idx` (`id_seller` ASC),
  INDEX `fk_carts_users2_idx` (`id_user` ASC),
  CONSTRAINT `fk_carts_users1`
    FOREIGN KEY (`id_seller`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carts_users2`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`payment_methods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`payment_methods` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image` VARCHAR(255) NULL,
  `is_required_data` TINYINT(1) NULL DEFAULT 0,
  `default_data` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`user_payment_methods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`user_payment_methods` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_payment_method` INT NOT NULL,
  `data` VARCHAR(60) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_payments_methods_users1_idx` (`id_user` ASC),
  INDEX `fk_user_payments_methods_payment_methods1_idx` (`id_payment_method` ASC),
  CONSTRAINT `fk_user_payments_methods_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_payments_methods_payment_methods1`
    FOREIGN KEY (`id_payment_method`)
    REFERENCES `dr_express`.`payment_methods` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_cart` INT NOT NULL,
  `id_address` INT NULL,
  `id_user_payment_method` INT NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `freight` DECIMAL(12,2) NULL DEFAULT 0,
  `is_delivery` TINYINT(1) NULL DEFAULT 0,
  `is_money` TINYINT(1) NULL DEFAULT 0,
  `conclued_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orders_carts1_idx` (`id_cart` ASC),
  INDEX `fk_orders_adresses1_idx` (`id_address` ASC),
  INDEX `fk_orders_user_payments_methods1_idx` (`id_user_payment_method` ASC),
  CONSTRAINT `fk_orders_carts1`
    FOREIGN KEY (`id_cart`)
    REFERENCES `dr_express`.`carts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_adresses1`
    FOREIGN KEY (`id_address`)
    REFERENCES `dr_express`.`adresses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_user_payments_methods1`
    FOREIGN KEY (`id_user_payment_method`)
    REFERENCES `dr_express`.`user_payment_methods` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`stock_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`stock_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `id_order` INT NULL,
  `type` VARCHAR(1) NOT NULL,
  `amount` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_stock_products1_idx` (`id_product` ASC),
  INDEX `fk_stock_orders1_idx` (`id_order` ASC),
  CONSTRAINT `fk_stock_products1`
    FOREIGN KEY (`id_product`)
    REFERENCES `dr_express`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_orders1`
    FOREIGN KEY (`id_order`)
    REFERENCES `dr_express`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`cart_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`cart_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_cart` INT NOT NULL,
  `id_product` INT NOT NULL,
  `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `deleted` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_table1_carts1_idx` (`id_cart` ASC),
  INDEX `fk_table1_products1_idx` (`id_product` ASC),
  CONSTRAINT `fk_table1_carts1`
    FOREIGN KEY (`id_cart`)
    REFERENCES `dr_express`.`carts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_products1`
    FOREIGN KEY (`id_product`)
    REFERENCES `dr_express`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`product_images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`product_images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `src` VARCHAR(255) NOT NULL,
  `is_principal` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_product_images_products1_idx` (`id_product` ASC),
  CONSTRAINT `fk_product_images_products1`
    FOREIGN KEY (`id_product`)
    REFERENCES `dr_express`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`served_districts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`served_districts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_district` INT NOT NULL,
  `freight` DECIMAL(12,2) NULL DEFAULT 0,
  `min_delivery_time` INT NULL DEFAULT 0,
  `max_delivery_time` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_served_districts_users1_idx` (`id_user` ASC),
  INDEX `fk_served_districts_districts1_idx` (`id_district` ASC),
  CONSTRAINT `fk_served_districts_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_served_districts_districts1`
    FOREIGN KEY (`id_district`)
    REFERENCES `dr_express`.`districts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`historic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`historic` (
  `id` INT NOT NULL,
  `id_user` INT NULL,
  `type` VARCHAR(45) NOT NULL,
  `reference` INT NOT NULL,
  `historic` TEXT NOT NULL,
  `payload` TEXT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_historic_users1_idx` (`id_user` ASC),
  INDEX `idx_reference` (`reference` ASC),
  CONSTRAINT `fk_historic_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`password_recovery`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`password_recovery` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `used` TINYINT(1) NULL DEFAULT 0,
  `token` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_password_recovery_users1_idx` (`id_user` ASC),
  CONSTRAINT `fk_password_recovery_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `slug` VARCHAR(45) NOT NULL,
  `description` VARCHAR(60) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`permissions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `slug` VARCHAR(45) NOT NULL,
  `description` VARCHAR(60) NULL,
  `active` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`role_permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`role_permissions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_role` INT NOT NULL,
  `id_permission` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_role_permissions_roles1_idx` (`id_role` ASC),
  INDEX `fk_role_permissions_permissions1_idx` (`id_permission` ASC),
  CONSTRAINT `fk_role_permissions_roles1`
    FOREIGN KEY (`id_role`)
    REFERENCES `dr_express`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_permissions_permissions1`
    FOREIGN KEY (`id_permission`)
    REFERENCES `dr_express`.`permissions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dr_express`.`user_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dr_express`.`user_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_role` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_roles_roles1_idx` (`id_role` ASC),
  INDEX `fk_user_roles_users1_idx` (`id_user` ASC),
  CONSTRAINT `fk_user_roles_roles1`
    FOREIGN KEY (`id_role`)
    REFERENCES `dr_express`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_roles_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `dr_express`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
