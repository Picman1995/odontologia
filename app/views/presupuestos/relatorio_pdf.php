<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #f5f5f5;
            padding: 10px 0;
            text-align: center;
        }

        header img {
            max-width: 250px;
            height: auto;
        }

        main {
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 25px;
        }

        h5 {
            font-size: 14px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        p {
            margin: 3px 0;
        }

        strong {
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            main {
                padding: 10mm;
            }

            header img {
                max-width: 200px;
            }

            h1 {
                font-size: 18px;
                margin-bottom: 15px;
            }

            h5 {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

    <header>
        <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(__DIR__ . '/../../../public/images/logo2.jpg')) ?>" alt="Sistema Odontológico">
    </header>

    <main>
        <h1>Presupuesto</h1>

        <h5>Datos del paciente | <?= htmlspecialchars($numeroOrcamento) ?></h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?= !empty($paciente['fecha_nacimiento']) ? date("d/m/Y", strtotime($paciente['fecha_nacimiento'])) : '—' ?></p>
        <p><strong>Cédula:</strong> <?= htmlspecialchars((string)($paciente['cpf'] ?? '')) ?></p>
        <p><strong>Direccion:</strong> <?= htmlspecialchars((string)($paciente['direccion'] ?? '')) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars((string)($paciente['ciudad'] ?? '')) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?></p>

        <h5>Datos del dentista</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($dentista['nombre']) ?></p>
        <p><strong>Especialidade:</strong> <?= htmlspecialchars($especialidade) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($dentista['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>
        <p><strong>Matrícula profesional:</strong> <?= htmlspecialchars((string)($dentista['matricula_profesional'] ?? '')) ?></p>

        <h5>Detalle del presupuesto</h5>
        <p><strong>Servicio:</strong><br><?= nl2br(htmlspecialchars((string)($orcamento['descripcion_servicio'] ?? ''))) ?></p>
        <p><strong>Valor:</strong> Gs. <?= number_format((float)($orcamento['valor'] ?? 0), 2, ',', '.') ?></p>
        <h5><strong>Fecha:</strong> <?= date("d/m/Y", strtotime((string)($orcamento['fecha'] ?? 'now'))) ?></h5>

        <h5><strong>Firmado digitalmente.</strong></h5>
        <p>Verificación: <a href="<?= BASE_URL ?>/verificar/<?= $assinatura ?>"><?= BASE_URL ?>/verificar/<?= $assinatura ?></a></p>
        <?= $assinaturaQrcode ?>
    </main>

</body>
</html>
