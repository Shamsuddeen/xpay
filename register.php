<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Create Account | xPay</title>

	<!-- Bootstrap -->
	<link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="assets/vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="assets/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<div id="info"></div>
					<form>
						<h1>Create Account</h1>
						<div>
							<label for="first_name">First Name</label>
							<input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" required="" />
						</div>
						<div>
							<label for="last_name">Last Name</label>
							<input type="text" class="form-control" placeholder="last name" id="last_name" name="last_name" required="" />
						</div>
						<div>
							<label for="email">Email</label>
							<input type="email" class="form-control" placeholder="Email" id="email" name="email" required="" />
						</div>
						<div>
							<label for="phone">Phone Number</label>
							<input type="tel" class="form-control" placeholder="phone" id="phone" name="phone" required="" />
						</div>
						<div>
							<label for="password">Password</label>
							<input type="password" class="form-control" placeholder="Password" name="password" id="password" required="" />
						</div>
						<div>
							<button class="btn btn-primary" type="submit">Create Account</button>
						</div>

						<div class="clearfix"></div>

						<div class="separator">
							<p class="change_link">Already a member ?
								<a href="./login.php" class="to_register"> Log in </a>
							</p>

							<div class="clearfix"></div>
							<br />

							<div>
								<h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
								<p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 4 template. Privacy and
									Terms</p>
							</div>
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
	<!-- jQuery -->
	<script src="assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- PNotify -->
    <script src="assets/vendors/pnotify/dist/pnotify.js"></script>
    <script src="assets/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="assets/vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <script src="./assets/js/ajax-loading.js"></script>
    <script>
        $(document).ready(function () {
            // Submit Form
            $('form').on('submit', function (e) {
                $.ajax({
                    type: 'post',
                    url: 'service/register.php',
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