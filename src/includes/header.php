<?php
// Encabezado común: <head>, Bootstrap 5 y barra de navegación.
// Cada página define $titulo y $pagina antes de incluir este archivo.
$titulo = $titulo ?? 'Librería';
$pagina = $pagina ?? '';

function activo(string $nombre, string $pagina): string
{
    return $nombre === $pagina ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($titulo) ?> | Librería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-body-tertiary">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="index.php">
            <i class="bi bi-book-half me-1"></i> Librería
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false" aria-label="Mostrar navegación">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= activo('inicio', $pagina) ?>" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= activo('registro', $pagina) ?>" href="registro.php">Registro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= activo('consulta', $pagina) ?>" href="consulta.php">Consulta</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5 flex-grow-1">
