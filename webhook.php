<?php
    require('./app/app.class.php');
    $response   = json_decode(file_get_contents('php://input'), true);
    if($response['notificationItems'][0]['notificationRequestItem']['eventType'] == "transaction"){
        $amount     = $response['notificationItems'][0]['notificationRequestItem']['data']['amount'];
        $fee        = $response['notificationItems'][0]['notificationRequestItem']['data']['fee'];
        $reference  = $response['notificationItems'][0]['notificationRequestItem']['data']['reference'];
        if(array_key_exists('creditAccountNumber', $response['notificationItems'][0]['notificationRequestItem']['data'])){
            $creditAccountNumber  = $response['notificationItems'][0]['notificationRequestItem']['data']['creditAccountNumber'];
            $data = array(
                'category' => 'credit',
                'method' => "Virtual Account Transfer to $creditAccountNumber",
                'amount' => $amount,
                'fee' => $fee,
            );
            $wallet = $app->getWallet(['account_number', $creditAccountNumber]);
        }
        
        if(strtolower($response['notificationItems'][0]['notificationRequestItem']['data']['description'] == "invoice link payment")){
            $data = array(
                'category' => 'credit',
                'method' => "Invoice Payment to $creditAccountNumber",
                'amount' => $amount,
                'fee' => $fee,
            );
            $wallet = $app->getWallet(['account_number', $creditAccountNumber]);
        }


        // Fund Wallet
        if($wallet != "404"){
            $amount     -= $fee;
            $oldBalance = $wallet->balance;
            $newBalance = $oldBalance + $amount;

            $fund = $app->fundWallet($wallet->id, $amount, $oldBalance, $newBalance, $data, $reference);
        }
    }

?>

<!-- {
    "notificationItems": [{
        "notificationRequestItem": {
            "eventType": "transaction",
            "eventDate": "2022-11-15 14:40:22",
            "eventId": "d7d0497261e04a7e9499bbe912bc039c",
            "data": {
                "amount": "54.56",
                "mobile": "404",
                "reference": "SBT-T68519480862",
                "gatewayMessage": "Successful",
                "publicKey": "SBPUBK_ZNUONZZSC7VK9PGWG9QWNNHWLKK0INNP",
                "bankCode": "",
                "description": "Invoice link payment",
                "fee": "0.81",
                "fullname": "SHAMSUDEEN  IBRAHIM",
                "email": "omacys2@gmail.com",
                "country": "NG",
                "currency": "NGN",
                "origin": "",
                "internalRef": "",
                "creditAccountName": "SEERBIT(xPay [Hackathon])",
                "creditAccountNumber": "4028273255",
                "originatorAccountnumber": "0237223991",
                "originatorName": "SHAMSUDEEN  IBRAHIM",
                "narration": "",
                "gatewayCode": "00",
                "reason": "Successful",
                "code": "00"
            }
        }
    }]
} -->