SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `dimpe_fivi3` ;
CREATE SCHEMA IF NOT EXISTS `dimpe_fivi3` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
SHOW WARNINGS;
USE `dimpe_fivi3` ;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_tipoperiodo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_tipoperiodo` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_tipoperiodo` (
  `cod_tipoper` INT NOT NULL ,
  `nom_tipoper` VARCHAR(50) NULL ,
  PRIMARY KEY (`cod_tipoper`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_admin_periodos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_admin_periodos` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_admin_periodos` (
  `cod_periodo` INT NOT NULL AUTO_INCREMENT ,
  `cod_tipoper` INT NOT NULL ,
  `periodo_ano` INT(4) NULL ,
  `periodo_sec` INT(3) NULL ,
  `nom_periodo` VARCHAR(50) NULL ,
  `estado_periodo` CHAR(1) NULL COMMENT 'A - Abierto\nC - Cerrado' ,
  PRIMARY KEY (`cod_periodo`) ,
  CONSTRAINT `fk_tipoperiodo_periodos`
    FOREIGN KEY (`cod_tipoper` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipoperiodo` (`cod_tipoper` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_tipoperiodo_periodos` ON `dimpe_fivi3`.`fivi_admin_periodos` (`cod_tipoper` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_super`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_super` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_super` (
  `cod_super` INT NOT NULL ,
  `nom_super` VARCHAR(45) NULL ,
  PRIMARY KEY (`cod_super`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_tipoent`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_tipoent` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_tipoent` (
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `nom_tipoent` VARCHAR(45) NULL ,
  PRIMARY KEY (`cod_tipoent`, `cod_super`) ,
  CONSTRAINT `fk_super_tipoent`
    FOREIGN KEY (`cod_super` )
    REFERENCES `dimpe_fivi3`.`fivi_param_super` (`cod_super` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_super_tipoent` ON `dimpe_fivi3`.`fivi_param_tipoent` (`cod_super` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_admin_entidades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_admin_entidades` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_admin_entidades` (
  `cod_entidad` INT NOT NULL ,
  `num_ident` INT NULL ,
  `dig_valida` TINYINT NULL ,
  `nom_entidad` VARCHAR(255) NULL ,
  `mail_entidad` VARCHAR(100) NULL ,
  `tipoper` INT NOT NULL ,
  `tipoform` TINYINT NOT NULL ,
  PRIMARY KEY (`cod_entidad`) ,
  CONSTRAINT `fk_tipoper_entidades`
    FOREIGN KEY (`tipoper` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipoperiodo` (`cod_tipoper` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_tipoper_entidades` ON `dimpe_fivi3`.`fivi_admin_entidades` (`tipoper` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_admin_control`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_admin_control` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_admin_control` (
  `cod_periodo` INT NOT NULL ,
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `cod_entidad` INT NOT NULL ,
  `nueva` TINYINT(1)  NULL ,
  `cap_identificacion` INT NULL ,
  `cap_fivi` INT NULL ,
  `novedad_fivi` INT NULL ,
  `estado_fivi` INT NULL ,
  `cap_sfv` INT NULL ,
  `novedad_sfv` INT NULL ,
  `estado_sfv` INT NULL ,
  `cap_leasing` INT NULL ,
  `novedad_leasing` INT NULL ,
  `estado_leasing` INT NULL ,
  `cap_envio` INT NULL ,
  `cod_critico` INT NULL ,
  `cod_logistico` INT NULL ,
  `fec_cargafivi` DATETIME NULL,
  `fec_cargasfv` DATETIME NULL,
  `fec_cargaleasing` DATETIME NULL,
  `fec_envio` DATETIME NULL,
  PRIMARY KEY (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) ,
  CONSTRAINT `fk_periodos_control`
    FOREIGN KEY (`cod_periodo` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_periodos` (`cod_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_super_control`
    FOREIGN KEY (`cod_super` )
    REFERENCES `dimpe_fivi3`.`fivi_param_super` (`cod_super` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoent_control`
    FOREIGN KEY (`cod_tipoent` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipoent` (`cod_tipoent` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entidad_control`
    FOREIGN KEY (`cod_entidad` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_entidades` (`cod_entidad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_periodos_control` ON `dimpe_fivi3`.`fivi_admin_control` (`cod_periodo` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_super_control` ON `dimpe_fivi3`.`fivi_admin_control` (`cod_super` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_tipoent_control` ON `dimpe_fivi3`.`fivi_admin_control` (`cod_tipoent` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_entidad_control` ON `dimpe_fivi3`.`fivi_admin_control` (`cod_entidad` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_admin_usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_admin_usuarios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_admin_usuarios` (
  `cod_usuario` INT NOT NULL ,
  `cod_tipoid` INT NULL ,
  `num_ident` INT NULL ,
  `dig_valida` TINYINT NULL ,
  `nom_usuario` VARCHAR(255) NULL ,
  `log_usuario` VARCHAR(15) NULL ,
  `pas_usuario` VARCHAR(255) NULL ,
  `mail_usuario` VARCHAR(100) NULL ,
  `fec_creacion` DATETIME NULL ,
  `estado_usuario` TINYINT(1)  NULL ,
  `cod_rol` INT NULL ,
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `cod_entidad` INT NOT NULL ,
  PRIMARY KEY (`cod_usuario`) ,
  CONSTRAINT `fk_super_usuarios`
    FOREIGN KEY (`cod_super` )
    REFERENCES `dimpe_fivi3`.`fivi_param_super` (`cod_super` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoent_usuarios`
    FOREIGN KEY (`cod_tipoent` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipoent` (`cod_tipoent` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entidad_usuarios`
    FOREIGN KEY (`cod_entidad` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_entidades` (`cod_entidad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_super_usuarios` ON `dimpe_fivi3`.`fivi_admin_usuarios` (`cod_super` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_tipoent_usuarios` ON `dimpe_fivi3`.`fivi_admin_usuarios` (`cod_tipoent` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_entidad_usuarios` ON `dimpe_fivi3`.`fivi_admin_usuarios` (`cod_entidad` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_form_identifica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_form_identifica` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_form_identifica` (
  `id_ident` INT NOT NULL AUTO_INCREMENT ,
  `resp_info` VARCHAR(255) NULL ,
  `cargo_info` VARCHAR(255) NULL ,
  `tel_info` INT(15) NULL ,
  `mail_info` VARCHAR(100) NULL ,
  `fec_dili` DATETIME NULL ,
  `cod_periodo` INT NOT NULL ,
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `cod_entidad` INT NOT NULL ,
  PRIMARY KEY (`id_ident`) ,
  CONSTRAINT `fk_identif_control`
    FOREIGN KEY (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_control` (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_identif_control` ON `dimpe_fivi3`.`fivi_form_identifica` (`cod_periodo` ASC, `cod_super` ASC, `cod_tipoent` ASC, `cod_entidad` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_nivsuperv`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_nivsuperv` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_nivsuperv` (
  `cod_nivsup` INT NOT NULL ,
  `nom_nivsup` VARCHAR(50) NULL ,
  PRIMARY KEY (`cod_nivsup`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_deptos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_deptos` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_deptos` (
  `cod_depto` INT NOT NULL ,
  `nom_depto` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_depto`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_mpios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_mpios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_mpios` (
  `cod_mpio` INT NOT NULL ,
  `nom_mpio` VARCHAR(100) NULL ,
  `cod_depto` INT NOT NULL ,
  PRIMARY KEY (`cod_mpio`) ,
  CONSTRAINT `fk_deptos_mpios`
    FOREIGN KEY (`cod_depto` )
    REFERENCES `dimpe_fivi3`.`fivi_param_deptos` (`cod_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_deptos_mpios` ON `dimpe_fivi3`.`fivi_param_mpios` (`cod_depto` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_opefin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_opefin` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_opefin` (
  `cod_opefin` INT NOT NULL ,
  `nom_opefin` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_opefin`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_destcred`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_destcred` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_destcred` (
  `cod_descre` INT NOT NULL ,
  `nom_descre` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_descre`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_tipovivienda`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_tipovivienda` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_tipovivienda` (
  `cod_tipoviv` INT NOT NULL ,
  `nom_tipoviv` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_tipoviv`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_moneda`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_moneda` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_moneda` (
  `cod_moneda` INT NOT NULL ,
  `nom_moneda` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_moneda`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_destino`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_destino` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_destino` (
  `cod_destino` INT NOT NULL ,
  `nom_destino` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_destino`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_modalidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_modalidad` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_modalidad` (
  `cod_modal` INT NOT NULL ,
  `nom_modal` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_modal`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_ranviv`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_ranviv` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_ranviv` (
  `cod_ranviv` INT NOT NULL ,
  `nom_ranviv` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_ranviv`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_form_fivireg`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_form_fivireg` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_form_fivireg` (
  `id_fivireg` INT NOT NULL AUTO_INCREMENT ,
  `n_sup` INT NOT NULL ,
  `cod_dep` INT NOT NULL ,
  `cod_mun` INT NOT NULL ,
  `cod_dep1` INT NOT NULL ,
  `cod_mun1` INT NOT NULL ,
  `ope_fin` INT NOT NULL ,
  `des_cre` INT NOT NULL ,
  `tip_viv` INT NOT NULL ,
  `sub_sfv` INT NULL ,
  `mon` INT NOT NULL ,
  `dest` INT NOT NULL ,
  `modal` INT NOT NULL ,
  `ran_viv` INT NOT NULL ,
  `num_cre` INT NULL ,
  `vr_cre` DOUBLE NULL ,
  `cod_periodo` INT NOT NULL ,
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `cod_entidad` INT NOT NULL ,
  PRIMARY KEY (`id_fivireg`) ,
  CONSTRAINT `fk_control_fiviregs`
    FOREIGN KEY (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_control` (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nivsuperv_fiviregs`
    FOREIGN KEY (`n_sup` )
    REFERENCES `dimpe_fivi3`.`fivi_param_nivsuperv` (`cod_nivsup` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos_fiviregs`
    FOREIGN KEY (`cod_dep` )
    REFERENCES `dimpe_fivi3`.`fivi_param_deptos` (`cod_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos1_fiviregs1`
    FOREIGN KEY (`cod_dep1` )
    REFERENCES `dimpe_fivi3`.`fivi_param_deptos` (`cod_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios_fiviregs`
    FOREIGN KEY (`cod_mun` )
    REFERENCES `dimpe_fivi3`.`fivi_param_mpios` (`cod_mpio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios1_fiviregs1`
    FOREIGN KEY (`cod_mun1` )
    REFERENCES `dimpe_fivi3`.`fivi_param_mpios` (`cod_mpio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opefin_fiviregs`
    FOREIGN KEY (`ope_fin` )
    REFERENCES `dimpe_fivi3`.`fivi_param_opefin` (`cod_opefin` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destcred_fiviregs`
    FOREIGN KEY (`des_cre` )
    REFERENCES `dimpe_fivi3`.`fivi_param_destcred` (`cod_descre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoviv_fiviregs`
    FOREIGN KEY (`tip_viv` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipovivienda` (`cod_tipoviv` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_moneda_fiviregs`
    FOREIGN KEY (`mon` )
    REFERENCES `dimpe_fivi3`.`fivi_param_moneda` (`cod_moneda` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_fiviregs`
    FOREIGN KEY (`dest` )
    REFERENCES `dimpe_fivi3`.`fivi_param_destino` (`cod_destino` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modal_fiviregs`
    FOREIGN KEY (`modal` )
    REFERENCES `dimpe_fivi3`.`fivi_param_modalidad` (`cod_modal` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rangoviv_fiviregs`
    FOREIGN KEY (`ran_viv` )
    REFERENCES `dimpe_fivi3`.`fivi_param_ranviv` (`cod_ranviv` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_control_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`cod_periodo` ASC, `cod_super` ASC, `cod_tipoent` ASC, `cod_entidad` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_nivsuperv_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`n_sup` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_deptos_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`cod_dep` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_deptos1_fiviregs1` ON `dimpe_fivi3`.`fivi_form_fivireg` (`cod_dep1` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_mpios_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`cod_mun` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_mpios1_fiviregs1` ON `dimpe_fivi3`.`fivi_form_fivireg` (`cod_mun1` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_opefin_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`ope_fin` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_destcred_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`des_cre` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_tipoviv_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`tip_viv` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_moneda_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`mon` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_destino_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`dest` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_modal_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`modal` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_rangoviv_fiviregs` ON `dimpe_fivi3`.`fivi_form_fivireg` (`ran_viv` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_sfvestado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_sfvestado` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_sfvestado` (
  `cod_sfvestado` INT NOT NULL ,
  `nom_sfvestado` VARCHAR(45) NULL ,
  PRIMARY KEY (`cod_sfvestado`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_sfvmodal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_sfvmodal` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_sfvmodal` (
  `cod_sfvmodal` INT NOT NULL ,
  `nom_sfvmodal` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_sfvmodal`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_sfvransub`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_sfvransub` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_sfvransub` (
  `cod_sfvransub` INT NOT NULL ,
  `nom_sfvransub` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_sfvransub`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_param_catnovis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_param_catnovis` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_param_catnovis` (
  `cod_catnovis` INT NOT NULL ,
  `nom_catnovis` VARCHAR(100) NULL ,
  PRIMARY KEY (`cod_catnovis`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_form_sfvreg`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_form_sfvreg` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_form_sfvreg` (
  `id_sfvreg` INT NOT NULL ,
  `cod_dep` INT NOT NULL ,
  `cod_mun` INT NOT NULL ,
  `est` INT NOT NULL ,
  `tip_viv` INT NOT NULL ,
  `dest` INT NOT NULL ,
  `modal` INT NOT NULL ,
  `ran_sub` INT NOT NULL ,
  `cat_nvis` INT NOT NULL ,
  `num_sfv` INT NULL ,
  `vr_sfv` DOUBLE NULL ,
  `cod_periodo` INT NOT NULL ,
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `cod_entidad` INT NOT NULL ,
  PRIMARY KEY (`id_sfvreg`) ,
  CONSTRAINT `fk_control_sfvreg`
    FOREIGN KEY (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_control` (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos_sfvreg`
    FOREIGN KEY (`cod_dep` )
    REFERENCES `dimpe_fivi3`.`fivi_param_deptos` (`cod_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios_sfvreg`
    FOREIGN KEY (`cod_mun` )
    REFERENCES `dimpe_fivi3`.`fivi_param_mpios` (`cod_mpio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfvesta_sfvreg`
    FOREIGN KEY (`est` )
    REFERENCES `dimpe_fivi3`.`fivi_param_sfvestado` (`cod_sfvestado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoviv_sfvreg`
    FOREIGN KEY (`tip_viv` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipovivienda` (`cod_tipoviv` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_sfvreg`
    FOREIGN KEY (`dest` )
    REFERENCES `dimpe_fivi3`.`fivi_param_destino` (`cod_destino` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfvmodal_sfvreg`
    FOREIGN KEY (`modal` )
    REFERENCES `dimpe_fivi3`.`fivi_param_sfvmodal` (`cod_sfvmodal` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfvransub_sfvreg`
    FOREIGN KEY (`ran_sub` )
    REFERENCES `dimpe_fivi3`.`fivi_param_sfvransub` (`cod_sfvransub` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catnovis_sfvreg`
    FOREIGN KEY (`cat_nvis` )
    REFERENCES `dimpe_fivi3`.`fivi_param_catnovis` (`cod_catnovis` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_control_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`cod_periodo` ASC, `cod_super` ASC, `cod_tipoent` ASC, `cod_entidad` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_deptos_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`cod_dep` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_mpios_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`cod_mun` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_sfvesta_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`est` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_tipoviv_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`tip_viv` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_destino_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`dest` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_sfvmodal_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`modal` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_sfvransub_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`ran_sub` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_catnovis_sfvreg` ON `dimpe_fivi3`.`fivi_form_sfvreg` (`cat_nvis` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_fivi3`.`fivi_form_leasreg`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_fivi3`.`fivi_form_leasreg` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_fivi3`.`fivi_form_leasreg` (
  `id_leasreg` INT NOT NULL ,
  `cod_dep` INT NOT NULL ,
  `cod_mun` INT NOT NULL ,
  `cod_dep1` INT NOT NULL ,
  `cod_mun1` INT NOT NULL ,
  `ope_fin` INT NOT NULL ,
  `des_lea` INT NOT NULL ,
  `tip_viv` INT NOT NULL ,
  `mon` INT NOT NULL ,
  `ran_viv` INT NOT NULL ,
  `num_lea` INT NULL ,
  `vr_lea` DOUBLE NULL ,
  `cod_periodo` INT NOT NULL ,
  `cod_super` INT NOT NULL ,
  `cod_tipoent` INT NOT NULL ,
  `cod_entidad` INT NOT NULL ,
  PRIMARY KEY (`id_leasreg`) ,
  CONSTRAINT `fk_control_leasreg`
    FOREIGN KEY (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    REFERENCES `dimpe_fivi3`.`fivi_admin_control` (`cod_periodo` , `cod_super` , `cod_tipoent` , `cod_entidad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos_leasreg`
    FOREIGN KEY (`cod_dep` )
    REFERENCES `dimpe_fivi3`.`fivi_param_deptos` (`cod_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos1_leasreg1`
    FOREIGN KEY (`cod_dep1` )
    REFERENCES `dimpe_fivi3`.`fivi_param_deptos` (`cod_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios_leasreg`
    FOREIGN KEY (`cod_mun` )
    REFERENCES `dimpe_fivi3`.`fivi_param_mpios` (`cod_mpio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios1_leasreg1`
    FOREIGN KEY (`cod_mun1` )
    REFERENCES `dimpe_fivi3`.`fivi_param_mpios` (`cod_mpio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opefin_leasreg`
    FOREIGN KEY (`ope_fin` )
    REFERENCES `dimpe_fivi3`.`fivi_param_opefin` (`cod_opefin` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_destcred_leasreg`
    FOREIGN KEY (`des_lea` )
    REFERENCES `dimpe_fivi3`.`fivi_param_destcred` (`cod_descre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoviv_leasreg`
    FOREIGN KEY (`tip_viv` )
    REFERENCES `dimpe_fivi3`.`fivi_param_tipovivienda` (`cod_tipoviv` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_moneda_leasreg`
    FOREIGN KEY (`mon` )
    REFERENCES `dimpe_fivi3`.`fivi_param_moneda` (`cod_moneda` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ranviv_leasreg`
    FOREIGN KEY (`ran_viv` )
    REFERENCES `dimpe_fivi3`.`fivi_param_ranviv` (`cod_ranviv` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `idx_control_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`cod_periodo` ASC, `cod_super` ASC, `cod_tipoent` ASC, `cod_entidad` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_deptos_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`cod_dep` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_deptos1_leasreg1` ON `dimpe_fivi3`.`fivi_form_leasreg` (`cod_dep1` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_mpios_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`cod_mun` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_mpios1_leasreg1` ON `dimpe_fivi3`.`fivi_form_leasreg` (`cod_mun1` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_opefin_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`ope_fin` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_destcred_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`des_lea` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_tipoviv_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`tip_viv` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_moneda_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`mon` ASC) ;

SHOW WARNINGS;
CREATE INDEX `idx_ranviv_leasreg` ON `dimpe_fivi3`.`fivi_form_leasreg` (`ran_viv` ASC) ;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `dimpe_fivi3`.`fivi_param_tipoperiodo`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `dimpe_fivi3`;
INSERT INTO `dimpe_fivi3`.`fivi_param_tipoperiodo` (`cod_tipoper`, `nom_tipoper`) VALUES ('1', 'Anual');
INSERT INTO `dimpe_fivi3`.`fivi_param_tipoperiodo` (`cod_tipoper`, `nom_tipoper`) VALUES ('2', 'Semestral');
INSERT INTO `dimpe_fivi3`.`fivi_param_tipoperiodo` (`cod_tipoper`, `nom_tipoper`) VALUES ('3', 'Trimestral');
INSERT INTO `dimpe_fivi3`.`fivi_param_tipoperiodo` (`cod_tipoper`, `nom_tipoper`) VALUES ('4', 'Mensual');

COMMIT;