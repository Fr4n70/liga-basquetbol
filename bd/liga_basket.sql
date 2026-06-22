-- ============================================================
-- BASE DE DATOS: liga_basket
-- Sistema de Gestión de Liga de Básquetbol
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `liga_basket`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `liga_basket`;

-- --------------------------------------------------------
-- Tabla: usuarios
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `codUsu` int(11) NOT NULL AUTO_INCREMENT,
  `dniUsu` char(8) DEFAULT NULL,
  `nomUsu` varchar(100) DEFAULT NULL,
  `apeUsu` varchar(100) DEFAULT NULL,
  `celUsu` char(15) DEFAULT NULL,
  `fnaUsu` date DEFAULT NULL,
  `sexUsu` tinyint(2) DEFAULT NULL COMMENT '0=femenino, 1=masculino',
  `emaUsu` varchar(150) DEFAULT NULL,
  `pasUsu` varchar(255) DEFAULT NULL,
  `rolUsu` tinyint(2) DEFAULT 0 COMMENT '0=admin, 1=usuario',
  `estUsu` tinyint(2) DEFAULT 1 COMMENT '1=activo, 0=bloqueado',
  `regUsu` datetime DEFAULT NULL,
  PRIMARY KEY (`codUsu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`dniUsu`,`nomUsu`,`apeUsu`,`celUsu`,`fnaUsu`,`sexUsu`,`emaUsu`,`pasUsu`,`rolUsu`,`estUsu`,`regUsu`) VALUES
('75939061','Yedison','Sistema','941509325','2003-07-30',1,'admin@liga.com','75939061',0,1,NOW()),
('87654321','Juan','Pérez','98765432','1995-06-15',1,'juan@liga.com','00067',1,1,NOW());
-- Contraseña para ambos: password

-- --------------------------------------------------------
-- Tabla: equipos
-- --------------------------------------------------------
CREATE TABLE `equipos` (
  `codEqu` int(11) NOT NULL AUTO_INCREMENT,
  `nomEqu` varchar(150) DEFAULT NULL,
  `ciudadEqu` varchar(100) DEFAULT NULL,
  `colorEqu` varchar(50) DEFAULT NULL,
  `estEqu` tinyint(2) DEFAULT 1 COMMENT '1=activo, 0=inactivo',
  `regEqu` datetime DEFAULT NULL,
  PRIMARY KEY (`codEqu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `equipos` (`nomEqu`,`ciudadEqu`,`colorEqu`,`estEqu`,`regEqu`) VALUES
('Cóndores del Sur','Arequipa','Rojo y Blanco',1,NOW()),
('Titanes del Norte','Trujillo','Azul y Oro',1,NOW()),
('Águilas de Lima','Lima','Verde y Negro',1,NOW()),
('Leones del Cusco','Cusco','Dorado y Rojo',1,NOW());

-- --------------------------------------------------------
-- Tabla: jugadores
-- --------------------------------------------------------
CREATE TABLE `jugadores` (
  `codJug` int(11) NOT NULL AUTO_INCREMENT,
  `codEqu` int(11) NOT NULL,
  `dniJug` char(8) DEFAULT NULL,
  `nomJug` varchar(100) DEFAULT NULL,
  `apeJug` varchar(100) DEFAULT NULL,
  `posJug` varchar(50) DEFAULT NULL COMMENT 'Base,Escolta,Alero,Ala-Pívot,Pívot',
  `numJug` tinyint(3) DEFAULT NULL,
  `celJug` char(15) DEFAULT NULL,
  `fnaJug` date DEFAULT NULL,
  `estJug` tinyint(2) DEFAULT 1 COMMENT '1=activo, 0=inactivo',
  `regJug` datetime DEFAULT NULL,
  PRIMARY KEY (`codJug`),
  KEY `codEqu` (`codEqu`),
  CONSTRAINT `fk_jugador_equipo` FOREIGN KEY (`codEqu`) REFERENCES `equipos` (`codEqu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `jugadores` (`codEqu`,`dniJug`,`nomJug`,`apeJug`,`posJug`,`numJug`,`celJug`,`fnaJug`,`estJug`,`regJug`) VALUES
(1,'11111111','Carlos','Mamani','Base',5,'911111111','2000-03-10',1,NOW()),
(1,'22222222','Luis','Quispe','Escolta',10,'922222222','1999-07-22',1,NOW()),
(2,'33333333','Pedro','García','Alero',23,'933333333','2001-01-05',1,NOW()),
(2,'44444444','Jorge','Flores','Pívot',33,'944444444','1998-11-30',1,NOW()),
(3,'55555555','Andrés','Torres','Base',7,'955555555','2002-05-18',1,NOW()),
(4,'66666666','Ricardo','López','Ala-Pívot',42,'966666666','1997-09-14',1,NOW());

-- --------------------------------------------------------
-- Tabla: partidos
-- --------------------------------------------------------
CREATE TABLE `partidos` (
  `codPar` int(11) NOT NULL AUTO_INCREMENT,
  `equLocPar` int(11) NOT NULL,
  `equVisPar` int(11) NOT NULL,
  `fechaPar` date DEFAULT NULL,
  `horaPar` time DEFAULT NULL,
  `lugarPar` varchar(200) DEFAULT NULL,
  `ptsLocPar` int(3) DEFAULT 0,
  `ptsVisPar` int(3) DEFAULT 0,
  `estPar` tinyint(2) DEFAULT 0 COMMENT '0=programado, 1=en juego, 2=finalizado',
  `regPar` datetime DEFAULT NULL,
  PRIMARY KEY (`codPar`),
  KEY `equLocPar` (`equLocPar`),
  KEY `equVisPar` (`equVisPar`),
  CONSTRAINT `fk_local` FOREIGN KEY (`equLocPar`) REFERENCES `equipos` (`codEqu`),
  CONSTRAINT `fk_visitante` FOREIGN KEY (`equVisPar`) REFERENCES `equipos` (`codEqu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `partidos` (`equLocPar`,`equVisPar`,`fechaPar`,`horaPar`,`lugarPar`,`ptsLocPar`,`ptsVisPar`,`estPar`,`regPar`) VALUES
(1,2,'2025-05-10','18:00:00','Coliseo Municipal Arequipa',85,72,2,NOW()),
(3,4,'2025-05-12','19:00:00','Coliseo Gran Chimú',0,0,0,NOW()),
(2,3,'2025-05-15','20:00:00','Polideportivo Lima Norte',0,0,0,NOW()),
(4,1,'2025-05-18','18:30:00','Coliseo Cusco',0,0,0,NOW());

COMMIT;
