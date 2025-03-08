-- Base de datos limpia para el framework FastLight.
-- Servirá como punto de partida de los proyectos FastLight.

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.
--  la tabla stats, para contar las visitas de cada URL de la aplicación.

-- Última modificación: 19/12/2024


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

