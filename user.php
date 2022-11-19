<?php 
    require('app/auth.php');
    if(isset($_GET['id'])){
        $userId     = trim($_GET['id']);
        $user    = $app->getUser(['id' => $userId]);
        if($user == "404"){
            header("Location: ./users.php");
        }
    } else{
        header("Location: ./users.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>User | xPay </title>
    <?php include('components/meta.php'); ?>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('components/side-nav.php'); ?>
            </div>

            <!-- top navigation -->
            <?php include('components/top-nav.php'); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div id="info"></div>
                    <div class="page-title">
                        <div class="title_left">
                            <h3>User</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>User</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <section class="content invoice">
                                        <!-- title row -->
                                        <div class="row">
                                            <div class="invoice-header">
                                                <h1>
                                                    <i class="fa fa-globe"></i><?php ?>
                                                </h1>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- info row -->
                                        <div class="row invoice-info">
                                            <div class="col-sm-5 invoice-col">
                                                Name: <?php echo $user->first_name." ".$user->last_name; ?> <br>
                                                Phone: <?php echo $user->phone; ?> <br>
                                                Country: <?php echo $user->country; ?> <br>
                                                Default Currency: <?php echo $user->currency; ?>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-7 invoice-col">
                                                <div class="row">
                                                    <div class="tile_count">
                                                        <?php 
                                                            $userWallet = $app->getWallet(['user' => $userId]);
                                                            if ($userWallet != "404") { 
                                                        ?>
                                                                <div class="col-md-12 col-sm-12 col-lg-12 tile_stats_count">
                                                                    <span class="count_top"><i class="fa fa-user"></i> <?php echo $userWallet->currency; ?> Wallet</span>
                                                                    <div class="count"><?php echo $userWallet->currency."".number_format($userWallet->balance, 2); ?></div>
                                                                    <span class="count_bottom">Acc. No.: <?php echo $userWallet->account_number; ?></span>
                                                                </div>
                                                        <?php 
                                                            }else{
                                                        ?>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="user" value="<?php echo $user->id; ?>">
                                                                    <input type="hidden" name="currency" value="<?php echo $user->currency; ?>">
                                                                    <button class="btn btn-primary btn-rounded btn-block" type="submit">Create Wallet for User</button>
                                                                </form>
                                                        <?php
                                                            } 
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.row -->

                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="card-box table-responsive">
                                                <table id="datatable-buttons" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Reference</th>
                                                            <th>Type</th>
                                                            <th>Amount</th>
                                                            <th>Data</th>
                                                            <th>Date</th>
                                                            <th>Balance Before</th>
                                                            <th>Nalance After</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $transactions   = $app->getTransactions(['user' => $userId]);
                                                            if($transactions != "404"){
                                                                $i = 1;
                                                                foreach($transactions as $transaction){ 
                                                        ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $transaction->reference; ?></td>
                                                                        <td><?php echo $transaction->type; ?></td>
                                                                        <td><?php echo number_format($transaction->amount, 2); ?></td>
                                                                        <td><?php print_r($transaction->data); ?></td>
                                                                        <td><?php echo date('jS, m Y @ G:i', strtotime($transaction->trxn_date)); ?></td>
                                                                        <td><?php echo number_format($transaction->balance_before, 2); ?></td>
                                                                        <td><?php echo number_format($transaction->balance_after, 2); ?></td>
                                                                    </tr>
                                                        <?php
                                                                $i++;
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <?php include('components/footer.php'); ?>
            <!-- /footer content -->
        </div>
    </div>

    <?php include('components/scripts.php'); ?>
    <script>
        $(document).ready(function () {
            // Submit Form
            $('form').on('submit', function (e) {
                $.ajax({
                    type: 'post',
                    url: 'service/create-wallet.php',
                    data: $(this).serialize(),
                    success: function (msg) {
                        $('#info').html(msg);
                    }
                });
                e.preventDefault();
            });
        });
        var loading = $.loading();

        $(document).ajaxStart(function(){
            $(this).find(':input').attr('readonly', 'readonly');
            $(this).find(':button').attr('disabled', 'disabled');
        });

        $(document).ajaxComplete(function(){
            $(this).find(':input').removeAttr('readonly');
            $(this).find(':button').removeAttr('disabled');
        });


        function openLoading(time) {
            loading.open(time);
        }

        function closeLoading() {
            loading.close();
        }

    </script>
</body>

</html>