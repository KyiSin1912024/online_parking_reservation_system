<?php 
require_once("../storage/db.php");
require_once("../storage/space_type_db.php");
require_once("../storage/location_db.php");
require_once("../storage/parking_space_db.php");
$parking_space_id = "";
$location = $space_type = $price_per_hour = $space_name = "";
$location_name_err = $space_type_err = $price_err = $space_name_err = "";

$space_types = get_all_space_types($mysqli);
$locations = get_all_locations($mysqli);
if (isset($_GET["parking_space_id"])) {
    $parking_space_id = $_GET["parking_space_id"];
}
$parking_space = get_parking_space_by_id($mysqli, $parking_space_id);
$space_name = $parking_space['space_name'];
$location = $parking_space['location_id'];
$space_type = $parking_space['space_type_id'];
$price_per_hour= $parking_space['price_per_hour'];
$validate = true;
$success = $invalid = false;
if(isset($_POST["update"])) {
    $space_name = $_POST["space-name"];
    $space_type = $_POST["space_type"];
    $location = $_POST["location"];
    $price_per_hour = $_POST["price_per_hour"];
    if($space_type === "00") {
        $validate = false;
        $space_type_err = "Space Type must not be blank.";
    } 
    if($location === "00") {
        $validate = false;
        $location_name_err = "Location must not be blank.";
    }
    if($price_per_hour === "") {
        $validate = false;
        $price_err = "Price field must not be blank.";
    }
    if($validate) {
        $result = update_parking_space($mysqli, $parking_space_id, $space_name, $space_type, $location, $price_per_hour);
        if($result) {
            $success = true;
            header('Location:./parking_space_list.php');
        } else {
            $invalid = true;
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-5">
      <h1>Parking Space Update</h1>
</div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post">
                    <?php
                        if ($success) echo '<div class="alert alert-primary" style="font-size:14px;">Parking Space Update Successful!</div>';
                        if ($invalid) echo '<div class="alert alert-danger">Parking Space Update Fail!</div>';
                    ?>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Parking Space Name</label>
                        </div>
                        <div class="col">
                            <input type="text" name="space-name" class="form-control" value="<?php echo $space_name ?>">
                            <small class="text-danger"><?php echo $space_name_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Space Type</label>
                        </div>
                        <div class="col">
                            <select name="space_type" class="form-control">
                                <option value="00">Choose Space Type</option>
                                <?php 
                                    while($space_type_o = $space_types->fetch_assoc()) { 
                                        $selected = "";
                                        if($space_type_o['space_type_id'] === $space_type) $selected = "selected";
                                ?>

                                        <option <?php echo $selected ?> value="<?php echo $space_type_o['space_type_id'] ?>"><?php echo $space_type_o['space_type_name'] ?></option>
                                    <?php } ?>
                            </select>
                            <small class="text-danger"><?php echo $space_type_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Location</label>
                        </div>
                        <div class="col">
                            <select name="location" class="form-control">
                                <option value="00">Choose Location</option>
                                <?php 
                                    while($location_o = $locations->fetch_assoc()) { 
                                        if($location_o['location_id'] = $location) $selected = "selected";
                                        ?>
                                        <option <?php echo $selected ?> value="<?php echo $location_o['location_id'] ?>"><?php echo $location_o['location_name'] ?></option>
                                    <?php } ?>
                            </select>
                            <small class="text-danger"><?php echo $location_name_err ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Price Per Hour</label>
                        </div>
                        <div class="col">
                            <input type="number" name="price_per_hour" class="form-control" value="<?php echo $price_per_hour ?>">
                            <small class="text-danger"><?php echo $price_err ?></small>
                        </div>
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
  