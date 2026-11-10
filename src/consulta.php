<?php
require __DIR__ . '/includes/db.php';

$titulo = 'Consulta';
$pagina = 'consulta';

$libros = [];
$error  = '';

try {
    $pdo = conectar();
    // No se trae la columna BLOB aquí: cada portada se pide aparte a imagen.php
    $libros = $pdo->query(
        'SELECT id, autor, titulo, fecha_publicacion FROM libros ORDER BY id DESC'
    )->fetchAll();
} catch (PDOException $e) {
    $error = 'No se pudo consultar la base de datos.';
}

require __DIR__ . '/includes/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-collection me-2"></i>Libros registrados
        <span class="badge text-bg-secondary align-middle fs-6"><?= count($libros) ?></span>
    </h1>
    <a href="registro.php" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Registrar libro
    </a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
<?php elseif (!$libros): ?>
    <div class="alert alert-info" role="alert">
        Todavía no hay libros registrados.
        <a href="registro.php" class="alert-link">Registra el primero</a>.
    </div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Portada</th>
                        <th scope="col">Título</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Fecha de publicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <th scope="row"><?= (int) $libro['id'] ?></th>
                            <td>
                                <img src="imagen.php?id=<?= (int) $libro['id'] ?>"
                                     alt="Portada de <?= htmlspecialchars($libro['titulo']) ?>"
                                     class="img-thumbnail" width="90" loading="lazy">
                            </td>
                            <td class="fw-semibold"><?= htmlspecialchars($libro['titulo']) ?></td>
                            <td><?= htmlspecialchars($libro['autor']) ?></td>
                            <td><?= date('d/m/Y', strtotime($libro['fecha_publicacion'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<nav aria-label="Navegación entre páginas" class="mt-5">
    <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="index.php">Inicio</a></li>
        <li class="page-item"><a class="page-link" href="registro.php">Registro</a></li>
        <li class="page-item active" aria-current="page"><span class="page-link">Consulta</span></li>
    </ul>
</nav>

<?php require __DIR__ . '/includes/footer.php'; ?>
