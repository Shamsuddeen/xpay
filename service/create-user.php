<?php
    require_once('../app/auth.php');
    $app    = new xPay;
    if ($_POST) {
        $firstName  = trim($_POST['first_name']);
        $lastName   = trim($_POST['last_name']);
        $phone      = trim($_POST['phone']);
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
            if($app->registerUser($firstName, $lastName, $phone, $country, $currency, null, $password, $uuid, 'user', $userId) != "error"){
?>
                <script>
                    new PNotify({
                        title: 'Great!',
                        text: 'User account have been created successfully!',
                        type: 'success',
                        hide: false,
                        styling: 'bootstrap3'
                    });

                    setTimeout(function () {
                        window.location="users.php"; 
                    }, 3000); //will call the function after 3 secs.
                </script>
<?php  
            }
        }
    }
?>