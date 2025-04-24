<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    public function index() {
        $userModel = new User();
        $users = $userModel->getAll();
        echo json_encode($users);
    }

    public function show($id) {
        $userModel = new User();
        $user = $userModel->getById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado.']);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios: name, email, password']);
            return;
        }
        $userModel = new User();
        echo json_encode($userModel->create($data['name'], $data['email'], $data['password']));
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['name']) || !isset($data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes.']);
            return;
        }
        $userModel = new User();
        echo json_encode($userModel->update($id, $data['name'], $data['email']));
    }

    public function delete($id) {
        $userModel = new User();
        if ($userModel->delete($id)) {
            echo json_encode(['message' => 'Usuário excluído com sucesso.']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado.']);
        }
    }
}
