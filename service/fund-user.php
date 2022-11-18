<?php
    require('../app/auth.php');
    if($_POST){
        $receiverId = trim($_POST['user']);
        $amount     = trim($_POST['amount']);
        $walletId   = trim($_POST['wallet']);
        
        $receiver   = $app->getUser(['id' => $receiverId]);

        if($receiver != "404"){
            $senderWallet = $app->getWallet(['id' => $walletId]);
            if($senderWallet != "404"){
                $oldBalance = $senderWallet->balance;
                $newBalance = $oldBalance - $amount;
                if($oldBalance >= $amount){
                    $data = array(
                        'category' => 'debit',
                        'method' => "Transfer to $receiver->first_name $receiver->last_name",
                        'amount' => $amount,
                        'fee' => 0
                    );

                    $debit = $app->debitWallet($walletId, $amount, $oldBalance, $newBalance, $data, null);
                    if($debit == 'success'){
                        $receiverWallet     = $app->getWallet(['user' => $receiverId]);
                        $oldBalance = $receiverWallet->balance;
                        $newBalance = $oldBalance + $amount;
        
                        $data = array(
                            'category' => 'credit',
                            'method' => "Transfer from $firstName $lastName",
                            'amount' => $amount,
                            'fee' => 0
                        );
                        $fund = $app->fundWallet($receiverWallet->id, $amount, $oldBalance, $newBalance, $data, null);
                        if($fund == "success"){
?>
                            <script>
                                new PNotify({
                                    title: 'Great!',
                                    text: 'User wallet has been funded successfully!',
                                    type: 'success',
                                    hide: true,
                                    styling: 'bootstrap3'
                                });

                                setTimeout(function () {
                                    window.location.reload(); 
                                }, 3000); //will call the function after 3 secs.
                            </script>
<?php
                        }
                    }
                }else{
?>
                    <script>
                        new PNotify({
                            title: 'Great!',
                            text: 'You don\'t have sufficient funds to per this transaction! Please try again...',
                            type: 'erorr',
                            hide: true,
                            styling: 'bootstrap3'
                        });
                    </script>
<?php
                }
            }
?>

<?php
        }else{
?>
            <script>
                new PNotify({
                    title: 'Great!',
                    text: 'User not found! Please try again...',
                    type: 'erorr',
                    hide: true,
                    styling: 'bootstrap3'
                });
            </script>
<?php
        }
    }
?>