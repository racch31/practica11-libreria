<?php
// Conexión a la base de datos con PDO.
// Los datos de conexión vienen de las variables de entorno definidas en docker-compose.yml.

function conectar(): PDO
{
    $host = getenv('DB_HOST') ?: 'db';
    $base = getenv('DB_NAME') ?: 'libreria';
    $user = getenv('DB_USER') ?: 'libreria_user';
    $pass = getenv('DB_PASS') ?: 'libreria_pass';

    $dsn = "mysql:host=$host;dbname=$base;charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
}
