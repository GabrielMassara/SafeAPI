<?php
class LogoutController {
    public function logout() {
        session_start();
        session_destroy();
        echo json_encode(['message' => 'Sessão encerrada com sucesso.']);
    }
}
