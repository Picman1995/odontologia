<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Verificar.php';

class VerificarController {
    private verificar $verificarModel;

    public function __construct() {
        $this->verificarModel = new Verificar();
    }

    public function verificar($token): void {
        $tokenStatus = $this->verificarModel->verificarToken($token);
        if ($tokenStatus) {
            $tokenId = $tokenStatus['id'];
            $tokenHash = $tokenStatus['token'];
            $tokenTipo = $tokenStatus['tipo_relatorio'];
            $tokenDados = $tokenStatus['dados_relatorio'];
            $tokenData = isset($tokenStatus['criado_em']) ? date('d/m/Y H:i', strtotime($tokenStatus['criado_em'])) : '';
        }
        include __DIR__ . '/../views/verificar/index.php';
    }

}
