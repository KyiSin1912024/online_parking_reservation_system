<?php

function save_parking_space($mysqli, $space_name, $space_type, $location, $charge_price)
{
    $sql = "INSERT INTO `parking_space`(`space_name`,`space_type_id`,`location_id`,`price_per_hour`) VALUES ('$space_name','$space_type','$location',$charge_price)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_parking_spaces($mysqli)
{
    $sql = "SELECT * FROM `parking_space`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_all_parking_spaces_with_time($mysqli, $start_time, $end_time) {
    $sql = "SELECT * 
    FROM `parking_space` 
    WHERE `parking_space`.`space_id` NOT IN (
        SELECT `parking_space_id` 
        FROM `booking` 
        WHERE booking_date = CURRENT_DATE AND (
            (booking_start_time <= '$start_time' AND booking_end_time > '$start_time') OR 
            (booking_start_time < '$end_time' AND booking_end_time >= '$end_time') OR 
            (booking_start_time >= '$start_time' AND booking_start_time < '$end_time') OR 
            (booking_end_time > '$start_time' AND booking_end_time <= '$end_time')
        )
    )";
    $result = $mysqli->query($sql);
    return $result;
}

function is_valid_space($mysqli, $location) {
    $sql = "SELECT COUNT(*) AS space_count FROM `parking_space`";
    $result = $mysqli->query($sql)->fetch_assoc();
    $sql1 = "SELECT * FROM `location` WHERE location_id = $location";
    $result1 = $mysqli->query($sql1)->fetch_assoc();
    return $result1['total_spaces'] > $result['space_count'];
}

function get_all_parking_spaces_with_space_type_location($mysqli) {
    $sql = "SELECT * FROM `car_space_type` INNER JOIN `parking_space` ON `car_space_type`.`space_type_id` = `parking_space`.`space_type_id` INNER JOIN `location` ON `parking_space`.`location_id` = `location`.`location_id`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_parking_spaces_count($mysqli) {
    $sql = "SELECT COUNT(*) as space_count FROM parking_space";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_parking_space_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `parking_space` WHERE `space_id`=$id";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_available_parking_space_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `parking_space` WHERE `space_id`=$id AND `space_id` NOT IN (SELECT `parking_space_id` FROM booking where `booking_date` = CURRENT_DATE)";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_available_parking_space($mysqli, $start_time, $end_time, $booking_date)
{
    $sql = "SELECT * 
    FROM `parking_space` 
    WHERE `parking_space`.`space_id` NOT IN (
        SELECT `parking_space_id` 
        FROM `booking` 
        WHERE booking_date = '$booking_date' AND (
            (booking_start_time <= '$start_time' AND booking_end_time > '$start_time') OR 
            (booking_start_time < '$end_time' AND booking_end_time >= '$end_time') OR 
            (booking_start_time >= '$start_time' AND booking_start_time < '$end_time') OR 
            (booking_end_time > '$start_time' AND booking_end_time <= '$end_time')
        )
    )";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_available_parking_spaces($mysqli, $start_time, $end_time, $booking_date)
{
    $sql = "SELECT * 
    FROM `parking_space` 
    WHERE `parking_space`.`space_id` NOT IN (
        SELECT `parking_space_id` 
        FROM `booking` 
        WHERE booking_date = $booking_date AND (
            (booking_start_time <= '$start_time' AND booking_end_time > '$start_time') OR 
            (booking_start_time < '$end_time' AND booking_end_time >= '$end_time') OR 
            (booking_start_time >= '$start_time' AND booking_start_time < '$end_time') OR 
            (booking_end_time > '$start_time' AND booking_end_time <= '$end_time')
        )
    )";
    $result = $mysqli->query($sql);
    if ($result)  return $result;
}

function update_parking_space($mysqli, $id, $space_name, $space_type_id, $location_id, $price_per_hour)
{
    $sql = "UPDATE `parking_space` SET `space_name`='$space_name', `space_type_id`='$space_type_id', `location_id`='$location_id', `price_per_hour`=$price_per_hour WHERE `space_id`=$id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function delete_parking_space($mysqli, $id)
{
    $bookings = get_booking_by_space_id($mysqli, $id);
    while($booking = $bookings->fetch_assoc()) {
        $bookingId = $booking['booking_id'];
        if ($bookingId)
        $sql = "DELETE FROM `payment` WHERE `booking_id`=$bookingId";
        $result = $mysqli->query($sql); 
        if($result == false) return $result;
    }
    $sql = "DELETE FROM `booking` WHERE `parking_space_id`=$id";
    if ($mysqli->query($sql)) {
        $sql = "DELETE FROM `parking_space` WHERE `space_id`=$id";
        if ($mysqli->query($sql)) {
            return true;
        }
    }
    return false;
}

function get_booking_by_space_id($mysqli, $id) {
    $sql = "SELECT * FROM `booking` WHERE `parking_space_id`=$id";
    $result = $mysqli->query($sql);
    if ($result)  return $result;
}