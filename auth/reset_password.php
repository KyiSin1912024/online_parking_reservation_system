<?php
require_once("../storage/user_db.php");
require_once("../storage/db.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
    if ($user['is_admin']) {
        header("Location:../admin/index.php");
    } else {
        header("Location:../user/index.php");
    }
}

$email = $con_password = $password = $invalid = "";
$con_password_err = $password_err = "";
$validate = true;
$success = false;
if (isset($_GET["email"])) $email = $_GET["email"];
if (isset($_POST['reset'])) {
    $con_password = htmlspecialchars($_POST["con_password"]);
    $password = htmlspecialchars($_POST["password"]);
    if ($con_password === "") {
        $validate = false;
        $con_password_err = "Confirm Password must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }
    if ($validate) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $match = password_verify($con_password, $password_hash);
        if ($match) {
            $result = update_user_password_by_email($mysqli, $email, $password_hash);
            if ($result) {
                $success = true;
            } else {
                $invalid = "Something went wrong! Failed to change password.";
            }
        } else {
            $invalid = "Confirm password doesn't match with password.";
        }
    }
}
require_once("../layout/header.php");
?>
<!-- Intro Section -->
<section class="inner-intro bg-img light-color overlay-before parallax-background">
    <div class="container">
        <div class="row title">
            <div class="title_row">
                <h1 data-title="Login"><span>Reset Password</span></h1>
                <div class="page-breadcrumb">
                    <a>Home</a>/ <span>Reset Password</span>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Intro Section End-->

<!-- Login Section -->
<div id="login" class="ptb ptb-xs-40 page-signin">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-body">
                    <div class="body-inner">
                        <div class="card bg-white">
                            <div class="card-content">
                                <section class="logo text-center">
                                    <h2>Reset Password</h2>
                                </section>
                                <?php
                                if ($success) echo '<div class="alert alert-success">Passwrod Reset is Successful!</div>';
                                if ($invalid) { ?> <div class="alert alert-danger"><?php echo $invalid ?> </div> <?php } ?>

                                <form class="form-horizontal ng-pristine ng-valid" method="post">
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="ui-input-group">
                                                <input type="password" required class="form-control" name="password">
                                                <span class="input-bar"></span>
                                                <label>New Password</label>
                                                <small class="text-danger"> <?php echo $password_err ?></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="ui-input-group">
                                                <input type="password" required class="form-control" name="con_password">
                                                <span class="input-bar"></span>
                                                <label>Confirm New Password</label>
                                                <small class="text-danger"> <?php echo $con_password_err ?></small>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="card-action no-border text-right"> <button type="submit" name="reset" class="custom-btn color-primary">Reset</>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="additional-info"> <a href="./forgot_password.php"><i class="fa-solid fa-arrow-left"></i> Back</a><span class="divider-h"></span><a href="./login.php">Login</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Login Section -->
<?php require_once("../layout/footer.php"); ?>