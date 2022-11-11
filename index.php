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

    <title>Dashboard | xPay </title>
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
                <!-- top tiles -->
                <div class="row" style="display: inline-block;">
					<div class="tile_count">
						<?php 
							if ($wallets != "404") { 
								foreach($wallets as $wallet){
						?>
									<div class="col-md-4 col-sm-6 col-lg-4 tile_stats_count">
										<span class="count_top"><i class="fa fa-user"></i> <?php echo $wallet->currency; ?> Wallet</span>
										<div class="count"><?php echo $wallet->currency."".number_format($wallet->balance, 2); ?></div>
										<span class="count_bottom">Acc. No.: <?php echo $wallet->account_number; ?></span>
									</div>
                    	<?php 
								}
							} 
						?>
                    </div>
                </div>
                <!-- /top tiles -->
                <hr>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <?php include('components/footer.php'); ?>
            <!-- /footer content -->
        </div>
    </div>

    <?php include('components/scripts.php'); ?>
	<?php
		if ($wallets == "404") {
			echo "
				<script>
					new PNotify({
						title: 'Opps...',
						text: 'Please complete you account setup. Redirecting...',
						type: 'error',
						hide: false,
						styling: 'bootstrap3'
					});
					setTimeout(function () {
						window.location='./profile.php'; 
					}, 3000); //will call the function after 3 secs.
				</script>
			";
		}
	?>
</body>

</html>