DROP TABLE IF EXISTS `option_service` ;
DROP TABLE IF EXISTS `service` ;
DROP TABLE IF EXISTS `reservation` ;
DROP TABLE IF EXISTS `user` ;
DROP TABLE IF EXISTS `car` ;
DROP TABLE IF EXISTS `motor` ;
DROP TABLE IF EXISTS `type` ;
DROP TABLE IF EXISTS `status` ;
-- -----------------------------------------------------
-- Table `status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `available` TINYINT NULL,
  `lieu` VARCHAR(125) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(125) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `motor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `motor` (
  `id` INT NOT NULL,
  `category_flue` VARCHAR(125) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `car`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `car` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `brand` VARCHAR(125) NOT NULL,
  `plate` VARCHAR(125) NOT NULL,
  `door` INT NOT NULL,
  `capacity` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `image` VARCHAR(125) NULL,
  `mileage` INT NULL,
  `description` LONGTEXT NULL,
  `motor_id` INT NOT NULL,
  `status_id` INT NULL,
  `type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Car_status_id`
    FOREIGN KEY (`status_id`)
    REFERENCES `status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_type_id`
    FOREIGN KEY (`type_id`)
    REFERENCES `type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_motor_id`
    FOREIGN KEY (`motor_id`)
    REFERENCES `motor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(125) NOT NULL,
  `lastname` VARCHAR(125) NOT NULL,
  `email` VARCHAR(125) NOT NULL,
  `adress` VARCHAR(125) NOT NULL,
  `phone` INT NOT NULL,
  `password` VARCHAR(125) NOT NULL,
  `role` JSON NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT NOT NULL,
  `car_id` INT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Reservation_customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reservation_car_id`
    FOREIGN KEY (`car_id`)
    REFERENCES `car` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `service` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `price` INT NOT NULL,
  `description` VARCHAR(125) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `option_service` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reservation_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Option_reservation_id`
    FOREIGN KEY (`reservation_id`)
    REFERENCES `reservation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Option_service_id`
    FOREIGN KEY (`service_id`)
    REFERENCES `service` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Insert to `Type`
-- -----------------------------------------------------
INSERT INTO `type` (`id`, `category`) VALUES (1,'SUV'),(2,'Berline'),(3,'Citadine'),(4,'Coupe');
-- -----------------------------------------------------
-- Insert to `Motor`
-- -----------------------------------------------------
INSERT INTO `motor` (`id`, `category_flue`) VALUES (1,'Electric'),(2,'Hybride'),(3,'Essence'),(4,'Diesel');
  -- -----------------------------------------------------
-- Insert to `Car`
-- -----------------------------------------------------
INSERT INTO car (`brand`, `plate`, `name`, `door`, `capacity`, `mileage`, `motor_id`, `type_id`) 
VALUES 
('Peugeot','AB-123-CD','5008',5,7,2000,2,1),
('Peugeot','BC-234-DE','2008',5,5,80000,1,1),
('Peugeot','CD-345-EF','508',5,5,100000,4,2),
('Peugeot','DE-456-FG','108',3,5,25000,3,3),
('Renault','CD-325-FK','Capture',5,5,2567,2,1),
('Renault','SN-121-TG','Kadjar',5,5,35067,3,1),
('Renault','TK-504-KR','Talisman',5,5,34567,4,2),
('Renault','SK-160-ST','Megane',5,5,4697,1, 2),
('Ford','JH-654-AZ','Mustang GT',3,4,10500,3, 2),
('Ford','ZK-619-PR','Mustang Mach-E AWD',5,5,5602,1,1),
('Ford','VD-243-RS','S-MAX VIGINALE',5,7,15320,2,3),
('Ford','IS-118-TF','Puma Flexifuel E85',5,5,25180,3,1);