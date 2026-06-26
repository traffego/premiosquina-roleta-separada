<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../initialize.php';
require_once __DIR__ . '/../class/Connection.php';

try {
    $db = new DBConnection();
    echo "Conexão com o banco de dados bem-sucedida!\n";
    var_dump($db->conn);
} catch (Exception $e) {
    echo "Erro de conexão: " . $e->getMessage() . "\n";
}
