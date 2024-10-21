<?php
require_once('../storage/auth_user.php');
require_once("../storage/db.php");
require_once("../storage/user_db.php");
$customers = get_all_customers($mysqli);

$success = "";
if (isset($_GET["success"])) $success = $_GET["success"];

require_once("./layout/header.php"); ?>
<div class="pagetitle mb-4">
    <h1>Customer List</h1>
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
                <th>Profile</th>
                <th>Phone No.</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                while ($customer = $customers->fetch_assoc()) {
            ?>
                    <tr>
                        <td> <?php echo ++$i; ?> </td>
                        <td> <?php echo $customer['name'] ?></td>
                        <td> <?php echo $customer['email'] ?></td>
                        <td> 
                            <?php  
                                if($customer['image']) { ?>
                                    <img src="../upload/<?php echo $customer['image'] ?>" style="width: 100px; height: 100px;">
                                <?php } else { ?>   
                                    <img src="./assets/img/profile/no-image.jpg" style="width: 100px; height: 100px;">
                                <?php } ?>
                        </td>
                        <td> <?php echo $customer['ph_no'] ?></td>                   
                    </tr>
                <?php
                } ?>
    </table>
</div>
<?php require_once("./layout/footer.php"); ?>