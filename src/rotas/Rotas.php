<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require BASE_PATH . '/src/rotas/RotasGET.php';
require BASE_PATH . '/src/rotas/RotasPOST.php';
require BASE_PATH . '/src/rotas/RotasPATCH.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET' && $method !== 'POST' && $method !== 'PATCH') {
    echo json_encode([
        "message" => "rota apontada nao configurada ate o momento"
    ]);
    exit;
}
