<?php
require __DIR__ . '/includes/db.php';

$titulo = 'Registro';
$pagina = 'registro';

const TAMANO_MAXIMO = 5 * 1024 * 1024; // 5 MB
const TIPOS_PERMITIDOS = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

$errores = [];
$exito   = false;
$autor   = '';
$tituloLibro = '';
$fecha   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $autor       = trim($_POST['autor'] ?? '');
    $tituloLibro = trim($_POST['titulo'] ?? '');
    $fecha       = trim($_POST['fecha_publicacion'] ?? '');

    // --- Validación de los campos de texto ---
    if ($autor === '') {
        $errores[] = 'El autor es obligatorio.';
    } elseif (mb_strlen($autor) > 150) {
        $errores[] = 'El autor no puede tener más de 150 caracteres.';
    }

    if ($tituloLibro === '') {
        $errores[] = 'El título es obligatorio.';
    } elseif (mb_strlen($tituloLibro) > 200) {
        $errores[] = 'El título no puede tener más de 200 caracteres.';
    }

    $fechaValida = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!$fechaValida || $fechaValida->format('Y-m-d') !== $fecha) {
        $errores[] = 'La fecha de publicación no es válida.';
    }

    // --- Validación de la imagen ---
    $archivo = $_FILES['portada'] ?? null;
    $tipo    = '';

    if (!$archivo || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
        $errores[] = 'La imagen de portada es obligatoria.';
    } elseif ($archivo['error'] === UPLOAD_ERR_INI_SIZE || $archivo['error'] === UPLOAD_ERR_FORM_SIZE
              || $archivo['size'] > TAMANO_MAXIMO) {
        $errores[] = 'La imagen no puede pesar más de 5 MB.';
    } elseif ($archivo['error'] !== UPLOAD_ERR_OK) {
        $errores[] = 'Ocurrió un error al subir la imagen.';
    } else {
        // Se revisa el contenido real del archivo, no solo su extensión
        $info = @getimagesize($archivo['tmp_name']);
        $tipo = $info['mime'] ?? '';
        if (!in_array($tipo, TIPOS_PERMITIDOS, true)) {
            $errores[] = 'La portada debe ser una imagen JPG, PNG, GIF o WEBP.';
        }
    }

    // --- Inserción en la base de datos ---
    if (!$errores) {
        try {
            $pdo = conectar();
            $sql = 'INSERT INTO libros (autor, titulo, fecha_publicacion, portada, portada_tipo)
                    VALUES (:autor, :titulo, :fecha, :portada, :tipo)';
            $stmt = $pdo->prepare($sql);

            // Se lee el contenido binario de la imagen y se guarda en la columna BLOB
            $imagen = file_get_contents($archivo['tmp_name']);
            $stmt->bindValue(':autor', $autor);
            $stmt->bindValue(':titulo', $tituloLibro);
            $stmt->bindValue(':fecha', $fecha);
            $stmt->bindValue(':portada', $imagen, PDO::PARAM_LOB);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->execute();

            $exito = true;
            $autor = $tituloLibro = $fecha = '';
        } catch (PDOException $e) {
            $errores[] = 'No se pudo guardar el libro en la base de datos.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">

        <h1 class="h2 mb-4"><i class="bi bi-journal-plus me-2"></i>Registro de libros</h1>

        <?php if ($exito): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                El libro se registró correctamente.
                <a href="consulta.php" class="alert-link">Ver libros registrados</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <?php if ($errores): ?>
            <div class="alert alert-danger" role="alert">
                <strong>No se pudo registrar el libro:</strong>
                <ul class="mb-0">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="registro.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" name="autor" maxlength="150"
                               value="<?= htmlspecialchars($autor) ?>" placeholder="Ej. Juan Rulfo" required>
                    </div>

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" maxlength="200"
                               value="<?= htmlspecialchars($tituloLibro) ?>" placeholder="Ej. Pedro Páramo" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_publicacion" class="form-label">Fecha de publicación</label>
                        <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion"
                               value="<?= htmlspecialchars($fecha) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="portada" class="form-label">Imagen de portada</label>
                        <input type="file" class="form-control" id="portada" name="portada"
                               accept="image/jpeg,image/png,image/gif,image/webp" required>
                        <div class="form-text">Formatos JPG, PNG, GIF o WEBP. Tamaño máximo: 5 MB.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Guardar libro
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>

        <nav aria-label="Navegación entre páginas" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="index.php">Inicio</a></li>
                <li class="page-item active" aria-current="page"><span class="page-link">Registro</span></li>
                <li class="page-item"><a class="page-link" href="consulta.php">Consulta</a></li>
            </ul>
        </nav>

    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
