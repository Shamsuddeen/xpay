<?php
    require('../app/auth.php');
    if ($_POST) {
        $storeId    = trim($_POST['store']);
        $store      = $app->getStore(['id' => $storeId]);
        if($store != "404"){
            $total      = 0;
            $amount     = 0;
            $items      = [];
            foreach ($_POST['itemName'] as $key => $value) {
                $title      = $_POST['itemName'][$key];
                $price      = trim($_POST['itemRate'][$key]);
                $quantity   = trim($_POST['itemQuantity'][$key]);
                $tax        = $_POST['itemTax'][$key];
                // $items[] = array(
                //     "itemName" => $_POST['itemName'][$key],
                //     "quantity" => $_POST['itemQuantity'][$key],
                //     "rate" => $_POST['itemRate'][$key],
                //     "tax" => $_POST['itemTax'][$key]
                // );
                $product = $app->addProduct($title, "Testing...", $price, $tax, $quantity, $store->id);
            }

        // print_r($items);
        // echo $total;

            if($product == "success"){
?>
                <script>
                    new PNotify({
                        title: 'Great!',
                        text: 'Product has been created successfully! Redirecting...',
                        type: 'success',
                        hide: false,
                        styling: 'bootstrap3'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000); //will call the function after 5 secs.
                </script>
<?php
            }else{
?>
                <script>
                    new PNotify({
                        title: 'Opps...',
                        text: 'Product cannot be created! Please try again...',
                        type: 'error',
                        hide: false,
                        styling: 'bootstrap3'
                    });
                </script>
<?php
            }
        }else{
?>
            <script>
                new PNotify({
                    title: 'Opps...',
                    text: 'Product cannot be created! Please try again...',
                    type: 'error',
                    hide: false,
                    styling: 'bootstrap3'
                });
            </script>
<?php
        }
    }
