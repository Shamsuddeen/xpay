<?php
	session_start();
	if(isset($_GET) & !empty($_GET)){
		$id = $_GET['product'];
		if(isset($_GET['quantity']) & !empty($_GET['quantity'])){ 
            $quantity = $_GET['quantity']; 
        }else{ 
            $quantity = 1;
        }
		$_SESSION['cart'][$id] = array(
            "quantity" => $quantity
        );
?>
        <script>
            new PNotify({
                title: 'Great!',
                text: 'Item has been added to cart! Continue shopping...',
                type: 'success',
                hide: false,
                styling: 'bootstrap3'
            });
            setTimeout(function() {
                window.location.reload();
            }, 3000); //will call the function after 5 secs.
        </script>
<?php
	}else{
		header('location: checkout.php');
	}
	// echo "<pre>";
	// print_r($_SESSION['cart']);
	// echo "</pre>";
?>