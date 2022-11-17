<?php
    require('../app/auth.php');

    if ($_POST) {
        $currency   = trim($_POST['currency']);
            $wallet = $app->createWallet($userId, $currency, null);
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
