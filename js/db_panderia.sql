DROP DATABASE  IF EXISTS panaderia;
CREATE DATABASE IF NOT EXISTS panaderia DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;

CREATE TABLE cliente (
	id CHAR(10),
	nombre VARCHAR(40),
	apellido VARCHAR(60),
	telefono VARCHAR(10),
	direccion VARCHAR(50),
	correo VARCHAR(50),
	PRIMARY KEY(id)
);

CREATE TABLE producto (
	id INT UNSIGNED AUTO_INCREMENT,
	nombre VARCHAR(50),
	descripcion VARCHAR(80),
	precio FLOAT(10, 2),
	cantidad SMALLINT UNSIGNED,
	PRIMARY KEY(id)
);


CREATE TABLE proveedor (
	id CHAR(10),
	nombre VARCHAR(40),
	apellido VARCHAR(60),
	telefono VARCHAR(10),
	telefono2 VARCHAR(10),
	PRIMARY KEY(id)
);


CREATE TABLE tipo_user (
	id TINYINT UNSIGNED AUTO_INCREMENT,
	nombre VARCHAR(20),
	PRIMARY KEY(id)
);


CREATE TABLE estado (
	id TINYINT UNSIGNED AUTO_INCREMENT,
	estado VARCHAR(20),
	PRIMARY KEY(id)
);


CREATE TABLE usuario(
	id CHAR(10),
	nombre VARCHAR(50),
	apellido VARCHAR(60),
	usuario VARCHAR(20),
	contrasena VARCHAR(170),
	telefono VARCHAR(10),
	direccion VARCHAR(50),
	tipo_usuario TINYINT UNSIGNED,
	PRIMARY KEY(id),
	FOREIGN KEY(tipo_usuario) REFERENCES tipo_user(id)


);

CREATE TABLE permisos (
    id TINYINT UNSIGNED,
    nombre VARCHAR(30),
    PRIMARY KEY(id)
);


CREATE TABLE permisos_users (
	cod TINYINT UNSIGNED AUTO_INCREMENT,
    permiso TINYINT UNSIGNED,
    user CHAR(10),
    estado_user VARCHAR(20),

    PRIMARY KEY(cod),
    FOREIGN KEY(permiso) REFERENCES permisos(id),
    FOREIGN KEY(user) REFERENCES usuario(id)
);


CREATE TABLE factura (
    codigo INT UNSIGNED AUTO_INCREMENT,
    id_cliente CHAR(10),
    id_vendedor CHAR(10),
    fecha DATETIME,
    total FLOAT(10,2),
    estado_factura ENUM('Activa','Incactiva'),

    PRIMARY KEY(codigo),
    FOREIGN KEY(id_cliente) REFERENCES cliente(id),
    FOREIGN KEY(id_vendedor) REFERENCES usuario(id)

);


CREATE TABLE item_factura (
    id_item INT UNSIGNED AUTO_INCREMENT,
    cod_factura INT UNSIGNED,
    id_producto INT UNSIGNED,
    cantidad TINYINT UNSIGNED,
    subtotal FLOAT(10,2),
    estado_factura ENUM('Activa','Incactiva'),

    PRIMARY KEY(id_item),
    FOREIGN KEY(cod_factura) REFERENCES factura(codigo),
    FOREIGN KEY(id_producto) REFERENCES producto(id)

);


CREATE TABLE gastos (
    id INT UNSIGNED,
    titulo FLOAT(10,2),
    total FLOAT(10,2),
    descripcion VARCHAR(80),

    PRIMARY KEY(id)
)

CREATE TABLE detalle_temp (
  correlativo INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
  token_user VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,
  codproducto INT(11) NOT NULL,
  cantidad SMALLINT,
  precio_vent FLOAT(10,2) NOT NULL
)


DELIMITER //
CREATE PROCEDURE detalle_factu_temp(cod_producto INT, cant INT, usuario VARCHAR(50))
	
	BEGIN

		DECLARE precio_actual FLOAT(10,2);
		SELECT precio INTO precio_actual FROM producto WHERE id = cod_producto;

		INSERT INTO detalle_temp(token_user, codproducto, cantidad, precio_vent) VALUES(token_user, cod_producto, cant, precio_actual);


		SELECT temp.correlativo, temp.codproducto, p.nombre, temp.cantidad, temp.precio_vent FROM detalle_temp temp
		INNER JOIN producto p ON temp.codproducto = p.id
		WHERE temp.token_user = token_user;

	END;//

DELIMITER ;


-- ALTER TABLE panaderia.usuario ADD contrasena VARCHAR(170) NULL;

-- PROCEDIMIENTO ELIMINAR ITEM
DELIMITER //
CREATE PROCEDURE eliminar_item_detalle(id_detalle int, token VARCHAR(50))
BEGIN
DELETE FROM detalle_temp WHERE correlativo = id_detalle;


SELECT tmp.correlativo, tmp.codproducto, p.nombre, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp INNER JOIN producto p ON tmp.codproducto = p.id WHERE tmp.token_user = token;
END; //
DELIMITER //