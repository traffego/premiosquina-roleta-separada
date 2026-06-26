<?php
require_once __DIR__ . '/../config.php';
$conn = $db->conn;
$slug = '01-sahara-ano-2024-ou-30-mil-no-pix-2';
$res = $conn->query("SELECT * FROM product_list WHERE slug = '$slug'");
if ($res && $res->num_rows > 0) {
    $prod = $res->fetch_assoc();
    foreach ($prod as $k => $v) {
        if ($k === 'description' || $k === 'cotas_premiadas_premios') {
            echo "$k: " . substr($v, 0, 100) . "... (truncated)\n";
        } else {
            echo "$k: $v\n";
        }
    }
} else {
    echo "Produto não encontrado";
}
