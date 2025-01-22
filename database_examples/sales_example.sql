-- Base de datos con un ejemplo para pruebas en FastLight

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.
--  la tabla stats, para contar las visitas de cada URL de la aplicación.

--  una tabla products para pruebas (POSIBLE EJERCICIO: implementar un CRUD de productos).
--  una tabla customers.
--  una tabla sales.

-- Ultima modificación: 21/01/2025


DROP DATABASE IF EXISTS fastlight;

CREATE DATABASE fastlight DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE fastlight;

-- tabla users
-- podéis crear los campos adicionales que necesitéis.
CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(255) NOT NULL,
	roles JSON NOT NULL,
	picture VARCHAR(256) DEFAULT NULL,
	blocked_at TIMESTAMP NULL DEFAULT NULL,
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
	message VARCHAR(256) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);

-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
	id INT PRIMARY KEY auto_increment,
    url VARCHAR(256) NOT NULL UNIQUE KEY,
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
	vendor VARCHAR(128) NOT NULL,
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
	idcustomer INT NOT NULL,
	idproduct INT NOT NULL,
	quantity INT NOT NULL DEFAULT 1,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

	FOREIGN KEY(idcustomer) REFERENCES customers(id)
		ON UPDATE CASCADE ON DELETE RESTRICT,

	FOREIGN KEY(idproduct) REFERENCES products(id)
		ON UPDATE CASCADE ON DELETE RESTRICT
);



-- usuarios para las pruebas, podéis crear tantos como necesitÃ©is
INSERT INTO users(id, displayname, email, phone, password, roles) VALUES 
	(1, 'admin', 'admin@fastlight.com', '666666666', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	(2, 'editor', 'editor@fastlight.com', '666666665', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	(3, 'user', 'user@fastlight.com', '666666664', md5('1234'), '["ROLE_USER"]'),
	(4, 'test', 'test@fastlight.com', '666666663', md5('1234'), '["ROLE_USER"]'),
	(5, 'api', 'api@fastlight.com', '666666662', md5('1234'), '["ROLE_API"]')
;


-- algunos productos para las pruebas, podéis crear tantos como necesitÃ©is
INSERT INTO products(id, name, vendor, price) VALUES 
	(1, 'Computer', 'Apple', 2000),
    (2, 'Folder', 'Cambridge', 10),
    (3, 'Pen', 'Bic', 2),
    (4, 'Pendrive', 'Kingston', 15),
    (5, 'Desk', 'Ikea', 150),
    (6, 'Computer', 'Acer', 500),
    (7, 'Desk','Furniture Inc.', 630),
    (8, 'Mouse', 'Logitech', 30),
    (9, 'Table', 'Ikea', 120),
    (10, 'Computer', 'IBM', 1850),
    (11, 'Steam Deck', 'Valve', 700)
;

-- algunos clientes
INSERT INTO customers(id, name, city, email) VALUES
	(1, 'Pep', 'Sabadell', 'pep@sabadell.cat'),
	(2, 'Joan', 'Barcelona', 'joan@barcelona.cat'),
	(3, 'Oriol', 'Girona', 'oriol@girona.cat'),
	(4, 'Borja', 'Pozuelo', 'borja@pozuelo.es'),
	(5, 'Michael', 'Detroit', 'muchael@detroit.com'),
	(6, 'Dembo', 'Johannesburgo', 'dembo@johannesburgo.com'),
	(7, 'Ramiro', 'Murcia', 'rodrigo@murcia.es'),
	(8, 'Marta', 'Sabadell', 'marta@sabadell.cat'),
	(9, 'Jose', 'Sabadell', 'jose@sabadell.cat'),
	(10, 'Pocholo', 'Pozuelo', 'pocholo@pozuelo.es')
;

-- algunas ventas
INSERT INTO sales(id, idcustomer, idproduct, quantity) VALUES
	(1,1,2,5),
	(2,1,3,1),
	(3,1,5,3),
	(4,2,3,1),
	(5,2,4,3),
	(6,2,5,5),
	(7,3,1,1),
	(8,4,1,4),
	(9,4,5,1),
	(10,4,6,1),
	(11,5,4,1),
	(12,5,5,1),
	(13,6,10,2),
	(14,6,5,1),
	(15,7,1,1),
	(16,5,11,2),
	(17,2,11,1),
	(18,4,11,3),
	(19,2,5,1),
	(20,6,4,1)
;