<?php
    require_once('../app/auth.php');
    if ($_POST) {
        $invoiceId  = trim($_POST['invoice']);
        $invoice    = $app->invoiceStatus($invoiceId);
        if ($invoice != "error") {
            // print_r($invoice);
?>
            <script>
                new PNotify({
                    title: 'Great!',
                    text: 'Invoice status have been updated successfully! Redirecting...',
                    type: 'success',
                    hide: false,
                    styling: 'bootstrap3'
                });

                setTimeout(function() {
                    window.location.reload();
                }, 5000); //will call the function after 5 secs.
            </script>
<?php
        }else{
?>
            <script>
                new PNotify({
                    title: 'Opps...',
                    text: 'Invoice Not Found...',
                    type: 'error',
                    hide: false,
                    styling: 'bootstrap3'
                });
            </script>
<?php
        }
    }
?>