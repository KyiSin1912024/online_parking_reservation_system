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

$email = $invalid = "";
$email_err = "";
$validate = true;
$success = false;

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST["email"]);
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }

    if ($validate) {
        $user = get_user_by_email($mysqli, $email);
        if ($user) {
            header("Location: ../auth/reset_password.php?email=$email");
        } else {
            $invalid = "Your email doesn't exist.";
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
      		<h1 data-title="Login"><span>Forgot Password ?</span></h1>
      		<div class="page-breadcrumb">
							<a>Home</a>/ <span>Forgot Password</span>
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
        	          <h2>Forgot Password?</h2>
        	        </section>
                    <?php
                        if ($invalid) { ?> <div class="alert alert-danger"><?php echo $invalid ?> </div> <?php } ?>
                    
        	        <form class="form-horizontal ng-pristine ng-valid" method="post">
        	          <fieldset>
        	            <div class="form-group">
        	              <div class="ui-input-group">
        	                <input type="email" required class="form-control" name="email" value="<?php echo $email ?>">
        	                <span class="input-bar"></span>
        	                <label>Enter your email</label>
                            <small class="text-danger"> <?php echo $email_err ?></small>
        	              </div>
        	            </div>
        	          </fieldset>
        	            <div class="card-action no-border text-right"> <button type="submit" name="submit" class="custom-btn color-primary">Submit</> </div>
        	        </form>
        	      </div>
        	    </div>
        	    <div class="additional-info"> <a href="./login.php"><i class="fa-solid fa-arrow-left"></i> &nbsp; Back</a></div>
        	  </div>
        	</div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Login Section --> 
<?php require_once("../layout/footer.php"); ?>