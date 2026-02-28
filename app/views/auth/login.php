<?php  
require_once __DIR__ . '/../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100vw;
            min-height: 100vh;
            object-fit: cover;
            z-index: -1;
            opacity: 1;
            transition: opacity 1s ease-in-out;
        }

        body {
            background-color: rgba(0,0,0,0.5);
            color: #fff;
        }

        .form-container {
            background-color: rgba(0,0,0,0.65);
            padding: 30px;
            border-radius: 10px;
        }

        .form-label {
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Vídeos de fundo -->
    <video id="bg1" class="video-bg" autoplay muted playsinline></video>
    <video id="bg2" class="video-bg d-none" muted playsinline></video>

    <script>
        const bg1 = document.getElementById('bg1');
        const bg2 = document.getElementById('bg2');

        bg1.src = "<?= BASE_URL ?>/videos/bg.mp4";
        bg2.src = "<?= BASE_URL ?>/videos/bg2.mp4";

        bg1.play();

        function alternarVideos(current, next) {
            current.classList.add('d-none');
            next.classList.remove('d-none');
            next.currentTime = 0;
            next.play();

            next.onended = () => {
                alternarVideos(next, current);
            };
        }

        bg1.onended = () => {
            alternarVideos(bg1, bg2);
        };
    </script>

    <!-- Formulário -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 form-container">
                <h3 class="text-center mb-4">Acceso al sistema</h3>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>/login">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
