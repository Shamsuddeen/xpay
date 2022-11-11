<?php
    require('../app/auth.php');

    if ($_POST) {
        $name       = trim($_POST['name']);
        $email      = trim($_POST['email']);
        $dueDate    = trim($_POST['date']);
        $currency   = trim($_POST['currency']);
        $total      = 0;
        $amount     = 0;
        $items      = [];
        foreach ($_POST['itemName'] as $key => $value) {
            $amount += ($_POST['itemRate'][$key] * $_POST['itemQuantity'][$key]);
            $tax    = ($_POST['itemTax'][$key]/100) * $amount;
            $total  = $amount + $tax;
            $items[] = array(
                "itemName" => $_POST['itemName'][$key],
                "quantity" => $_POST['itemQuantity'][$key],
                "rate" => $_POST['itemRate'][$key],
                "tax" => $_POST['itemTax'][$key]
            );
        }

        // print_r($items);
        // echo $total;

        $invoice = $app->createInvoice($name, $email, $items, $currency, $total, $dueDate);

            if($invoice == "success"){
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
                    }, 5000); //will call the function after 5 secs.
                </script>
<?php
            }
    }
