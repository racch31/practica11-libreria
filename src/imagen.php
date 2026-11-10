<?php
// Devuelve la portada (BLOB) de un libro para usarla en una etiqueta <img>.
require __DIR__ . '/includes/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    exit('Identificador no válido.');
}

try {
    $stmt = conectar()->prepare('SELECT portada, portada_tipo FROM libros WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $libro = $stmt->fetch();
} catch (PDOException $e) {
    http_response_code(500);
    exit('Error al consultar la base de datos.');
}

if (!$libro) {
    http_response_code(404);
    exit('Portada no encontrada.');
}

header('Content-Type: ' . $libro['portada_tipo']);
header('Content-Length: ' . strlen($libro['portada']));
header('X-Content-Type-Options: nosniff');
echo $libro['portada'];
