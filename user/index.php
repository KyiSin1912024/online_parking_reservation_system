<?php
require_once('../storage/auth_user.php');
require_once('../storage/db.php');
require_once('../storage/parking_space_db.php');
require_once('../layout/header.php');
require_once('../storage/booking_db.php');
require_once('../storage/payment_db.php');
$parking_spaces = get_all_parking_spaces($mysqli);

date_default_timezone_set('Asia/Yangon');
$booking_date = $start_time = $end_time = $invalid = $space_id = $space_name = $success = "";
$booking_date_err = $start_time_err = $end_time_err = "";
$validate = true;
$current_date_time = $search_start_time = $search_end_time = "";

if(isset(($_POST['search']))) {
	$search_start_time = $_POST['search_start_time'];
	$search_end_time = $_POST['search_end_time'];
	if(empty($search_start_time)) {
		$validate = false;
	}
	if(empty($search_end_time)) {
		$validate = false;
	}
	if($validate) {
		$parking_spaces = get_all_parking_spaces_with_time($mysqli, $search_start_time, $search_start_time);
	}
}

if (isset($_POST['request'])) {
	$booking_date = $_POST['booking_date'];
	$start_time = $_POST['advance_start_time'];
	$end_time = $_POST['advance_end_time'];

	if (empty($booking_date)) {
		$validate = false;
		$booking_date_err = "Booking Date can't be blank";
	}
	if (!empty($booking_date)) {
		$booking_date = new DateTime($_POST['booking_date']);
		$current_date_time = new DateTime();
		if ($booking_date->format('Y-m-d') < $current_date_time->format('Y-m-d')) {
			$validate = false;
			$booking_date_err = "You can't take booking for past days.";
		}
	}
	if (empty($start_time)) {
		$validate = false;
		$start_time_err = "Start Time can't be blank";
	}
	// if (!empty($start_time)) {
	$start_time = new DateTime($start_time);
	// 	$current_date_time = new DateTime();
	// 	if ($booking_date->format('Y-m-d') == $current_date_time->format('Y-m-d') && $start_time->format('H:i:s') < $current_date_time->format('H:i:s')) {
	// 		$validate = false;
	// 		$start_time_err = "Your requested time is behind the current time";
	// 	}
	// }
	if (empty($end_time)) {
		$validate = false;
		$end_time_err = "End Time can't be blank";
	}
	if (!empty($end_time)) {
		$end_time = new DateTime($end_time);
		$current_date_time = new DateTime();
		if ($booking_date->format('Y-m-d') == $current_date_time->format('Y-m-d') && $end_time < $start_time) {
			$validate = false;
			$end_time_err = "End Time can't be behind the start time";
		}
	}
	if (!empty($booking_date) && !empty($start_time) && !empty($end_time) && empty($booking_date_err)) {
		$booking_date = $booking_date->format('Y-m-d');
		$start_time = $start_time->format('H:i:s');
		$end_time = $end_time->format('H:i:s');
		$parking_space = get_available_parking_space($mysqli, $start_time, $end_time, $booking_date);
		if ($parking_space != null) {
			$space_id = $parking_space['space_id'];
			$space_name = $parking_space['space_name'];
		} else {
			$validate = false;
			$invalid = "Your booking is unavailable at this time for " . $booking_date;
		}
	}
	if ($validate) {
		$start_time = new DateTime($start_time);
                $end_time = new DateTime($end_time);
		$time_interval = $end_time->diff($start_time);
                $hours = $time_interval->h;
                $minutes = $time_interval->i;
                if($minutes > 30) 
                    $hours += 1;
					$start_time = $start_time->format('H:i:s');
					$end_time = $end_time->format('H:i:s');
		$result = save_booking($mysqli, $space_id, $user['user_id'], $start_time, $end_time, $booking_date);
		if ($result) {
		$booking = get_booking_by_user_start_time_date_advance($mysqli, $user['user_id'], $start_time, $booking_date);
		$amount = $booking['price_per_hour'] * $hours;
		$payment_result = save_payment($mysqli, $booking['booking_id'], $amount);
		if($payment_result) $success = "Your Booking is successful.";
	}
		
		else $invalid = "Server Error";
	}
}
?>


<!-- star-banner -->
<!--  Main Banner Start Here-->
<div class="main-banner">
	<div id="rev_slider_34_1_wrapper" class="rev_slider_wrapper" data-alias="news-gallery34">
		<!-- START REVOLUTION SLIDER 5.0.7 fullwidth mode -->
		<div id="rev_slider_34_1" class="rev_slider" data-version="5.0.7">
			<ul>
				<!-- SLIDE  -->
				<li data-index="rs-129">
					<!-- MAIN IMAGE -->
					<img src="../assets/images/banner/parking.jpg" alt="" class="rev-slidebg">
					<!-- LAYERS -->

					<!-- LAYER NR. 2 -->
					<div class="tp-caption Newspaper-Title tp-resizeme" id="slide-129-layer-1" data-x="['left','left','left','left']" data-hoffset="['100','50','50','30']" data-y="['top','top','top','center']" data-voffset="['165','135','105','0']" data-fontsize="['50','50','50','30']" data-lineheight="['55','55','55','35']" data-width="['600','600','600','420']" data-height="none" data-whitespace="normal" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:0;y:0;s:inherit;e:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on">
						<div class="banner-text">
							
							<h2>Welcome to Parking Lots <span>Parking Services</span></h2>

							<p>
								
Our car parking services offer convenient, secure, and efficient solutions for your vehicle. With options ranging from valet parking to self-parking and reserved spots, we ensure your car is well-cared for and easily accessible, making your experience seamless.
							</p>
							
						</div>
					</div>

				</li>
				<!-- SLIDE  -->
				<li data-index="rs-130" data-title="" data-description="">
					<!-- MAIN IMAGE -->
					<img src="../assets/images/banner/parking2.jpg" alt="" class="rev-slidebg">
					<!-- LAYERS -->

					<!-- LAYER NR. 2 -->
					<div class="tp-caption Newspaper-Title tp-resizeme" id="slide-129-layer-2" data-x="['left','left','left','left']" data-hoffset="['100','50','50','30']" data-y="['top','top','top','center']" data-voffset="['165','135','105','0']" data-fontsize="['50','50','50','30']" data-lineheight="['55','55','55','35']" data-width="['600','600','600','420']" data-height="none" data-whitespace="normal" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:0;y:0;s:inherit;e:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on">
						<div class="banner-text">
							
							<h2>Assuring you of Our Best <span>Services & Solutions</span></h2>

							<p>
								
Our car parking services offer convenient, secure, and efficient solutions for your vehicle. With options ranging from valet parking to self-parking and reserved spots, we ensure your car is well-cared for and easily accessible, making your experience seamless.
							</p>
							
						</div>
					</div>

				</li>
				<!-- SLIDE  -->
				<li data-index="rs-131">
					<!-- MAIN IMAGE -->
					<img src="../assets/images/banner/parking3.jpg" alt="" class="rev-slidebg">
					<!-- LAYERS -->

					<!-- LAYER NR. 2 -->
					<div class="tp-caption Newspaper-Title tp-resizeme" id="slide-129-layer-3" data-x="['left','left','left','left']" data-hoffset="['100','50','50','30']" data-y="['top','top','top','center']" data-voffset="['165','135','105','0']" data-fontsize="['50','50','50','30']" data-lineheight="['55','55','55','35']" data-width="['600','600','600','420']" data-height="none" data-whitespace="normal" data-transform_idle="o:1;" data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:0;y:0;s:inherit;e:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on">
						<div class="banner-text">
							
							<h2>We Are Available For <span>Important Appointment</span></h2>

							<p>
								
Our car parking services offer convenient, secure, and efficient solutions for your vehicle. With options ranging from valet parking to self-parking and reserved spots, we ensure your car is well-cared for and easily accessible, making your experience seamless.
							</p>
							
						</div>
					</div>
				</li>
				<!-- SLIDE  -->
			</ul>
			<div class="tp-bannertimer tp-bottom"></div>
		</div>
	</div>
</div>
<!--  Main Banner End Here-->

<!--About-->
<section id="about_us" class="padding ptb-xs-40 gray-bg">
	<div class="container">
		<div class="row d-flex align-items-center">
			<div class="col-md-12 col-lg-7 about-left">

				<div class="sec_hedding">
					<h2><span>About </span>us</h2>
					<span class="b-line l-left"></span>
				</div>
				<p>
				we specialize in innovative car parking systems designed for efficiency and security. Our solutions streamline parking, reduce wait times, and enhance convenience, making every journey smoother for you.
				</p>
				<div class="row mt-30">
					<div class="col-lg-4 col-md-4 process mb-40">
						<div class="icon-lf float-left">
							<i class="ion-ios-paperplane-outline"></i>
						</div>
						<div class="right-txt float-right">
							<h3>Quick Help</h3>
							
						</div>
					</div>

					<div class="col-lg-4 col-md-4 process mb-40">
						<div class="icon-lf float-left">
							<i class="ion-ios-bolt-outline"></i>
						</div>
						<div class="right-txt float-right">
							<h3>Easy To Use</h3>
							
						</div>
					</div>

					<div class="col-lg-4 col-md-4 process mb-40">
						<div class="icon-lf float-left">
							<i class="ion-ios-gear-outline"></i>
						</div>
						<div class="right-txt float-right">
							<h3>Events</h3>
							
						</div>
					</div>

				</div>
			</div>

			<div class="col-md-12 col-lg-5">
				<img src="../assets/images/cartoon.jpg" class="repo-full" alt="" style="width:300px; height:320px"/>
			</div>

		</div>

	</div>
</section>
<!--About Us-->

<!-- Booking for current day -->
<section id="spaces" class="padding ptb-xs-40">
	<div class="container-fluid">
		<div class="row text-center mb-30">
			<div class="col-sm-12">
				<div class="sec_hedding">
					<h2><span>Parking</span> Spaces</h2>
					<span class="b-line"></span>
				</div>
				<p>By clicking the avaiable space, you can take reservation for today.</p>
			</div>
		</div>
		<div class="row">
			<div class="col">
			<form class="form-inline my-2 my-lg-0 w-100" method="post">
				<label>Start Time</label>
      <input name="search_start_time" class="form-control mr-sm-2" type="time" placeholder="Search with time" aria-label="Search" value="<?php echo $search_start_time ?>">
		<label>End Time</label>
	  <input name="search_end_time" class="form-control mr-sm-2" type="time" placeholder="Search with time" aria-label="Search" value="<?php echo $search_end_time ?>">
      <button class="btn text-success my-2 my-sm-0" type="submit" name="search">Search</button>
    </form> 
	<p class="">(Your can search the avaiable space with the corresponding time)</p>	
			</div>
		</div>
		
		<div class="row justify-content-center">
			<?php
			while ($space = $parking_spaces->fetch_assoc()) {
				$book_space = get_booking_by_time_date_current($mysqli, $space['space_id'], 'NOW()', 'NOW()', 'CURRENT_DATE');
			?>
				<div class="col-2">
					<div class="btn <?php if ($book_space) echo 'btn-warning';
									else echo 'btn-success' ?> w-100" name="book" onclick="book(<?php echo $space['space_id'] ?>,'<?php echo $space['space_name'] ?>')" data-toggle="modal" data-target="#bookingModal" id="book-<?php echo $space['space_id'] ?>">
						<?php echo $space['space_name']; ?>
					</div>
				</div>
			<?php } ?>
			<!-- Modal -->
			<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<form id="bookingForm" method="POST">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Reserve For Today!</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="success_msg"></div>
								<div id="invalid_msg"></div>
								<input type="hidden" id="space_id" name="space_id">
								<div class="row">
									<div class="col col-lg-4">
										<label>Space Number</label>
									</div>
									<div class="col">
										<input type="text" class="form-control" name="space_num" id="space_number">
										<small class="text-danger" id="space_number_err"></small>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col col-lg-4">
										<label>Booking Start Time</label>
									</div>
									<div class="col">
										<input type="time" name="start_time" class="form-control" id="start_time">
										<small class="text-danger" id="start_time_err"></small>
									</div>
								</div>
								<div class="row">
									<div class="col col-lg-4">
										<label>Booking End Time</label>
									</div>
									<div class="col">
										<input type="time" name="end_time" class="form-control" id="end_time">
										<small class="text-danger" id="end_time_err"></small>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-close-custom" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-warning" id="book_btn" name="submit" type="submit"> Book </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Booking for current day END-->

<!-- Appointment Section -->
<section id="appointment" class="padding ptb-xs-40 text-center gray-bg">
	<div class="container">
		<div class="row text-center mb-30">
			<div class="col-sm-12">
				<div class="sec_hedding">
					<h2><span>Get An</span> Appointment</h2>
					<span class="b-line"></span>
				</div>
			</div>
		</div>

		<!--Team Carousel -->
		<div class="row mt-10 justify-content-center">
			<div class="col-12 col-md-6">
				<div class="card p-4">
					<form method="post">
						<span class="text-success mb-1"><?php echo $success ?></span>
						<?php if ($success) echo '<br><span class="text-warning"> Your Space: ' . $space_name . '</span>'; ?>
						<span class="text-danger"><?php echo $invalid ?></span>
						<div class="row my-2">
							<div class="col col-lg-4">
								<label>Booking Date</label>
							</div>
							<div class="col">
								<input type="date" class="form-control" name="booking_date" id="booking_date">
								<small class="text-danger" id="booking_date_err"><?php echo $booking_date_err ?></small>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col col-lg-4">
								<label>Booking Start Time</label>
							</div>
							<div class="col">
								<input type="time" name="advance_start_time" class="form-control" id="advance_start_time">
								<small class="text-danger" id="advance_start_time_err"><?php echo $start_time_err ?></small>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col col-lg-4">
								<label>Booking End Time</label>
							</div>
							<div class="col">
								<input type="time" name="advance_end_time" class="form-control" id="advance_end_time">
								<small class="text-danger" id="advance_end_time_err"><?php echo $end_time_err ?></small>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<button type="submit" class="btn btn-sm btn-warning" class="booked" name="request"> Request </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--End Team Carousel -->
	</div>
</section>
<!-- End Appointment Section -->





			




<script>
	function book(id, name) {
		space_number.value = name;
		space_id.value = id;
		start_time.value = '';
		end_time.value = '';
		document.getElementById('invalid_msg').innerHTML = "";
		document.getElementById('success_msg').innerHTML = "";
	}

	document.addEventListener('DOMContentLoaded', function() {
		book_btn.addEventListener('click', function(event) {
			event.preventDefault();
			var formData = new FormData(bookingForm);
			console.log(formData);
			fetch('booking_today.php', {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					console.log(data);
					console.log(formData);
					if (data.status === 'success') {
						document.getElementById('space_number_err').textContent = "";
						document.getElementById('start_time_err').textContent = "";
						document.getElementById('end_time_err').textContent = "";
						document.getElementById('invalid_msg').innerHTML = "";
						document.getElementById('success_msg').innerHTML = `<div class="alert" style="background-color: #afd989; color:white;">${data.message}</div>`;
					} else {
						document.getElementById('success_msg').innerHTML = "";
						document.getElementById('space_number_err').textContent = data.errors.space_number;
						document.getElementById('start_time_err').textContent = data.errors.start_time;
						document.getElementById('end_time_err').textContent = data.errors.end_time;
						if (!data.errors.space_number && !data.errors.start_time && !data.errors.end_time)
							document.getElementById('invalid_msg').innerHTML = `<div class="alert" style="background-color: #d35e69; color:white;">${data.errors.booking_fail}</div>`;
					}
				})
				.catch(error => {
					console.error('Error submitting form:', error);
				});
		});
	});
</script>
<?php require_once('../layout/footer.php');
