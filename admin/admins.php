<?php
require_once('../storage/auth_user.php');
require_once("../storage/db.php");
require_once("../storage/user_db.php");
$admins = get_all_admins($mysqli);

$success = "";
if (isset($_GET["success"])) $success = $_GET["success"];

if (isset(($_GET["admin_id"]))) {
    $status = delete_user($mysqli, $_GET["admin_id"]);
    if ($status) {
        header("Location: ./admins.php?success=Successfully deleted.");
    }
}

require_once("./layout/header.php"); ?>
<div class="pagetitle mb-4">
    <h1>Admin List</h1>
</div><!-- End Page Title -->
<div class="container min-vh-100">
    <?php if (isset($_GET["success"])) {  ?>
        <div class="text-success mb-3 fw-bold">
            <?php echo $success ?>
        </div>
    <?php } ?>
    <table id="example" class="table table-striped table-bordered mb-3" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                while ($admin = $admins->fetch_assoc()) {
            ?>
                    <tr>
                        <td> <?php echo ++$i; ?> </td>
                        <td> <?php echo $admin['name'] ?></td>
                        <td> <?php echo $admin['email'] ?></td>
                        <td> <?php echo $admin['ph_no'] ?></td>
                        <td> 
                            <?php  
                                if($admin['image']) { ?>
                                    <img src="../upload/<?php echo $admin['image'] ?>" style="width: 100px; height: 100px;"></td>
                                <?php } else { ?>   
                                    <img src="./assets/img/profile/no-image.jpg" style="width: 100px; height: 100px;"></td>
                                <?php } ?>
                        <td class="text-center"> <?php if($user['user_id'] != $admin['user_id']) { ?> <a href="admins.php?admin_id=<?php echo $admin['user_id'] ?>" class="text-danger"><i class="ms-3 fa-solid fa-trash text-danger"></i> Out</a> <?php } ?></td>
                    </tr>
                <?php
                } ?>
    </table>
</div>
<?php require_once("./layout/footer.php"); ?>