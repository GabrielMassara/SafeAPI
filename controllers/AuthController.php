<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/jwt.php';

class AuthController {
    public function login() {
        session_start();
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $payload = [
                "iat" => time(),
                "exp" => time() + 3600,
                "id" => $user['id'],
                "email" => $user['email']
            ];
            $token = jwt_encode($payload, 'chave_secreta');

            // Salvar dados do usuário na sessão
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

            echo json_encode([
                'token' => $token,
                'session' => $_SESSION['user']
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciais inválidas']);
        }
    }
}
