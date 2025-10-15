-- Base de datos limpia para el framework FastLight.
-- Servirá como punto de partida de los proyectos FastLight.

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.
--  la tabla stats, para contar las visitas de cada URL de la aplicación.

-- Última modificación: 10/10/2025


DROP DATABASE IF EXISTS fastlight;

CREATE DATABASE fastlight 
	DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE fastlight;

-- tabla users
-- se pueden crear campos adicionales o relaciones con otras entidades si es necesario
CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(255) NOT NULL,
	roles VARCHAR(1024) NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	template VARCHAR(32) NULL DEFAULT NULL COMMENT 'Template a cargar, de entre los que se encuentran en la carpeta templates',
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(id, displayname, email, phone, picture, password, roles) VALUES 
	(1, 'admin', 'admin@fastlight.org', '000001', 'admin.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	(2, 'editor', 'editor@fastlight.org', '000002', 'editor.png', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	(3, 'user', 'user@fastlight.org', '000003', 'user.png', md5('1234'), '["ROLE_USER"]'),
	(4, 'test', 'test@fastlight.org', '000004', 'test.png', md5('1234'), '["ROLE_USER", "ROLE_TEST"]'),
	(5, 'api', 'api@fastlight.org', '000005', 'api.png', md5('1234'), '["ROLE_API"]'),
    (6, 'blocked', 'blocked@fastlight.org', '000006', 'blocked.png', md5('1234'), '["ROLE_USER", "ROLE_BLOCKED"]'),
    (7, 'default', 'default@fastlight.org', '000007', NULL, md5('1234'), '[]'),
    (8, 'Robert', 'robert@fastlight.org', '000008', 'other.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN", "ROLE_TEST"]')    
;



-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type CHAR(3) NOT NULL DEFAULT 'WEB',
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(2048) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

