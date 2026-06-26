<?php
$_POST['product_id'] = 11; // Vamos usar o ID do produto
$_POST['cotas_premiadas'] = '432709,019083,553110';
$_POST['cotas_array'] = '432709:R$50:premiada,019083:R$50:premiada,553110:R$50:premiada';
$_POST['quantidade_auto_cota'] = '0';

// Configurar o settings e conexao
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../class/Main.php';

$main = new Main();
echo $main->load_cotas();
