<?php 
    require('./app/auth.php');
    if(isset($_GET)){
        $walletId   = trim($_GET['wallet']);
        $reference  = trim($_GET['reference']);
    }
    $url        = "api/v2/payments/query/$reference";
    $request    = $app->sendRequest('seerbit', 'GET', $url, [], '');
    $request    = json_decode($request, true);
    if(strtolower($request['status']) == "success" && $request['data']['code'] == "00"){
        if($app->getTransaction(['reference' => $reference]) == "404"){
            // print_r($request); 
            $amount = $request['data']['payments']['amount'];
            $fee    = $request['data']['payments']['fee'];
            $amount -= $fee;

            $wallet = $app->getWallet(['id' => $walletId]);
            if($wallet != "404"){
                $oldBalance = $wallet->balance;
                $newBalance = $oldBalance + $amount;
                $data = array(
                    'category' => 'credit',
                    'method' => $request['data']['payments']['paymentType'],
                    'amount' => $request['data']['payments']['amount'],
                    'fee' => $request['data']['payments']['fee'],
                );
                $fund = $app->fundWallet($walletId, $amount, $oldBalance, $newBalance, $data, $reference);
                if($fund == "success"){
                    header("Location: ./");
                }
            }
        }
    }
?>

<!-- {
    "code": "00",
    "message": "Successful",
    "payments": {
        "redirectLink": "https://checkout.seerbitapi.com/#/",
        "amount": 207.6,
        "fee": "7.60",
        "mobilenumber": "404",
        "publicKey": "SBTESTPUBK_afXR5UIYCD26aNXBFePI3dBdhaq2pAz0",
        "paymentType": "CARD",
        "productId": "",
        "maskedPan": "5123-45xx-xxxx-0008",
        "gatewayMessage": "Successful",
        "gatewayCode": "00",
        "gatewayref": "SEERQOTUE6V7C4TELEM",
        "businessName": "xPay [Hackathon]",
        "mode": "test",
        "callbackurl": "http://yourdomain.com",
        "redirecturl": "https://checkout.seerbitapi.com/#/",
        "channelType": "MASTERCARD",
        "sourceIP": "105.112.126.27",
        "deviceType": "Desktop",
        "cardBin": "512345",
        "lastFourDigits": "0008",
        "country": "NG",
        "currency": "NGN",
        "paymentReference": "1668734753261",
        "reason": "Successful",
        "transactionProcessedTime": "2022-11-18 02:26:44.717",
        "linkingreference": "SEERQOTUE6V7C4TELEM",
        "reference": "1668734753261"
    },
    "customers": {
        "customerName": "Shamsuddeen Omacy",
        "customerMobile": "404",
        "customerEmail": "omacy@mail.ng",
        "fee": "7.60"
    }
} -->