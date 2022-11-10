<?php
    session_start();
    require_once('../app/app.class.php');
    $app    = new xPay;
    if ($_POST) {
        $phone      = trim($_POST['phone']);
        $password   = $_POST['password'];
        $error      = [];

        // if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //     $error[] = "Invalid email address";
        // }

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
            $login = $app->loginUser($phone, $password);
            if($login != "error"){
                $_SESSION['user']       = $login->id;
                $_SESSION['email']      = $login->email;
                $_SESSION['phone']      = $login->phone;
                $_SESSION['uuid']       = $login->uuid;
?>
                <script>
                    new PNotify({
                        title: 'Great!',
                        text: 'You are logged in successfully! Redirecting...',
                        type: 'success',
                        hide: false,
                        styling: 'bootstrap3'
                    });

                    setTimeout(function () {
                        window.location="./index.php"; 
                    }, 5000); //will call the function after 3 secs.
                </script>
<?php  
            }
        }
    }
?>