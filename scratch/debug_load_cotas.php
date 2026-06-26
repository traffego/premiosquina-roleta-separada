<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_POST['product_id'] = 11; // Vamos usar o ID do produto
$_POST['cotas_premiadas'] = '432709,019083,553110';
$_POST['cotas_array'] = '432709:R$50:premiada,019083:R$50:premiada,553110:R$50:premiada';
$_POST['quantidade_auto_cota'] = '0';

require_once __DIR__ . '/../initialize.php';
require_once __DIR__ . '/../classes/SystemSettings.php'; // Se for necessário instanciar a SystemSettings
require_once __DIR__ . '/../class/Main.php';

try {
    echo "Instanciando Main...\n";
    $main = new Main();
    echo "Main instanciado com sucesso.\n";
    
    echo "Chamando load_cotas()...\n";
    $res = $main->load_cotas();
    echo "load_cotas executado.\n";
    echo "Resultado:\n";
    echo $res;
    echo "\nFIM\n";
} catch (Throwable $e) {
    echo "Exceção capturada: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
