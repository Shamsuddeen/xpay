<?php
    require('../app/auth.php');

    if ($_POST) {
        if(isset($_POST['user']) && isset($_POST['currency'])){
            $userId     = trim($_POST['user']);
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
                        window.location.reload();
                    }, 2000); //will call the function after 2 secs.
                </script>
<?php
            }
        }else{
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
                    }, 3000); //will call the function after 3 secs.
                </script>
<?php
            }
        }
    }
