<?php 
    require('app/auth.php');
    if(isset($_GET['id'])){
        $storeId    = trim($_GET['id']); 
        $store      = $app->getStore(['id' => $storeId]);
    }else{
        header("Location: ./");
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

    <title><?php echo $store->name; ?> | xPay </title>
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
                            <h3><?php echo $store->name; ?></h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Products</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row">
                                    <?php 
                                        $products = $app->getProducts(['store' => $storeId]); 
                                        if($products != "404"){
                                            foreach ($products as $product) {
                                    ?>
                                                <div class="col-md-55">
                                                    <div class="thumbnail">
                                                        <div class="image view view-first">
                                                            <img style="width: 100%; display: block;" src="images/media.jpg" alt="image" />
                                                            <div class="mask">
                                                                <p><?php echo $product->title; ?></p>
                                                                <div class="tools tools-bottom">
                                                                    <a href="#"><i class="fa fa-link"></i></a>
                                                                    <a href="#" onclick="addToCart('<?php echo $product->id; ?>')"><i class="fa fa-shopping-cart"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="caption">
                                                            <p><?php echo $product->title; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    ?>
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
        function addToCart(product){
            $.ajax({
                type: 'get',
                url: 'service/add-to-cart.php',
                data: {
                    product: product
                },
                success: function (msg) {
                    $('#info').html(msg);
                }
            });
        }

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