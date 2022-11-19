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

    <title>Fund User | xPay </title>
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
                            <h3>Fund User</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Fund User</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <section class="content invoice">
                                        <!-- info row -->
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-lg-12 tile_stats_count">
                                                <form id="verify" method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="phone">User Phone Number</label>
                                                                <input type="tel" name="phone" class="form-control" id="phone" placeholder="+2347012345678">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="amount">Amount</label>
                                                                <input type="tel" name="amount" class="form-control" id="phone" placeholder="+2347012345678">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-rounded btn-block" type="submit">Verify User</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="account" method="post"></form>
                                            </div>
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
            $('#verify').on('submit', function (e) {
                $.ajax({
                    type: 'post',
                    url: 'service/verify-user.php',
                    data: $(this).serialize(),
                    success: function (msg) {
                        $('#account').html(msg);
                    }
                });
                e.preventDefault();
            });

            // Submit Form
            $('#account').on('submit', function (e) {
                $.ajax({
                    type: 'post',
                    url: 'service/debit-user.php',
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