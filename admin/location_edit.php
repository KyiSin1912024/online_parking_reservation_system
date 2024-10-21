<?php 
require_once("../storage/db.php");
require_once("../storage/location_db.php");
$location_id = "";
if (isset($_GET["location_id"])) {
    $location_id = $_GET["location_id"];
}
$location = get_location_by_id($mysqli, $location_id);
$location_name = $location['location_name'];
$total_spaces= $location['total_spaces'];
$location_name_err = $total_space_err = "";
$validate = true;
$success = $invalid = false;
if(isset($_POST["update"])) {
    $location_name = $_POST["location-name"];
    $total_spaces = $_POST["total-spaces"];
    if($location_name == "") {
        $validate = false;
        $location_name_err = "Space type field must not be blank.";
    } 
    if($total_spaces === "") {
        $validate = false;
        $total_space_err = "Total Spaces must not be blank.";
    }
    if($validate) {
        $result = update_location($mysqli, $location_id, $location_name, $total_spaces);
        if($result) {
            $success = true;
        } else {
            $invalid = true;
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-5">
      <h1>Location Update</h1>
</div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post">
                    <?php
                        if ($success) echo '<div class="alert alert-primary" style="font-size:14px;">Space Type Update Successful!</div>';
                        if ($invalid) echo '<div class="alert alert-danger">Space Type Update Fail!</div>';
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
                            <input type="number" name="total-spaces" class="form-control" value="<?php echo $total_spaces?>">
                            <small class="text-danger"><?php echo $total_space_err ?> </small>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <button class="btn btn-secondary w-100" type="submit" name="update"> Update </button>                           
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
 
<?php require_once("./layout/footer.php") ?>
  