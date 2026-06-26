<?php
require_once __DIR__ . '/../config.php';
$conn = $db->conn;
$slug = '01-sahara-ano-2024-ou-30-mil-no-pix-2';
$res = $conn->query("SELECT id, name, cotas_premiadas, cotas_premiadas_premios, quantidade_auto_cota FROM product_list WHERE slug = '$slug'");
if ($res && $res->num_rows > 0) {
    $prod = $res->fetch_assoc();
    echo json_encode($prod, JSON_PRETTY_PRINT);
} else {
    echo "Produto não encontrado";
}
