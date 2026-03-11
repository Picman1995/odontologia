<?php 
$pageTitle = "Cambiar contraseña - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div class="container">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h1 class="text-center mt-4">Cambiar contraseña</h1>

    <div class="form-container">
        <form action="<?= BASE_URL ?>/usuarios/change-password" method="POST">
            <div class="mb-3">
                <label for="clave_actual" class="form-label">Clave actual:</label>
                <input type="password" name="clave_actual" id="clave_actual" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nueva_clave" class="form-label">Nueva clave:</label>
                <input type="password" name="nueva_clave" id="nueva_clave" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Cambiar clave</button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Volver al inicio</a>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
