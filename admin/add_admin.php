<?php 
require_once("../storage/db.php");
require_once("../storage/user_db.php");
$name = $email = $phone = $image = "";
$name_err = $email_err = $phone_err = $image_err = $invalid_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    // $image = $_POST["image"];
    if($name == "") {
        $validate = false;
        $name_err = "Name must not be blank.";
    } 
    if($email === "") {
        $validate = false;
        $email_err = "Email must not be blank.";
    }
    $db_user = get_user_by_email($mysqli,$email);
    if($db_user) {
        $validate = false;
        $email_err = "This email is already existed.";
    }
    if($phone === "") {
        $validate = false;
        $phone_err = "Phone Number must not be blank.";
    }
    if($_FILES['image']['name'] === "") {
        $validate = false;
        $image_err = "Photo must not be blank.";
    }
    $img = $_FILES["image"]["tmp_name"];
    $image = $_FILES["image"]["name"];
    if($validate) {
        $password_hash = password_hash('password', PASSWORD_DEFAULT);
        $result = save_admin($mysqli, $name, $email, $phone, $password_hash, $image);
        if($result) {
            try {
                move_uploaded_file($img, "../upload/" . $image);
                $success = true;
                $name = $email = $phone = "";
            } catch (\Throwable $th) {
                $invalid_err = "Image upload error!";
                $invalid = true;
            }
            
        } else {
            $invalid = true;
            $invalid_err = "Admin Registeration Fail!";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-5">
      <h1>Admin Registeration</h1>
</div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post" enctype="multipart/form-data">
                    <?php
                        if ($success) echo '<div class="alert alert-primary" style="font-size:14px;">Admin Registeration Successful!</div>';
                        if ($invalid) echo '<div class="alert alert-danger">$invalid_err</div>';
                    ?>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
                            <small class="text-danger"><?php echo $name_err ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Email</label>
                        </div>
                        <div class="col mb-3">
                            <input type="email" name="email" class="form-control" value="<?php echo $email ?>">
                            <small class="text-danger"><?php echo $email_err ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Phone</label>
                        </div>
                        <div class="col mb-3">
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone ?>">
                            <small class="text-danger"><?php echo $phone_err ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Upload Photo</label>
                        </div>
                        <div class="col mb-3">
                            <input type="file" name="image" class="form-control">
                            <small class="text-danger"><?php echo $image_err ?></small>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col">
                            <button class="btn btn-secondary w-100" type="submit" name="register"> Register </button>                           
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
 
<?php require_once("./layout/footer.php") ?>
  