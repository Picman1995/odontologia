<?php

require_once __DIR__ . '/../models/Receita.php';
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../models/Dentista.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

use chillerlan\QRCode\{QRCode, QROptions};

class ReceitaController {
    private Receita $receitaModel;
    private Paciente $pacienteModel;
    private Dentista $dentistaModel;

    public function __construct() {
        $this->receitaModel = new Receita();
        $this->pacienteModel = new Paciente();
        $this->dentistaModel = new Dentista();
    }

    public function index(): void {
        $receitas = $this->receitaModel->getAll();
        require __DIR__ . '/../views/recetas/index.php';
    }

    public function create(): void {
        $pacientes = $this->pacienteModel->getAll();
        $dentistas = $this->dentistaModel->getAll();
        require __DIR__ . '/../views/recetas/create.php';
    }

    public function store(): void {
        $data = [
            'paciente_id' => $_POST['paciente_id'] ?? '',
            'dentista_id' => $_POST['dentista_id'] ?? '',
            'fecha' => $_POST['fecha'] ?? $_POST['data'] ?? '',
            'contenido' => $_POST['contenido'] ?? $_POST['conteudo'] ?? ''
        ];
        $this->receitaModel->create($data);
        header('Location: ' . BASE_URL . '/recetas');
    }

    public function edit(int $id): void {
        $receita = $this->receitaModel->find($id);
        $pacientes = $this->pacienteModel->getAll();
        $dentistas = $this->dentistaModel->getAll();
        require __DIR__ . '/../views/recetas/edit.php';
    }

    public function update(int $id): void {
        $data = [
            'paciente_id' => $_POST['paciente_id'] ?? '',
            'dentista_id' => $_POST['dentista_id'] ?? '',
            'fecha' => $_POST['fecha'] ?? $_POST['data'] ?? '',
            'contenido' => $_POST['contenido'] ?? $_POST['conteudo'] ?? ''
        ];
        $this->receitaModel->update($id, $data);
        header('Location: ' . BASE_URL . '/recetas');
    }

    public function delete(int $id): void {
        $this->receitaModel->delete($id);
        header('Location: ' . BASE_URL . '/recetas');
    }

    public function relatorio(int $id): void {
        $receita = $this->receitaModel->find($id);
        $paciente = $this->pacienteModel->find($receita['paciente_id']);
        $dentista = $this->dentistaModel->find($receita['dentista_id']);
        require __DIR__ . '/../views/recetas/relatorio.php';
    }

    public function gerarRelatorioPDF(int $id): void {
        $receita = $this->receitaModel->find($id);
        $paciente = $this->pacienteModel->find($receita['paciente_id']);
        $dentista = $this->dentistaModel->find($receita['dentista_id']);
        $especialidade = $this->dentistaModel->getEspecialidadeNameById((int)($dentista['especialidad_id'] ?? 0));
    
        $dadosParaAssinar = ($paciente['cpf'] ?? '') . $dentista['cro'] . $receita['id_receta'] . $receita['contenido'];
        $assinatura = hash('sha256', $dadosParaAssinar . SECRET_KEY);       

        if (!$receita || !$paciente || !$dentista) {
            echo "Dados não encontrados.";
            return;
        }    

        $dadosRelatorio = [
            'receita' => $receita,
            'paciente' => $paciente,
            'dentista' => $dentista,
            'especialidade' => $especialidade
        ];

        $assinar = $this->receitaModel->assinar($assinatura, 'Receituário', $dadosRelatorio);

        $meses = [
            1 => 'janeiro', 2 => 'fevereiro', 3 => 'março',
            4 => 'abril',   5 => 'maio',      6 => 'junho',
            7 => 'julho',   8 => 'agosto',    9 => 'setembro',
            10 => 'outubro',11 => 'novembro',12 => 'dezembro'
        ];

        $data = new DateTime($receita['fecha'] ?? 'now');
        $dia   = $data->format('d');
        $mes   = (int)$data->format('m');
        $ano   = $data->format('Y');      
        
        $link = BASE_URL .'/verificar/'. $assinatura;

        // quick and simple:
        $assinaturaQrcode = '<div style="text-align: center;"><img src="'.(new QRCode)->render($link).'" alt="QR Code" style="width:150px; height:150px;"/></div>';

        ob_start();
        include __DIR__ . '/../views/recetas/relatorio_pdf.php';
        $html = ob_get_clean();
    
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
    
        $options->set('isRemoteEnabled', true); // <--- habilita imagens externas

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $dompdf->stream("Receita_{$id}.pdf", ["Attachment" => false]);
    }

}
