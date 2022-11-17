<?php
    require_once('../app/app.class.php');
    $app    = new xPay;
    if ($_POST) {
        $firstName  = trim($_POST['first_name']);
        $lastName   = trim($_POST['last_name']);
        $phone      = trim($_POST['phone']);
        $email      = trim($_POST['email']);
        $password   = $_POST['password'];
        $uuid       = str_replace('+', '', $phone);
        $error      = [];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error[] = "Invalid email address";
        }

        // Check if Phone number is registered
        if($app->getUser(['phone' => $phone]) != "404"){
            $error[] = "Phone number already exists.";
        }

        // Check if Email is registered
        if($app->getUser(['email' => $email]) != "404"){
            $error[] = "Email address have been registered";
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
            if($app->registerUser($firstName, $lastName, $phone, $country = "NG", $currency = "NGN", $email, $password, $uuid, 'user', null) != "error"){
?>
                <script>
                    new PNotify({
                        title: 'Great!',
                        text: 'Your account have been created successfully! Head on and Login...',
                        type: 'success',
                        hide: false,
                        styling: 'bootstrap3'
                    });

                    setTimeout(function () {
                        window.location="./login.php"; 
                    }, 2000); //will call the function after 2 secs.
                </script>
<?php  
            }
        }
    }
?>