<?php
require_once("../storage/db.php");
require_once("../storage/location_db.php");
require_once("../storage/space_type_db.php");
require_once("../storage/location_db.php");
require_once("../storage/parking_space_db.php");
$location = $space_type = $price_per_hour = $space_name = $invalid = "";
$location_name_err = $space_type_err = $price_err = $space_name_err = "";
$validate = true;
$success = false;
$space_types = get_all_space_types($mysqli);
$locations = get_all_locations($mysqli);
if (isset($_POST["register"])) {
    $space_name = $_POST["space-name"];
    $space_type = $_POST["space_type"];
    $location = $_POST["location"];
    $price_per_hour = $_POST["price_per_hour"];
    if ($space_type === "00") {
        $validate = false;
        $space_type_err = "Space Type must not be blank.";
    }
    if ($location === "00") {
        $validate = false;
        $location_name_err = "Location must not be blank.";
    }
    if ($price_per_hour === "") {
        $validate = false;
        $price_err = "Price field must not be blank.";
    }
    if ($validate) {
        $status = is_valid_space($mysqli, $location);
        if ($status) {
            $result = save_parking_space($mysqli, $space_name, $space_type, $location, $price_per_hour);
            if ($result) {
                $success = true;
                $space_name = $location = $space_type = $price_per_hour = "";
            } else {
                $invalid = "Parking Space Registeration Fail!";
            }
        } else {
            $invalid = "Parking spaces can't be created over the limit.";
        }
    }
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-5">
    <h1>Parking Space Registeration</h1>
</div><!-- End Page Title -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card bg-light p-4">
                <form method="post">
                    <?php
                    if ($success) echo '<div class="alert alert-primary" style="font-size:14px;">Parking Space Registeration Successful!</div>';
                    if ($invalid) { ?> <div class="alert alert-danger"><?php echo $invalid ?></div> <?php } ?>

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
                                while ($space_type = $space_types->fetch_assoc()) { ?>
                                    <option value="<?php echo $space_type['space_type_id'] ?>"><?php echo $space_type['space_type_name'] ?></option>
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
                                while ($location = $locations->fetch_assoc()) { ?>
                                    <option value="<?php echo $location['location_id'] ?>"><?php echo $location['location_name'] ?></option>
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
                            <button class="btn btn-secondary w-100" type="submit" name="register"> Register </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require_once("./layout/footer.php") ?>