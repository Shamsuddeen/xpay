<?php
    require('../app/auth.php');
    if($_POST){
        $amount     = trim($_POST['total']);
        $storeId    = trim($_POST['store']);
        $store      = $app->getStore(['id' => $storeId]);
?>
        <script src="https://checkout.seerbitapi.com/api/v2/seerbit.js"></script>

        <script type="text/javascript">
            function paywithSeerbit() {
                SeerbitPay(
                    {
                        //replace with your public key
                        "public_key": "SBTESTPUBK_afXR5UIYCD26aNXBFePI3dBdhaq2pAz0",
                        "tranref": new Date().getTime(),
                        "currency": "<?php echo $store->currency; ?>",
                        "country": "<?php echo $country; ?>",
                        "amount": "<?php echo $amount; ?>",
                        "phone_number": "<?php echo $phone; ?>",
                        "email": "<?php echo $email; ?>",
                        //optional field. Set to true to allow customer set the amount
                        "setAmountByCustomer": false,
                        "full_name": "<?php echo $firstName.' '.$lastName; ?>", //optional
                        "callbackurl": "http://localhost/xpay/store-checkout.php",
                    },
                    function callback(response, closeModal) {
                        window.location="store-checkout.php?store=<?php echo $storeId ?>&reference="+response.payments.reference
                        // console.log(response) //response of transaction
                    },
                    function close(close) {
                        console.log(close) //transaction close
                    }
                )
            }

            paywithSeerbit();
        </script>
<?php } ?>