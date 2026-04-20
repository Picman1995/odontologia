<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Orçamento</title>
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
            background-color: #f5f5f5; /* cinza claro */
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
        <h1>Orçamento</h1>

        <h5>Informacciones do Paciente | <?= htmlspecialchars($numeroOrcamento) ?></h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?= !empty($paciente['fecha_nacimiento']) ? date("d/m/Y", strtotime($paciente['fecha_nacimiento'])) : '—' ?></p>
        <p><strong>Cédula:</strong> <?= htmlspecialchars((string)($paciente['cpf'] ?? '')) ?></p>
        <p><strong>Direccion:</strong> <?= htmlspecialchars((string)($paciente['direccion'] ?? '')) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars((string)($paciente['ciudad'] ?? '')) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?></p>

        <h5>Informacciones do Dentista</h5>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($dentista['nombre']) ?></p>
        <p><strong>Especialidade:</strong> <?= htmlspecialchars($especialidade) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($dentista['telefono']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>
        <p><strong>CRO:</strong> <?= htmlspecialchars($dentista['cro']) ?></p>

        <h5>Informacciones do Orçamento</h5>
        <p><strong>Serviço:</strong><br><?= nl2br(htmlspecialchars($orcamento['descricao_servico'])) ?></p>
        <p><strong>Valor:</strong> R$ <?= number_format($orcamento['valor'], 2, ',', '.') ?></p>
        <h5><strong>Data:</strong> <?= date("d/m/Y", strtotime($orcamento['data'])) ?></h5>

        <h5><strong>Assinado digitalmente.</strong></h5>
        <p>Verifique em: <a href="<?= BASE_URL ?>/verificar/<?= $assinatura ?>"><?= BASE_URL ?>/verificar/<?= $assinatura ?></a></p>
        <?= $assinaturaQrcode ?>
    </main>

</body>
</html>
