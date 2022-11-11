<?php
    require('app/app.class.php');
    $app = new xPay;
    // require_once realpath(__DIR__ . '/vendor/autoload.php');

    // // Looing for .env at the root directory
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // $arr = array('key' => $_ENV['SEERBIT_SEC'].".".$_ENV['SEERBIT_PUB']);
    // $request = $app->sendRequest('seerbit', 'POST', '/api/v2/encrypt/keys', ['body' => json_encode($arr)], '');
    // print_r($request);
    $items = [
        [
            "itemName" => "Bluetooth Pods",
            "quantity" => 1,
            "rate" => 25000,
            "tax" => 7.5
        ],
        [
            "itemName" => "Quest 10",
            "quantity" => 4,
            "rate" => 100000,
            "tax" => 7.5
        ]
    ];
    echo $app->createInvoice('Shamsuddeen Omacy', 'omacys2@gmail.com', $items, 'NGN', 7.5, 1000, '2022-12-11'); 
    // {
    //     "status": "SUCCESS",
    //     "data": {
    //         "code": "S20",
    //         "payments": {
    //             "walletName": "SEERBIT(xPay [Hackathon])",
    //             "wallet": "4017092537",
    //             "bankName": " 9PAYMENT SERVICE BANK",
    //             "accountNumber": "4017092537",
    //             "reference": "a474cc34530d1b7c4bc63f773ba0063b"
    //         },
    //         "message": "Account created "
    //     }
    // }
