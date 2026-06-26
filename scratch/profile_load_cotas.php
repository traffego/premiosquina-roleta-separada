<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$start = microtime(true);
require_once __DIR__ . '/../config.php';
echo "Config carregada em " . (microtime(true) - $start) . "s\n";

$conn = $db->conn;

$id = 135; // ID do produto real

$prod_res = $conn->query("SELECT cotas_premiadas, cotas_premiadas_premios FROM product_list WHERE id = $id");
$prod = $prod_res->fetch_assoc();
$cotas_premiadas = $prod['cotas_premiadas'];

$cotas_premiadas_array = explode(',', $cotas_premiadas);
echo "Total de cotas premiadas: " . count($cotas_premiadas_array) . "\n";

$cotas_vendidas = [];
$step_start = microtime(true);
$count = 0;

foreach ($cotas_premiadas_array as $num) {
    if (empty($num)) {
        continue;
    }
    $count++;
    
    // Consulta FIND_IN_SET
    $stmt = $conn->prepare('SELECT customer_id FROM order_list WHERE FIND_IN_SET(?, order_numbers) AND product_id = ? AND status = 2 ');
    $stmt->bind_param('si', $num, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $cotas_vendidas[] = ['cota' => $num, 'winner' => $row['customer_id']];
    }
    $stmt->close();
    
    if ($count % 50 == 0) {
        echo "Processadas $count cotas em " . (microtime(true) - $step_start) . "s\n";
        $step_start = microtime(true);
    }
}

echo "Busca de cotas concluída em " . (microtime(true) - $start) . "s. Encontradas " . count($cotas_vendidas) . " vendidas.\n";
