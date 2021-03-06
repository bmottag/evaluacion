-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.27


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema dimpe_fivi
--

CREATE DATABASE IF NOT EXISTS dimpe_fivi;
USE dimpe_fivi;

--
-- Definition of table `fivi_admin_control`
--

DROP TABLE IF EXISTS `fivi_admin_control`;
CREATE TABLE `fivi_admin_control` (
  `cod_periodo` int(11) NOT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  `nueva` tinyint(1) DEFAULT NULL,
  `cap_identificacion` int(11) DEFAULT NULL,
  `cap_fivi` int(11) DEFAULT NULL,
  `novedad_fivi` int(11) DEFAULT NULL,
  `estado_fivi` int(11) DEFAULT NULL,
  `cap_sfv` int(11) DEFAULT NULL,
  `novedad_sfv` int(11) DEFAULT NULL,
  `estado_sfv` int(11) DEFAULT NULL,
  `cap_leasing` int(11) DEFAULT NULL,
  `novedad_leasing` int(11) DEFAULT NULL,
  `estado_leasing` int(11) DEFAULT NULL,
  `cap_envio` int(11) DEFAULT NULL,
  `cod_critico` int(11) DEFAULT NULL,
  `cod_logistico` int(11) DEFAULT NULL,
  `fec_cargafivi` datetime DEFAULT NULL,
  `fec_cargasfv` datetime DEFAULT NULL,
  `fec_cargaleasing` datetime DEFAULT NULL,
  `fec_envio` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`),
  KEY `idx_periodos_control` (`cod_periodo`),
  KEY `idx_super_control` (`cod_super`),
  KEY `idx_tipoent_control` (`cod_tipoent`),
  KEY `idx_entidad_control` (`cod_entidad`),
  CONSTRAINT `fk_entidad_control` FOREIGN KEY (`cod_entidad`) REFERENCES `fivi_admin_entidades` (`cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_periodos_control` FOREIGN KEY (`cod_periodo`) REFERENCES `fivi_admin_periodos` (`cod_periodo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_super_control` FOREIGN KEY (`cod_super`) REFERENCES `fivi_param_super` (`cod_super`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoent_control` FOREIGN KEY (`cod_tipoent`) REFERENCES `fivi_param_tipoent` (`cod_tipoent`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_admin_control`
--

/*!40000 ALTER TABLE `fivi_admin_control` DISABLE KEYS */;
INSERT INTO `fivi_admin_control` (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`,`nueva`,`cap_identificacion`,`cap_fivi`,`novedad_fivi`,`estado_fivi`,`cap_sfv`,`novedad_sfv`,`estado_sfv`,`cap_leasing`,`novedad_leasing`,`estado_leasing`,`cap_envio`,`cod_critico`,`cod_logistico`,`fec_cargafivi`,`fec_cargasfv`,`fec_cargaleasing`,`fec_envio`) VALUES 
 (4,1,1,1234,1,2,2,99,4,2,99,4,2,99,4,2,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `fivi_admin_control` ENABLE KEYS */;


--
-- Definition of table `fivi_admin_entidades`
--

DROP TABLE IF EXISTS `fivi_admin_entidades`;
CREATE TABLE `fivi_admin_entidades` (
  `cod_entidad` int(11) NOT NULL,
  `num_ident` int(11) DEFAULT NULL,
  `dig_valida` tinyint(4) DEFAULT NULL,
  `nom_entidad` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mail_entidad` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipoper` int(11) NOT NULL,
  `tipoform` tinyint(4) NOT NULL,
  PRIMARY KEY (`cod_entidad`),
  KEY `idx_tipoper_entidades` (`tipoper`),
  CONSTRAINT `fk_tipoper_entidades` FOREIGN KEY (`tipoper`) REFERENCES `fivi_param_tipoperiodo` (`cod_tipoper`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_admin_entidades`
--

/*!40000 ALTER TABLE `fivi_admin_entidades` DISABLE KEYS */;
INSERT INTO `fivi_admin_entidades` (`cod_entidad`,`num_ident`,`dig_valida`,`nom_entidad`,`mail_entidad`,`tipoper`,`tipoform`) VALUES 
 (1234,123456789,0,'Entidad de Prueba','entidadprueba@localhost.com',3,7);
/*!40000 ALTER TABLE `fivi_admin_entidades` ENABLE KEYS */;


--
-- Definition of table `fivi_admin_periodos`
--

DROP TABLE IF EXISTS `fivi_admin_periodos`;
CREATE TABLE `fivi_admin_periodos` (
  `cod_periodo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_tipoper` int(11) NOT NULL,
  `periodo_ano` int(4) DEFAULT NULL,
  `periodo_sec` int(3) DEFAULT NULL,
  `nom_periodo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_periodo` char(1) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'A - Abierto\nC - Cerrado',
  PRIMARY KEY (`cod_periodo`),
  KEY `idx_tipoperiodo_periodos` (`cod_tipoper`),
  CONSTRAINT `fk_tipoperiodo_periodos` FOREIGN KEY (`cod_tipoper`) REFERENCES `fivi_param_tipoperiodo` (`cod_tipoper`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_admin_periodos`
--

/*!40000 ALTER TABLE `fivi_admin_periodos` DISABLE KEYS */;
INSERT INTO `fivi_admin_periodos` (`cod_periodo`,`cod_tipoper`,`periodo_ano`,`periodo_sec`,`nom_periodo`,`estado_periodo`) VALUES 
 (1,3,2013,1,'Trimestre Enero - Marzo 2013','C'),
 (2,3,2013,2,'Trimestre Abril - Junio 2013','C'),
 (3,3,2013,3,'Trimestre Julio - Septiembre 2013','C'),
 (4,3,2013,4,'Trimestre Octubre - Diciembre','A'),
 (5,4,2013,1,'Enero 2013','C'),
 (6,4,2013,2,'Febrero 2013','C'),
 (7,4,2013,3,'Marzo 2013','C'),
 (8,4,2013,4,'Abril 2013','C'),
 (9,4,2013,5,'Mayo 2013','C'),
 (10,4,2013,6,'Junio 2013','C'),
 (11,4,2013,7,'Julio 2013','C'),
 (12,4,2013,8,'Agosto 2013','C'),
 (13,4,2013,9,'Septiembre 2013','C'),
 (14,4,2013,10,'Octubre 2013','C'),
 (15,4,2013,11,'Noviembre 2013','A'),
 (16,4,2013,12,'Diciembre 2013','C');
/*!40000 ALTER TABLE `fivi_admin_periodos` ENABLE KEYS */;


--
-- Definition of table `fivi_admin_usuarios`
--

DROP TABLE IF EXISTS `fivi_admin_usuarios`;
CREATE TABLE `fivi_admin_usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `cod_tipoid` int(11) DEFAULT NULL,
  `num_ident` int(11) DEFAULT NULL,
  `dig_valida` tinyint(4) DEFAULT NULL,
  `nom_usuario` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `log_usuario` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pas_usuario` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mail_usuario` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_creacion` datetime DEFAULT NULL,
  `estado_usuario` tinyint(1) DEFAULT NULL,
  `cod_rol` int(11) DEFAULT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  PRIMARY KEY (`cod_usuario`),
  KEY `idx_super_usuarios` (`cod_super`),
  KEY `idx_tipoent_usuarios` (`cod_tipoent`),
  KEY `idx_entidad_usuarios` (`cod_entidad`),
  CONSTRAINT `fk_entidad_usuarios` FOREIGN KEY (`cod_entidad`) REFERENCES `fivi_admin_entidades` (`cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_super_usuarios` FOREIGN KEY (`cod_super`) REFERENCES `fivi_param_super` (`cod_super`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoent_usuarios` FOREIGN KEY (`cod_tipoent`) REFERENCES `fivi_param_tipoent` (`cod_tipoent`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_admin_usuarios`
--

/*!40000 ALTER TABLE `fivi_admin_usuarios` DISABLE KEYS */;
INSERT INTO `fivi_admin_usuarios` (`cod_usuario`,`cod_tipoid`,`num_ident`,`dig_valida`,`nom_usuario`,`log_usuario`,`pas_usuario`,`mail_usuario`,`fec_creacion`,`estado_usuario`,`cod_rol`,`cod_super`,`cod_tipoent`,`cod_entidad`) VALUES 
 (1,1,123456789,0,'Entidad de Prueba','F1234','E2OFnvmK4Sy5RoJ2bGAeWtN-J5l4BpL1WvHCaGdbZmw','entidadprueba@localhost.com','2013-11-18 10:33:00',1,1,1,1,1234);
/*!40000 ALTER TABLE `fivi_admin_usuarios` ENABLE KEYS */;


--
-- Definition of table `fivi_backup_regs`
--

DROP TABLE IF EXISTS `fivi_backup_regs`;
CREATE TABLE `fivi_backup_regs` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_reg` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_reg` int(11) DEFAULT NULL,
  `fec_backup` datetime DEFAULT NULL,
  `str_backup` longtext COLLATE utf8_spanish_ci,
  `obs_backup` text COLLATE utf8_spanish_ci,
  `cod_periodo` int(11) DEFAULT NULL,
  `cod_super` int(11) DEFAULT NULL,
  `cod_tipoent` int(11) DEFAULT NULL,
  `cod_entidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_backup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_backup_regs`
--

/*!40000 ALTER TABLE `fivi_backup_regs` DISABLE KEYS */;
/*!40000 ALTER TABLE `fivi_backup_regs` ENABLE KEYS */;


--
-- Definition of table `fivi_form_certnomov`
--

DROP TABLE IF EXISTS `fivi_form_certnomov`;
CREATE TABLE `fivi_form_certnomov` (
  `id_certnomov` int(11) NOT NULL AUTO_INCREMENT,
  `form_certificado` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_certificado` datetime DEFAULT NULL,
  `just_certificado` longtext COLLATE utf8_spanish_ci,
  `cod_periodo` int(11) NOT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  PRIMARY KEY (`id_certnomov`),
  KEY `fk_control_certnomov` (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`),
  CONSTRAINT `fk_control_certnomov` FOREIGN KEY (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) REFERENCES `fivi_admin_control` (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_form_certnomov`
--

/*!40000 ALTER TABLE `fivi_form_certnomov` DISABLE KEYS */;
INSERT INTO `fivi_form_certnomov` (`id_certnomov`,`form_certificado`,`fec_certificado`,`just_certificado`,`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`) VALUES 
 (1,'fivi','2013-11-29 04:23:14','No se diligenciaron registros FIVI.',4,1,1,1234),
 (2,'sfv','2013-11-29 04:23:30','No se diligenciaron registros SFV.',4,1,1,1234),
 (3,'leasing','2013-11-29 04:23:45','No se diligenciaron registros Leasing.',4,1,1,1234);
/*!40000 ALTER TABLE `fivi_form_certnomov` ENABLE KEYS */;


--
-- Definition of table `fivi_form_fivireg`
--

DROP TABLE IF EXISTS `fivi_form_fivireg`;
CREATE TABLE `fivi_form_fivireg` (
  `id_fivireg` int(11) NOT NULL AUTO_INCREMENT,
  `n_sup` int(11) NOT NULL,
  `cod_dep` int(11) NOT NULL,
  `cod_mun` int(11) NOT NULL,
  `cod_dep1` int(11) NOT NULL,
  `cod_mun1` int(11) NOT NULL,
  `ope_fin` int(11) NOT NULL,
  `des_cre` int(11) NOT NULL,
  `tip_viv` int(11) NOT NULL,
  `sub_sfv` int(11) DEFAULT NULL,
  `mon` int(11) NOT NULL,
  `dest` int(11) NOT NULL,
  `modal` int(11) NOT NULL,
  `ran_viv` int(11) NOT NULL,
  `num_cre` int(11) DEFAULT NULL,
  `vr_cre` double DEFAULT NULL,
  `cod_periodo` int(11) NOT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  PRIMARY KEY (`id_fivireg`),
  KEY `idx_control_fiviregs` (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`),
  KEY `idx_nivsuperv_fiviregs` (`n_sup`),
  KEY `idx_deptos_fiviregs` (`cod_dep`),
  KEY `idx_deptos1_fiviregs1` (`cod_dep1`),
  KEY `idx_mpios_fiviregs` (`cod_mun`),
  KEY `idx_mpios1_fiviregs1` (`cod_mun1`),
  KEY `idx_opefin_fiviregs` (`ope_fin`),
  KEY `idx_destcred_fiviregs` (`des_cre`),
  KEY `idx_tipoviv_fiviregs` (`tip_viv`),
  KEY `idx_moneda_fiviregs` (`mon`),
  KEY `idx_destino_fiviregs` (`dest`),
  KEY `idx_modal_fiviregs` (`modal`),
  KEY `idx_rangoviv_fiviregs` (`ran_viv`),
  CONSTRAINT `fk_control_fiviregs` FOREIGN KEY (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) REFERENCES `fivi_admin_control` (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos1_fiviregs1` FOREIGN KEY (`cod_dep1`) REFERENCES `fivi_param_deptos` (`cod_depto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos_fiviregs` FOREIGN KEY (`cod_dep`) REFERENCES `fivi_param_deptos` (`cod_depto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_destcred_fiviregs` FOREIGN KEY (`des_cre`) REFERENCES `fivi_param_destcred` (`cod_descre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_fiviregs` FOREIGN KEY (`dest`) REFERENCES `fivi_param_destino` (`cod_destino`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_modal_fiviregs` FOREIGN KEY (`modal`) REFERENCES `fivi_param_modalidad` (`cod_modal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_moneda_fiviregs` FOREIGN KEY (`mon`) REFERENCES `fivi_param_moneda` (`cod_moneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios1_fiviregs1` FOREIGN KEY (`cod_mun1`) REFERENCES `fivi_param_mpios` (`cod_mpio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios_fiviregs` FOREIGN KEY (`cod_mun`) REFERENCES `fivi_param_mpios` (`cod_mpio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nivsuperv_fiviregs` FOREIGN KEY (`n_sup`) REFERENCES `fivi_param_nivsuperv` (`cod_nivsup`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_opefin_fiviregs` FOREIGN KEY (`ope_fin`) REFERENCES `fivi_param_opefin` (`cod_opefin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rangoviv_fiviregs` FOREIGN KEY (`ran_viv`) REFERENCES `fivi_param_ranviv` (`cod_ranviv`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoviv_fiviregs` FOREIGN KEY (`tip_viv`) REFERENCES `fivi_param_tipovivienda` (`cod_tipoviv`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_form_fivireg`
--

/*!40000 ALTER TABLE `fivi_form_fivireg` DISABLE KEYS */;
/*!40000 ALTER TABLE `fivi_form_fivireg` ENABLE KEYS */;


--
-- Definition of table `fivi_form_identifica`
--

DROP TABLE IF EXISTS `fivi_form_identifica`;
CREATE TABLE `fivi_form_identifica` (
  `id_ident` int(11) NOT NULL AUTO_INCREMENT,
  `resp_info` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cargo_info` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tel_info` int(15) DEFAULT NULL,
  `mail_info` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_dili` datetime DEFAULT NULL,
  `cod_periodo` int(11) NOT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  PRIMARY KEY (`id_ident`),
  KEY `idx_identif_control` (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`),
  CONSTRAINT `fk_identif_control` FOREIGN KEY (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) REFERENCES `fivi_admin_control` (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_form_identifica`
--

/*!40000 ALTER TABLE `fivi_form_identifica` DISABLE KEYS */;
INSERT INTO `fivi_form_identifica` (`id_ident`,`resp_info`,`cargo_info`,`tel_info`,`mail_info`,`fec_dili`,`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`) VALUES 
 (1,'Responsable de la Información','Cargo del responsable de la informacion',123456789,'regpruebas@localhost.com','2013-11-18 04:42:55',4,1,1,1234);
/*!40000 ALTER TABLE `fivi_form_identifica` ENABLE KEYS */;


--
-- Definition of table `fivi_form_leasreg`
--

DROP TABLE IF EXISTS `fivi_form_leasreg`;
CREATE TABLE `fivi_form_leasreg` (
  `id_leasreg` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dep` int(11) NOT NULL,
  `cod_mun` int(11) NOT NULL,
  `cod_dep1` int(11) NOT NULL,
  `cod_mun1` int(11) NOT NULL,
  `ope_fin` int(11) NOT NULL,
  `des_lea` int(11) NOT NULL,
  `tip_viv` int(11) NOT NULL,
  `mon` int(11) NOT NULL,
  `ran_viv` int(11) NOT NULL,
  `num_lea` int(11) DEFAULT NULL,
  `vr_lea` double DEFAULT NULL,
  `cod_periodo` int(11) NOT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  PRIMARY KEY (`id_leasreg`),
  KEY `idx_control_leasreg` (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`),
  KEY `idx_deptos_leasreg` (`cod_dep`),
  KEY `idx_deptos1_leasreg1` (`cod_dep1`),
  KEY `idx_mpios_leasreg` (`cod_mun`),
  KEY `idx_mpios1_leasreg1` (`cod_mun1`),
  KEY `idx_opefin_leasreg` (`ope_fin`),
  KEY `idx_destcred_leasreg` (`des_lea`),
  KEY `idx_tipoviv_leasreg` (`tip_viv`),
  KEY `idx_moneda_leasreg` (`mon`),
  KEY `idx_ranviv_leasreg` (`ran_viv`),
  CONSTRAINT `fk_control_leasreg` FOREIGN KEY (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) REFERENCES `fivi_admin_control` (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos1_leasreg1` FOREIGN KEY (`cod_dep1`) REFERENCES `fivi_param_deptos` (`cod_depto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos_leasreg` FOREIGN KEY (`cod_dep`) REFERENCES `fivi_param_deptos` (`cod_depto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_destcred_leasreg` FOREIGN KEY (`des_lea`) REFERENCES `fivi_param_destcred` (`cod_descre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_moneda_leasreg` FOREIGN KEY (`mon`) REFERENCES `fivi_param_moneda` (`cod_moneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios1_leasreg1` FOREIGN KEY (`cod_mun1`) REFERENCES `fivi_param_mpios` (`cod_mpio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios_leasreg` FOREIGN KEY (`cod_mun`) REFERENCES `fivi_param_mpios` (`cod_mpio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_opefin_leasreg` FOREIGN KEY (`ope_fin`) REFERENCES `fivi_param_opefin` (`cod_opefin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ranviv_leasreg` FOREIGN KEY (`ran_viv`) REFERENCES `fivi_param_ranviv` (`cod_ranviv`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoviv_leasreg` FOREIGN KEY (`tip_viv`) REFERENCES `fivi_param_tipovivienda` (`cod_tipoviv`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_form_leasreg`
--

/*!40000 ALTER TABLE `fivi_form_leasreg` DISABLE KEYS */;
/*!40000 ALTER TABLE `fivi_form_leasreg` ENABLE KEYS */;


--
-- Definition of table `fivi_form_sfvreg`
--

DROP TABLE IF EXISTS `fivi_form_sfvreg`;
CREATE TABLE `fivi_form_sfvreg` (
  `id_sfvreg` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dep` int(11) NOT NULL,
  `cod_mun` int(11) NOT NULL,
  `est` int(11) NOT NULL,
  `tip_viv` int(11) NOT NULL,
  `dest` int(11) NOT NULL,
  `modal` int(11) NOT NULL,
  `ran_sub` int(11) NOT NULL,
  `cat_nvis` int(11) NOT NULL,
  `num_sfv` int(11) DEFAULT NULL,
  `vr_sfv` double DEFAULT NULL,
  `cod_periodo` int(11) NOT NULL,
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `cod_entidad` int(11) NOT NULL,
  PRIMARY KEY (`id_sfvreg`),
  KEY `idx_control_sfvreg` (`cod_periodo`,`cod_super`,`cod_tipoent`,`cod_entidad`),
  KEY `idx_deptos_sfvreg` (`cod_dep`),
  KEY `idx_mpios_sfvreg` (`cod_mun`),
  KEY `idx_sfvesta_sfvreg` (`est`),
  KEY `idx_tipoviv_sfvreg` (`tip_viv`),
  KEY `idx_destino_sfvreg` (`dest`),
  KEY `idx_sfvmodal_sfvreg` (`modal`),
  KEY `idx_sfvransub_sfvreg` (`ran_sub`),
  KEY `idx_catnovis_sfvreg` (`cat_nvis`),
  CONSTRAINT `fk_catnovis_sfvreg` FOREIGN KEY (`cat_nvis`) REFERENCES `fivi_param_catnovis` (`cod_catnovis`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_sfvreg` FOREIGN KEY (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) REFERENCES `fivi_admin_control` (`cod_periodo`, `cod_super`, `cod_tipoent`, `cod_entidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deptos_sfvreg` FOREIGN KEY (`cod_dep`) REFERENCES `fivi_param_deptos` (`cod_depto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_destino_sfvreg` FOREIGN KEY (`dest`) REFERENCES `fivi_param_destino` (`cod_destino`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mpios_sfvreg` FOREIGN KEY (`cod_mun`) REFERENCES `fivi_param_mpios` (`cod_mpio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfvesta_sfvreg` FOREIGN KEY (`est`) REFERENCES `fivi_param_sfvestado` (`cod_sfvestado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfvmodal_sfvreg` FOREIGN KEY (`modal`) REFERENCES `fivi_param_sfvmodal` (`cod_sfvmodal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sfvransub_sfvreg` FOREIGN KEY (`ran_sub`) REFERENCES `fivi_param_sfvransub` (`cod_sfvransub`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoviv_sfvreg` FOREIGN KEY (`tip_viv`) REFERENCES `fivi_param_tipovivienda` (`cod_tipoviv`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_form_sfvreg`
--

/*!40000 ALTER TABLE `fivi_form_sfvreg` DISABLE KEYS */;
/*!40000 ALTER TABLE `fivi_form_sfvreg` ENABLE KEYS */;


--
-- Definition of table `fivi_param_catnovis`
--

DROP TABLE IF EXISTS `fivi_param_catnovis`;
CREATE TABLE `fivi_param_catnovis` (
  `cod_catnovis` int(11) NOT NULL,
  `nom_catnovis` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_catnovis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_catnovis`
--

/*!40000 ALTER TABLE `fivi_param_catnovis` DISABLE KEYS */;
INSERT INTO `fivi_param_catnovis` (`cod_catnovis`,`nom_catnovis`) VALUES 
 (1,'Oficial'),
 (2,'Suboficial'),
 (3,'Agente'),
 (4,'Soldado');
/*!40000 ALTER TABLE `fivi_param_catnovis` ENABLE KEYS */;


--
-- Definition of table `fivi_param_deptos`
--

DROP TABLE IF EXISTS `fivi_param_deptos`;
CREATE TABLE `fivi_param_deptos` (
  `cod_depto` int(11) NOT NULL,
  `nom_depto` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_depto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_deptos`
--

/*!40000 ALTER TABLE `fivi_param_deptos` DISABLE KEYS */;
INSERT INTO `fivi_param_deptos` (`cod_depto`,`nom_depto`) VALUES 
 (5,'Antioquia'),
 (8,'Atlantico'),
 (11,'Bogota D.C.'),
 (13,'Bolivar'),
 (15,'Boyaca'),
 (17,'Caldas'),
 (18,'Caqueta'),
 (19,'Cauca'),
 (20,'Cesar'),
 (23,'Cordoba'),
 (25,'Cundinamarca'),
 (27,'Choco'),
 (41,'Huila'),
 (44,'Guajira'),
 (47,'Magdalena'),
 (50,'Meta'),
 (52,'Nariño'),
 (54,'Norte de Santander'),
 (63,'Quindio'),
 (66,'Risaralda'),
 (68,'Santander'),
 (70,'Sucre'),
 (73,'Tolima'),
 (76,'Valle del Cauca'),
 (81,'Arauca'),
 (85,'Casanare'),
 (86,'Putumayo'),
 (88,'San Andres y Providencia'),
 (91,'Amazonas'),
 (94,'Guainia'),
 (95,'Guaviare'),
 (97,'Vaupes'),
 (99,'Vichada');
/*!40000 ALTER TABLE `fivi_param_deptos` ENABLE KEYS */;


--
-- Definition of table `fivi_param_destcred`
--

DROP TABLE IF EXISTS `fivi_param_destcred`;
CREATE TABLE `fivi_param_destcred` (
  `cod_descre` int(11) NOT NULL,
  `nom_descre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_descre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_destcred`
--

/*!40000 ALTER TABLE `fivi_param_destcred` DISABLE KEYS */;
INSERT INTO `fivi_param_destcred` (`cod_descre`,`nom_descre`) VALUES 
 (1,'Habitacional'),
 (2,'No Habitacional');
/*!40000 ALTER TABLE `fivi_param_destcred` ENABLE KEYS */;


--
-- Definition of table `fivi_param_destino`
--

DROP TABLE IF EXISTS `fivi_param_destino`;
CREATE TABLE `fivi_param_destino` (
  `cod_destino` int(11) NOT NULL,
  `nom_destino` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_destino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_destino`
--

/*!40000 ALTER TABLE `fivi_param_destino` DISABLE KEYS */;
INSERT INTO `fivi_param_destino` (`cod_destino`,`nom_destino`) VALUES 
 (1,'Apartamento'),
 (2,'Casa');
/*!40000 ALTER TABLE `fivi_param_destino` ENABLE KEYS */;


--
-- Definition of table `fivi_param_modalidad`
--

DROP TABLE IF EXISTS `fivi_param_modalidad`;
CREATE TABLE `fivi_param_modalidad` (
  `cod_modal` int(11) NOT NULL,
  `nom_modal` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_modal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_modalidad`
--

/*!40000 ALTER TABLE `fivi_param_modalidad` DISABLE KEYS */;
INSERT INTO `fivi_param_modalidad` (`cod_modal`,`nom_modal`) VALUES 
 (1,'Compra'),
 (2,'Construcción en sitio propio');
/*!40000 ALTER TABLE `fivi_param_modalidad` ENABLE KEYS */;


--
-- Definition of table `fivi_param_moneda`
--

DROP TABLE IF EXISTS `fivi_param_moneda`;
CREATE TABLE `fivi_param_moneda` (
  `cod_moneda` int(11) NOT NULL,
  `nom_moneda` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_moneda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_moneda`
--

/*!40000 ALTER TABLE `fivi_param_moneda` DISABLE KEYS */;
INSERT INTO `fivi_param_moneda` (`cod_moneda`,`nom_moneda`) VALUES 
 (1,'Pesos'),
 (2,'UVR');
/*!40000 ALTER TABLE `fivi_param_moneda` ENABLE KEYS */;


--
-- Definition of table `fivi_param_mpios`
--

DROP TABLE IF EXISTS `fivi_param_mpios`;
CREATE TABLE `fivi_param_mpios` (
  `cod_mpio` int(11) NOT NULL,
  `nom_mpio` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_depto` int(11) NOT NULL,
  PRIMARY KEY (`cod_mpio`),
  KEY `idx_deptos_mpios` (`cod_depto`),
  CONSTRAINT `fk_deptos_mpios` FOREIGN KEY (`cod_depto`) REFERENCES `fivi_param_deptos` (`cod_depto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_mpios`
--

/*!40000 ALTER TABLE `fivi_param_mpios` DISABLE KEYS */;
INSERT INTO `fivi_param_mpios` (`cod_mpio`,`nom_mpio`,`cod_depto`) VALUES 
 (5001,'MEDELLÍN',5),
 (5002,'ABEJORRAL',5),
 (5004,'ABRIAQUÍ',5),
 (5021,'ALEJANDRÍA',5),
 (5030,'AMAGÁ',5),
 (5031,'AMALFI',5),
 (5034,'ANDES',5),
 (5036,'ANGELÓPOLIS',5),
 (5038,'ANGOSTURA',5),
 (5040,'ANORÍ',5),
 (5042,'SANTAFÉ DE ANTIOQUIA',5),
 (5044,'ANZA',5),
 (5045,'APARTADÓ',5),
 (5051,'ARBOLETES',5),
 (5055,'ARGELIA',5),
 (5059,'ARMENIA',5),
 (5079,'BARBOSA',5),
 (5086,'BELMIRA',5),
 (5088,'BELLO',5),
 (5091,'BETANIA',5),
 (5093,'BETULIA',5),
 (5101,'CIUDAD BOLÍVAR',5),
 (5107,'BRICEÑO',5),
 (5113,'BURITICÁ',5),
 (5120,'CÁCERES',5),
 (5125,'CAICEDO',5),
 (5129,'CALDAS',5),
 (5134,'CAMPAMENTO',5),
 (5138,'CAÑASGORDAS',5),
 (5142,'CARACOLÍ',5),
 (5145,'CARAMANTA',5),
 (5147,'CAREPA',5),
 (5148,'EL CARMEN DE VIBORAL',5),
 (5150,'CAROLINA',5),
 (5154,'CAUCASIA',5),
 (5172,'CHIGORODÓ',5),
 (5190,'CISNEROS',5),
 (5197,'COCORNÁ',5),
 (5206,'CONCEPCIÓN',5),
 (5209,'CONCORDIA',5),
 (5212,'COPACABANA',5),
 (5234,'DABEIBA',5),
 (5237,'DONMATÍAS',5),
 (5240,'EBÉJICO',5),
 (5250,'EL BAGRE',5),
 (5264,'ENTRERRIOS',5),
 (5266,'ENVIGADO',5),
 (5282,'FREDONIA',5),
 (5284,'FRONTINO',5),
 (5306,'GIRALDO',5),
 (5308,'GIRARDOTA',5),
 (5310,'GÓMEZ PLATA',5),
 (5313,'GRANADA',5),
 (5315,'GUADALUPE',5),
 (5318,'GUARNE',5),
 (5321,'GUATAPE',5),
 (5347,'HELICONIA',5),
 (5353,'HISPANIA',5),
 (5360,'ITAGUI',5),
 (5361,'ITUANGO',5),
 (5364,'JARDÍN',5),
 (5368,'JERICÓ',5),
 (5376,'LA CEJA',5),
 (5380,'LA ESTRELLA',5),
 (5390,'LA PINTADA',5),
 (5400,'LA UNIÓN',5),
 (5411,'LIBORINA',5),
 (5425,'MACEO',5),
 (5440,'MARINILLA',5),
 (5467,'MONTEBELLO',5),
 (5475,'MURINDÓ',5),
 (5480,'MUTATÁ',5),
 (5483,'NARIÑO',5),
 (5490,'NECOCLÍ',5),
 (5495,'NECHÍ',5),
 (5501,'OLAYA',5),
 (5541,'PEÑOL',5),
 (5543,'PEQUE',5),
 (5576,'PUEBLORRICO',5),
 (5579,'PUERTO BERRÍO',5),
 (5585,'PUERTO NARE',5),
 (5591,'PUERTO TRIUNFO',5),
 (5604,'REMEDIOS',5),
 (5607,'RETIRO',5),
 (5615,'RIONEGRO',5),
 (5628,'SABANALARGA',5),
 (5631,'SABANETA',5),
 (5642,'SALGAR',5),
 (5647,'SAN ANDRÉS DE CUERQUÍA',5),
 (5649,'SAN CARLOS',5),
 (5652,'SAN FRANCISCO',5),
 (5656,'SAN JERÓNIMO',5),
 (5658,'SAN JOSÉ DE LA MONTAÑA',5),
 (5659,'SAN JUAN DE URABÁ',5),
 (5660,'SAN LUIS',5),
 (5664,'SAN PEDRO DE LOS MILAGROS',5),
 (5665,'SAN PEDRO DE URABA',5),
 (5667,'SAN RAFAEL',5),
 (5670,'SAN ROQUE',5),
 (5674,'SAN VICENTE',5),
 (5679,'SANTA BÁRBARA',5),
 (5686,'SANTA ROSA DE OSOS',5),
 (5690,'SANTO DOMINGO',5),
 (5697,'EL SANTUARIO',5),
 (5736,'SEGOVIA',5),
 (5756,'SONSON',5),
 (5761,'SOPETRÁN',5),
 (5789,'TÁMESIS',5),
 (5790,'TARAZÁ',5),
 (5792,'TARSO',5),
 (5809,'TITIRIBÍ',5),
 (5819,'TOLEDO',5),
 (5837,'TURBO',5),
 (5842,'URAMITA',5),
 (5847,'URRAO',5),
 (5854,'VALDIVIA',5),
 (5856,'VALPARAÍSO',5),
 (5858,'VEGACHÍ',5),
 (5861,'VENECIA',5),
 (5873,'VIGÍA DEL FUERTE',5),
 (5885,'YALÍ',5),
 (5887,'YARUMAL',5),
 (5890,'YOLOMBÓ',5),
 (5893,'YONDÓ',5),
 (5895,'ZARAGOZA',5),
 (8001,'BARRANQUILLA',8),
 (8078,'BARANOA',8),
 (8137,'CAMPO DE LA CRUZ',8),
 (8141,'CANDELARIA',8),
 (8296,'GALAPA',8),
 (8372,'JUAN DE ACOSTA',8),
 (8421,'LURUACO',8),
 (8433,'MALAMBO',8),
 (8436,'MANATÍ',8),
 (8520,'PALMAR DE VARELA',8),
 (8549,'PIOJÓ',8),
 (8558,'POLONUEVO',8),
 (8560,'PONEDERA',8),
 (8573,'PUERTO COLOMBIA',8),
 (8606,'REPELÓN',8),
 (8634,'SABANAGRANDE',8),
 (8638,'SABANALARGA',8),
 (8675,'SANTA LUCÍA',8),
 (8685,'SANTO TOMÁS',8),
 (8758,'SOLEDAD',8),
 (8770,'SUAN',8),
 (8832,'TUBARÁ',8),
 (8849,'USIACURÍ',8),
 (11001,'BOGOTÁ, D.C.',11),
 (13001,'CARTAGENA',13),
 (13006,'ACHÍ',13),
 (13030,'ALTOS DEL ROSARIO',13),
 (13042,'ARENAL',13),
 (13052,'ARJONA',13),
 (13062,'ARROYOHONDO',13),
 (13074,'BARRANCO DE LOBA',13),
 (13140,'CALAMAR',13),
 (13160,'CANTAGALLO',13),
 (13188,'CICUCO',13),
 (13212,'CÓRDOBA',13),
 (13222,'CLEMENCIA',13),
 (13244,'EL CARMEN DE BOLÍVAR',13),
 (13248,'EL GUAMO',13),
 (13268,'EL PEÑÓN',13),
 (13300,'HATILLO DE LOBA',13),
 (13430,'MAGANGUÉ',13),
 (13433,'MAHATES',13),
 (13440,'MARGARITA',13),
 (13442,'MARÍA LA BAJA',13),
 (13458,'MONTECRISTO',13),
 (13468,'MOMPÓS',13),
 (13473,'MORALES',13),
 (13490,'NOROSÍ',13),
 (13549,'PINILLOS',13),
 (13580,'REGIDOR',13),
 (13600,'RÍO VIEJO',13),
 (13620,'SAN CRISTÓBAL',13),
 (13647,'SAN ESTANISLAO',13),
 (13650,'SAN FERNANDO',13),
 (13654,'SAN JACINTO',13),
 (13655,'SAN JACINTO DEL CAUCA',13),
 (13657,'SAN JUAN NEPOMUCENO',13),
 (13667,'SAN MARTÍN DE LOBA',13),
 (13670,'SAN PABLO',13),
 (13673,'SANTA CATALINA',13),
 (13683,'SANTA ROSA',13),
 (13688,'SANTA ROSA DEL SUR',13),
 (13744,'SIMITÍ',13),
 (13760,'SOPLAVIENTO',13),
 (13780,'TALAIGUA NUEVO',13),
 (13810,'TIQUISIO',13),
 (13836,'TURBACO',13),
 (13838,'TURBANÁ',13),
 (13873,'VILLANUEVA',13),
 (13894,'ZAMBRANO',13),
 (15001,'TUNJA',15),
 (15022,'ALMEIDA',15),
 (15047,'AQUITANIA',15),
 (15051,'ARCABUCO',15),
 (15087,'BELÉN',15),
 (15090,'BERBEO',15),
 (15092,'BETÉITIVA',15),
 (15097,'BOAVITA',15),
 (15104,'BOYACÁ',15),
 (15106,'BRICEÑO',15),
 (15109,'BUENAVISTA',15),
 (15114,'BUSBANZÁ',15),
 (15131,'CALDAS',15),
 (15135,'CAMPOHERMOSO',15),
 (15162,'CERINZA',15),
 (15172,'CHINAVITA',15),
 (15176,'CHIQUINQUIRÁ',15),
 (15180,'CHISCAS',15),
 (15183,'CHITA',15),
 (15185,'CHITARAQUE',15),
 (15187,'CHIVATÁ',15),
 (15189,'CIÉNEGA',15),
 (15204,'CÓMBITA',15),
 (15212,'COPER',15),
 (15215,'CORRALES',15),
 (15218,'COVARACHÍA',15),
 (15223,'CUBARÁ',15),
 (15224,'CUCAITA',15),
 (15226,'CUÍTIVA',15),
 (15232,'CHÍQUIZA',15),
 (15236,'CHIVOR',15),
 (15238,'DUITAMA',15),
 (15244,'EL COCUY',15),
 (15248,'EL ESPINO',15),
 (15272,'FIRAVITOBA',15),
 (15276,'FLORESTA',15),
 (15293,'GACHANTIVÁ',15),
 (15296,'GAMEZA',15),
 (15299,'GARAGOA',15),
 (15317,'GUACAMAYAS',15),
 (15322,'GUATEQUE',15),
 (15325,'GUAYATÁ',15),
 (15332,'GÃœICÁN',15),
 (15362,'IZA',15),
 (15367,'JENESANO',15),
 (15368,'JERICÓ',15),
 (15377,'LABRANZAGRANDE',15),
 (15380,'LA CAPILLA',15),
 (15401,'LA VICTORIA',15),
 (15403,'LA UVITA',15),
 (15407,'VILLA DE LEYVA',15),
 (15425,'MACANAL',15),
 (15442,'MARIPÍ',15),
 (15455,'MIRAFLORES',15),
 (15464,'MONGUA',15),
 (15466,'MONGUÍ',15),
 (15469,'MONIQUIRÁ',15),
 (15476,'MOTAVITA',15),
 (15480,'MUZO',15),
 (15491,'NOBSA',15),
 (15494,'NUEVO COLÓN',15),
 (15500,'OICATÁ',15),
 (15507,'OTANCHE',15),
 (15511,'PACHAVITA',15),
 (15514,'PÁEZ',15),
 (15516,'PAIPA',15),
 (15518,'PAJARITO',15),
 (15522,'PANQUEBA',15),
 (15531,'PAUNA',15),
 (15533,'PAYA',15),
 (15537,'PAZ DE RÍO',15),
 (15542,'PESCA',15),
 (15550,'PISBA',15),
 (15572,'PUERTO BOYACÁ',15),
 (15580,'QUÍPAMA',15),
 (15599,'RAMIRIQUÍ',15),
 (15600,'RÁQUIRA',15),
 (15621,'RONDÓN',15),
 (15632,'SABOYÁ',15),
 (15638,'SÁCHICA',15),
 (15646,'SAMACÁ',15),
 (15660,'SAN EDUARDO',15),
 (15664,'SAN JOSÉ DE PARE',15),
 (15667,'SAN LUIS DE GACENO',15),
 (15673,'SAN MATEO',15),
 (15676,'SAN MIGUEL DE SEMA',15),
 (15681,'SAN PABLO DE BORBUR',15),
 (15686,'SANTANA',15),
 (15690,'SANTA MARÍA',15),
 (15693,'SANTA ROSA DE VITERBO',15),
 (15696,'SANTA SOFÍA',15),
 (15720,'SATIVANORTE',15),
 (15723,'SATIVASUR',15),
 (15740,'SIACHOQUE',15),
 (15753,'SOATÁ',15),
 (15755,'SOCOTÁ',15),
 (15757,'SOCHA',15),
 (15759,'SOGAMOSO',15),
 (15761,'SOMONDOCO',15),
 (15762,'SORA',15),
 (15763,'SOTAQUIRÁ',15),
 (15764,'SORACÁ',15),
 (15774,'SUSACÓN',15),
 (15776,'SUTAMARCHÁN',15),
 (15778,'SUTATENZA',15),
 (15790,'TASCO',15),
 (15798,'TENZA',15),
 (15804,'TIBANÁ',15),
 (15806,'TIBASOSA',15),
 (15808,'TINJACÁ',15),
 (15810,'TIPACOQUE',15),
 (15814,'TOCA',15),
 (15816,'TOGÃœÍ',15),
 (15820,'TÓPAGA',15),
 (15822,'TOTA',15),
 (15832,'TUNUNGUÁ',15),
 (15835,'TURMEQUÉ',15),
 (15837,'TUTA',15),
 (15839,'TUTAZÁ',15),
 (15842,'UMBITA',15),
 (15861,'VENTAQUEMADA',15),
 (15879,'VIRACACHÁ',15),
 (15897,'ZETAQUIRA',15),
 (17001,'MANIZALES',17),
 (17013,'AGUADAS',17),
 (17042,'ANSERMA',17),
 (17050,'ARANZAZU',17),
 (17088,'BELALCÁZAR',17),
 (17174,'CHINCHINÁ',17),
 (17272,'FILADELFIA',17),
 (17380,'LA DORADA',17),
 (17388,'LA MERCED',17),
 (17433,'MANZANARES',17),
 (17442,'MARMATO',17),
 (17444,'MARQUETALIA',17),
 (17446,'MARULANDA',17),
 (17486,'NEIRA',17),
 (17495,'NORCASIA',17),
 (17513,'PÁCORA',17),
 (17524,'PALESTINA',17),
 (17541,'PENSILVANIA',17),
 (17614,'RIOSUCIO',17),
 (17616,'RISARALDA',17),
 (17653,'SALAMINA',17),
 (17662,'SAMANÁ',17),
 (17665,'SAN JOSÉ',17),
 (17777,'SUPÍA',17),
 (17867,'VICTORIA',17),
 (17873,'VILLAMARÍA',17),
 (17877,'VITERBO',17),
 (18001,'FLORENCIA',18),
 (18029,'ALBANIA',18),
 (18094,'BELÉN DE LOS ANDAQUÍES',18),
 (18150,'CARTAGENA DEL CHAIRÁ',18),
 (18205,'CURILLO',18),
 (18247,'EL DONCELLO',18),
 (18256,'EL PAUJIL',18),
 (18410,'LA MONTAÑITA',18),
 (18460,'MILÁN',18),
 (18479,'MORELIA',18),
 (18592,'PUERTO RICO',18),
 (18610,'SAN JOSÉ DEL FRAGUA',18),
 (18753,'SAN VICENTE DEL CAGUÁN',18),
 (18756,'SOLANO',18),
 (18785,'SOLITA',18),
 (18860,'VALPARAÍSO',18),
 (19001,'POPAYÁN',19),
 (19022,'ALMAGUER',19),
 (19050,'ARGELIA',19),
 (19075,'BALBOA',19),
 (19100,'BOLÍVAR',19),
 (19110,'BUENOS AIRES',19),
 (19130,'CAJIBÍO',19),
 (19137,'CALDONO',19),
 (19142,'CALOTO',19),
 (19212,'CORINTO',19),
 (19256,'EL TAMBO',19),
 (19290,'FLORENCIA',19),
 (19300,'GUACHENÉ',19),
 (19318,'GUAPI',19),
 (19355,'INZÁ',19),
 (19364,'JAMBALÓ',19),
 (19392,'LA SIERRA',19),
 (19397,'LA VEGA',19),
 (19418,'LÓPEZ',19),
 (19450,'MERCADERES',19),
 (19455,'MIRANDA',19),
 (19473,'MORALES',19),
 (19513,'PADILLA',19),
 (19517,'PAEZ',19),
 (19532,'PATÍA',19),
 (19533,'PIAMONTE',19),
 (19548,'PIENDAMÓ',19),
 (19573,'PUERTO TEJADA',19),
 (19585,'PURACÉ',19),
 (19622,'ROSAS',19),
 (19693,'SAN SEBASTIÁN',19),
 (19698,'SANTANDER DE QUILICHAO',19),
 (19701,'SANTA ROSA',19),
 (19743,'SILVIA',19),
 (19760,'SOTARA',19),
 (19780,'SUÁREZ',19),
 (19785,'SUCRE',19),
 (19807,'TIMBÍO',19),
 (19809,'TIMBIQUÍ',19),
 (19821,'TORIBIO',19),
 (19824,'TOTORÓ',19),
 (19845,'VILLA RICA',19),
 (20001,'VALLEDUPAR',20),
 (20011,'AGUACHICA',20),
 (20013,'AGUSTÍN CODAZZI',20),
 (20032,'ASTREA',20),
 (20045,'BECERRIL',20),
 (20060,'BOSCONIA',20),
 (20175,'CHIMICHAGUA',20),
 (20178,'CHIRIGUANÁ',20),
 (20228,'CURUMANÍ',20),
 (20238,'EL COPEY',20),
 (20250,'EL PASO',20),
 (20295,'GAMARRA',20),
 (20310,'GONZÁLEZ',20),
 (20383,'LA GLORIA',20),
 (20400,'LA JAGUA DE IBIRICO',20),
 (20443,'MANAURE',20),
 (20517,'PAILITAS',20),
 (20550,'PELAYA',20),
 (20570,'PUEBLO BELLO',20),
 (20614,'RÍO DE ORO',20),
 (20621,'LA PAZ',20),
 (20710,'SAN ALBERTO',20),
 (20750,'SAN DIEGO',20),
 (20770,'SAN MARTÍN',20),
 (20787,'TAMALAMEQUE',20),
 (23001,'MONTERÍA',23),
 (23068,'AYAPEL',23),
 (23079,'BUENAVISTA',23),
 (23090,'CANALETE',23),
 (23162,'CERETÉ',23),
 (23168,'CHIMÁ',23),
 (23182,'CHINÚ',23),
 (23189,'CIÉNAGA DE ORO',23),
 (23300,'COTORRA',23),
 (23350,'LA APARTADA',23),
 (23417,'LORICA',23),
 (23419,'LOS CÓRDOBAS',23),
 (23464,'MOMIL',23),
 (23466,'MONTELÍBANO',23),
 (23500,'MOÑITOS',23),
 (23555,'PLANETA RICA',23),
 (23570,'PUEBLO NUEVO',23),
 (23574,'PUERTO ESCONDIDO',23),
 (23580,'PUERTO LIBERTADOR',23),
 (23586,'PURÍSIMA',23),
 (23660,'SAHAGÚN',23),
 (23670,'SAN ANDRÉS SOTAVENTO',23),
 (23672,'SAN ANTERO',23),
 (23675,'SAN BERNARDO DEL VIENTO',23),
 (23678,'SAN CARLOS',23),
 (23682,'SAN JOSÉ DE URÉ',23),
 (23686,'SAN PELAYO',23),
 (23807,'TIERRALTA',23),
 (23815,'TUCHÍN',23),
 (23855,'VALENCIA',23),
 (25001,'AGUA DE DIOS',25),
 (25019,'ALBÁN',25),
 (25035,'ANAPOIMA',25),
 (25040,'ANOLAIMA',25),
 (25053,'ARBELÁEZ',25),
 (25086,'BELTRÁN',25),
 (25095,'BITUIMA',25),
 (25099,'BOJACÁ',25),
 (25120,'CABRERA',25),
 (25123,'CACHIPAY',25),
 (25126,'CAJICÁ',25),
 (25148,'CAPARRAPÍ',25),
 (25151,'CAQUEZA',25),
 (25154,'CARMEN DE CARUPA',25),
 (25168,'CHAGUANÍ',25),
 (25175,'CHÍA',25),
 (25178,'CHIPAQUE',25),
 (25181,'CHOACHÍ',25),
 (25183,'CHOCONTÁ',25),
 (25200,'COGUA',25),
 (25214,'COTA',25),
 (25224,'CUCUNUBÁ',25),
 (25245,'EL COLEGIO',25),
 (25258,'EL PEÑÓN',25),
 (25260,'EL ROSAL',25),
 (25269,'FACATATIVÁ',25),
 (25279,'FOMEQUE',25),
 (25281,'FOSCA',25),
 (25286,'FUNZA',25),
 (25288,'FÚQUENE',25),
 (25290,'FUSAGASUGÁ',25),
 (25293,'GACHALA',25),
 (25295,'GACHANCIPÁ',25),
 (25297,'GACHETÁ',25),
 (25299,'GAMA',25),
 (25307,'GIRARDOT',25),
 (25312,'GRANADA',25),
 (25317,'GUACHETÁ',25),
 (25320,'GUADUAS',25),
 (25322,'GUASCA',25),
 (25324,'GUATAQUÍ',25),
 (25326,'GUATAVITA',25),
 (25328,'GUAYABAL DE SIQUIMA',25),
 (25335,'GUAYABETAL',25),
 (25339,'GUTIÉRREZ',25),
 (25368,'JERUSALÉN',25),
 (25372,'JUNÍN',25),
 (25377,'LA CALERA',25),
 (25386,'LA MESA',25),
 (25394,'LA PALMA',25),
 (25398,'LA PEÑA',25),
 (25402,'LA VEGA',25),
 (25407,'LENGUAZAQUE',25),
 (25426,'MACHETA',25),
 (25430,'MADRID',25),
 (25436,'MANTA',25),
 (25438,'MEDINA',25),
 (25473,'MOSQUERA',25),
 (25483,'NARIÑO',25),
 (25486,'NEMOCÓN',25),
 (25488,'NILO',25),
 (25489,'NIMAIMA',25),
 (25491,'NOCAIMA',25),
 (25506,'VENECIA',25),
 (25513,'PACHO',25),
 (25518,'PAIME',25),
 (25524,'PANDI',25),
 (25530,'PARATEBUENO',25),
 (25535,'PASCA',25),
 (25572,'PUERTO SALGAR',25),
 (25580,'PULÍ',25),
 (25592,'QUEBRADANEGRA',25),
 (25594,'QUETAME',25),
 (25596,'QUIPILE',25),
 (25599,'APULO',25),
 (25612,'RICAURTE',25),
 (25645,'SAN ANTONIO DEL TEQUENDAMA',25),
 (25649,'SAN BERNARDO',25),
 (25653,'SAN CAYETANO',25),
 (25658,'SAN FRANCISCO',25),
 (25662,'SAN JUAN DE RÍO SECO',25),
 (25718,'SASAIMA',25),
 (25736,'SESQUILÉ',25),
 (25740,'SIBATÉ',25),
 (25743,'SILVANIA',25),
 (25745,'SIMIJACA',25),
 (25754,'SOACHA',25),
 (25758,'SOPÓ',25),
 (25769,'SUBACHOQUE',25),
 (25772,'SUESCA',25),
 (25777,'SUPATÁ',25),
 (25779,'SUSA',25),
 (25781,'SUTATAUSA',25),
 (25785,'TABIO',25),
 (25793,'TAUSA',25),
 (25797,'TENA',25),
 (25799,'TENJO',25),
 (25805,'TIBACUY',25),
 (25807,'TIBIRITA',25),
 (25815,'TOCAIMA',25),
 (25817,'TOCANCIPÁ',25),
 (25823,'TOPAIPÍ',25),
 (25839,'UBALÁ',25),
 (25841,'UBAQUE',25),
 (25843,'VILLA DE SAN DIEGO DE UBATE',25),
 (25845,'UNE',25),
 (25851,'ÚTICA',25),
 (25862,'VERGARA',25),
 (25867,'VIANÍ',25),
 (25871,'VILLAGÓMEZ',25),
 (25873,'VILLAPINZÓN',25),
 (25875,'VILLETA',25),
 (25878,'VIOTÁ',25),
 (25885,'YACOPÍ',25),
 (25898,'ZIPACÓN',25),
 (25899,'ZIPAQUIRÁ',25),
 (27001,'QUIBDÓ',27),
 (27006,'ACANDÍ',27),
 (27025,'ALTO BAUDÓ',27),
 (27050,'ATRATO',27),
 (27073,'BAGADÓ',27),
 (27075,'BAHÍA SOLANO',27),
 (27077,'BAJO BAUDÓ',27),
 (27099,'BOJAYA',27),
 (27135,'EL CANTÓN DEL SAN PABLO',27),
 (27150,'CARMEN DEL DARIEN',27),
 (27160,'CÉRTEGUI',27),
 (27205,'CONDOTO',27),
 (27245,'EL CARMEN DE ATRATO',27),
 (27250,'EL LITORAL DEL SAN JUAN',27),
 (27361,'ISTMINA',27),
 (27372,'JURADÓ',27),
 (27413,'LLORÓ',27),
 (27425,'MEDIO ATRATO',27),
 (27430,'MEDIO BAUDÓ',27),
 (27450,'MEDIO SAN JUAN',27),
 (27491,'NÓVITA',27),
 (27495,'NUQUÍ',27),
 (27580,'RÍO IRÓ',27),
 (27600,'RÍO QUITO',27),
 (27615,'RIOSUCIO',27),
 (27660,'SAN JOSÉ DEL PALMAR',27),
 (27745,'SIPÍ',27),
 (27787,'TADÓ',27),
 (27800,'UNGUÍA',27),
 (27810,'UNIÓN PANAMERICANA',27),
 (41001,'NEIVA',41),
 (41006,'ACEVEDO',41),
 (41013,'AGRADO',41),
 (41016,'AIPE',41),
 (41020,'ALGECIRAS',41),
 (41026,'ALTAMIRA',41),
 (41078,'BARAYA',41),
 (41132,'CAMPOALEGRE',41),
 (41206,'COLOMBIA',41),
 (41244,'ELÍAS',41),
 (41298,'GARZÓN',41),
 (41306,'GIGANTE',41),
 (41319,'GUADALUPE',41),
 (41349,'HOBO',41),
 (41357,'IQUIRA',41),
 (41359,'ISNOS',41),
 (41378,'LA ARGENTINA',41),
 (41396,'LA PLATA',41),
 (41483,'NÁTAGA',41),
 (41503,'OPORAPA',41),
 (41518,'PAICOL',41),
 (41524,'PALERMO',41),
 (41530,'PALESTINA',41),
 (41548,'PITAL',41),
 (41551,'PITALITO',41),
 (41615,'RIVERA',41),
 (41660,'SALADOBLANCO',41),
 (41668,'SAN AGUSTÍN',41),
 (41676,'SANTA MARÍA',41),
 (41770,'SUAZA',41),
 (41791,'TARQUI',41),
 (41797,'TESALIA',41),
 (41799,'TELLO',41),
 (41801,'TERUEL',41),
 (41807,'TIMANÁ',41),
 (41872,'VILLAVIEJA',41),
 (41885,'YAGUARÁ',41),
 (44001,'RIOHACHA',44),
 (44035,'ALBANIA',44),
 (44078,'BARRANCAS',44),
 (44090,'DIBULLA',44),
 (44098,'DISTRACCIÓN',44),
 (44110,'EL MOLINO',44),
 (44279,'FONSECA',44),
 (44378,'HATONUEVO',44),
 (44420,'LA JAGUA DEL PILAR',44),
 (44430,'MAICAO',44),
 (44560,'MANAURE',44),
 (44650,'SAN JUAN DEL CESAR',44),
 (44847,'URIBIA',44),
 (44855,'URUMITA',44),
 (44874,'VILLANUEVA',44),
 (47001,'SANTA MARTA',47),
 (47030,'ALGARROBO',47),
 (47053,'ARACATACA',47),
 (47058,'ARIGUANÍ',47),
 (47161,'CERRO SAN ANTONIO',47),
 (47170,'CHIBOLO',47),
 (47189,'CIÉNAGA',47),
 (47205,'CONCORDIA',47),
 (47245,'EL BANCO',47),
 (47258,'EL PIÑON',47),
 (47268,'EL RETÉN',47),
 (47288,'FUNDACIÓN',47),
 (47318,'GUAMAL',47),
 (47460,'NUEVA GRANADA',47),
 (47541,'PEDRAZA',47),
 (47545,'PIJIÑO DEL CARMEN',47),
 (47551,'PIVIJAY',47),
 (47555,'PLATO',47),
 (47570,'PUEBLOVIEJO',47),
 (47605,'REMOLINO',47),
 (47660,'SABANAS DE SAN ANGEL',47),
 (47675,'SALAMINA',47),
 (47692,'SAN SEBASTIÁN DE BUENAVISTA',47),
 (47703,'SAN ZENÓN',47),
 (47707,'SANTA ANA',47),
 (47720,'SANTA BÁRBARA DE PINTO',47),
 (47745,'SITIONUEVO',47),
 (47798,'TENERIFE',47),
 (47960,'ZAPAYÁN',47),
 (47980,'ZONA BANANERA',47),
 (50001,'VILLAVICENCIO',50),
 (50006,'ACACÍAS',50),
 (50110,'BARRANCA DE UPÍA',50),
 (50124,'CABUYARO',50),
 (50150,'CASTILLA LA NUEVA',50),
 (50223,'CUBARRAL',50),
 (50226,'CUMARAL',50),
 (50245,'EL CALVARIO',50),
 (50251,'EL CASTILLO',50),
 (50270,'EL DORADO',50),
 (50287,'FUENTE DE ORO',50),
 (50313,'GRANADA',50),
 (50318,'GUAMAL',50),
 (50325,'MAPIRIPÁN',50),
 (50330,'MESETAS',50),
 (50350,'LA MACARENA',50),
 (50370,'URIBE',50),
 (50400,'LEJANÍAS',50),
 (50450,'PUERTO CONCORDIA',50),
 (50568,'PUERTO GAITÁN',50),
 (50573,'PUERTO LÓPEZ',50),
 (50577,'PUERTO LLERAS',50),
 (50590,'PUERTO RICO',50),
 (50606,'RESTREPO',50),
 (50680,'SAN CARLOS DE GUAROA',50),
 (50683,'SAN JUAN DE ARAMA',50),
 (50686,'SAN JUANITO',50),
 (50689,'SAN MARTÍN',50),
 (50711,'VISTAHERMOSA',50),
 (52001,'PASTO',52),
 (52019,'ALBÁN',52),
 (52022,'ALDANA',52),
 (52036,'ANCUYÁ',52),
 (52051,'ARBOLEDA',52),
 (52079,'BARBACOAS',52),
 (52083,'BELÉN',52),
 (52110,'BUESACO',52),
 (52203,'COLÓN',52),
 (52207,'CONSACA',52),
 (52210,'CONTADERO',52),
 (52215,'CÓRDOBA',52),
 (52224,'CUASPUD',52),
 (52227,'CUMBAL',52),
 (52233,'CUMBITARA',52),
 (52240,'CHACHAGÃœÍ',52),
 (52250,'EL CHARCO',52),
 (52254,'EL PEÑOL',52),
 (52256,'EL ROSARIO',52),
 (52258,'EL TABLÓN DE GÓMEZ',52),
 (52260,'EL TAMBO',52),
 (52287,'FUNES',52),
 (52317,'GUACHUCAL',52),
 (52320,'GUAITARILLA',52),
 (52323,'GUALMATÁN',52),
 (52352,'ILES',52),
 (52354,'IMUÉS',52),
 (52356,'IPIALES',52),
 (52378,'LA CRUZ',52),
 (52381,'LA FLORIDA',52),
 (52385,'LA LLANADA',52),
 (52390,'LA TOLA',52),
 (52399,'LA UNIÓN',52),
 (52405,'LEIVA',52),
 (52411,'LINARES',52),
 (52418,'LOS ANDES',52),
 (52427,'MAGÃœI',52),
 (52435,'MALLAMA',52),
 (52473,'MOSQUERA',52),
 (52480,'NARIÑO',52),
 (52490,'OLAYA HERRERA',52),
 (52506,'OSPINA',52),
 (52520,'FRANCISCO PIZARRO',52),
 (52540,'POLICARPA',52),
 (52560,'POTOSÍ',52),
 (52565,'PROVIDENCIA',52),
 (52573,'PUERRES',52),
 (52585,'PUPIALES',52),
 (52612,'RICAURTE',52),
 (52621,'ROBERTO PAYÁN',52),
 (52678,'SAMANIEGO',52),
 (52683,'SANDONÁ',52),
 (52685,'SAN BERNARDO',52),
 (52687,'SAN LORENZO',52),
 (52693,'SAN PABLO',52),
 (52694,'SAN PEDRO DE CARTAGO',52),
 (52696,'SANTA BÁRBARA',52),
 (52699,'SANTACRUZ',52),
 (52720,'SAPUYES',52),
 (52786,'TAMINANGO',52),
 (52788,'TANGUA',52),
 (52835,'SAN ANDRES DE TUMACO',52),
 (52838,'TÚQUERRES',52),
 (52885,'YACUANQUER',52),
 (54001,'CÚCUTA',54),
 (54003,'ABREGO',54),
 (54051,'ARBOLEDAS',54),
 (54099,'BOCHALEMA',54),
 (54109,'BUCARASICA',54),
 (54125,'CÁCOTA',54),
 (54128,'CACHIRÁ',54),
 (54172,'CHINÁCOTA',54),
 (54174,'CHITAGÁ',54),
 (54206,'CONVENCIÓN',54),
 (54223,'CUCUTILLA',54),
 (54239,'DURANIA',54),
 (54245,'EL CARMEN',54),
 (54250,'EL TARRA',54),
 (54261,'EL ZULIA',54),
 (54313,'GRAMALOTE',54),
 (54344,'HACARÍ',54),
 (54347,'HERRÁN',54),
 (54377,'LABATECA',54),
 (54385,'LA ESPERANZA',54),
 (54398,'LA PLAYA',54),
 (54405,'LOS PATIOS',54),
 (54418,'LOURDES',54),
 (54480,'MUTISCUA',54),
 (54498,'OCAÑA',54),
 (54518,'PAMPLONA',54),
 (54520,'PAMPLONITA',54),
 (54553,'PUERTO SANTANDER',54),
 (54599,'RAGONVALIA',54),
 (54660,'SALAZAR',54),
 (54670,'SAN CALIXTO',54),
 (54673,'SAN CAYETANO',54),
 (54680,'SANTIAGO',54),
 (54720,'SARDINATA',54),
 (54743,'SILOS',54),
 (54800,'TEORAMA',54),
 (54810,'TIBÚ',54),
 (54820,'TOLEDO',54),
 (54871,'VILLA CARO',54),
 (54874,'VILLA DEL ROSARIO',54),
 (63001,'ARMENIA',63),
 (63111,'BUENAVISTA',63),
 (63130,'CALARCA',63),
 (63190,'CIRCASIA',63),
 (63212,'CÓRDOBA',63),
 (63272,'FILANDIA',63),
 (63302,'GÉNOVA',63),
 (63401,'LA TEBAIDA',63),
 (63470,'MONTENEGRO',63),
 (63548,'PIJAO',63),
 (63594,'QUIMBAYA',63),
 (63690,'SALENTO',63),
 (66001,'PEREIRA',66),
 (66045,'APÍA',66),
 (66075,'BALBOA',66),
 (66088,'BELÉN DE UMBRÍA',66),
 (66170,'DOSQUEBRADAS',66),
 (66318,'GUÁTICA',66),
 (66383,'LA CELIA',66),
 (66400,'LA VIRGINIA',66),
 (66440,'MARSELLA',66),
 (66456,'MISTRATÓ',66),
 (66572,'PUEBLO RICO',66),
 (66594,'QUINCHÍA',66),
 (66682,'SANTA ROSA DE CABAL',66),
 (66687,'SANTUARIO',66),
 (68001,'BUCARAMANGA',68),
 (68013,'AGUADA',68),
 (68020,'ALBANIA',68),
 (68051,'ARATOCA',68),
 (68077,'BARBOSA',68),
 (68079,'BARICHARA',68),
 (68081,'BARRANCABERMEJA',68),
 (68092,'BETULIA',68),
 (68101,'BOLÍVAR',68),
 (68121,'CABRERA',68),
 (68132,'CALIFORNIA',68),
 (68147,'CAPITANEJO',68),
 (68152,'CARCASÍ',68),
 (68160,'CEPITÁ',68),
 (68162,'CERRITO',68),
 (68167,'CHARALÁ',68),
 (68169,'CHARTA',68),
 (68176,'CHIMA',68),
 (68179,'CHIPATÁ',68),
 (68190,'CIMITARRA',68),
 (68207,'CONCEPCIÓN',68),
 (68209,'CONFINES',68),
 (68211,'CONTRATACIÓN',68),
 (68217,'COROMORO',68),
 (68229,'CURITÍ',68),
 (68235,'EL CARMEN DE CHUCURÍ',68),
 (68245,'EL GUACAMAYO',68),
 (68250,'EL PEÑÓN',68),
 (68255,'EL PLAYÓN',68),
 (68264,'ENCINO',68),
 (68266,'ENCISO',68),
 (68271,'FLORIÁN',68),
 (68276,'FLORIDABLANCA',68),
 (68296,'GALÁN',68),
 (68298,'GAMBITA',68),
 (68307,'GIRÓN',68),
 (68318,'GUACA',68),
 (68320,'GUADALUPE',68),
 (68322,'GUAPOTÁ',68),
 (68324,'GUAVATÁ',68),
 (68327,'GUEPSA',68),
 (68344,'HATO',68),
 (68368,'JESÚS MARÍA',68),
 (68370,'JORDÁN',68),
 (68377,'LA BELLEZA',68),
 (68385,'LANDÁZURI',68),
 (68397,'LA PAZ',68),
 (68406,'LEBRIJA',68),
 (68418,'LOS SANTOS',68),
 (68425,'MACARAVITA',68),
 (68432,'MÁLAGA',68),
 (68444,'MATANZA',68),
 (68464,'MOGOTES',68),
 (68468,'MOLAGAVITA',68),
 (68498,'OCAMONTE',68),
 (68500,'OIBA',68),
 (68502,'ONZAGA',68),
 (68522,'PALMAR',68),
 (68524,'PALMAS DEL SOCORRO',68),
 (68533,'PÁRAMO',68),
 (68547,'PIEDECUESTA',68),
 (68549,'PINCHOTE',68),
 (68572,'PUENTE NACIONAL',68),
 (68573,'PUERTO PARRA',68),
 (68575,'PUERTO WILCHES',68),
 (68615,'RIONEGRO',68),
 (68655,'SABANA DE TORRES',68),
 (68669,'SAN ANDRÉS',68),
 (68673,'SAN BENITO',68),
 (68679,'SAN GIL',68),
 (68682,'SAN JOAQUÍN',68),
 (68684,'SAN JOSÉ DE MIRANDA',68),
 (68686,'SAN MIGUEL',68),
 (68689,'SAN VICENTE DE CHUCURÍ',68),
 (68705,'SANTA BÁRBARA',68),
 (68720,'SANTA HELENA DEL OPÓN',68),
 (68745,'SIMACOTA',68),
 (68755,'SOCORRO',68),
 (68770,'SUAITA',68),
 (68773,'SUCRE',68),
 (68780,'SURATÁ',68),
 (68820,'TONA',68),
 (68855,'VALLE DE SAN JOSÉ',68),
 (68861,'VÉLEZ',68),
 (68867,'VETAS',68),
 (68872,'VILLANUEVA',68),
 (68895,'ZAPATOCA',68),
 (70001,'SINCELEJO',70),
 (70110,'BUENAVISTA',70),
 (70124,'CAIMITO',70),
 (70204,'COLOSO',70),
 (70215,'COROZAL',70),
 (70221,'COVEÑAS',70),
 (70230,'CHALÁN',70),
 (70233,'EL ROBLE',70),
 (70235,'GALERAS',70),
 (70265,'GUARANDA',70),
 (70400,'LA UNIÓN',70),
 (70418,'LOS PALMITOS',70),
 (70429,'MAJAGUAL',70),
 (70473,'MORROA',70),
 (70508,'OVEJAS',70),
 (70523,'PALMITO',70),
 (70670,'SAMPUÉS',70),
 (70678,'SAN BENITO ABAD',70),
 (70702,'SAN JUAN DE BETULIA',70),
 (70708,'SAN MARCOS',70),
 (70713,'SAN ONOFRE',70),
 (70717,'SAN PEDRO',70),
 (70742,'SAN LUIS DE SINCÉ',70),
 (70771,'SUCRE',70),
 (70820,'SANTIAGO DE TOLÚ',70),
 (70823,'TOLÚ VIEJO',70),
 (73001,'IBAGUÉ',73),
 (73024,'ALPUJARRA',73),
 (73026,'ALVARADO',73),
 (73030,'AMBALEMA',73),
 (73043,'ANZOÁTEGUI',73),
 (73055,'ARMERO',73),
 (73067,'ATACO',73),
 (73124,'CAJAMARCA',73),
 (73148,'CARMEN DE APICALÁ',73),
 (73152,'CASABIANCA',73),
 (73168,'CHAPARRAL',73),
 (73200,'COELLO',73),
 (73217,'COYAIMA',73),
 (73226,'CUNDAY',73),
 (73236,'DOLORES',73),
 (73268,'ESPINAL',73),
 (73270,'FALAN',73),
 (73275,'FLANDES',73),
 (73283,'FRESNO',73),
 (73319,'GUAMO',73),
 (73347,'HERVEO',73),
 (73349,'HONDA',73),
 (73352,'ICONONZO',73),
 (73408,'LÉRIDA',73),
 (73411,'LÍBANO',73),
 (73443,'SAN SEBASTIÁN DE MARIQUITA',73),
 (73449,'MELGAR',73),
 (73461,'MURILLO',73),
 (73483,'NATAGAIMA',73),
 (73504,'ORTEGA',73),
 (73520,'PALOCABILDO',73),
 (73547,'PIEDRAS',73),
 (73555,'PLANADAS',73),
 (73563,'PRADO',73),
 (73585,'PURIFICACIÓN',73),
 (73616,'RIOBLANCO',73),
 (73622,'RONCESVALLES',73),
 (73624,'ROVIRA',73),
 (73671,'SALDAÑA',73),
 (73675,'SAN ANTONIO',73),
 (73678,'SAN LUIS',73),
 (73686,'SANTA ISABEL',73),
 (73770,'SUÁREZ',73),
 (73854,'VALLE DE SAN JUAN',73),
 (73861,'VENADILLO',73),
 (73870,'VILLAHERMOSA',73),
 (73873,'VILLARRICA',73),
 (76001,'CALI',76),
 (76020,'ALCALÁ',76),
 (76036,'ANDALUCÍA',76),
 (76041,'ANSERMANUEVO',76),
 (76054,'ARGELIA',76),
 (76100,'BOLÍVAR',76),
 (76109,'BUENAVENTURA',76),
 (76111,'GUADALAJARA DE BUGA',76),
 (76113,'BUGALAGRANDE',76),
 (76122,'CAICEDONIA',76),
 (76126,'CALIMA',76),
 (76130,'CANDELARIA',76),
 (76147,'CARTAGO',76),
 (76233,'DAGUA',76),
 (76243,'EL ÁGUILA',76),
 (76246,'EL CAIRO',76),
 (76248,'EL CERRITO',76),
 (76250,'EL DOVIO',76),
 (76275,'FLORIDA',76),
 (76306,'GINEBRA',76),
 (76318,'GUACARÍ',76),
 (76364,'JAMUNDÍ',76),
 (76377,'LA CUMBRE',76),
 (76400,'LA UNIÓN',76),
 (76403,'LA VICTORIA',76),
 (76497,'OBANDO',76),
 (76520,'PALMIRA',76),
 (76563,'PRADERA',76),
 (76606,'RESTREPO',76),
 (76616,'RIOFRÍO',76),
 (76622,'ROLDANILLO',76),
 (76670,'SAN PEDRO',76),
 (76736,'SEVILLA',76),
 (76823,'TORO',76),
 (76828,'TRUJILLO',76),
 (76834,'TULUÁ',76),
 (76845,'ULLOA',76),
 (76863,'VERSALLES',76),
 (76869,'VIJES',76),
 (76890,'YOTOCO',76),
 (76892,'YUMBO',76),
 (76895,'ZARZAL',76),
 (81001,'ARAUCA',81),
 (81065,'ARAUQUITA',81),
 (81220,'CRAVO NORTE',81),
 (81300,'FORTUL',81),
 (81591,'PUERTO RONDÓN',81),
 (81736,'SARAVENA',81),
 (81794,'TAME',81),
 (85001,'YOPAL',85),
 (85010,'AGUAZUL',85),
 (85015,'CHAMEZA',85),
 (85125,'HATO COROZAL',85),
 (85136,'LA SALINA',85),
 (85139,'MANÍ',85),
 (85162,'MONTERREY',85),
 (85225,'NUNCHÍA',85),
 (85230,'OROCUÉ',85),
 (85250,'PAZ DE ARIPORO',85),
 (85263,'PORE',85),
 (85279,'RECETOR',85),
 (85300,'SABANALARGA',85),
 (85315,'SÁCAMA',85),
 (85325,'SAN LUIS DE PALENQUE',85),
 (85400,'TÁMARA',85),
 (85410,'TAURAMENA',85),
 (85430,'TRINIDAD',85),
 (85440,'VILLANUEVA',85),
 (86001,'MOCOA',86),
 (86219,'COLÓN',86),
 (86320,'ORITO',86),
 (86568,'PUERTO ASÍS',86),
 (86569,'PUERTO CAICEDO',86),
 (86571,'PUERTO GUZMÁN',86),
 (86573,'PUERTO LEGUÍZAMO',86),
 (86749,'SIBUNDOY',86),
 (86755,'SAN FRANCISCO',86),
 (86757,'SAN MIGUEL',86),
 (86760,'SANTIAGO',86),
 (86865,'VALLE DEL GUAMUEZ',86),
 (86885,'VILLAGARZÓN',86),
 (88001,'SAN ANDRÉS',88),
 (88564,'PROVIDENCIA',88),
 (91001,'LETICIA',91),
 (91263,'EL ENCANTO',91),
 (91405,'LA CHORRERA',91),
 (91407,'LA PEDRERA',91),
 (91430,'LA VICTORIA',91),
 (91460,'MIRITI - PARANÁ',91),
 (91530,'PUERTO ALEGRÍA',91),
 (91536,'PUERTO ARICA',91),
 (91540,'PUERTO NARIÑO',91),
 (91669,'PUERTO SANTANDER',91),
 (91798,'TARAPACÁ',91),
 (94001,'INÍRIDA',94),
 (94343,'BARRANCO MINAS',94),
 (94663,'MAPIRIPANA',94),
 (94883,'SAN FELIPE',94),
 (94884,'PUERTO COLOMBIA',94),
 (94885,'LA GUADALUPE',94),
 (94886,'CACAHUAL',94),
 (94887,'PANA PANA',94),
 (94888,'MORICHAL',94),
 (95001,'SAN JOSÉ DEL GUAVIARE',95),
 (95015,'CALAMAR',95),
 (95025,'EL RETORNO',95),
 (95200,'MIRAFLORES',95),
 (97001,'MITÚ',97),
 (97161,'CARURU',97),
 (97511,'PACOA',97),
 (97666,'TARAIRA',97),
 (97777,'PAPUNAUA',97),
 (97889,'YAVARATÉ',97),
 (99001,'PUERTO CARREÑO',99),
 (99524,'LA PRIMAVERA',99),
 (99624,'SANTA ROSALÍA',99),
 (99773,'CUMARIBO',99);
/*!40000 ALTER TABLE `fivi_param_mpios` ENABLE KEYS */;


--
-- Definition of table `fivi_param_nivsuperv`
--

DROP TABLE IF EXISTS `fivi_param_nivsuperv`;
CREATE TABLE `fivi_param_nivsuperv` (
  `cod_nivsup` int(11) NOT NULL,
  `nom_nivsup` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_nivsup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_nivsuperv`
--

/*!40000 ALTER TABLE `fivi_param_nivsuperv` DISABLE KEYS */;
INSERT INTO `fivi_param_nivsuperv` (`cod_nivsup`,`nom_nivsup`) VALUES 
 (1,'Trimestral'),
 (2,'Semestral'),
 (3,'Anual');
/*!40000 ALTER TABLE `fivi_param_nivsuperv` ENABLE KEYS */;


--
-- Definition of table `fivi_param_opefin`
--

DROP TABLE IF EXISTS `fivi_param_opefin`;
CREATE TABLE `fivi_param_opefin` (
  `cod_opefin` int(11) NOT NULL,
  `nom_opefin` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_opefin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_opefin`
--

/*!40000 ALTER TABLE `fivi_param_opefin` DISABLE KEYS */;
INSERT INTO `fivi_param_opefin` (`cod_opefin`,`nom_opefin`) VALUES 
 (1,'Operaciones a constructores'),
 (2,'Creditos Individuales'),
 (3,'Subrogaciones');
/*!40000 ALTER TABLE `fivi_param_opefin` ENABLE KEYS */;


--
-- Definition of table `fivi_param_ranviv`
--

DROP TABLE IF EXISTS `fivi_param_ranviv`;
CREATE TABLE `fivi_param_ranviv` (
  `cod_ranviv` int(11) NOT NULL,
  `nom_ranviv` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_ranviv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_ranviv`
--

/*!40000 ALTER TABLE `fivi_param_ranviv` DISABLE KEYS */;
INSERT INTO `fivi_param_ranviv` (`cod_ranviv`,`nom_ranviv`) VALUES 
 (1,'De 0 a 50 SMLMV'),
 (2,'De 51 a 70 SMLMV'),
 (3,'De 71 a 135 SMLMV'),
 (4,'De 136 a 170 SMLMV'),
 (5,'De 171 a 235 SMLMV'),
 (6,'Mas de 235 SMLMV');
/*!40000 ALTER TABLE `fivi_param_ranviv` ENABLE KEYS */;


--
-- Definition of table `fivi_param_sfvestado`
--

DROP TABLE IF EXISTS `fivi_param_sfvestado`;
CREATE TABLE `fivi_param_sfvestado` (
  `cod_sfvestado` int(11) NOT NULL,
  `nom_sfvestado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_sfvestado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_sfvestado`
--

/*!40000 ALTER TABLE `fivi_param_sfvestado` DISABLE KEYS */;
INSERT INTO `fivi_param_sfvestado` (`cod_sfvestado`,`nom_sfvestado`) VALUES 
 (1,'Asignado'),
 (2,'Desembolsado');
/*!40000 ALTER TABLE `fivi_param_sfvestado` ENABLE KEYS */;


--
-- Definition of table `fivi_param_sfvmodal`
--

DROP TABLE IF EXISTS `fivi_param_sfvmodal`;
CREATE TABLE `fivi_param_sfvmodal` (
  `cod_sfvmodal` int(11) NOT NULL,
  `nom_sfvmodal` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_sfvmodal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_sfvmodal`
--

/*!40000 ALTER TABLE `fivi_param_sfvmodal` DISABLE KEYS */;
INSERT INTO `fivi_param_sfvmodal` (`cod_sfvmodal`,`nom_sfvmodal`) VALUES 
 (1,'Compra'),
 (2,'Construcción en sitio propio'),
 (3,'Mejora');
/*!40000 ALTER TABLE `fivi_param_sfvmodal` ENABLE KEYS */;


--
-- Definition of table `fivi_param_sfvransub`
--

DROP TABLE IF EXISTS `fivi_param_sfvransub`;
CREATE TABLE `fivi_param_sfvransub` (
  `cod_sfvransub` int(11) NOT NULL,
  `nom_sfvransub` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_sfvransub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_sfvransub`
--

/*!40000 ALTER TABLE `fivi_param_sfvransub` DISABLE KEYS */;
INSERT INTO `fivi_param_sfvransub` (`cod_sfvransub`,`nom_sfvransub`) VALUES 
 (1,'4 SMMLV'),
 (2,'9 SMMLV'),
 (3,'13 SMMLV'),
 (4,'15 SMMLV'),
 (5,'17 SMMLV'),
 (6,'19 SMMLV'),
 (7,'21 SMMLV'),
 (8,'21.5 SMMLV'),
 (9,'22 SMMLV');
/*!40000 ALTER TABLE `fivi_param_sfvransub` ENABLE KEYS */;


--
-- Definition of table `fivi_param_super`
--

DROP TABLE IF EXISTS `fivi_param_super`;
CREATE TABLE `fivi_param_super` (
  `cod_super` int(11) NOT NULL,
  `nom_super` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_super`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_super`
--

/*!40000 ALTER TABLE `fivi_param_super` DISABLE KEYS */;
INSERT INTO `fivi_param_super` (`cod_super`,`nom_super`) VALUES 
 (1,'Superintendencia Financiera'),
 (2,'Superintendencia de Economía Solidaria'),
 (3,'Superintendencia de Subsidio Familiar'),
 (9,'Reporte Directo');
/*!40000 ALTER TABLE `fivi_param_super` ENABLE KEYS */;


--
-- Definition of table `fivi_param_tipoent`
--

DROP TABLE IF EXISTS `fivi_param_tipoent`;
CREATE TABLE `fivi_param_tipoent` (
  `cod_super` int(11) NOT NULL,
  `cod_tipoent` int(11) NOT NULL,
  `nom_tipoent` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_tipoent`,`cod_super`),
  KEY `idx_super_tipoent` (`cod_super`),
  CONSTRAINT `fk_super_tipoent` FOREIGN KEY (`cod_super`) REFERENCES `fivi_param_super` (`cod_super`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_tipoent`
--

/*!40000 ALTER TABLE `fivi_param_tipoent` DISABLE KEYS */;
INSERT INTO `fivi_param_tipoent` (`cod_super`,`cod_tipoent`,`nom_tipoent`) VALUES 
 (1,1,'Establecimientos Bancarios'),
 (2,1,'Cooperativas Especializadas de Ahorro y Vivie'),
 (3,1,'Cajas de Compensación Familiar'),
 (9,1,'Caja Promotora de Vivienda Militar y de Polic'),
 (2,2,'Multiactivas Con Sección de Ahorro y Crédito'),
 (9,2,'Fondo Nacional de Vivienda'),
 (2,3,'Cooperativas Especializadas Diferentes a las '),
 (1,4,'Compañias de Financiamiento'),
 (2,4,'Multiactivas Sin Sección de Ahorro y Crédito'),
 (2,6,'Organismos de Segundo Grado'),
 (2,7,'Organismos de Tercer Grado'),
 (1,8,'Organismos Cooperativos de Grado Superior'),
 (2,8,'Fondos de Empleados'),
 (2,9,'Asociaciones Mutuales'),
 (2,10,'Aportes y Crédito'),
 (2,11,'Cooperativa de Trabajo Asociado'),
 (2,12,'Cooperativa Integral Con Sección de Ahorro y '),
 (2,13,'Cooperativa Integral Sin Sección de Ahorro y '),
 (2,15,'Precooperativas'),
 (1,22,'Instituciones Oficiales Especiales'),
 (1,32,'Entidades Cooperativas de Carácter Financiero');
/*!40000 ALTER TABLE `fivi_param_tipoent` ENABLE KEYS */;


--
-- Definition of table `fivi_param_tipoperiodo`
--

DROP TABLE IF EXISTS `fivi_param_tipoperiodo`;
CREATE TABLE `fivi_param_tipoperiodo` (
  `cod_tipoper` int(11) NOT NULL,
  `nom_tipoper` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_tipoper`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_tipoperiodo`
--

/*!40000 ALTER TABLE `fivi_param_tipoperiodo` DISABLE KEYS */;
INSERT INTO `fivi_param_tipoperiodo` (`cod_tipoper`,`nom_tipoper`) VALUES 
 (1,'Anual'),
 (2,'Semestral'),
 (3,'Trimestral'),
 (4,'Mensual');
/*!40000 ALTER TABLE `fivi_param_tipoperiodo` ENABLE KEYS */;


--
-- Definition of table `fivi_param_tipovivienda`
--

DROP TABLE IF EXISTS `fivi_param_tipovivienda`;
CREATE TABLE `fivi_param_tipovivienda` (
  `cod_tipoviv` int(11) NOT NULL,
  `nom_tipoviv` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cod_tipoviv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `fivi_param_tipovivienda`
--

/*!40000 ALTER TABLE `fivi_param_tipovivienda` DISABLE KEYS */;
INSERT INTO `fivi_param_tipovivienda` (`cod_tipoviv`,`nom_tipoviv`) VALUES 
 (1,'Nueva'),
 (2,'Usada');
/*!40000 ALTER TABLE `fivi_param_tipovivienda` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
