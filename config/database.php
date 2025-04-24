<?php

function getDBConnection() {
    $dsn = "pgsql:host=" . getenv("DB_HOST") . 
           ";port=" . getenv("DB_PORT") . 
           ";dbname=" . getenv("DB_NAME");

    try {
        return new PDO($dsn, getenv("DB_USER"), getenv("DB_PASS"), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao conectar ao banco.']);
        exit;
    }
}
