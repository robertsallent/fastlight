-- Base de datos vacía para fastlight
-- solamente se incluye la tabla para los usuarios y unos pocos usuarios de prueba

DROP DATABASE IF EXISTS fastlight;

CREATE DATABASE fastlight DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE fastlight;

-- tabla usuarios
-- podéis crear los campos adicionales que necesitéis.

CREATE TABLE users(
	id INT(11) NOT NULL PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(32) NOT NULL,
	roles JSON NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- algunos usuarios para las pruebas
-- podéis crear tantos como necesitéis

INSERT INTO users(displayname, email, phone, password, roles) VALUES 
	('admin', 'admin@fastlight.com', '666666666', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	('editor', 'editor@fastlight.com', '666666665', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	('user', 'user@fastlight.com', '666666664', md5('1234'), '["ROLE_USER"]')
;