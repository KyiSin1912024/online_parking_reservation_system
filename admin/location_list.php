<?php
require_once("../storage/db.php");
require_once("../storage/location_db.php");
$locations = get_all_locations($mysqli);

$success = "";
if (isset($_GET["success"])) $success = $_GET["success"];

if (isset(($_GET["location_id"]))) {
    $status = delete_location($mysqli, $_GET["location_id"]);
    if ($status) {
        header("location: ./location_list.php?success=Location is successfully deleted.");
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
                <th>Location Name</th>
                <th>Total Space</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($locations) {
                $i = 0;
                while ($location = $locations->fetch_assoc()) {
            ?>
                    <tr>
                        <td> <?php echo ++$i; ?> </td>
                        <td> <?php echo $location['location_name'] ?></td>
                        <td> <?php echo $location['total_spaces'] ?></td>
                        <td> <a href="location_edit.php?location_id=<?php echo $location['location_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a> | <a href="location_list.php?location_id=<?php echo $location['location_id'] ?>"><i class="ms-3 fa-solid fa-trash text-danger"></i></a></td>
                    </tr>
                <?php
                }
            } else { ?>
                <tr>
                    <td colspan="4">No Data.</td>
                </tr>
            <?php } ?>
    </table>
</div>
<?php require_once("./layout/footer.php"); ?>