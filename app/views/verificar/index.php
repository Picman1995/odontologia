<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Verificação de Documento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 255, 255);
            color: #222;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color:rgb(255, 255, 255);
            padding: 20px 0;
        }

        header img {
            max-width: 200px;
            height: auto;
        }

        main {
            padding: 30px 20px;
        }

        h1 {
            font-size: 22px;
            margin-top: 20px;
            color: #28a745;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        .error {
            color: #dc3545;
        }

        @media print {
            header img {
                max-width: 150px;
            }

            h1 {
                font-size: 18px;
                color: #000;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <header>
        <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(__DIR__ . '/../../../public/images/logo3.jpg')) ?>" alt="Sistema Odontológico">
    </header>

    <main>
        <?php if ($tokenStatus): ?>
            <h1>✅ Documento Válido</h1>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($tokenTipo) ?></p>
            <p><strong>Data de Geração:</strong> <?= htmlspecialchars($tokenData) ?></p>
        <?php else: ?>
            <h1 class="error">❌ Documento não encontrado ou inválido</h1>
        <?php endif; ?>
    </main>

</body>
</html>