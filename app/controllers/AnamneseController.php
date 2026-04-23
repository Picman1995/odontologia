<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Anamnese.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

use chillerlan\QRCode\{QRCode, QROptions};

class AnamneseController {
    private Anamnese $anamneseModel;

    public function __construct() {
        $this->anamneseModel = new Anamnese();
    }

    public function index(): void {
        $anamneses = $this->anamneseModel->getAll();
        include __DIR__ . '/../views/anamnesis/index.php';
    }

    public function create(): void {
        include __DIR__ . '/../views/anamnesis/create.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $_POST['paciente_id'] ?? '',
                'dentista_id' => $_POST['dentista_id'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'fecha' => $_POST['fecha'] ?? ''
            ];
            $this->anamneseModel->create($data);
            header('Location: '. BASE_URL .'/anamnesis');
            exit;
        }
    }

    public function edit(int $id): void {
        $anamnese = $this->anamneseModel->find($id);
        if ($anamnese) {
            include __DIR__ . '/../views/anamnesis/edit.php';
        } else {
            echo "Anamnesis no encontrada.";
        }
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $_POST['paciente_id'] ?? '',
                'dentista_id' => $_POST['dentista_id'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'fecha' => $_POST['fecha'] ?? ''
            ];
            $this->anamneseModel->update($id, $data);
            header('Location: '. BASE_URL .'/anamnesis');
            exit;
        }
    }

    public function delete(int $id): void {
        $this->anamneseModel->delete($id);
        header('Location: '. BASE_URL .'/anamnesis');
        exit;
    }

    public function relatorio($anamneseId): void {
        $paciente = $this->anamneseModel->getPacienteAllInfoById($anamneseId);
        $dentista = $this->anamneseModel->getDentistaAllInfoById($anamneseId);
        $especialidade = $this->anamneseModel->getEspecialidadeNameById($dentista['especialidad_id'] ?? 0);
        $anamnese = $this->anamneseModel->find($anamneseId);
        $ano = date("Y", strtotime($anamnese['fecha']));
        $numeroAnamnese = $this->anamneseModel->gerarNumeroAnamnese($anamneseId, $ano);
        include __DIR__ . '/../views/anamnesis/relatorio.php';
    }

    public function gerarRelatorioPDF(int $anamneseId): void {
        
        $paciente = $this->anamneseModel->getPacienteAllInfoById($anamneseId);
        $dentista = $this->anamneseModel->getDentistaAllInfoById($anamneseId);
        $especialidade = $this->anamneseModel->getEspecialidadeNameById($dentista['especialidad_id'] ?? 0);
        $anamnese = $this->anamneseModel->find($anamneseId);
        $ano = date("Y", strtotime($anamnese['fecha']));
        $numeroAnamnese = $this->anamneseModel->gerarNumeroAnamnese($anamneseId, $ano);

        $dadosParaAssinar = ($paciente['cpf'] ?? '') . ($dentista['matricula_profesional'] ?? '') . $anamnese['descripcion'] . $anamnese['fecha'];
        $assinatura = hash('sha256', $dadosParaAssinar . SECRET_KEY);   

        if (!$anamnese || !$paciente || !$dentista) {
            echo "Datos no encontrados.";
            return;
        }    

        $dadosRelatorio = [
            'anamnese' => $anamnese,
            'paciente' => $paciente,
            'dentista' => $dentista,
            'especialidade' => $especialidade
        ];

        $assinar = $this->anamneseModel->assinar($assinatura, 'Anamnese Odontológica', $dadosRelatorio);

        $data = BASE_URL .'/verificar/'. $assinatura;

        // quick and simple:
        $assinaturaQrcode = '<div style="text-align: center;"><img src="'.(new QRCode)->render($data).'" alt="QR Code" style="width:150px; height:150px;"/></div>';

        ob_start();
        include __DIR__ . '/../views/anamnesis/relatorio_pdf.php';
        $html = ob_get_clean();
    
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
    
        $options->set('isRemoteEnabled', true); // <--- habilita imagens externas

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $dompdf->stream("Anamnese_{$anamneseId}.pdf", ["Attachment" => false]);
    }

}
