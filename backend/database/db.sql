-- MySQL Script generated by MySQL Workbench
-- Sun Sep 18 18:59:26 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `profile_image` VARCHAR(255) NULL,
  `profile_cover` VARCHAR(255) NULL,
  `following` INT NULL,
  `follower` INT NULL,
  `bio` VARCHAR(140) NULL,
  `location` VARCHAR(45) NULL,
  `joined_date` DATE NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tweets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tweets` (
  `tweet_id` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(280) NULL,
  `tweet_date` DATE NULL,
  `likes_count` INT NULL,
  `tweet_by` INT NULL,
  `tweet_image` VARCHAR(45) NULL,
  `users_user_id` INT NOT NULL,
  PRIMARY KEY (`tweet_id`, `users_user_id`),
  INDEX `fk_tweets_users1_idx` (`users_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_tweets_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `mydb`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`follows`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`follows` (
  `follow_id` INT NOT NULL AUTO_INCREMENT,
  `sender` INT NULL,
  `receiver` INT NULL,
  `users_user_id` INT NOT NULL,
  PRIMARY KEY (`follow_id`, `users_user_id`),
  INDEX `fk_follows_users1_idx` (`users_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_follows_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `mydb`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`blocks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`blocks` (
  `block_id` INT NOT NULL AUTO_INCREMENT,
  `blocker_id` INT NULL,
  `blocked_id` INT NULL,
  `users_user_id` INT NOT NULL,
  PRIMARY KEY (`block_id`, `users_user_id`),
  INDEX `fk_blocks_users1_idx` (`users_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_blocks_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `mydb`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`likes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`likes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `liked_by` INT NULL,
  `tweets_tweet_id` INT NOT NULL,
  `tweets_users_user_id` INT NOT NULL,
  PRIMARY KEY (`id`, `tweets_tweet_id`, `tweets_users_user_id`),
  INDEX `fk_likes_tweets1_idx` (`tweets_tweet_id` ASC, `tweets_users_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_likes_tweets1`
    FOREIGN KEY (`tweets_tweet_id` , `tweets_users_user_id`)
    REFERENCES `mydb`.`tweets` (`tweet_id` , `users_user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;