<?php
require_once("../storage/db.php");
require_once("../storage/booking_db.php");
require_once("../storage/space_type_db.php");
require_once("../storage/payment_db.php");
$bookings = get_all_bookings($mysqli);
$invalid = "";
if(isset($_POST['is_charged'])) {
    $booking_id = $_POST['booking_id'];
    $is_charged = $_POST['is_charged'];
    if($is_charged === 'charged') $is_charged = 'false';
    else $is_charged = 'true';
    $result = update_booking_by_id($mysqli, $booking_id, $is_charged);
    if($result) {
        if($is_charged === 'true') $space_type = get_space_type_by_name($mysqli, 'EV');
        $previous_payment = get_payment_by_booking_id($mysqli, $booking_id);
        $amount = $previous_payment['amount'] + $space_type['charge_price'];
        $status = update_payment_booking_id($mysqli, $booking_id, $amount);
        header('location: ./booking.php');
    }
    else $invalid = 'Something went wrong!';
}
require_once("./layout/header.php"); ?>
<div class="pagetitle mb-4">
    <h1>Booking List</h1>
</div><!-- End Page Title -->
<div class="container min-vh-100">
    <?php if($invalid) { ?>
        <div class="text-danger"> <?php echo $invalid ?> </div>
    <?php } ?>
    <table id="example" class="table table-striped table-bordered mb-3" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Space Number</th>
                <th>Location</th>
                <th>Charged?</th>
                <th>Duration</th>
                <th>Total Fee</th>
                <th>Parked Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                while ($booking = $bookings->fetch_assoc()) {

                    $start_time = new DateTime($booking['booking_start_time']);
                    $end_time = new DateTime($booking['booking_end_time']);
                    $time_interval = $end_time->diff($start_time);
            ?>
                    
                    <tr>
                        <td> <?php echo ++$i; ?> </td>
                        <td> <?php echo $booking['space_name'] ?></td>
                        <td> <?php echo $booking['location_name'] ?></td>
                        <td> <form method="post">
                        <input type="hidden" value="<?php echo $booking['booking_id'] ?>" name="booking_id">
                             <button class="btn" type="submit" name="is_charged" style="background-color: #c0d5e9" value="<?php echo $booking['is_charged'] ? 'charged' : 'not-charged' ?>" <?php echo $booking['is_charged'] ? 'disabled' : '' ?>><?php echo $booking['is_charged'] ? 'charged' : 'not-charged' ?> </button>
                             </form>
                        </td>
                        <td> <?php echo $time_interval->format('%H:%I:%S') ?></td>
                        <td> <?php echo $booking['amount'] ?> MMK</td>
                        <td> <?php echo $booking['booking_date'] ?></td>
                    </tr>
                    
                <?php
                }
            ?>
    </table>
</div>
<?php require_once("./layout/footer.php"); ?>