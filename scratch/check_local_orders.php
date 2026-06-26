<?php
require_once __DIR__ . '/../config.php';
$conn = $db->conn;
$id = 135;

$res = $conn->query("SELECT COUNT(*) as total FROM order_list WHERE product_id = $id AND status = 2");
$row = $res->fetch_assoc();
echo "Total de pedidos pagos localmente para o produto $id: " . $row['total'] . "\n";

// Listar os primeiros 10 numeros de cotas vendidas
$res2 = $conn->query("SELECT order_numbers, customer_id FROM order_list WHERE product_id = $id AND status = 2 LIMIT 10");
while ($row2 = $res2->fetch_assoc()) {
    echo "Customer: " . $row2['customer_id'] . " - Cotas: " . $row2['order_numbers'] . "\n";
}
