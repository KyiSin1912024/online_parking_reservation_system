<?php
function save_payment($mysqli, $booking_id, $amount) {
    $sql = "INSERT INTO payment(booking_id, amount, payment_date_time) VALUES ($booking_id, $amount, NOW())";
    $result = $mysqli->query($sql);
    if($result) return true;
    return false;
}

function update_payment_booking_id($mysqli, $booking_id, $amount) {
    $sql = "UPDATE `payment` SET `amount`=$amount WHERE `booking_id`=$booking_id";
    $result = $mysqli->query($sql);
    if($result) return true;
    return false;
}

function get_payment_by_booking_id($mysqli, $id)
{
    $sql = "SELECT * FROM `payment` WHERE `booking_id`=$id";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_total_income($mysqli){
    $sql = "SELECT SUM(amount) as total_amount FROM payment";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}