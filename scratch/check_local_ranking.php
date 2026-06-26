<?php
require_once __DIR__ . '/../config.php';
$conn = $db->conn;
$id = 135;
$ranking_qty = 6;

$requests = $conn->query("SELECT c.firstname, SUM(o.quantity) AS total_quantity FROM order_list o INNER JOIN customer_list c ON o.customer_id = c.id WHERE o.product_id = $id AND o.status = 2 GROUP BY o.customer_id ORDER BY total_quantity DESC LIMIT $ranking_qty");

if ($requests) {
    echo "Total de linhas no ranking local: " . $requests->num_rows . "\n";
    while ($row = $requests->fetch_assoc()) {
        echo "Cliente: " . $row['firstname'] . " - Quantidade: " . $row['total_quantity'] . "\n";
    }
} else {
    echo "Erro na query do ranking: " . $conn->error . "\n";
}
