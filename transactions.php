<?php 
    require('app/auth.php');
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

    <title>Transactions | xPay </title>
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
                            <h3>Transactions</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Transactions</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <section class="content invoice">
                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="card-box table-responsive">
                                                <table id="datatable-buttons" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
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
                                                                foreach($transactions as $transaction){ 
                                                        ?>
                                                                    <tr>
                                                                        <td><?php echo $transaction->reference; ?></td>
                                                                        <td><?php echo $transaction->type; ?></td>
                                                                        <td><?php echo number_format($transaction->amount, 2); ?></td>
                                                                        <td><?php print_r($transaction->data); ?></td>
                                                                        <td><?php echo date('jS, m Y', strtotime($transaction->trxn_date)); ?></td>
                                                                        <td><?php echo number_format($transaction->balance_before, 2); ?></td>
                                                                        <td><?php echo number_format($transaction->balance_after, 2); ?></td>
                                                                    </tr>
                                                        <?php
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