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

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Contrasena`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Admin', 'Marco', 'Fernandez', '1', 'Madrid', 'España', 28099, 666666666, 'marcof@gmail.com', 1000);

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Contrasena`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Cliente', 'Andrea', 'Martin', '1', 'Madrid', 'España', 28077, 699999999, 'andream@gmail.com' , 10);

INSERT INTO `Usuarios` (`Tipo_usuario`,`Nombre`, `Apellidos`, `Contrasena`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Cliente', 'Perico', 'Muñoz', '1', 'Madrid', 'España', 28088, 611111111, 'pericom@gmail.com', 0 );

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

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (1, 1, 1, 1, 7, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (2, 1, 1, 1, 15, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (3, 1, 1, 1, 1, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (4, 1, 1, 1, 2, 4);

INSERT INTO `LineaReservaenlocal` (`Id_lineapedido`, `Id_reserva`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (5, 1, 1, 1, 2, 2);

/*******************************************************************************
								PEDIDO A DOMICILIO DESDE LA WEB
			Perico pide a domicilio a las 22:00 del 4 de mayo de 2022
			Repartidor asignado: Manolo Lama, que esta disponible
			Comensales piden:
			
			-Postres: Helado de vainilla, chocolate y mango. (Uno de cada)
********************************************************************************/

INSERT INTO `Enviodomicilio` (`Id_pedido`, `Id_repartidor`, `Id_usuario`, `Fecha`, `Preciototal`, `Ubicacion`) VALUES (1, 1, 3, '2022-05-4 22:00:00' , 21 , 'Calle Alberto Aguilera 16 Portal 2 Piso 6B');

INSERT INTO `Lineapedidodomicilio` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (1, 1, 7, 1, 5, 1);

INSERT INTO `Lineapedidodomicilio` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (2, 1, 8, 1, 6, 1);

INSERT INTO `Lineapedidodomicilio` (`Id_lineapedido`, `Id_pedido`, `Id_plato`,`Id_usuario`, `Precio`, `Cantidad`) VALUES (3, 1, 9, 1, 10, 1);

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


/*******************************************************************************
										Platos
********************************************************************************/

/*******************************************************************************
   Platos del menú 1:
********************************************************************************/
use cafeteria2;

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Espaguetis Carbonara', 'Comida', 8.47);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Ensalada Primavera', 'Comida', 6.05);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Verdura plancha', 'Comida', 7.26);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Fetucchini al Pesto', 'Comida', 9.68);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Lasana Vegetariana', 'Comida', 12.1);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Pizza Prosciutto', 'Comida', 13.31);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Pizza Calabresa', 'Comida', 14.52);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Escalope de Pollo', 'Comida', 9.68);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tortilla Espanola', 'Comida', 12.1);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Entrecot', 'Comida', 18.15);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Gnocchi Sorrentina', 'Comida', 18.15);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tiramisu', 'Postre', 8.47);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tarta de queso', 'Postre', 10.89);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tarrina vainilla', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tarrina chocolate', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Tarrina fresa', 'Postre', 4.84);

/*******************************************************************************
   Platos del menú 2:
********************************************************************************/

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Canelones tomate', 'Comida', 10.89);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Sandwich mixto', 'Comida', 6.05);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Sandwich vegano', 'Comida', 7.26);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Bocadillo lomo', 'Comida', 9.68);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Ensaladilla rusa', 'Comida', 7.26);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Salmorejo', 'Comida', 13.31);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Chuletas cordero', 'Comida', 14.52);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Berenjenas rellenas', 'Comida', 9.68);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Croquetas de jamon', 'Comida', 12.1);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Calamares romana', 'Comida', 18.15);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Costillas barbacoa', 'Comida', 18.15);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Fritura pescado', 'Comida', 18.15);

/*******************************************************************************
   Postres:
********************************************************************************/

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cafe con hielo', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cafe con leche', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cafe con cortado', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cafe con solo', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cafe con americano', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Capucchino', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Mocca', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Machiatto', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Frappe', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Natillas', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Flan de huevo', 'Postre', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Cocacola', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Fanta naranja', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Fanta limon', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Nestea', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Pepsi', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Acuarius naranja', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Acuarius limon', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Sprite', 'Bebida', 2.42);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Agua', 'Bebida', 0);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Helado de chocolate', 'Helado', 4.84);

INSERT INTO `Platos` (`Nombre`, `Tipo`, `Precio`) VALUES ( 'Helado de fresa', 'Helado', 4.84);

/*******************************************************************************
   INSERTAR PLATOS EN ALMACEN:
********************************************************************************/

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '1', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '2', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '3', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '4', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '5', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '6', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '7', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '8', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '9', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '10', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '11', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '12', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '13', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '14', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '15', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '16', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '17', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '18', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '19', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '20', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '21', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '22', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '23', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '24', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '25', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '26', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '27', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '28', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '29', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '30', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '31', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '32', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '33', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '34', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '35', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '36', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '37', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '38', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '39', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '40', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '41', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '42', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '43', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '44', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '45', 100);

INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '46', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '47', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '48', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '49', 100);
INSERT INTO `Almacen` (`Id_almacen`, `Id_plato`, `Stockplato`) VALUES ( '1', '50', 100);








