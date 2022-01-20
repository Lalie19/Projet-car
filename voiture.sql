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