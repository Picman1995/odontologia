<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Lançamentos</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 12px;
        }

        th {
            background-color: #eee;
            text-align: center;
        }

        td {
            text-align: left;
        }

        .text-success {
            color: green;
            font-weight: bold;
        }

        .text-danger {
            color: red;
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
        <h1>Relatório de Lançamentos</h1>

        <h5>Informações do Paciente</h5>
        <p><strong>Nome:</strong> <?= htmlspecialchars($paciente['nome']) ?></p>
        <p><strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf']) ?></p>
        <p><strong>RG:</strong> <?= htmlspecialchars($paciente['rg']) ?></p>
        <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($paciente['data_nascimento'])) ?></p>
        <p><strong>Sexo:</strong> <?= htmlspecialchars($paciente['sexo']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($paciente['telefone']) ?></p>
        <p><strong>Endereço:</strong> <?= htmlspecialchars($paciente['endereco']) ?>, <?= htmlspecialchars($paciente['cidade']) ?> - <?= htmlspecialchars($paciente['estado']) ?>, CEP: <?= htmlspecialchars($paciente['cep']) ?></p>
        <p><strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($paciente['created_at'])) ?></p>

        <h5>Lançamentos Financeiros</h5>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Valor (R$)</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lancamentos as $l): ?>
                    <tr>
                        <td style="text-align: center;"><?= $l['id_lancamento'] ?></td>
                        <td style="text-align: center;"><?= date('d/m/Y', strtotime($l['data_lancamento'])) ?></td>
                        <td style="text-align: center;" class="<?= $l['tipo'] === 'credito' ? 'text-success' : 'text-danger' ?>">
                            <?= ucfirst($l['tipo']) ?>
                        </td>
                        <td style="text-align: center;"><?= ucfirst($l['categoria']) ?></td>
                        <td style="text-align: right;">R$ <?= number_format($l['valor'], 2, ',', '.') ?></td>
                        <td><?= nl2br(htmlspecialchars($l['descricao'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h5>Saldo Final</h5>
        <p>
            <strong>Saldo:</strong>
            <span class="<?= $saldo >= 0 ? 'text-success' : 'text-danger' ?>">
                R$ <?= number_format($saldo, 2, ',', '.') ?>
            </span>
        </p>

        <h5>Assinado digitalmente.</h5>
        <p><strong>Verifique em:</strong> <a href="<?= $urlVerificacao ?>"><?= $urlVerificacao ?></a></p>
        <?= $qrcode ?>
    </main>

</body>
</html>
