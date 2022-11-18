<?php
    require('../app/auth.php');
    if($_POST){
        $phone      = trim($_POST['phone']);
        $receiver   = $app->getUser(['phone' => $phone]);

        if($receiver != "404"){
?>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Amount</label>
                    <div class="input-group">
                        <div class="input-group-addon"><?php echo $receiver->currency; ?></div>
                        <input type="tel" class="form-control" name="amount" placeholder="Amount">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" name="accountName" readonly="readonly" class="form-control" value="<?php echo $receiver->first_name.' '.$receiver->last_name; ?>" >
                    </div>
                </div>
                <input type="hidden" name="user" value="<?php echo $receiver->id; ?>">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="wallet">Wallet</label>
                        <select name="wallet" id="wallet" class="form-control">
                            <option selected disabled>SELECT WALLET</option>
                            <?php
                                $wallets = $app->getWallets(['user' => $userId, 'currency' => $receiver->currency]);
                                if($wallets != "404"){
                                    foreach ($wallets as $wallet) {
                            ?>
                                        <option value="<?php echo $wallet->id; ?>"><?php echo $wallet->currency." Wallet (".number_format($wallet->balance, 2).")"; ?></option>
                            <?php 
                                    } 
                                }
                            ?>
                        </select>

                        <?php
                            // print_r($wallets);
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Fund User</button>
                </div>
            </div>
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