<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = ltrim($uri, '/');

// Se o arquivo físico existir (e não for um diretório), serve diretamente
if ($uri && file_exists(__DIR__ . '/' . $uri) && !is_dir(__DIR__ . '/' . $uri)) {
    return false;
}

// Simular regras de Rewrite do .htaccess
if ($uri === 'cadastrar') {
    $_GET['p'] = 'pages/register';
} elseif ($uri === 'meus-numeros') {
    $_GET['p'] = 'pages/my-numbers';
} elseif ($uri === 'ganhadores') {
    $_GET['p'] = 'pages/winners';
} elseif ($uri === 'contato') {
    $_GET['p'] = 'pages/contact';
} elseif ($uri === 'termos-de-uso') {
    $_GET['p'] = 'pages/terms';
} elseif ($uri === 'campanhas') {
    $_GET['p'] = 'pages/campaign';
} elseif ($uri === 'concluidas') {
    $_GET['p'] = 'pages/campaign-finished';
} elseif ($uri === 'em-breve') {
    $_GET['p'] = 'pages/campaign-soon';
} elseif ($uri === 'recuperar-senha') {
    $_GET['p'] = 'pages/recover-password';
} elseif ($uri === 'logout') {
    $_GET['f'] = 'logout_customer';
    include __DIR__ . '/classes/Login.php';
    exit;
} elseif (preg_match('#^campanha/(.+)$#', $uri, $matches)) {
    $_GET['p'] = 'pages/products/view_product';
    $_GET['id'] = $matches[1];
} elseif (preg_match('#^compra/(.+)$#', $uri, $matches)) {
    $_GET['p'] = 'pages/orders/view_order';
    $_GET['id'] = $matches[1];
} elseif ($uri === 'user/compras') {
    $_GET['p'] = 'pages/orders';
} elseif ($uri === 'user/alterar-senha') {
    $_GET['p'] = 'pages/change-password';
} elseif ($uri === 'user/atualizar-cadastro') {
    $_GET['p'] = 'pages/update-registration';
} elseif ($uri === 'user/afiliado') {
    $_GET['p'] = 'pages/affiliate';
}

include __DIR__ . '/index.php';
