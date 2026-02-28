<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Orcamento.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use chillerlan\QRCode\{QRCode, QROptions};

class OrcamentoController {
    private Orcamento $orcamentoModel;

    public function __construct() {
        $this->orcamentoModel = new Orcamento();
    }

    public function index(): void {
        $orcamentos = $this->orcamentoModel->getAll();
        include __DIR__ . '/../views/presupuestos/index.php';
    }

    public function relatorio($orcamentoId): void {
        $paciente = $this->orcamentoModel->getPacienteAllInfoById($orcamentoId);
        $dentista = $this->orcamentoModel->getDentistaAllInfoById($orcamentoId);
        $especialidade = $this->orcamentoModel->getEspecialidadeNameById($dentista['especialidad_id'] ?? 0);
        $orcamento = $this->orcamentoModel->find($orcamentoId);
        $numeroOrcamento = $this->orcamentoModel->gerarNumeroOrcamento($orcamentoId);
        include __DIR__ . '/../views/presupuestos/relatorio.php';
    }

    public function gerarRelatorioPDF(int $id): void {
        $orcamento = $this->orcamentoModel->find($id);
        $paciente = $this->orcamentoModel->getPacienteAllInfoById($id);
        $dentista = $this->orcamentoModel->getDentistaAllInfoById($id);
        $especialidade = $this->orcamentoModel->getEspecialidadeNameById($dentista['especialidad_id'] ?? 0);
        $numeroOrcamento = $this->orcamentoModel->gerarNumeroOrcamento($id);

        $dadosParaAssinar = $paciente['cpf'] . $dentista['cro'] . $orcamento['valor'] . $orcamento['fecha'];
        $assinatura = hash('sha256', $dadosParaAssinar . SECRET_KEY);       

        if (!$orcamento || !$paciente || !$dentista) {
            echo "Datos no encontrados.";
            return;
        }

        $dadosRelatorio = [
            'orcamento' => $orcamento,
            'paciente' => $paciente,
            'dentista' => $dentista,
            'especialidade' => $especialidade
        ];

        $assinar = $this->orcamentoModel->assinar($assinatura, 'Presupuesto', $dadosRelatorio);
        $data = BASE_URL . '/verificar/' . $assinatura;
        $assinaturaQrcode = '<div style="text-align: center;"><img src="' . (new QRCode)->render($data) . '" alt="QR Code" style="width:150px; height:150px;"/></div>';

        ob_start();
        include __DIR__ . '/../views/presupuestos/relatorio_pdf.php';
        $html = ob_get_clean();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Presupuesto_{$id}.pdf", ["Attachment" => false]);
    }

    public function create(): void {
        include __DIR__ . '/../views/presupuestos/create.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $_POST['paciente_id'] ?? '',
                'dentista_id' => $_POST['dentista_id'] ?? '',
                'descripcion_servicio' => $_POST['descripcion_servicio'] ?? '',
                'valor' => $_POST['valor'] ?? '',
                'fecha' => $_POST['fecha'] ?? ''
            ];
            $result = $this->orcamentoModel->create($data);
            if ($result === true) {
                header('Location: ' . BASE_URL . '/presupuestos');
                exit;
            } elseif (is_string($result)) {
                $_SESSION['error'] = $result;
                header('Location: ' . BASE_URL . '/presupuestos/create');
                exit;
            } else {
                $_SESSION['error'] = "Error al crear el presupuesto.";
                header('Location: ' . BASE_URL . '/presupuestos/create');
                exit;
            }
        }
    }
    

    public function edit(int $id): void {
        $orcamento = $this->orcamentoModel->find($id);
        if ($orcamento) {
            include __DIR__ . '/../views/presupuestos/edit.php';
        } else {
            echo "Presupuesto no encontrado.";
        }
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $_POST['paciente_id'] ?? '',
                'dentista_id' => $_POST['dentista_id'] ?? '',
                'descripcion_servicio' => $_POST['descripcion_servicio'] ?? '',
                'valor' => $_POST['valor'] ?? '',
                'fecha' => $_POST['fecha'] ?? ''
            ];
            $this->orcamentoModel->update($id, $data);
            header('Location: ' . BASE_URL . '/presupuestos');
            exit;
        }
    }

    public function delete(int $id): void {
        $this->orcamentoModel->delete($id);
        header('Location: ' . BASE_URL . '/presupuestos');
        exit;
    }
}
