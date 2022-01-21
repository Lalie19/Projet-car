DROP TABLE IF EXISTS `Option` ;
DROP TABLE IF EXISTS `Service` ;
DROP TABLE IF EXISTS `Reservation` ;
DROP TABLE IF EXISTS `User` ;
DROP TABLE IF EXISTS `Car` ;
DROP TABLE IF EXISTS `Motor` ;
DROP TABLE IF EXISTS `Type` ;
DROP TABLE IF EXISTS `Status` ;
-- -----------------------------------------------------
-- Table `Status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Available` TINYINT NULL,
  `Lieu` VARCHAR(125) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `Type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Category` VARCHAR(125) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `Motor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Motor` (
  `id` INT NOT NULL,
  `Category_flue` VARCHAR(125) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `Car`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Car` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Brand` VARCHAR(125) NOT NULL,
  `Plate` VARCHAR(125) NOT NULL,
  `Door` INT NOT NULL,
  `Capacity` INT NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `Image` VARCHAR(125) NULL,
  `Mileage` INT NULL,
  `Description` LONGTEXT NULL,
  `Motor_id` INT NOT NULL,
  `Status_id` INT NULL,
  `Type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Car_Status_id`
    FOREIGN KEY (`Status_id`)
    REFERENCES `Status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_Type_id`
    FOREIGN KEY (`Type_id`)
    REFERENCES `Type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_Motor_id`
    FOREIGN KEY (`Motor_id`)
    REFERENCES `Motor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `User` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Firstname` VARCHAR(125) NOT NULL,
  `Lastname` VARCHAR(125) NOT NULL,
  `E-mail` VARCHAR(125) NOT NULL,
  `Adress` VARCHAR(125) NOT NULL,
  `Phone` INT NOT NULL,
  `Password` VARCHAR(125) NOT NULL,
  `Role` JSON NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `Reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reservation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Customer_id` INT NOT NULL,
  `Car_id` INT NOT NULL,
  `Start_date` DATE NOT NULL,
  `End_date` DATE NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Reservation_customer_id`
    FOREIGN KEY (`Customer_id`)
    REFERENCES `User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reservation_car_id`
    FOREIGN KEY (`Car_id`)
    REFERENCES `Car` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `Service`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Service` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Price` INT NOT NULL,
  `Description` VARCHAR(125) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `Option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Option` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Reservation_id` INT NOT NULL,
  `Service_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Option_Reservation_id`
    FOREIGN KEY (`Reservation_id`)
    REFERENCES `Reservation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Option_Service_id`
    FOREIGN KEY (`Service_id`)
    REFERENCES `Service` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Insert to `Type`
-- -----------------------------------------------------
INSERT INTO `Type` (`id`, `Category`) VALUES (1,'SUV'),(2,'Berline'),(3,'Citadine'),(4,'Coupe');
-- -----------------------------------------------------
-- Insert to `Motor`
-- -----------------------------------------------------
INSERT INTO `Motor` (`id`, `Category_flue`) VALUES (1,'Electric'),(2,'Hybride'),(3,'Essence'),(4,'Diesel');
  -- -----------------------------------------------------
-- Insert to `Car`
-- -----------------------------------------------------
INSERT INTO Car (`Brand`, `Plate`, `Name`, `Door`, `Capacity`, `Mileage`, `Motor_id`, `Type_id`) 
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

