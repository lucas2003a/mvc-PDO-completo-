CREATE DATABASE senati;
USE senati;

CREATE TABLE cursos
(
	idcurso		INT AUTO_INCREMENT	PRIMARY KEY,
	nombrecurso	VARCHAR(50)	NOT NULL,
	especialidad	VARCHAR(70)	NOT NULL,
	complejidad	CHAR(1)		NOT NULL DEFAULT 'B',
	fechainicio	DATE 		NOT NULL,
	precio		DECIMAL(7,2)	NOT NULL,
	fechacreacion	DATETIME	NOT NULL DEFAULT NOW(),
	fechaupdate	DATETIME	NULL,
	estado		CHAR(1)		NOT NULL DEFAULT '1'
)ENGINE = INNODB;

INSERT INTO cursos (nombrecurso, especialidad, complejidad, fechainicio, precio) VALUES
('Java', 'ETI', 'M', '2023-05-10', 180),
('Desarrollo Web', 'ETI', 'B', '2023-04-20', 190),
('Excel Financiero', 'Administración', 'A', '2023-05-14', 250),
('ERP SAP', 'Administración', 'A', '2023-05-11', 400),
('Inventor','Mecánica', 'M', '2023-04-29', 380);

SELECT * FROM cursos;

-- STORE PROCEDURE
-- Un procedimiento almacenado es un PROGRAMA  que se ejecuta desde el
-- motor de BD, y que permite recibir valores de entrada, realizar
-- diferentes tipos de calculos y entregar una salida
DELIMITER $$
CREATE PROCEDURE spu_cursos_listar()
BEGIN
	SELECT 	idcurso,
		nombrecurso,
		especialidad,
		complejidad,
		fechainicio,
		precio
	FROM cursos
	WHERE estado = '1'
	ORDER BY idcurso DESC;
END $$

CALL spu_cursos_listar();
SELECT * FROM cursos


-- Procedimiento registrar cursos
DELIMITER $$
CREATE PROCEDURE spu_cursos_registrar(
	IN _nombrecurso	VARCHAR(50),
	IN _especialidad	VARCHAR(70),
	IN _complejidad	CHAR(1),
	IN _fechainicio	DATE,
	IN _precio			DECIMAL(7,2)

)
BEGIN
	INSERT INTO cursos(nombrecurso,especialidad,complejidad,fechainicio,precio) VALUES
		(_nombrecurso,_especialidad,_complejidad,_fechainicio,_precio);
END $$

CALL spu_cursos_registrar('Python para todos','ETI','B','2023-05-10',120);
CALL spu_cursos_listar();



-- Lunes 10 de Abril 2023
DELIMITER $$
CREATE PROCEDURE spu_cursos_recuperar_id(IN _idcurso INT)
BEGIN
	SELECT * FROM cursos WHERE idcurso = _idcurso;
END $$

CALL spu_cursos_recuperar_id(3);



DELIMITER $$
CREATE PROCEDURE spu_cursos_actualizar
(
	IN _idcurso			INT,
	IN _nombrecurso	VARCHAR(50),
	IN _especialidad	VARCHAR(70),
	IN _complejidad	CHAR(1),
	IN _fechainicio	DATE,
	IN _precio			DECIMAL(7,2)
)
BEGIN
	UPDATE cursos SET
		nombrecurso = _nombrecurso,
		especialidad = _especialidad,
		complejidad = _complejidad,
		fechainicio = _fechainicio,
		precio = _precio,
		fechaupdate = NOW()
	WHERE idcurso = _idcurso;
END $$

SELECT * FROM cursos WHERE idcurso = 3;
CALL spu_cursos_actualizar(3, 'Excel para Gestión', 'ETI', 'A', '2023-07-20', 255);



-- drop table usuarios
CREATE TABLE usuarios
(
	idusuario		INT AUTO_INCREMENT PRIMARY KEY,
	nombreusuario	VARCHAR(30)	NOT NULL,
	claveacceso		VARCHAR(90)	NOT NULL,
	apellidos		VARCHAR(30)	NOT NULL,
	nombres			VARCHAR(30)	NOT NULL,
	nivelacceso		CHAR(1)		NOT NULL DEFAULT 'A',
	estado			CHAR(1)		NOT NULL DEFAULT '1',
	fecharegistro 	DATETIME		NOT NULL DEFAULT NOW(),
	fechaupdate		DATETIME		NULL,
	CONSTRAINT uk_nombreusuario_usa UNIQUE (nombreusuario)
)ENGINE = INNODB;

INSERT INTO usuarios (nombreusuario,claveacceso,apellidos,nombres) VALUES
	('Ana', '123456', 'Sotelo Cardenas','Ana'),
	('Jhon', '123456', 'Francia Minaya', 'Jhon Edward');

SELECT * FROM usuarios;

-- ACTUALIZANDO por la clave encriptada
-- Defecto: SENATI

UPDATE usuarios SET
	claveacceso = '$2y$10$cZQ/5Kg57IS1l0s83L9jCuwe.nCW/esjLuYnU4bOGqJhHq5DYWxTW'
	WHERE idusuario = 1;

UPDATE usuarios SET
	claveacceso = '$2y$10$46OhZ8ONDy7L6Fv1iXLM5.1MarRXKKUnwqVUQzOux5ePe64suTvau'
	WHERE idusuario = 2;
	
SELECT * FROM usuarios;


DELIMITER $$
CREATE PROCEDURE spu_usuarios_login(IN _nombreusuario VARCHAR(30))
BEGIN
	SELECT 	idusuario, nombreusuario, claveacceso,
				apellidos, nombres, nivelacceso
	FROM usuarios
	WHERE nombreusuario = _nombreusuario AND estado = '1';
END $$

CALL spu_usuarios_login('Ana');


-- CRUD DE USUARIOS
-- LISTAR USUARIOS
DELIMITER $$
CREATE PROCEDURE spu_usuarios_listar()
BEGIN
	SELECT 	idusuario,
		nombreusuario,
		apellidos,
		nombres,
		nivelacceso,
		fecharegistro
	FROM usuarios
	WHERE estado = '1'
	ORDER BY idusuario DESC;
END $$

CALL spu_usuarios_listar();
-- REGISTRAR USUARIOS
DELIMITER $$
CREATE PROCEDURE spu_usuarios_registrar(
	IN _nombreusuario	VARCHAR(30),
	IN _claveacceso	VARCHAR(90),
	IN _nivelacceso	CHAR(1),
	IN _apellidos		VARCHAR(30),
	IN _nombres		VARCHAR(30)

)
BEGIN
	INSERT INTO usuarios(nombreusuario,claveacceso,nivelacceso, apellidos,nombres) VALUES
		(_nombreusuario,_claveacceso,_nivelacceso,_apellidos,_nombres);
END $$

CALL spu_usuarios_registrar('Re9dyt4ox','Origen','A','Castillo Marquez','Jesús');
CALL spu_usuarios_listar();



-- ACTUALIZAR O MODIFICAR USUARIOS
DELIMITER $$
CREATE PROCEDURE spu_usuarios_actualizar
(
	IN _idusuario		INT,
	IN _nombreusuario	VARCHAR(30),
	IN _claveacceso	VARCHAR(90),
	IN _apellidos		VARCHAR(30),
	IN _nombres			VARCHAR(30),
	IN _nivelacceso	CHAR(1)

)
BEGIN
	UPDATE usuarios SET
		nombreusuario 	= _nombreusuario,
		claveacceso 	= _claveacceso,
		apellidos 		= _apellidos,
		nombres 			= _nombres,
		nivelacceso 	=_nivelacceso,
		fechaupdate 	= NOW()
	WHERE idusuario = _idusuario;
END $$

-- CALL spu_usuarios_actualizar(7, 'Yisus', 'Abril', 'Castillo Marquez', 'Jesús', 'I');
CALL spu_usuarios_listar;


-- ELIMINAR USUARIOS
DELIMITER $$
CREATE PROCEDURE spu_usuarios_eliminar(IN _idusuario INT)
BEGIN
	DELETE FROM usuarios
	WHERE idusuario = _idusuario;
END $$

CALL spu_usuarios_eliminar(3);

DELIMITER $$
CREATE PROCEDURE spu_usuarios_recuperar_id(IN _idusuario INT)
BEGIN
	SELECT * FROM usuarios WHERE idusuario = _idusuario;
END $$

CALL spu_usuarios_recuperar_id(1);


