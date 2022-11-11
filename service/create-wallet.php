<?php
    require('../app/auth.php');

    if ($_POST) {
        $currency   = trim($_POST['currency']);
        $user       = $app->getUser(['id' => $userId]);
        $key        = rand(001, 999).rand(001, 999).rand(001, 999).rand(1, 9);
        $key        = md5($key.$user->uuid);
        $url        = "/api/v2/virtual-accounts";
        $data       = array(
            "publicKey" => $_ENV['SEERBIT_PUB'],
            "fullName" => $user->first_name." ".$user->last_name,
            "bankVerificationNumber" => "",
            "currency" => $currency,
            "country" => $country,
            "reference" => $key,
            "email" => $user->email
        );
        $request    = $app->sendRequest('seerbit', 'POST', $url, ['body' => json_encode($data)], "");
        $request    = json_decode($request, true);
        if(strtolower($request['status']) == "success"){
            $wallet = $app->createWallet(
                $userId, 
                $key, 
                $request['data']['payments']['accountNumber'], 
                $request['data']['payments']['bankName'], 
                $currency, null
            );

            if($wallet == "success"){
?>
                <script>
                    new PNotify({
                        title: 'Great!',
                        text: 'Wallet created successfully! Redirecting...',
                        type: 'success',
                        hide: false,
                        styling: 'bootstrap3'
                    });

                    setTimeout(function() {
                        window.location = "./index.php";
                    }, 5000); //will call the function after 5 secs.
                </script>
<?php
            }
        }
    }
