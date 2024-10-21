<?php 
function save_booking($mysqli, $space_id, $user_id, $start_time, $end_time, $booking_date) {
    $sql = "INSERT INTO `booking`(booking_start_time,booking_end_time,parking_space_id,user_id,booking_date) VALUES ('$start_time', '$end_time', $space_id, $user_id, '$booking_date')";
    $result = $mysqli->query($sql);
    if($result) return true;
    return false;
} 

function save_booking_current_date($mysqli, $space_id, $user_id, $start_time, $end_time, $booking_date) {
    $sql = "INSERT INTO `booking`(booking_start_time,booking_end_time,parking_space_id,user_id,booking_date) VALUES ('$start_time', '$end_time', $space_id, $user_id, $booking_date)";
    $result = $mysqli->query($sql);
    if($result) return true;
    return false;
} 

function get_booking_by_user_start_time_date($mysqli, $user_id, $start_time, $date) {
    $sql = "SELECT * FROM booking INNER JOIN parking_space on booking.parking_space_id = parking_space.space_id where booking.user_id = $user_id AND booking.booking_start_time = '$start_time' AND booking.booking_date = $date";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_booking_by_user_start_time_date_advance($mysqli, $user_id, $start_time, $date) {
    $sql = "SELECT * FROM booking INNER JOIN parking_space on booking.parking_space_id = parking_space.space_id where booking.user_id = $user_id AND booking.booking_start_time = '$start_time' AND booking.booking_date = '$date'";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_booking_by_time_date($mysqli, $space_id, $start_time, $end_time, $date) {
    $sql = "SELECT * FROM `booking` WHERE parking_space_id = $space_id AND booking_date = $date AND (
        (booking_start_time <= '$start_time' AND booking_end_time > '$start_time') OR 
        (booking_start_time < '$end_time' AND booking_end_time >= '$end_time') OR 
        (booking_start_time >= '$start_time' AND booking_start_time < '$end_time') OR 
        (booking_end_time > '$start_time' AND booking_end_time <= '$end_time')
    )";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_booking_by_time_date_current($mysqli, $space_id, $start_time, $end_time, $date) {
    $sql = "SELECT * FROM `booking` WHERE parking_space_id = $space_id AND booking_date = $date AND (
        (booking_start_time <= $start_time AND booking_end_time > $start_time) OR 
        (booking_start_time < $end_time AND booking_end_time >= $end_time) OR 
        (booking_start_time >= $start_time AND booking_start_time < $end_time) OR 
        (booking_end_time > $start_time AND booking_end_time <= $end_time)
    )";
    $result = $mysqli->query( $sql);
    return $result->fetch_assoc();
}

function get_booking_by_user_id( $mysqli, $user_id ) {
    $sql = "SELECT * FROM `booking` INNER JOIN `parking_space` ON `booking`.`parking_space_id` = `parking_space`.`space_id` INNER JOIN `location` ON `parking_space`.`location_id` = `location`.`location_id` INNER JOIN `payment` ON `booking`.`booking_id` = `payment`.`booking_id`  WHERE `booking`.`user_id` = $user_id";
    var_dump($sql);
    $result = $mysqli->query($sql);
    return $result;
}

function get_booking_count_for_today($mysqli) {
    $sql = "SELECT COUNT(*) as booking_count FROM booking where booking_date = CURRENT_DATE";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_all_bookings($mysqli)
{
    $sql = "SELECT * FROM `booking` INNER JOIN `parking_space` ON `booking`.`parking_space_id` = `parking_space`.`space_id` INNER JOIN `location` ON `parking_space`.`location_id` = `location`.`location_id` INNER JOIN `payment` ON `booking`.`booking_id` = `payment`.`booking_id`";
    $result = $mysqli->query($sql);
    return $result;
}

function update_booking_by_id($mysqli, $booking_id, $is_charged) {
    $sql = "UPDATE `booking` SET `is_charged`= $is_charged WHERE `booking_id`=$booking_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
