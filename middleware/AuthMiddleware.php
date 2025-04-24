<?php
require_once __DIR__ . '/../utils/jwt.php';

function verificarToken() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Token ausente']);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $payload = jwt_decode($token, 'chave_secreta');

    if (!$payload) {
        http_response_code(401);
        echo json_encode(['error' => 'Token inválido ou expirado']);
        exit;
    }

    return $payload;
}
