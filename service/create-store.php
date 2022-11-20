<?php
    require_once('../app/auth.php');
    $app    = new xPay;
    if ($_POST) {
        $name       = trim($_POST['name']);
        $address    = trim($_POST['address']);
        $phone      = trim($_POST['phone']);
        $email      = trim($_POST['email']);
        $country    = trim($_POST['country']);
        $currency   = trim($_POST['currency']);
        $uuid       = str_replace('+', '', $phone);
        $password   = $uuid;
        $error      = [];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error[] = "Invalid email address";
        }

        // Check if Phone number is registered
        if($app->getUser(['phone' => $phone]) != "404"){
            $error[] = "Phone number already exists.";
        }

        if(count($error) > 0){
            foreach ($error as $err) {
?>
                <script>
                    new PNotify({
                        title: 'Opps...',
                        text: '<?php echo $err; ?>',
                        type: 'error',
                        hide: false,
                        styling: 'bootstrap3'
                    });
                </script>
<?php
            }
        }else{
            if($app->createStore($name, $phone, $email, $address, $country, $currency, $userId) != "error"){
?>
                <script>
                    new PNotify({
                        title: 'Great!',
                        text: 'Store has been created successfully!',
                        type: 'success',
                        hide: false,
                        styling: 'bootstrap3'
                    });

                    setTimeout(function () {
                        window.location="stores.php"; 
                    }, 3000); //will call the function after 3 secs.
                </script>
<?php  
            }
        }
    }
?>