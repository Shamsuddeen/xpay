<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>xPay</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span>Welcome,</span>
            <h2><?php echo $firstName." ".$lastName; ?></h2>
        </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="./#">Dashboard</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="users.php">View Users</a></li>
                        <li><a href="register-user.php">Register User</a></li>
                        <li><a href="fund-user.php">Fund User's Wallet</a></li>
                        <li><a href="debit-user.php">Debit User's Wallet</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-table"></i> Invoices <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="invoices.php">Invoices</a></li>
                        <li><a href="create-invoice.php">Create Invoice</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-table"></i> Transactions <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="transactions.php">View Transactions</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-money"></i> Wallet <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="wallets.php">My Wallets</a></li>
                        <li><a href="collection.php">xPay Collections</a></li>
                        <li><a href="chechout.php">xPay Checkout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings" href="profile.php">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>