<?php
    require('../app/auth.php');
    if($_POST){
        $amount     = trim($_POST['amount']);
        $walletId   = trim($_POST['wallet']);
        $wallet     = $app->getWallet(['id' => $walletId]);
?>
        <script src="https://checkout.seerbitapi.com/api/v2/seerbit.js"></script>

        <script type="text/javascript">
            function paywithSeerbit() {
                SeerbitPay(
                    {
                        //replace with your public key
                        "public_key": "SBTESTPUBK_afXR5UIYCD26aNXBFePI3dBdhaq2pAz0",
                        "tranref": new Date().getTime(),
                        "currency": "<?php echo $wallet->currency; ?>",
                        "country": "<?php echo $country; ?>",
                        "amount": "<?php echo $amount; ?>",
                        "phone_number": "<?php echo $phone; ?>",
                        "email": "<?php echo $email; ?>",
                        //optional field. Set to true to allow customer set the amount
                        "setAmountByCustomer": false,
                        "full_name": "<?php echo $firstName.' '.$lastName; ?>", //optional
                        "callbackurl": "http://localhost/xpay/seerbit.php",
                    },
                    function callback(response, closeModal) {
                        window.location="seerbit.php?wallet=<?php echo $walletId ?>&reference="+response.payments.reference
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