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

    <title>Add Product | xPay </title>
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
                            <h3>Add Product</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Add Product</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form action="" method="POST" role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="store">Store</label>
                                                    <select name="store" id="store" class="form-control" required="required" >
                                                        <?php
                                                            $stores = $app->getStores(['owner' => $userId]);
                                                            if($stores != "404"){
                                                                foreach ($stores as $store) {
                                                                    echo "<option value='$store->id'>$store->name</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="primaryField">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Item Name</label>
                                                        <input type="text" name="itemName[]" placeholder="Item Name"
                                                            class="form-control" required="required"
                                                            title="Item Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Quantity</label>
                                                        <input type="number" name="itemQuantity[]"
                                                            placeholder="Quantity" class="form-control"
                                                            required="required" title="Item Quantity">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="number" name="itemRate[]" placeholder="Rate"
                                                            class="form-control" required="required"
                                                            title="Item Amount per Each">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Tax</label>
                                                        <input type="text" name="itemTax[]" placeholder="Tax"
                                                            class="form-control" required="required"
                                                            placeholder="7.5">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Action</label>
                                                    <button class="btn btn-icon btn-rounded btn-primary" id="addMore" type="button"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="addtionalField">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Add Product</button>
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
    <script>
        var inputs_field = `
        <div class="singleOne">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="itemName[]" placeholder="Item Name"
                            class="form-control" required="required"
                            title="Item Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" name="itemQuantity[]"
                            placeholder="Quantity" class="form-control"
                            required="required" title="Item Quantity">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" name="itemRate[]" placeholder="Rate"
                            class="form-control" required="required"
                            title="Item Amount per Each">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" name="itemTax[]" placeholder="Tax"
                            class="form-control" required="required"
                            placeholder="7.5">
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-icon btn-rounded btn-danger removeOne" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>`;
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var x = 1; //initlal text box count
            $('#addMore').on('click', function(e){ //on add input button click
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $('.addtionalField').append(inputs_field); //add input box
                }
                e.preventDefault();
            });

            $('.addtionalField').on("click", ".removeOne", function(e){ //user click on remove text
                e.preventDefault(); $(this).parents('.singleOne').remove(); x--;
            })
        });
        $(document).ready(function () {
            // Submit Form
            $('form').on('submit', function (e) {
                $.ajax({
                    type: 'post',
                    url: 'service/create-product.php',
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