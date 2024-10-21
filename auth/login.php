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

$email = $password = $invalid = "";
$email_err = $password_err = "";
$validate = true;
$success = false;

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }

    if ($validate) {
        $user = get_user_by_email($mysqli, $email);
        if ($user) {
        $match = password_verify($password, $user['password']);
        if ($match) {
            $success = true;
            setcookie("user", json_encode($user), time() + 3600 * 24 * 7, '/');
            if ($user['is_admin']) {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ./signup.php");
            }
        } else {
            $invalid = "Password doesn't match.";
        }} else {
            $invalid = "This user doesn't exist.";
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
      		<h1 data-title="Login"><span>Login</span></h1>
      		<div class="page-breadcrumb">
							<a>Home</a>/ <span>Login</span>
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
        	          <h2>Login</h2>
        	        </section>
                    <?php
                        if ($success) echo '<div class="alert alert-success">Login Successful!</div>';
                        if ($invalid) { ?> <div class="alert alert-danger"><?php echo $invalid ?> </div> <?php } ?>
                    
        	        <form class="form-horizontal ng-pristine ng-valid" method="post">
        	          <fieldset>
        	            <div class="form-group">
        	              <div class="ui-input-group">
        	                <input type="email" required class="form-control" name="email">
        	                <span class="input-bar"></span>
        	                <label>Email</label>
                            <small class="text-danger"> <?php echo $email_err ?></small>
        	              </div>
        	            </div>
        	            <div class="form-group">
        	              <div class="ui-input-group">
        	                <input type="password" required class="form-control" name="password">
        	                <span class="input-bar"></span>
        	                <label>Password</label>
                            <small class="text-danger"> <?php echo $password_err ?></small>
        	              </div>
        	            </div>
        	          </fieldset>
        	            <div class="card-action no-border text-right"> <button type="submit" name="login" class="custom-btn color-primary">Sign in</> </div>
        	        </form>
        	      </div>
        	    </div>
        	    <div class="additional-info"> <a href="./signup.php">Register</a><span class="divider-h"></span><a href="./forgot_password.php">Forgot your password?</a> </div>
        	  </div>
        	</div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Login Section --> 
<?php require_once("../layout/footer.php"); ?>