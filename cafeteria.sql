/*******************************************************************************
   Drop database if it exists
********************************************************************************/
DROP DATABASE IF EXISTS `cafeteria`;


/*******************************************************************************
   Crear base de datos
********************************************************************************/
CREATE DATABASE `cafeteria`;


USE `cafeteria`;


CREATE TABLE `Usuarios`
(
    `Id_usuario` INT AUTO_INCREMENT NOT NULL,
	`Tipo_usuario` NVARCHAR(10) NOT NULL,
    `Nombre` NVARCHAR(20) NOT NULL,
    `Apellidos` NVARCHAR(40) NOT NULL,
    `Ciudad` NVARCHAR(20),
    `Pais` NVARCHAR(20),
    `Codigo_postal` NVARCHAR(5),
    `Telefono` NVARCHAR(9),
    `Email` NVARCHAR(60) NOT NULL,
    CONSTRAINT `PK_Usuarios` PRIMARY KEY  (`Id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Platos`
(
    `Id_plato` INT AUTO_INCREMENT NOT NULL,
    `Nombre` NVARCHAR(20) NOT NULL,
    `Tipo` NVARCHAR(20) ,
    `Precio` INT NOT NULL,
    CONSTRAINT `PK_Platos` PRIMARY KEY  (`Id_plato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Mesas`
(
    `Id_mesa` INT AUTO_INCREMENT NOT NULL,
    `Ocupado` BOOLEAN DEFAULT false,
    `Sillas` INT NOT NULL,
    CONSTRAINT `PK_Mesas` PRIMARY KEY  (`Id_mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Almacen`
(
    `Id_almacen` INT AUTO_INCREMENT NOT NULL,
    `Id_plato` INT NOT NULL,
    `Cantidad` INT NOT NULL,
    CONSTRAINT `PK_Almacen` PRIMARY KEY  (`Id_almacen`),
	CONSTRAINT `FK_AlmacenId_plato` FOREIGN KEY (`Id_plato`) REFERENCES `Platos` (`Id_plato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `UsuariopidePlatoenMesa`
(
    `Id_usuario` INT NOT NULL,
	`Id_mesa` INT NOT NULL,
    `Id_plato` INT NOT NULL,
	
    `Precio_plato` INT NOT NULL,
	`Cantidad_plato` INT NOT NULL,
		
	CONSTRAINT `FK_UsuariopidePlatoenMesaId_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `Usuarios` (`Id_usuario`),
		CONSTRAINT `FK_UsuariopidePlatoenMesaId_mesa` FOREIGN KEY (`Id_mesa`) REFERENCES `Mesas` (`Id_mesa`),
	CONSTRAINT `FK_UsuariopidePlatoenMesaId_plato` FOREIGN KEY (`Id_plato`) REFERENCES `Platos` (`Id_plato`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/*******************************************************************************
   Pruebas:
********************************************************************************/

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`) VALUES ('Admin', 'Marco', 'Fernandez', 'Madrid', 'España', 28099, 666666666, 'marco@gmail.com');

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Pincho_de_tortilla', 'Comida', 4);

INSERT INTO `Mesas` (`Ocupado`, `Sillas`) VALUES (false, 4);

INSERT INTO `Mesas` (`Ocupado`, `Sillas`) VALUES (true, 8);

INSERT INTO `Almacen` (`Id_plato`, `Cantidad`) VALUES (1, 50);

INSERT INTO `UsuariopidePlatoenMesa` (`Id_usuario`, `Id_mesa`, `Id_plato`, `Precio_plato`, `Cantidad_plato`) VALUES (1, 1, 1, 10, 2 );








