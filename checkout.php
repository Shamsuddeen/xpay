<?php require('app/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Checkout | xPay </title>
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
                            <h3>Checkout</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Checkout</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form action="" method="POST" role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="wallet">Pay With</label>
                                                    <?php 
                                                        if($wallets != "404"){
                                                    ?>
                                                            <select name="wallet" id="wallet" class="form-control" required="required">
                                                                <?php 
                                                                    foreach ($wallets as $wallet) {
                                                                        echo "<option value='$wallet->id'>$wallet->currency Wallet (".number_format($wallet->balance, 2).")</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <!-- Table row -->
                                                <div class="row">
                                                    <div class="  table">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Product</th>
                                                                    <th>Rate</th>
                                                                    <th>Qty</th>
                                                                    <th>Tax</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    $i = 1;
                                                                    $total = 0;
                                                                    // print_r($cart);
                                                                    foreach($cart as $item => $value){ 
                                                                        $product = $app->getProduct(['id' => $item]);
                                                                        $amount = $product->price;
                                                                        $subTotal = ($amount) + (($product->tax/100) * $amount);
                                                                        $total    += $subTotal;
                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo $i; ?></td>
                                                                            <td><?php echo $product->title; ?></td>
                                                                            <td><?php echo number_format($product->price, 2); ?></td>
                                                                            <td>1</td>
                                                                            <td><?php echo $product->tax; ?></td>
                                                                            <td>
                                                                                <?php 
                                                                                    echo number_format($subTotal, 2); 
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                <?php
                                                                    $i++;
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                                                        <input type="hidden" name="store" value="<?php echo $product->store; ?>">
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Pay <?php echo number_format($total, 2); ?></button>
                                    </form>

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
    <script src="https://checkout.seerbitapi.com/api/v2/seerbit.js"></script>
    <script>
        $(document).ready(function () {
            // Submit Form
            $('form').on('submit', function (e) {
                $.ajax({
                    type: 'post',
                    url: 'service/checkout.php',
                    data: $(this).serialize(),
                    success: function (msg) {
                        $('#info').html(msg);
                    }
                });
                e.preventDefault();
            });
        });

        var loading = $.loading();

        $(document).ajaxStart(function () {
            $(this).find(':input').attr('readonly', 'readonly');
            $(this).find(':button').attr('disabled', 'disabled');
        });

        $(document).ajaxComplete(function () {
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