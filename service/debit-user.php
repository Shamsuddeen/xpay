<?php
    require('../app/auth.php');
    if($_POST){
        $debitUserId    = trim($_POST['user']);
        $amount         = trim($_POST['amount']);
        $walletId       = trim($_POST['wallet']);
        $otp            = trim($_POST['otp']);
        if($otp == "123456"){
            $debitUser      = $app->getUser(['id' => $debitUserId]);
            $creditUser     = $app->getUser(['id' => $userId]);
            if($debitUser != "404"){
                $debitWallet = $app->getWallet(['user' => $debitUserId]);
                if($debitWallet != "404"){
                    $oldBalance = $debitWallet->balance;
                    $newBalance = $oldBalance - $amount;
                    if($oldBalance >= $amount){
                        $data = array(
                            'category' => 'debit',
                            'method' => "Withdrawal by $creditUser->first_name $creditUser->last_name",
                            'amount' => $amount,
                            'fee' => 0
                        );

                        $debit = $app->debitWallet($debitWallet->id, $amount, $oldBalance, $newBalance, $data, null);
                        if($debit == 'success'){
                            $creditWallet   = $app->getWallet(['id' => $walletId]);
                            $oldBalance     = $creditWallet->balance;
                            $newBalance     = $oldBalance + $amount;
            
                            $data = array(
                                'category' => 'credit',
                                'method' => "Withdrawal from $debitUser->first_name $debitUser->last_name",
                                'amount' => $amount,
                                'fee' => 0
                            );
                            $fund = $app->fundWallet($creditWallet->id, $amount, $oldBalance, $newBalance, $data, null);
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
        }else{
?>
            <script>
                new PNotify({
                    title: 'Oppps!',
                    text: 'Invalid OTP! Please try again...',
                    type: 'erorr',
                    hide: true,
                    styling: 'bootstrap3'
                });
            </script>
<?php
        }
    }
?>