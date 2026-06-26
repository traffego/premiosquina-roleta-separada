<?php
require_once __DIR__ . '/../config.php';
$conn = $db->conn;
$id = 135;

$prod_res = $conn->query("SELECT cotas_premiadas FROM product_list WHERE id = $id");
$prod = $prod_res->fetch_assoc();
$cotas_premiadas = explode(',', $prod['cotas_premiadas']);

$sold = [];
foreach ($cotas_premiadas as $cota) {
    if (empty($cota)) continue;
    $res = $conn->query("SELECT order_numbers, customer_id FROM order_list WHERE FIND_IN_SET('$cota', order_numbers) AND product_id = $id AND status = 2");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $sold[] = ['cota' => $cota, 'customer_id' => $row['customer_id']];
    }
}

echo "Total de cotas premiadas vendidas encontradas: " . count($sold) . "\n";
print_r($sold);
