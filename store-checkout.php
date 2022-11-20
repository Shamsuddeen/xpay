<?php 
    require('./app/auth.php');
    if(isset($_GET['store'])){
        $storeId    = trim($_GET['store']);
        $store      = $app->getStore(['id' => $storeId]); // Get Store
        $ownerId    = $store->owner; // Get Store Owner
        // $->i   = trim($_GET['wallet']);
        $reference  = trim($_GET['reference']);

        $url        = "api/v2/payments/query/$reference";
        $request    = $app->sendRequest('seerbit', 'GET', $url, [], '');
        $request    = json_decode($request, true);
        if(strtolower($request['status']) == "success" && $request['data']['code'] == "00"){
            if($app->getTransaction(['reference' => $reference]) == "404"){
                // print_r($request); 
                $amount = $request['data']['payments']['amount'];
                $fee    = $request['data']['payments']['fee'];
                $amount -= $fee;
    
                $wallet = $app->getWallet(['user' => $ownerId, 'currency' => $store->currency]);
                if($wallet != "404"){
                    $oldBalance = $wallet->balance;
                    $newBalance = $oldBalance + $amount;
                    $data = array(
                        'category' => 'credit',
                        'method' => $request['data']['payments']['paymentType'],
                        'amount' => $request['data']['payments']['amount'],
                        'fee' => $request['data']['payments']['fee'],
                    );
                    $fund = $app->fundWallet($wallet->id, $amount, $oldBalance, $newBalance, $data, $reference);
                    if($fund == "success"){
                        $_SESSION['cart'] = [];
                        header("Location: ./");
                    }
                }
            }
        }
    }else{
        $_SESSION['cart'] = [];
        header("Location: ./");
    }
?>