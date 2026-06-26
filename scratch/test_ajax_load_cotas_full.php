<?php
require_once __DIR__ . '/../config.php';
$conn = $db->conn;
$id = 135;

$prod_res = $conn->query("SELECT cotas_premiadas, cotas_premiadas_premios, quantidade_auto_cota FROM product_list WHERE id = $id");
$prod = $prod_res->fetch_assoc();

$post_data = [
    'product_id' => $id,
    'cotas_premiadas' => $prod['cotas_premiadas'],
    'cotas_array' => $prod['cotas_premiadas_premios'],
    'quantidade_auto_cota' => $prod['quantidade_auto_cota']
];

$ch = curl_init('http://localhost:8080/class/Main.php?action=load_cotas');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $http_code\n";
echo "Response Length: " . strlen($response) . " bytes\n";
echo "Response Preview: " . substr($response, 0, 1000) . "...\n";
if (strlen($response) < 1000) {
    echo "Full Response: $response\n";
}
