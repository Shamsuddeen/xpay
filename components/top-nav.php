<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="profile.php" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <img src="images/img.jpg" alt=""><?php echo $firstName." ".$lastName; ?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile.php"> Profile</a>
                        <a class="dropdown-item" href="profile.php">
                            <span class="badge bg-red pull-right">50%</span>
                            <span>Settings</span>
                        </a>
                        <a class="dropdown-item" href="login.php"><i class="fa fa-sign-out pull-right"></i>
                            Log Out</a>
                    </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="badge bg-green">
                            <?php 
                                if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
                                    $cart = $_SESSION['cart'];
                                    echo count($_SESSION['cart']);
                                }else{
                                    $cart = 0;
                                    echo 0;
                                }
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        <?php 
                            if($cart != 0){
                                foreach ($cart as $key => $value) {
                                    $product = $app->getProduct(['id' => $key]);
                        ?>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span><?php echo $product->title; ?></span>
                                                <span class="time"><?php echo number_format($product->price, 2); ?></span>
                                            </span>
                                            <span class="message">
                                                <?php echo $product->title; ?>
                                            </span>
                                        </a>
                                    </li>
                        <?php } ?>
                            <li class="nav-item">
                                <div class="text-center">
                                    <a href="checkout.php" class="dropdown-item">
                                        <strong>View Cart</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>