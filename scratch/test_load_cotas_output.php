<?php
$_POST['product_id'] = 135;
$_POST['cotas_premiadas'] = '0432709,0019083,0553110';
$_POST['cotas_array'] = '0432709:R$50:premiada,0019083:R$50:premiada,0553110:R$50:premiada';
$_POST['quantidade_auto_cota'] = '0';

// Simular settings e conexao
require_once __DIR__ . '/../config.php';
$conn = $db->conn;

// Emular a funcao load_cotas diretamente do Main.php sem instanciar para evitar include path issues
$id = $_POST['product_id'];
$prod = $conn->query("SELECT roleta, box FROM product_list WHERE id = $id ");
$produto = $prod->fetch_assoc();

$cotas_premiadas = $_POST['cotas_premiadas'];
$cotas_vendidas = [];
$cotas_array = $_POST['cotas_array'];
$quantidade_auto_cota = $_POST['quantidade_auto_cota'];
$deserialized = [];
$pairs = explode(',', $cotas_array);

foreach ($pairs as $pair) {
    $first_split = explode(':', $pair, 2);
    $key = $first_split[0];
    $rest = $first_split[1];

    $last_colon_pos = strrpos($rest, ':');
    $value = substr($rest, 0, $last_colon_pos);
    $tipo = substr($rest, $last_colon_pos + 1);

    $deserialized[$key] = "$value";
    $deserialized[$key . '_tipo'] = $tipo;
}

$cotas_array = $deserialized;

$cotas_premiadas_array = explode(',', $cotas_premiadas);
foreach ($cotas_premiadas_array as $num) {
    if (empty($num)) {
        continue;
    }

    $stmt = $conn->prepare('SELECT customer_id FROM order_list WHERE FIND_IN_SET(?, order_numbers) AND product_id = ? AND status = 2 ');
    $stmt->bind_param('si', $num, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $cotas_vendidas[] = ['cota' => $num, 'winner' => $row['customer_id']];
    }
}

$all_lucky_numbers = array_column($cotas_vendidas, 'cota');
$cotas_premiadas_all = $cotas_premiadas_array;
$cotas_premiadas_sold = array_intersect($all_lucky_numbers, $cotas_premiadas_all);

$cotas_premiadas_available = array_diff($cotas_premiadas_all, $cotas_premiadas_sold);
// Note que $min_cotas_purchased nao esta definida. Vamos ver se emite warning.
if (isset($min_cotas_purchased) && $min_cotas_purchased > 0) {
    $cotas_premiadas_available = $cotas_premiadas_all;
    $cotas_premiadas_sold = [];
}
ob_start();

$btnTheme = "btn-warning";
if ($cotas_premiadas_sold) {
    foreach ($cotas_premiadas_sold as $cota) {
        $prize = isset($cotas_array[$cota]) ? $cotas_array[$cota] : '';
        $tipo = isset($cotas_array[$cota . '_tipo']) ? ucfirst($cotas_array[$cota . '_tipo']) : '';

        $winner = $cotas_vendidas[array_search($cota, $all_lucky_numbers)]['winner'];
        $customer = $conn->query("SELECT * FROM customer_list WHERE id = $winner")->fetch_assoc();
        $customer_name = $customer['firstname'];

        if ($cota != '') {
            if ($produto['roleta'] || $produto['box']) {
                echo '<div class="rounded p-1 w-100 d-flex justify-content-center align-items-center">';
                echo '    <div class="numero rounded-pill d-flex justify-content-center align-items-center btn text-start ' . $btnTheme . ' btn-sm p-0 text-nowrap font-xss">';
                echo '        <span class="px-2" style="min-width: 150px">🚀 ' . $cota . ' vale ' . $prize . '</span>';
                echo '       <span class="d-flex justify-content-start align-items-center valor rounded-pill py-0 px-2  btn btn-warning" style="min-width: 130px"><i class="bi bi-circle-fill me-3" style="font-size: 5px;"></i>' . $customer_name . ' 🏆</span>';
                echo '    </div>';
                echo '</div>';
            } else {
                echo '<div class="rounded p-1 w-100 d-flex justify-content-center align-items-center">';
                echo '    <div class="numero rounded-pill d-flex justify-content-center align-items-center btn text-start ' . $btnTheme . ' btn-sm p-0 text-nowrap font-xss">';
                echo '        <span class="px-2" style="min-width: 150px">🚀 ' . $cota . ' vale ' . $prize . '</span>';
                echo '       <span class="d-flex justify-content-start align-items-center valor rounded-pill py-0 px-2  btn btn-warning" style="min-width: 130px"><i class="bi bi-circle-fill me-3" style="font-size: 5px;"></i>' . $customer_name . ' 🏆</span>';
                echo '    </div>';
                echo '</div>';
            }
        }
    }
}
$output = ob_get_clean();
echo "OUTPUT:\n";
echo $output;
echo "\nFIM\n";
