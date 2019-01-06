CREATE SCHEMA `programmers` DEFAULT CHARACTER SET utf8;

USE programmers;

CREATE TABLE `programmers`.`prog_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(70) NOT NULL,
  `surname` VARCHAR(100) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `register_date` DATETIME NOT NULL DEFAULT NOW(),
  `update_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UK_user_email` (`email` ASC))
ENGINE = InnoDB;

DELIMITER $$

DROP TRIGGER IF EXISTS programmers.prog_users_BEFORE_UPDATE$$
CREATE DEFINER = CURRENT_USER TRIGGER `programmers`.`prog_users_BEFORE_UPDATE` BEFORE UPDATE ON `prog_users` FOR EACH ROW
BEGIN
  SET NEW.update_date = NOW();
END
$$
DELIMITER ;


CREATE TABLE `programmers`.`prog_phones` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `phone` VARCHAR(18) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UK_prog_phones_user` (`id_user` ASC, `phone` ASC),
  INDEX `FK_prog_phones_user_idx` (`id_user` ASC),
  CONSTRAINT `FK_prog_phones_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `programmers`.`prog_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;