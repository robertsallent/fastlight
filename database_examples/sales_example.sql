-- Base de datos con un ejemplo para pruebas en FastLight

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.
--  la tabla stats, para contar las visitas de cada URL de la aplicación.

--  una tabla products para pruebas (POSIBLE EJERCICIO: implementar un CRUD de productos).
--  una tabla customers.
--  una tabla sales.

-- Ultima modificación: 29/01/2025


DROP DATABASE IF EXISTS fastlight;

CREATE DATABASE fastlight DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE fastlight;

-- tabla users
-- se pueden crear campos adicionales o relaciones con otras entidadessi es necesario
CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(255) NOT NULL,
	roles VARCHAR(1024) NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);


-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(2048) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);

-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
	id INT PRIMARY KEY auto_increment,
    url VARCHAR(250) NOT NULL UNIQUE KEY,
	count INT NOT NULL DEFAULT 1,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);



-- TABLAS DE EJEMPLO para realizar ejercicios de clase, pruebas y test

-- tabla products
CREATE TABLE products(
	id INT NOT NULL PRIMARY KEY auto_increment,
	name VARCHAR(32) NOT NULL,
	description VARCHAR(256) NULL DEFAULT NULL,
	price FLOAT NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE customers(
	id INT NOT NULL PRIMARY KEY auto_increment,
	name VARCHAR(32) NOT NULL,
	city VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL UNIQUE KEY,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE sales(
	id INT NOT NULL PRIMARY KEY auto_increment,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	idcustomer INT NULL COMMENT 'Puede ser null (ticket de tienda, no pidió factura)',
	idproduct INT NOT NULL,
	quantity INT NOT NULL DEFAULT 1,
    price FLOAT NOT NULL COMMENT 'Precio de compra, puede no ser el precio actual del producto',
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

	FOREIGN KEY(idcustomer) REFERENCES customers(id)
		ON UPDATE CASCADE ON DELETE RESTRICT,

	FOREIGN KEY(idproduct) REFERENCES products(id)
		ON UPDATE CASCADE ON DELETE RESTRICT
);

-- tabla proveedores
CREATE TABLE providers(
	id INT NOT NULL PRIMARY KEY auto_increment,
	name VARCHAR(32) NOT NULL,
	contactperson VARCHAR(128) NOT NULL,
	contactphone VARCHAR(16) NOT NULL,
    contactemail VARCHAR(64) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- tabla intermedia en la relación N a N entre proveedores y productos
CREATE TABLE products_providers(
	idproduct INT NOT NULL,
    idprovider INT NOT NULL,
    since TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    until DATE NULL DEFAULT NULL,
    
    PRIMARY KEY(idproduct, idprovider),
    
    FOREIGN KEY(idproduct) REFERENCES products(id) 
		ON UPDATE CASCADE ON DELETE CASCADE,
        
	FOREIGN KEY(idprovider) REFERENCES providers(id) 
		ON UPDATE CASCADE ON DELETE CASCADE
);



-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(id, displayname, email, phone, picture, password, roles) VALUES 
	(1, 'admin', 'admin@fastlight.org', '666666661', 'admin.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	(2, 'editor', 'editor@fastlight.org', '666666662', NULL, md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	(3, 'user', 'user@fastlight.org', '666666663', 'user.png', md5('1234'), '["ROLE_USER"]'),
	(4, 'test', 'test@fastlight.org', '666666664', 'test.png', md5('1234'), '["ROLE_USER", "ROLE_TEST"]'),
	(5, 'api', 'api@fastlight.org', '666666665', NULL, md5('1234'), '["ROLE_API"]'),
    (6, 'blocked', 'blocked@fastlight.org', '666666666', NULL, md5('1234'), '["ROLE_USER", "ROLE_BLOCKED"]'),
    (7, 'Robert', 'robert@fastlight.org', '666666667', NULL, md5('1234'), '["ROLE_USER", "ROLE_ADMIN", "ROLE_TEST"]')
;


-- algunos productos para las pruebas, podéis crear tantos como necesiteis
INSERT INTO products(id, name, description, price) VALUES 
	(1, 'Computer', 'Nice computer, with keys and stuff.', 2000),
    (2, 'Folder', 'Little folder with a smurfs sticker.', 10),
    (3, 'Pen', 'Red pen, zeros are rounder with it.', 2),
    (4, 'Pendrive', 'Will fail at the worst moment.', 15),
    (5, 'Desk', 'Used by the most popular hunchbacks.', 150),
    (6, 'Laptop Computer', 'Big one, will crush your spine.', 500),
    (7, 'Keyboard','Spanish keyboard, with letters ñ and ç (wtf?).', 30),
    (8, 'Mouse', 'Not the animal, the other one.', 30),
    (9, 'Table', 'You can put things on it.', 120),
    (10, 'Server', 'Linux machine, god bless Linus.', 1850),
    (11, 'Steam Deck', 'Will cause arguments with your girlfriend.', 700),
    (12, 'Furby', 'Old retro toy, boomer memories.', 50),
    (13, 'Pijama', 'Not suitable for the office', 30),
    (14, 'Newspaper', 'Still in paper.', 4),
    (15, 'Screen', 'EGA resolution, nice pixels.', 40)
;



-- algunos clientes
INSERT INTO customers(id, name, city, email) VALUES
	(1, 'Pep', 'Sabadell', 'pep@sabadell.cat'),
	(2, 'Joan', 'Barcelona', 'joan@barcelona.cat'),
	(3, 'Oriol', 'Girona', 'oriol@girona.cat'),
	(4, 'Tomás', 'Terrassa', 'tomas@terrassa.cat'),
	(5, 'Michael', 'Detroit', 'muchael@detroit.com'),
	(6, 'Eva', 'Terrassa', 'eva@terrassa.cat'),
	(7, 'Ramiro', 'Sabadell', 'ramiro@sabadell.cat'),
	(8, 'Marta', 'Sabadell', 'marta@sabadell.cat'),
	(9, 'Jose', 'Sabadell', 'jose@sabadell.cat'),
	(10, 'Ignacio', 'Terrassa', 'ignacio@terrassa.cat'),
    (11, 'Roberto', 'Girona', 'roberto@girona.cat'),
    (12, 'Carlos', 'Terrassa', 'carlos@terrassa.cat'),
    (13, 'Paco', 'Sabadell', 'paco@sabadell.cat')
;

-- algunas ventas
INSERT INTO sales(id, idcustomer, idproduct, quantity, price) VALUES
	(1,1,2,5,11),
	(2,1,3,1,2),
	(3,1,5,3,175),
	(4,2,3,1,3),
	(5,2,4,3,10),
	(6,2,5,5,150),
	(7,3,1,1,1950),
	(8,4,1,4,2100),
	(9,4,5,1,145),
	(10,4,6,1,550),
	(11,5,4,1,17.50),
	(12,5,5,1,180),
	(13,6,10,2,2500),
	(14,6,5,1,180),
	(15,7,1,1,2050),
	(16,5,11,2,559),
	(17,2,11,1,649),
	(18,4,11,3,649),
	(19,NULL,5,1,190),
	(20,6,4,1,17.50),
    (21,7,5,1,150),
	(22,7,10,1,2100),
	(23,8,5,1,145),
	(24,10,1,1,1590),
    (25,11,8,3,25),
    (26,1,7,1,25),
    (27,12,2,1,11.50),
    (28,NULL,5,1,150),
    (29,11,6,1,559),
    (30,NULL,8,2,35.90)
;


-- algunos proveedores
INSERT INTO providers(id, name, contactperson, contactphone, contactemail) VALUES
(1, 'Suministradora del Vallès', 'Ramón', '123456987', 'ramon@lasumi.cat'),
(2, 'PcBox', 'Pedro', '98745854', 'pedrito@pcbox.es'),
(3, 'PcComponentes', 'Lola', '987458745', 'lola@pccomponentes.es'),
(4, 'Dell España', 'Ana', '9874584758', 'ana@dell.es'),
(5, 'Logic Center Sabadell', 'Julián', '525252541', 'juli@lcs.cat'),
(6, 'Valve', 'Gabe', '984984415', 'gabe@valve.com'),
(7, 'Ikea', 'Steven', '958547858', 'steven@ikea.com'),
(8, 'Llibreria Paes', 'Marta', '874745847', 'marta@paes.cat'),
(9, 'Toys R us', 'Lucy', '123878784', 'lucy@toysrus.com'),
(10, 'Burger King', 'Claudio', '984984988', 'claudio@burgerking.ar')
;

-- productos que suministran los proveedores
INSERT INTO products_providers(idproduct, idprovider) VALUES
(1,1), (1,2), (1,3),
(2,8),
(3,8),
(4,1), (4,3), (4,4), (4,5),
(5,7),
(6,3), (6,4), (6,5),
(7,1), (7,2), (7,5),
(8,1), (8,3),
(9,7),
(10,4),
(11,6),
(12,9),
(15, 1),(15,2), (15,3)
;


-- VISTAS

-- vista que muestra compras junto con datos del producto
CREATE VIEW v_sales AS
SELECT s.*, p.name AS product, p.price AS currentprice
FROM sales s LEFT JOIN customers c ON s.idcustomer = c.id
			 LEFT JOIN products p ON s.idproduct = p.id;
