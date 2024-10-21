<?php
require_once("../storage/db.php");
require_once("../storage/user_db.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
    if ($user['is_admin']) {
        header("Location:../admin/index.php");
    } else {
        header("Location:../user/index.php");
    }
}

$u_name = $email = $phone = $password = $con_password = $agree = "";
$u_name_err = $email_err = $phone_err = $password_err = $con_password_err = $agree_err = "";
$validate = true;
$success = false;
$invalid = false;

if (isset($_POST['signup'])) {
    $u_name = htmlspecialchars($_POST["u_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $password = htmlspecialchars($_POST["password"]);
    $con_password = htmlspecialchars($_POST["con_password"]);
    if(isset($_POST["agree"])) $agree = htmlspecialchars($_POST["agree"]);
    if ($u_name === "") {
        $validate = false;
        $u_name_err = "Name must not be blank!";
    }
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }
    if ($phone === "") {
        $validate = false;
        $phone_err = "Phone No must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }

    if ($con_password === "") {
        $validate = false;
        $con_password_err = "Password must not be blank!";
    }

    if ($password !==  $con_password) {
        $validate = false;
        $con_password_err = "Confirm password must be match with password!";
    }

    if(!$agree) {
        $validate = false;
        $agree_err = "Agree terms and policy?";
    }

    $db_user = get_user_by_email($mysqli,$email);
    if($db_user) {
        $validate = false;
        $email_err = "This email is already existed.";
    }

    if ($validate) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $status = save_user($mysqli, $u_name, $email, $phone, $password_hash);
        if ($status) {
            $success = true;
        } else {
            $invalid = true;
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
      		<h1 data-title="Register"><span>Register</span></h1>
      		<div class="page-breadcrumb">
							<a>Home</a>/ <span>Register</span>
						</div>
      		
      	</div>
        
      </div>
    </div>
  </section>
 <!-- Intro Section End-->
 
  <!-- Register Section -->
  <div id="login" class="ptb ptb-xs-40 page-signin">
    <div class="container">
      <div class="row">
      	<div class="col-sm-12">
        <div class="main-body">
          <div class="body-inner">
            <div class="card bg-white">
              <div class="card-content">
                <section class="logo text-center">
                  <h2>Register</h2>
                </section>
                <?php
                    if ($success) echo '<div class="alert alert-success" role="alert">User Registeration Done!</div>';
                    if ($invalid) echo '<div class="alert alert-danger" role="alert">Invalid Registeration!</div>';
                ?>
                <form class="form-horizontal ng-pristine ng-valid" method="post">
                  <fieldset>
                    <div class="form-group">
                      <div class="ui-input-group">
                        <input type="text" required class="form-control" name="u_name">
                        <span class="input-bar"></span>
                        <label>Your username</label>
                        <small class="text-danger"> <?php echo $u_name_err ?></small>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="ui-input-group">
                        <input type="email" required  class="form-control" name="email">
                        <span class="input-bar"></span>
                        <label>Your email</label>
                        <small class="text-danger"> <?php echo $email_err ?></small>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="ui-input-group">
                        <input type="text" required  class="form-control" name="phone">
                        <span class="input-bar"></span>
                        <label>Your phone</label>
                        <small class="text-danger"> <?php echo $phone_err ?></small>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="ui-input-group">
                        <input type="password"  required class="form-control" name="password">
                        <span class="input-bar"></span>
                        <label>Your password </label>
                        <small class="text-danger"> <?php echo $password_err ?></small>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="ui-input-group">
                        <input type="password" required  class="form-control" name="con_password">
                        <span class="input-bar"></span>
                        <label>Please confirm your password </label>
                        <small class="text-danger"> <?php echo $con_password_err ?></small>
                      </div>
                    </div>
                    <div class="spacer"></div>
                    <div class="form-group checkbox-field">
                      <label for="check_box" class="text-small">
                        <input type="checkbox" id="check_box" name="agree" value="1">
                        <span class="ion-ios-checkmark-empty22 custom-check"></span> By clicking on sign up, you agree to <a href="javascript:;"><i>terms</i></a> and <a href="javascript:;"><i>privacy policy</i></a></label>
                        <small class="text-danger"> <?php echo $agree_err ?></small>
                    </div>
                  </fieldset>
                  <div class="card-action no-border text-right"> <a href="./login.php">Login</a><button type="submit" name="signup" class="custom-btn color-primary">Sign Up</button> </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
  <!-- End Register Section --> 
<?php require_once("../layout/footer.php"); ?>