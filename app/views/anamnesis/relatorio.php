<?php 
$pageTitle = "Anamnese - Sistema Odontológico";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container text-center mt-3">
    <img src="<?= BASE_URL ?>/images/logo.jpg" alt="Sistema Odontológico" style="max-height: 100px;">
</div>

<div class="container">
    <h1 class="text-center mt-4">ANAMNESE ODONTOLÓGICA</h1>

    <div class="form-container mt-4 p-4 rounded shadow-sm bg-dark text-light">

        <h5 class="border-bottom pb-2 mb-3">Informações do Paciente - <?= $numeroAnamnese ?></h5>
        <p><strong>Nome:</strong> <?= htmlspecialchars($paciente['nome']) ?></p>
        <p><strong>Data de Nascimento:</strong> <?= htmlspecialchars(date("d/m/Y", strtotime($paciente['data_nascimento']))) ?></p>
        <p><strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf']) ?></p>
        <p><strong>RG:</strong> <?= htmlspecialchars($paciente['rg']) ?></p>
        <p><strong>Endereço:</strong> <?= htmlspecialchars($paciente['endereco']) ?></p>
        <p><strong>Cidade:</strong> <?= htmlspecialchars($paciente['cidade']) ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($paciente['estado']) ?></p>
        <p><strong>CEP:</strong> <?= htmlspecialchars($paciente['cep']) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($paciente['telefone']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($paciente['email']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Informações do Dentista</h5>
        <p><strong>Nome:</strong> <?= htmlspecialchars($dentista['nome']) ?></p>
        <p><strong>Especialidade:</strong> <?= htmlspecialchars($especialidade) ?></p>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($dentista['telefone']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($dentista['email']) ?></p>
        <p><strong>CRO:</strong> <?= htmlspecialchars($dentista['cro']) ?></p>

        <h5 class="border-bottom pb-2 mb-3 mt-4">Informações da Anamnese</h5>
        <p><?=  nl2br(htmlspecialchars($anamnese['descricao'])) ?></p>
        <h5 class="border-bottom pb-2 mb-3 mt-4"><strong>Data:</strong> <?= htmlspecialchars(date("d/m/Y", strtotime($anamnese['data']))) ?></h5>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/anamneses/relatorio/pdf/<?= $anamnese['id_anamnese'] ?>" class="btn btn-sm btn-success" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Gerar PDF
            </a>
            <a href="<?= BASE_URL ?>/anamneses" class="btn btn-outline-light btn-sm rounded-1 px-4 shadow-sm">Voltar para lista</a>
        </div>
    </div>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
