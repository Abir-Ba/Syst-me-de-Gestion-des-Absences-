SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
#drop database gestion_absences;
-- -----------------------------------------------------
-- Schema gestion_absences
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `gestion_absences` DEFAULT CHARACTER SET utf8 ;
USE `gestion_absences` ;

-- -----------------------------------------------------
-- Table `Groupe`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Groupe` (
  `idGroupe` INT auto_increment NOT NULL ,
  `nom` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGroupe`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Enseignant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Enseignant` (
  `idEnseignant` INT auto_increment NOT NULL,
  `nom` VARCHAR(45) NOT NULL,
  `prenom` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idEnseignant`)
    )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Etudiant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Etudiant` (
  `idEtudiant` INT auto_increment NOT NULL,
  `nom` VARCHAR(45) NOT NULL,
  `prenom` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `idGroupe` INT NOT NULL,
  PRIMARY KEY (`idEtudiant`, `idGroupe`),
  CONSTRAINT `fk_Etudiant_group`
    FOREIGN KEY (`idGroupe`)
    REFERENCES `groupe` (`idGroupe`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `cour`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cour` (
  `idCour` INT auto_increment NOT NULL,
  `date` date NOT NULL,
  `heurDebut` time NOT NULL,
  `heurFin` time NOT NULL,
  `status` enum('terminer','pasEncore','remplacer'),
  `idEnseignant` INT NOT NULL,
  `idGroupe` INT NOT NULL,
  PRIMARY KEY (`idcour`, `idEnseignant`, `idGroupe`),
  CONSTRAINT `fk_cour_Enseignant1`
    FOREIGN KEY (`idEnseignant`)
    REFERENCES `Enseignant` (`idEnseignant`),
  CONSTRAINT `fk_cour_groupe1`
    FOREIGN KEY (`idGroupe`)
    REFERENCES `groupe` (`idGroupe`)
    )
ENGINE = InnoDB;
alter table cour 
add check (heurDebut < heurFin);

-- -----------------------------------------------------
-- Table `absence`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `absence` (
  `idEtudiant` INT NOT NULL,
  `idGroupe` INT NOT NULL,
  `idCour` INT NOT NULL,
  `status` enum('justifiée','nonJustifiée'),
  PRIMARY KEY (`idEtudiant`, `idGroupe`, `idCour`),
  CONSTRAINT `fk_Etudiant_has_cour_Etudiant1`
    FOREIGN KEY (`idEtudiant` , `idGroupe`)
    REFERENCES `Etudiant` (`idEtudiant` , `idGroupe`),
  CONSTRAINT `fk_Etudiant_has_cour_cour1`
    FOREIGN KEY (`idCour`)
    REFERENCES `cour` (`idCour`)
    )
ENGINE = InnoDB;

insert into Enseignant(nom,prenom,email,password) values('Enseignant','Enseignant','Enseignant@gmail.com','$2y$10$RmhZEXVrKOWViffSH5ULMexJTZT7AgG1X4FzjLoYnaPHDOpS3PodS');

insert into Groupe(nom) values('A'),('B'),('C'),('D'),('E'),('F');

insert into Etudiant(nom,prenom,email,idGroupe) values();

insert into cour(date,heurDebut,heurFin,Status,idEnseignant,idGroupe) values('2022-10-02','09:00:00','11:00:00','pasEncore',1,1),
('2022-10-02','13:00:00','15:00:00','pasEncore',1,2),('2022-10-04','09:00:00','11:00:00','pasEncore',1,2),('2022-10-04','13:00:00','15:00:00','pasEncore',1,1),
('2022-10-06','09:00:00','11:00:00','pasEncore',1,1),('2022-10-06','13:00:00','15:00:00','pasEncore',1,2),
('2022-10-09','09:00:00','11:00:00','pasEncore',1,2),('2022-10-09','13:00:00','15:00:00','pasEncore',1,1),
('2022-10-11','09:00:00','11:00:00','pasEncore',1,1),('2022-10-11','13:00:00','15:00:00','pasEncore',1,2),
('2022-10-13','09:00:00','11:00:00','pasEncore',1,2),('2022-10-13','13:00:00','15:00:00','pasEncore',1,1),
('2022-09-28','13:00:00','15:00:00','pasEncore',1,2),('2022-09-27','13:00:00','15:00:00','pasEncore',1,1);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

