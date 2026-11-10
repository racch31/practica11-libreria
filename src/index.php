<?php
$titulo = 'Inicio';
$pagina = 'inicio';
require __DIR__ . '/includes/header.php';
?>

<div class="p-5 mb-4 bg-white border rounded-3 shadow-sm text-center">
    <i class="bi bi-book-half display-1 text-primary"></i>
    <h1 class="display-5 fw-bold mt-3">Bienvenido a la Librería</h1>
    <p class="lead text-secondary col-lg-8 mx-auto">
        Sistema de registro de libros. Desde aquí puedes dar de alta libros nuevos
        con su portada y consultar todos los que están guardados en la base de datos.
    </p>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <i class="bi bi-journal-plus fs-1 text-success"></i>
                <h2 class="h4 card-title mt-2">Registro</h2>
                <p class="card-text text-secondary">
                    Captura el autor, el título, la fecha de publicación y la imagen de portada de un libro nuevo.
                </p>
                <a href="registro.php" class="btn btn-success">Registrar un libro</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <i class="bi bi-collection fs-1 text-primary"></i>
                <h2 class="h4 card-title mt-2">Consulta</h2>
                <p class="card-text text-secondary">
                    Revisa el catálogo completo de libros registrados, con su portada.
                </p>
                <a href="consulta.php" class="btn btn-primary">Ver libros registrados</a>
            </div>
        </div>
    </div>
</div>

<nav aria-label="Navegación entre páginas" class="mt-5">
    <ul class="pagination justify-content-center">
        <li class="page-item active" aria-current="page"><span class="page-link">Inicio</span></li>
        <li class="page-item"><a class="page-link" href="registro.php">Registro</a></li>
        <li class="page-item"><a class="page-link" href="consulta.php">Consulta</a></li>
    </ul>
</nav>

<?php require __DIR__ . '/includes/footer.php'; ?>
