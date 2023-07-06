-- Base de datos con un ejemplo para pruebas en fastlight

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.

--  una tabla products para pruebas (POSIBLE EJERCICIO: implementar un CRUD de productos).
--  una tabla customers.
--  una tabla sales.


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
	password VARCHAR(32) NOT NULL,
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
	email VARCHAR(128) NOT NULL UNIQUE KEY
);

CREATE TABLE sales(
	id INT NOT NULL PRIMARY KEY auto_increment,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	idcustomer INT NOT NULL,
	idproduct INT NOT NULL,
	quantity INT NOT NULL DEFAULT 1,

	FOREIGN KEY(idcustomer) REFERENCES customers(id)
		ON UPDATE CASCADE ON DELETE RESTRICT,

	FOREIGN KEY(idproduct) REFERENCES products(id)
		ON UPDATE CASCADE ON DELETE RESTRICT
);



-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(displayname, email, phone, password, roles) VALUES 
	('admin', 'admin@fastlight.com', '666666666', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	('editor', 'editor@fastlight.com', '666666665', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	('user', 'user@fastlight.com', '666666664', md5('1234'), '["ROLE_USER"]'),
	('test', 'test@fastlight.com', '666666663', md5('1234'), '["ROLE_USER"]'),
	('api', 'api@fastlight.com', '666666662', md5('1234'), '["ROLE_API"]')
;


-- algunos productos para las pruebas, podéis crear tantos como necesitéis
INSERT INTO products(name, vendor, price) VALUES 
	('Computer', 'Apple', 2000),
    ('Folder', 'Cambridge', 10),
    ('Pen', 'Bic', 2),
    ('Pendrive', 'Kingston', 15),
    ('Desk', 'Ikea', 150),
    ('Computer', 'Acer', 500),
    ('Desk','Furniture Inc.', 630),
    ('Mouse', 'Logitech', 30)
;

-- algunos clientes
INSERT INTO customers(name, city, email) VALUES
	('Pep', 'Sabadell', 'pep@sabadell.cat'),
	('Joan', 'Barcelona', 'joan@barcelona.cat'),
	('Oriol', 'Girona', 'oriol@girona.cat'),
	('Borja', 'Aranjuez', 'borja@aranjuez.es'),
	('Michael', 'Detroit', 'muchael@detroit.com'),
	('Dembo', 'Johannesburgo', 'dembo@johannesburgo.com')
;

-- algunas ventas
INSERT INTO sales(idcustomer, idproduct, quantity) VALUES
	(1,2,5),(1,3,1),(1,5,3),
	(2,3,1),(2,4,3),(2,5,5),
	(3,1,1),
	(4,1,4),(4,5,1),(4,6,1),
	(5,4,1),(5,5,1)
;