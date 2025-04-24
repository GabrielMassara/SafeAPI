<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/MeController.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$method = $_SERVER['REQUEST_METHOD'];

if ($uri[0] === 'api' && $uri[1] === 'login' && $method === 'POST') {
    $auth = new AuthController();
    $auth->login();
    return;
}

if ($uri[0] === 'api' && $uri[1] === 'me' && $method === 'GET') {
    $controller = new MeController();
    $controller->show();
    return;
}

if ($uri[0] === 'api' && $uri[1] === 'users') {
    $controller = new UserController();
    $id = $uri[2] ?? null;

    if ($method === 'POST' && !$id) {
        $controller->store(); // permite cadastro sem token
        return;
    }

    verificarToken(); // protege o restante

    switch ($method) {
        case 'GET':
            $id ? $controller->show($id) : $controller->index();
            break;
        case 'PUT':
            $id ? $controller->update($id) : http_response_code(400);
            break;
        case 'DELETE':
            $id ? $controller->delete($id) : http_response_code(400);
            break;
        default:
            http_response_code(405);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Rota não encontrada.']);
}
