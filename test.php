<?php
    require('app/app.class.php');
    $app = new xPay;
    // require_once realpath(__DIR__ . '/vendor/autoload.php');

    // // Looing for .env at the root directory
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $arr = array('key' => $_ENV['SEERBIT_SEC'].$_ENV['SEERBIT_PUB']);
    $request = $app->sendRequest('seerbit', 'POST', '/api/v2/encrypt/keys', ['body' => json_encode($arr)], '');
    print_r($request);