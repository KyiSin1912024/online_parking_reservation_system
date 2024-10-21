<?php 
require_once("../storage/db.php");
require_once("../storage/space_type_db.php");
$space_type_name = "";
$charge_price= 0.00;
$space_type_name_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $space_type_name = $_POST["space-type-name"];
    $charge_price = $_POST["charge-price"];
    if($space_type_name == "") {
        $validate = false;
        $space_type_name_err = "Space type field must not be blank.";
    } 
    if($charge_price === "") $charge_price = 0.00;
    if($validate) {
        $result = save_space_type($mysqli, $space_type_name, $charge_price);
        if($result) {
            $success = true;
        } else {
            $invalid = true;
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-5">
      <h1>Space Type Registeration</h1>
</div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post">
                    <?php
                        if ($success) echo '<div class="alert alert-primary" style="font-size:14px;">Space Type Registeration Successful!</div>';
                        if ($invalid) echo '<div class="alert alert-danger">Space Type Registeration Fail!</div>';
                    ?>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Space Type Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="space-type-name" class="form-control" value="<?php echo $space_type_name ?>">
                            <small class="text-danger"><?php echo $space_type_name_err ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Charge Price Per Hour <br>
                                 (If EV space type)</label>
                        </div>
                        <div class="col mb-3">
                            <input type="number" name="charge-price" class="form-control" value="<?php echo $charge_price ?>">
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
  