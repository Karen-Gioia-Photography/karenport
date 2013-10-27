CREATE SCHEMA IF NOT EXISTS `karenport` DEFAULT CHARACTER SET utf8 ;
USE `karenport` ;

-- -----------------------------------------------------
-- Table `karenport`.`galleries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `karenport`.`galleries` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `description` VARCHAR(4000) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `homepage_position` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `homepage_position_UNIQUE` (`homepage_position` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC)
);


-- -----------------------------------------------------
-- Table `karenport`.`photos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `karenport`.`photos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(1000) NULL DEFAULT NULL,
  `path` VARCHAR(1000) NOT NULL,
  `gallery_id` INT(11) NOT NULL,
  `gallery_position` INT(10) UNSIGNED NOT NULL,
  `homepage_position` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `gallery_position_UNIQUE` (`gallery_position` ASC, `gallery_id` ASC),
  INDEX `gallery_photo_fk_idx` (`gallery_id` ASC),
  CONSTRAINT `gallery_photo_fk`
    FOREIGN KEY (`gallery_id`)
    REFERENCES `karenport`.`galleries` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);


