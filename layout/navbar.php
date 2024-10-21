<!-- header Start -->
<header id="header" class="header">

<div class="nav-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    <a href="../user/index.php" style="font-size: larger; margin-top: 11px;">Parking Lots</a>
                </div>
                <!-- Phone Menu button -->
                <button id="menu" class="menu hidden-md-up"></button>
            </div>
            <div class="col-md-9 nav-bg d-flex align-items-center">
                <nav class="navigation">
                    <ul>
                        <li>
                            <a href="../user/index.php">Home</a><i class="ion-ios-plus-empty hidden-md-up"></i>
                        </li>

                        <li>
                            <a href="#about_us">About us</a><i class="ion-ios-plus-empty hidden-md-up"></i>                            
                        </li>
                        <li>
                            <a href="javascript:avoid(0);">services</a><i class="ion-ios-plus-empty hidden-md-up"></i>
                            <ul class="sub-nav">
                                <li>
                                    <a href="#spaces">Parking Spaces</a>
                                </li>
                                <li>
                                    <a href="#appointment">Get an appointment</a>
                                </li>
                            </ul>
                        </li>                     
                        <li>
                            <a href="#contact_us">Contact Us</a><i class="ion-ios-plus-empty hidden-md-up"></i>
                        </li>
                        <li>
                            <a href="javascript:avoid(0);"><?php if(isset($user)) echo $user['name']; else echo "My Account"; ?></a><i class="ion-ios-plus-empty hidden-md-up"></i>
                            <ul class="sub-nav">
                            <?php if(isset($user)) { ?>
                                <li>
                                    <a href="../profile/profile.php">My Profile</a>
                                </li>
                                <li>
                                    <a href="../auth/logout.php?logout=logout">Logout</a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a href="../auth/login.php">Login</a>
                                </li>
                                <li>
                                    <a href="../auth/signup.php">New Member? <i>Register</i></a>
                                </li>
                            <?php } ?>
                            </ul>
                        </li>

                    </ul>

                </nav>
            </div>
        </div>
    </div>
</div>
</header>
<!--Header End-->