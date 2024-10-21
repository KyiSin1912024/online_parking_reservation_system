<?php
require_once("../storage/db.php");
require_once("../storage/parking_space_db.php");
$parking_spaces = get_all_parking_spaces_with_space_type_location($mysqli);

$success = "";
if (isset($_GET["success"])) $success = $_GET["success"];

if (isset($_GET["parking_space_id"])) {
    var_dump('helllo');
    $status = delete_parking_space($mysqli, $_GET["parking_space_id"]);
    if ($status) {
        header("location:./parking_space_list.php?success=Parking Space is successfully deleted.");
    }
}

require_once("./layout/header.php"); ?>
<div class="pagetitle mb-4">
    <h1>Space Type List</h1>
</div><!-- End Page Title -->
<div class="container">
    <?php if (isset($_GET["success"])) {  ?>
        <div class="text-success mb-3 fw-bold">
            <?php echo $success ?>
        </div>
    <?php } ?>
    <table id="example" class="table table-striped table-bordered mb-3" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Parking Space Name</th>
                <th>Space Type Name</th>
                <th>Location</th>
                <th>Price Per Hour</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($parking_spaces) {
                $i = 0;
                while ($parking_space = $parking_spaces->fetch_assoc()) {
            ?>
                    <tr>
                        <td> <?php echo ++$i; ?> </td>
                        <td> <?php echo $parking_space['space_name'] ?></td>
                        <td> <?php echo $parking_space['space_type_name'] ?></td>
                        <td> <?php echo $parking_space['location_name'] ?></td>
                        <td> <?php echo $parking_space['price_per_hour'] ?></td>
                        <td> <a href="parking_space_edit.php?parking_space_id=<?php echo $parking_space['space_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a> | <a href="parking_space_list.php?parking_space_id=<?php echo $parking_space['space_id'] ?>"><i class="ms-3 fa-solid fa-trash text-danger"></i></a></td>
                    </tr>
                <?php
                }
            } else { ?>
                <tr>
                    <td colspan="4" class="text-center">No Data.</td>
                </tr>
            <?php } ?>
    </table>
</div>
<?php require_once("./layout/footer.php"); ?>