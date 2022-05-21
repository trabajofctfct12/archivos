/*******************************************************************************
   Drop database if it exists
********************************************************************************/
DROP DATABASE IF EXISTS `cafeteria2`;


/*******************************************************************************
   Crear base de datos
********************************************************************************/
CREATE DATABASE `cafeteria2`;


USE `cafeteria2`;


CREATE TABLE `Usuarios`
(
    `Id_usuario` INT AUTO_INCREMENT NOT NULL,
	`Tipo_usuario` NVARCHAR(10) NOT NULL,
    `Nombre` NVARCHAR(20) NOT NULL,
    `Apellidos` NVARCHAR(40) NOT NULL,
    `Contrasena` NVARCHAR(40) NOT NULL,
    `Ciudad` NVARCHAR(20),
    `Pais` NVARCHAR(20),
    `Codigo_postal` NVARCHAR(5),
    `Telefono` NVARCHAR(9),
    `Email` NVARCHAR(60) NOT NULL,
	`Saldo` INT,
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
    `Id_almacen` INT NOT NULL,
    `Id_plato` INT NOT NULL,
    `Stockplato` INT NOT NULL,
	CONSTRAINT `FK_AlmacenId_plato` FOREIGN KEY (`Id_plato`) REFERENCES `Platos` (`Id_plato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Repartidor`
(
    `Id_repartidor` INT NOT NULL,
    `Nombre` VARCHAR(50) NOT NULL,
    `Disponibilidad` BOOLEAN DEFAULT true,
	CONSTRAINT `PK_Repartidor` PRIMARY KEY  (`Id_repartidor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `Pedidolocal`
(
    `Id_pedido` INT NOT NULL,
	`Id_mesa` INT NOT NULL,
    `Fecha` DATETIME NOT NULL,
    `Preciototal` INT,
		 CONSTRAINT `PK_Pedidolocal` PRIMARY KEY  (`Id_pedido`),
	CONSTRAINT `FK_PedidolocalId_mesa` FOREIGN KEY (`Id_mesa`) REFERENCES `Mesas` (`Id_mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `LineaPedidolocal`
(
	`Id_lineapedido` INT NOT NULL,
    `Id_pedido` INT NOT NULL,
	`Id_plato` INT NOT NULL,
	`Id_usuario` INT NOT NULL,
    `Precio` INT,
    `Cantidad` INT NOT NULL,
		 CONSTRAINT `PK_LineaPedidolocal` PRIMARY KEY  (`Id_lineapedido`),
	CONSTRAINT `FK_LineaPedidolocalId_pedido` FOREIGN KEY (`Id_pedido`) REFERENCES `Pedidolocal` (`Id_pedido`),
	CONSTRAINT `FK_LineaPedidolocalId_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `Usuarios` (`Id_usuario`),
		CONSTRAINT `FK_LineaPedidolocalId_plato` FOREIGN KEY (`Id_plato`) REFERENCES `Platos` (`Id_plato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `Reservaenlocal`
(
    `Id_usuario` INT NOT NULL,
	`Id_reserva` INT NOT NULL,
	`Id_mesa` INT NOT NULL,
	`Telefono` INT(9) NOT NULL,
    `Email` VARCHAR(40) NOT NULL,
    `Fechainicio` DATETIME,
	`Fechafin` DATETIME,
	CONSTRAINT `PK_Reservaenlocal` PRIMARY KEY  (`Id_reserva`),
		 CONSTRAINT `FK_ReservaenlocalId_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `Usuarios` (`Id_usuario`),
	CONSTRAINT `FK_ReservaenlocalId_mesa` FOREIGN KEY (`Id_mesa`) REFERENCES `Mesas` (`Id_mesa`)
	
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `LineaReservaenlocal`
(
    `Id_lineapedido` INT NOT NULL,
	`Id_reserva` INT NOT NULL,
	`Id_plato` INT NOT NULL,
		`Id_usuario` INT NOT NULL,
	`Precio` INT,
    `Cantidad` INT(4) NOT NULL,
	CONSTRAINT `PK_LineaReservaenlocal` PRIMARY KEY  (`Id_lineapedido`),
		 CONSTRAINT `FK_LineaReservaenlocalId_reserva` FOREIGN KEY (`Id_reserva`) REFERENCES `Reservaenlocal` (`Id_reserva`),
		CONSTRAINT `FK_LineaReservaenlocalId_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `Usuarios` (`Id_usuario`),
	CONSTRAINT `FK_LineaReservaenlocalId_plato` FOREIGN KEY (`Id_plato`) REFERENCES `Platos` (`Id_plato`)		
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `Enviodomicilio`
(
    `Id_pedido` INT NOT NULL,
	`Id_repartidor` INT NOT NULL,
	`Id_usuario` INT NOT NULL,
	`Fecha` DATETIME,
    `Preciototal` INT,
    `Ubicacion` VARCHAR(60) NOT NULL,
	CONSTRAINT `PK_Enviodomicilio` PRIMARY KEY  (`Id_pedido`),
		 CONSTRAINT `FK_EnviodomicilioId_repartidor` FOREIGN KEY (`Id_repartidor`) REFERENCES `Repartidor` (`Id_repartidor`),
	CONSTRAINT `FK_EnviodomicilioId_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `Usuarios` (`Id_usuario`)
	
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `Lineapedidodomicilio`
(
    `Id_lineapedido` INT NOT NULL,
	`Id_pedido` INT NOT NULL,
	`Id_plato` INT NOT NULL,
		`Id_usuario` INT NOT NULL,
	`Precio` INT,
    `Cantidad` INT(4) NOT NULL,
		CONSTRAINT `PK_Lineapedidodomicilio` PRIMARY KEY  (`Id_lineapedido`),
		 CONSTRAINT `FK_LineapedidodomicilioId_pedido` FOREIGN KEY (`Id_pedido`) REFERENCES `Enviodomicilio` (`Id_pedido`),
			CONSTRAINT `FK_LineapedidodomicilioId_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `Usuarios` (`Id_usuario`),
	CONSTRAINT `FK_LineapedidodomicilioId_plato` FOREIGN KEY (`Id_plato`) REFERENCES `Platos` (`Id_plato`)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/*******************************************************************************
   Pruebas:
********************************************************************************/

/*******************************************************************************
									USUARIOS
   1 - Admin
   2 - Cliente con saldo de 100 euros
   3 - Cliente con saldo de 10 euros
   4 - Cliente sin saldo
********************************************************************************/

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Contrasena`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Admin', 'Marco', 'Fernandez', '1', 'Madrid', 'España', 28099, 666666666, 'marcof@gmail.com', 100);

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Contrasena`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Cliente', 'Andrea', 'Martin', '1', 'Madrid', 'España', 28077, 699999999, 'andream@gmail.com' , 10);

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Contrasena`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Cliente', 'Perico', 'Muñoz', '1', 'Madrid', 'España', 28088, 611111111, 'pericom@gmail.com', 0 );


/*******************************************************************************
									PLATOS
   1 - Pinxto
   2 - Comida
   3 - Refresco
   4 - Café
   5 - Postres
   6-  Helados
********************************************************************************/

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tortilla', 'Pintxo', 4);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Macarrones', 'Comida', 7);
INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Lenguado marinado', 'Comida', 15);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cocacola', 'Refresco', 2);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Café solo', 'Café', 2);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Natillas', 'Postre', 1);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Helado de vainilla', 'Helado', 5);
INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Helado de chocolate', 'Helado', 6);
INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Helado de mango', 'Helado', 10);

/*******************************************************************************
									MESAS
   1 - 2 personas
   2 - 4 personas
   3 - 6 personas, ocupada
********************************************************************************/

INSERT INTO `Mesas` (`Ocupado`, `Sillas`) VALUES (false, 2);

INSERT INTO `Mesas` (`Ocupado`, `Sillas`) VALUES (false, 4);

INSERT INTO `Mesas` (`Ocupado`, `Sillas`) VALUES (true, 6);

/*******************************************************************************
								PRODUCTOS EN ALMACEN
   1 - Pinxto de tortilla, 50
   2 - Macarrones, 20
   3 - Cocacola, 200
   4 - Café solo, 20
********************************************************************************/

INSERT INTO `Almacen` (`Id_almacen`,`Id_plato`, `Stockplato`) VALUES (1, 1, 50);

INSERT INTO `Almacen` (`Id_almacen`,`Id_plato`, `Stockplato`) VALUES (1, 2, 20);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES (1, 3, 200);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES (1, 4, 20);

/*******************************************************************************
								REPARTIDORES
   1 - Repartidor disponible
   2 - Repartidor no disponible
********************************************************************************/

INSERT INTO `Repartidor` (`Id_repartidor`, `Nombre`, `Disponibilidad`) VALUES (1, 'Manolo Lama Gil', true);

INSERT INTO `Repartidor` (`Id_repartidor`, `Nombre`, `Disponibilidad`) VALUES (2, 'Iker Jimenez', false);

/*******************************************************************************
								PEDIDO LOCAL EN CAFETERIA
								
	Pedido de un pintxo de tortilla y una cocacola
********************************************************************************/

INSERT INTO `Pedidolocal` (`Id_pedido`, `Id_mesa`, `Fecha`, `Preciototal` ) VALUES (1, 1, '2022-05-5 14:00:00', 6);

INSERT INTO `LineaPedidolocal` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (1, 1, 1, 1, 1, 4);

INSERT INTO `LineaPedidolocal` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`,  `Cantidad`) VALUES (2, 1, 1, 3, 1, 2);

/*******************************************************************************
								RESERVA LOCAL EN CAFETERIA DESDE LA WEB
			Andrea reserva en una mesa para 4 personas a las 14:00-16:00 del 4 de mayo de 2022
			
			Comensales comen:
			
			-PRIMERO: Macarrones todos
			-SEGUNDO: Lenguado todos
			-POSTRE: Natillas todos
			-REFRESCO: Cocacola todos
			-CAFES: 2 cafes solos
********************************************************************************/

INSERT INTO `Reservaenlocal` (`Id_usuario`, `Id_reserva`, `Id_mesa`, `Telefono`, `Email`, `Fechainicio`, `Fechafin` ) VALUES (2, 1, 2, 699999999, 'andrea@gmail.com', '2022-05-4 14:00:00', '2022-05-4 16:00:00');

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (1, 1, 1, 2, 7, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (2, 1, 1, 6, 15, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (3, 1, 1, 5, 1, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (4, 1, 1, 3, 2, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (5 1,, 1, 4, 2, 2);

/*******************************************************************************
								PEDIDO A DOMICILIO DESDE LA WEB
			Perico pide a domicilio a las 22:00 del 4 de mayo de 2022
			Repartidor asignado: Manolo Lama, que esta disponible
			Comensales piden:
			
			-Postres: Helado de vainilla, chocolate y mango. (Uno de cada)
********************************************************************************/

INSERT INTO `Enviodomicilio` (`Id_pedido`, `Id_repartidor`, `Id_usuario`, `Fecha`, `Preciototal`, `Ubicacion`) VALUES (1, 1, 3, '2022-05-4 22:00:00' , 21 , 'Calle Alberto Aguilera 16 Portal 2 Piso 6B');

INSERT INTO `Lineapedidodomicilio` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (1, 1, 1, 7, 5, 1);

INSERT INTO `Lineapedidodomicilio` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (2, 1, 1, 8, 6, 1);

INSERT INTO `Lineapedidodomicilio` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (3, 1, 1, 9, 10, 1);

/*******************************************************************************
								QUERYS PARA COMPROBAR LOS PEDIDOS REALIZADOS
								
	1. PEDIDOS LOCALES
	
	select * from pedidolocal;
	
	select * from lineapedidolocal where id_pedido=1;
	
	2. RESERVAS LOCALES 
	
	select * from reservaenlocal;
	
	select * from lineareservaenlocal where id_reserva=1;
	
	3. ENVIOS A DOMICILIO
	
	select * from enviodomicilio;
	
	select * from lineaenviodomicilio where id_pedido=1;
								
********************************************************************************/




