<?php
$date_expirate = '9999-99-99';

if ($date_expirate == date('Y-m-d')) {
?>
    <div style="width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center;flex-direction: column;">

        <h1>Pagamento não identificado!</h1>
        <div>
            <span>Entre em contato com o adminstrador do site.</span>
        </div>
    </div>

<?php

} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(1);
    if (!defined('BASE_REF')) define('BASE_REF', 'https://premiosquina.com');
    if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
    if (!defined('BASE_APP')) define('BASE_APP', str_replace('\\', '/', __DIR__) . '/');

    $is_localhost = false;
    if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost:8080')) {
        $is_localhost = true;
    } elseif (php_sapi_name() === 'cli') {
        $is_localhost = true; 
    }

    if ($is_localhost) {
        if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
        if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
        if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
        if (!defined('DB_NAME')) define('DB_NAME', 'u731203135_rfnovo');
        if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost:8080/');
        if (!defined('base_url')) define('base_url', 'http://localhost:8080/');
        if (!defined('ADMIN_URL')) define('ADMIN_URL', 'http://localhost:8080/admin/');
    } else {
        if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
        if (!defined('DB_USERNAME')) define('DB_USERNAME', 'u731203135_rfnovo');
        if (!defined('DB_PASSWORD')) define('DB_PASSWORD', 'Traffego444#');
        if (!defined('DB_NAME')) define('DB_NAME', 'u731203135_rfnovo');
        if (!defined('BASE_URL')) define('BASE_URL', 'https://premiosquina.com/');
        if (!defined('base_url')) define('base_url', 'https://premiosquina.com/');
        if (!defined('ADMIN_URL')) define('ADMIN_URL', 'https://premiosquina.com/admin/');
    }
}

?>