<?php
require_once('../storage/db.php');
require_once('../storage/parking_space_db.php');
require_once('../storage/user_db.php');
require_once('../storage/booking_db.php');
require_once('../storage/payment_db.php');
date_default_timezone_set('Asia/Yangon');
$start_time = $end_time = $invalid = $parking_spaces = $success = $space_id = $space_name = $user_id = "";
$start_time_err = $end_time_err = "";
$validate = true;
$is_search = $payment_result = false;

if (isset($_POST['search'])) {
	$is_search = true;
	$start_time = $_POST['advance_start_time'];
	$end_time = $_POST['advance_end_time'];

	if (empty($start_time)) {
		$validate = false;
		$start_time_err = "Start Time can't be blank";
	}
	if (empty($end_time)) {
		$validate = false;
		$end_time_err = "End Time can't be blank";
	}
	if (!empty($end_time)) {
		$end_time = new DateTime($end_time);
		if ($end_time < $start_time) {
			$validate = false;
			$end_time_err = "End Time can't be behind the start time";
		}
	}
	if ($validate) {
		$start_time = new DateTime($start_time);
		$start_time = $start_time->format('H:i:s');
		$end_time = $end_time->format('H:i:s');
		$parking_spaces = get_available_parking_spaces($mysqli, $start_time, $end_time, 'CURRENT_DATE');
	}
	// if ($validate) {
	// 	$result = save_booking($mysqli, $space_id, $user['user_id'], $start_time, $end_time, $booking_date);
	// 	if ($result) $success = "Your Booking is successful.";
	// 	else $invalid = "Server Error";
	// }
}

if(isset($_POST['place'])) {
	$space_id = $_POST['space_id'];
	$space_name = $_POST['space_name'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$user_id = $_POST['user_id'];
	$user = get_user_by_id($mysqli, $user_id);
	$result = save_booking_current_date($mysqli, $space_id, $user_id, $start_time, $end_time, 'CURRENT_DATE');
	if($result) {
		$booking = get_booking_by_user_start_time_date($mysqli, $user_id, $start_time, 'CURRENT_DATE');
		$start_time = new DateTime($start_time);
		$end_time = new DateTime($end_time);
		$time_interval = $end_time->diff($start_time);
		$hours = $time_interval->h;
		$minutes = $time_interval->i;
		if($minutes > 30) {
			$hours += 1;
		}
		if($booking) {
			$amount = $booking['price_per_hour'] * $hours;
			$payment_result = save_payment($mysqli, $booking['booking_id'], $amount);
		}
	if ($payment_result) {
		$success = "Successfully set to ". $space_name . " for Customer " . $user['name'] . ".";
		$space_id = "";
		$space_name = "";
		$start_time = "";
		$end_time = "";
		$user_id = "";
		$invalid = "";
	} } else {
		$invalid = "Fail to set a space.";
		$success = "";
	}
}

require_once("./layout/header.php"); ?>
<div class="min-vh-100">
	<div class="pagetitle mb-4">
		<h1>Set A Space For Today!</h1>
	</div><!-- End Page Title -->
	<div class="container">
		<form method="post">
			<div class="row mt-10 justify-content-center">
				<div class="col-4">
					<label>Booking Start Time</label>
					<input type="time" name="advance_start_time" class="form-control" id="advance_start_time" value="<?php echo $start_time ?>">
					<small class="text-danger" id="advance_start_time_err"><?php echo $start_time_err ?></small>
				</div>
				<div class="col-4">
					<label>Booking End Time</label>
					<input type="time" name="advance_end_time" class="form-control" id="advance_end_time" value="<?php echo $end_time ?>">
					<small class="text-danger" id="advance_end_time_err"><?php echo $end_time_err ?></small>
				</div>
				<div class="col-4 position-relative">
					<button type="submit" class="btn btn-primary position-absolute" style="bottom: 1px;" class="booked " name="search"> Search </button>
				</div>
			</div>
		</form>
		<?php if($success) { ?> 
		<div class="alert alert-success mt-4 text-center">
			<?php echo $success ?>
		</div>
		<?php } ?>
		<?php if($invalid) { ?> 
		<div class="alert alert-danger mt-4 text-center">
			<?php echo $invalid ?>
		</div>
		<?php } ?>
		<div class="mt-4">
			<div class="row mb-2">
				<?php
				if ($is_search && $parking_spaces) {
					while ($parking_space = $parking_spaces->fetch_assoc()) { ?>
						<div class="col-4 mb-2">
							<form method="post">
								<input type="hidden" value="<?php echo $start_time ?>" name="start_time">
								<input type="hidden" value="<?php echo $end_time ?>" name="end_time">
								<input type="hidden" value="<?php echo $parking_space['space_id'] ?>" name="space_id">
								<div class="row align-items-center justify-content-between">
									<div class="col-4">
										<input type="text" style="border-color: transparent; background-color: transparent" value="<?php echo $parking_space['space_name'] ?>" name="space_name">
									</div>
									<div class="col-auto">
										<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $parking_space['space_id'].$parking_space['space_name']?>"> Place </button>
									</div>
								</div>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal-<?php echo $parking_space['space_id'].$parking_space['space_name']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header">
										<h1 class="modal-title fs-5" id="exampleModalLabel">Choose Customer</h1>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<select name="user_id" class="form-control">
											<?php 
												$customers = get_all_customers($mysqli);
											    while($customer = $customers->fetch_assoc()) { ?>
												<option value="<?php echo $customer['user_id'] ?>"><?php echo $customer['name'] ?></option>
												<?php }
											?>
										</select>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="submit" name="place" class="btn btn-primary">Submit</button>
									</div>
									</div>
								</div>
								</div>
							</form>
						</div>

				<?php }
				} ?>
			</div>
			<?php if ($is_search && !$parking_spaces) { ?>
				<div class="row justify-content-center">
					<div class="col">
						No parking for this period.
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php require_once("./layout/footer.php"); ?>