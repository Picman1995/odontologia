<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Receita Odontológica</title>
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

        .assinatura {
            margin-top: 60px;
        }

        .assinatura p {
            border-top: 1px solid #000;
            width: 250px;
            margin: 20px auto 0;
            text-align: center;
            padding-top: 5px;
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
    <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(__DIR__ . '/../../../public/images/logo2.jpg')) ?>" alt="Logo Clínica">
</header>

<main>
    <h1>Receituário</h1>

    <h5>Emitente</h5>
    <p><strong>Nome:</strong> <?= htmlspecialchars($dentista['nome']) ?> - <?= htmlspecialchars($dentista['cro']) ?></p>
    <p><strong>Endereço:</strong> <?= htmlspecialchars($dentista['endereco']) ?> - <?= htmlspecialchars($dentista['cidade']) ?>/<?= htmlspecialchars($dentista['estado']) ?></p>

    <h5>Cidadão</h5>
    <p><strong>Nome:</strong> <?= htmlspecialchars($paciente['nome']) ?> - <strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf']) ?></p>
    <p><strong>Endereço:</strong> <?= htmlspecialchars($paciente['endereco']) ?> - <?= htmlspecialchars(CIDADE_CLINICA) ?>/<?= htmlspecialchars(ESTADO_CLINICA) ?></p>

    <h5>Medicamentos</h5>
    <p><?= nl2br(htmlspecialchars($receita['conteudo'])) ?></p>

    <div class="assinatura">
        <p><?= htmlspecialchars($dentista['nome']) ?><br><?= htmlspecialchars($dentista['cro']) ?><br><?= htmlspecialchars($paciente['cidade']) ?> - <?= htmlspecialchars($paciente['estado']) ?>, <?php echo"$dia de {$meses[$mes]} de $ano" ?></p>
    </div>

    <h5><strong>Assinado digitalmente.</strong></h5>
    <p>Verifique em: <a href="<?= BASE_URL ?>/verificar/<?= $assinatura ?>"><?= BASE_URL ?>/verificar/<?= $assinatura ?></a></p>
    <?= $assinaturaQrcode ?>
</main>

</body>
</html>
