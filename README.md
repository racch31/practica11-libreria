# Práctica 11 · Librería (HTML + PHP + SQL + Bootstrap 5)

Mini-sistema para registrar y consultar los libros de una librería.

| Página | Archivo | Qué hace |
|---|---|---|
| Inicio | `src/index.php` | Bienvenida y accesos a las otras secciones |
| Registro | `src/registro.php` | Formulario para dar de alta un libro con su portada |
| Consulta | `src/consulta.php` | Tabla con los libros guardados en la base de datos |

`src/imagen.php` lee la portada (BLOB) de la base de datos y la entrega al navegador para mostrarla en la consulta.

## Estructura

```
practica11/
├── docker-compose.yml      Servicios: web (PHP 8.2 + Apache), db (MySQL 8) y phpMyAdmin
├── docker/Dockerfile       Imagen de PHP con las extensiones de MySQL
├── db/init.sql             Crea la base `libreria` y la tabla `libros`
└── src/                    Código fuente del sitio
    ├── index.php
    ├── registro.php
    ├── consulta.php
    ├── imagen.php
    └── includes/           Conexión (db.php), encabezado con navbar y pie de página
```

## Base de datos

Tabla `libros`:

| Columna | Tipo | Notas |
|---|---|---|
| `id` | INT UNSIGNED AUTO_INCREMENT | Llave primaria |
| `autor` | VARCHAR(150) | |
| `titulo` | VARCHAR(200) | |
| `fecha_publicacion` | DATE | |
| `portada` | MEDIUMBLOB | Imagen de portada en binario |
| `portada_tipo` | VARCHAR(50) | Tipo MIME de la imagen (se necesita para poder mostrarla) |

## Cómo ejecutarlo

Requisito: Docker Desktop instalado y abierto.

```bash
docker compose up -d --build
```

- Sitio: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (usuario `root`, contraseña `root_pass`)

Para detenerlo: `docker compose down` (agrega `-v` si también quieres borrar los datos).

## Volcado de la base de datos

Con los contenedores corriendo y ya con libros registrados:

```bash
docker exec libreria_db mysqldump -u root -proot_pass --hex-blob libreria > db/volcado_libreria.sql
```

`--hex-blob` escribe las imágenes en hexadecimal para que el volcado sea un archivo de texto válido.

## Git y GitHub

El proyecto ya es un repositorio git con commits. Para vincularlo con GitHub, crea un repositorio vacío en github.com y ejecuta:

```bash
git remote add origin https://github.com/TU_USUARIO/practica11-libreria.git
git branch -M main
git push -u origin main
```
