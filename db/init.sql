-- Práctica 11: base de datos de la librería
-- Este script se ejecuta automáticamente la primera vez que se levanta el contenedor de MySQL.

CREATE DATABASE IF NOT EXISTS libreria
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE libreria;

CREATE TABLE IF NOT EXISTS libros (
    id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    autor             VARCHAR(150) NOT NULL,
    titulo            VARCHAR(200) NOT NULL,
    fecha_publicacion DATE         NOT NULL,
    portada           MEDIUMBLOB   NOT NULL,   -- imagen de portada (hasta 16 MB)
    portada_tipo      VARCHAR(50)  NOT NULL,   -- tipo MIME, p. ej. image/jpeg
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
