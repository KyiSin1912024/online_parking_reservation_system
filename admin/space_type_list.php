<?php
require_once("../storage/db.php");
require_once("../storage/space_type_db.php");
$space_types = get_all_space_types($mysqli);

$success = "";
if (isset($_GET["success"])) $success = $_GET["success"];

if (isset(($_GET["space_type_id"]))) {
    $status = delete_space_type($mysqli, $_GET["space_type_id"]);
    if ($status) {
        header("location: ./space_type_list.php?success=Space Type is successfully deleted.");
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
                <th>Space Type Name</th>
                <th>Charge Price Per Hour</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($space_types) {
                $i = 0;
                while ($space_type = $space_types->fetch_assoc()) {
            ?>
                    <tr>
                        <td> <?php echo ++$i; ?> </td>
                        <td> <?php echo $space_type['space_type_name'] ?></td>
                        <td> <?php echo $space_type['charge_price'] ?></td>
                        <td> <a href="space_type_edit.php?space_type_id=<?php echo $space_type['space_type_id'] ?>"><i class="fa-solid fa-pen-to-square text-secondary me-3"></i></a></td>
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