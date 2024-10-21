<?php 
require_once("../storage/db.php");
require_once("../storage/location_db.php");
$location_name = $total_space = "";
$location_name_err = $total_space_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["register"])) {
    $location_name = $_POST["location-name"];
    $total_space = $_POST["total-space"];
    if($location_name == "") {
        $validate = false;
        $location_name_err = "Location Name must not be blank.";
    } 
    if($total_space === "") {
        $validate = false;
        $total_space_err = "Total Spaces must not be blank.";
    }
    if($validate) {
        $result = save_location($mysqli, $location_name, $total_space);
        if($result) {
            $success = true;
            $location_name = $total_space = "";
        } else {
            $invalid = true;
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-5">
      <h1>Location Registeration</h1>
</div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post">
                    <?php
                        if ($success) echo '<div class="alert alert-primary" style="font-size:14px;">Location Registeration Successful!</div>';
                        if ($invalid) echo '<div class="alert alert-danger">Location Registeration Fail!</div>';
                    ?>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Location Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="location-name" class="form-control" value="<?php echo $location_name ?>">
                            <small class="text-danger"><?php echo $location_name_err ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Total Spaces</label>
                        </div>
                        <div class="col mb-3">
                            <input type="number" name="total-space" class="form-control" value="<?php echo $total_space ?>">
                            <small class="text-danger"><?php echo $total_space_err ?></small>
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
  