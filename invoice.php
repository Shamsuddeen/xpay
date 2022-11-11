<?php 
    require('app/auth.php');
    if(isset($_GET['id'])){
        $invoiceId  = trim($_GET['id']);
        $invoice    = $app->getInvoice(['id' => $invoiceId]);
        if($invoice == "404"){
            header("Location: ./invoices.php");
        }
    } else{
        header("Location: ./invoices.php");
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

    <title>Invoices | xPay </title>
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
                            <h3>Invoices</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Invoices</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <section class="content invoice">
                                        <!-- title row -->
                                        <div class="row">
                                            <div class="invoice-header">
                                                <h1>
                                                    <i class="fa fa-globe"></i>xPay Invoice.
                                                </h1>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- info row -->
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                From
                                                <address>
                                                    <strong>Iron Admin, Inc.</strong>
                                                    <br>795 Freedom Ave, Suite 600
                                                    <br>Zing, TR 661103
                                                    <br>Phone: 234 (0) 701 234 5678
                                                    <br>Email: xpay.com
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                To
                                                <address>
                                                    <strong><?php echo $invoice->receiver_name; ?></strong>
                                                    <br>795 Freedom Ave, Suite 600
                                                    <br>Zing, TR 661103
                                                    <br>Phone: 234 (0) 701 234 5678
                                                    <br>Email: <?php echo $invoice->receiver_email; ?>
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                <b>Invoice #000<?php echo $invoice->id; ?></b>
                                                <br>
                                                <br>
                                                <b>Order ID:</b> <?php echo $invoice->order_number; ?>
                                                <br>
                                                <b>Payment Due:</b> <?php echo $invoice->due_date; ?>
                                                <br>
                                                <b>Account:</b> 968-34567
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="  table">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Qty</th>
                                                            <th>Product</th>
                                                            <th>Rate</th>
                                                            <th>Tax</th>
                                                            <th style="width: 59%">Description</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $items = json_decode($invoice->items, true);
                                                            foreach($items as $item){ 
                                                                $amount = $item['rate']*$item['quantity'];
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $item['quantity']; ?></td>
                                                                <td><?php echo $item['itemName']; ?></td>
                                                                <td><?php echo $item['rate']; ?></td>
                                                                <td><?php echo $item['tax']; ?></td>
                                                                <td>
                                                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magnam blanditiis consequuntur consequatur aliquid fugit quos quas numquam sapiente architecto esse, fugiat mollitia odit, voluptatem quo quae incidunt aliquam, repudiandae temporibus!
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        echo ($amount) + (($item['tax']/100) * $amount); 
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="row">
                                            <!-- accepted payments column -->
                                            <div class="col-md-6">
                                                <p class="lead">Payment Methods:</p>
                                                <img src="images/visa.png" alt="Visa">
                                                <img src="images/mastercard.png" alt="Mastercard">
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-6">
                                                <p class="lead">Amount Due <?php echo $invoice->due_date; ?></p>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th>Total:</th>
                                                                <td><?php echo $invoice->currency." ".number_format($invoice->total, 2); ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- this row will not appear when printing -->
                                        <div class="row no-print">
                                            <div class=" ">
                                                <button class="btn btn-default" onclick="window.print();"><i
                                                        class="fa fa-print"></i>
                                                    Print</button>
                                                <button class="btn btn-success pull-right"><i
                                                        class="fa fa-credit-card"></i> Submit
                                                    Payment</button>
                                                <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i
                                                        class="fa fa-download"></i> Generate PDF</button>
                                            </div>
                                        </div>
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
</body>

</html>