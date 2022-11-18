<?php
    // require('app/app.class.php');
    // $app = new xPay;
    // require_once realpath(__DIR__ . '/vendor/autoload.php');

    // // // Looing for .env at the root directory
    // $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    // $dotenv->load();
    // $arr = array('key' => $_ENV['SEERBIT_SEC'].".".$_ENV['SEERBIT_PUB']);
    // $request = $app->sendRequest('seerbit', 'POST', '/api/v2/encrypt/keys', ['body' => json_encode($arr)], '');
    // print_r($request);
    // // $items = [
    // //     [
    // //         "itemName" => "Bluetooth Pods",
    // //         "quantity" => 1,
    // //         "rate" => 25000,
    // //         "tax" => 7.5
    // //     ],
    // //     [
    // //         "itemName" => "Quest 10",
    // //         "quantity" => 4,
    // //         "rate" => 100000,
    // //         "tax" => 7.5
    // //     ]
    // // ];
    // // echo $app->createInvoice(1, 'Shamsuddeen Omacy', 'omacys2@gmail.com', $items, 'NGN', 1000, '2022-12-11'); 
    // // {
    // //     "status": "SUCCESS",
    // //     "data": {
    // //         "code": "S20",
    // //         "payments": {
    // //             "walletName": "SEERBIT(xPay [Hackathon])",
    // //             "wallet": "4017092537",
    // //             "bankName": " 9PAYMENT SERVICE BANK",
    // //             "accountNumber": "4017092537",
    // //             "reference": "a474cc34530d1b7c4bc63f773ba0063b"
    // //         },
    // //         "message": "Account created "
    // //     }
    // // }

    // print_r($_ENV);
?>
<html>

<head>
    <title>SeerBit Simple Checkout</title>
    <script src="https://checkout.seerbitapi.com/api/v2/seerbit.js"></script>
</head>

<body>
    <button onlick="paywithSeerbit()">Pay Now</button>

    <script type="text/javascript">
        function paywithSeerbit() {
            SeerbitPay({
                    //replace with your public key
                    "public_key": "SBPUBK_ZNUONZZSC7VK9PGWG9QWNNHWLKK0INNP",
                    "tranref": new Date().getTime(),
                    "currency": "NGN",
                    "country": "NG",
                    "amount": "150.00",
                    "email": "test@emaildomain.com",
                    //optional field. Set to true to allow customer set the amount
                    "setAmountByCustomer": false,
                    "full_name": "John Doe", //optional
                    "callbackurl": "http://yourdomain.com",
                },
                function callback(response, closeModal) {
                    console.log(response) //response of transaction
                },
                function close(close) {
                    console.log(close) //transaction close
                })
        }

        paywithSeerbit();
    </script>

</body>

</html>