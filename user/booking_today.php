<?php 
    require_once('../storage/auth_user.php');
    require_once('../storage/db.php');
    require_once('../storage/booking_db.php');
    require_once('../storage/payment_db.php');
    date_default_timezone_set('Asia/Yangon');
    $space_id = $space_name = $start_time = $end_time = "";
    $space_name_err = $start_time_err = $end_time_err = "";
    $response = array();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $space_id = $_POST['space_id'];
        $space_name = $_POST['space_num'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $errors = [];
        if(empty($space_id)) {
            $errors['space_id'] = "ID Error";
        }
        if(empty($space_name)) {
            $errors['space_number'] = "Space Number mustn't be blank.";
        }
        if(empty($start_time)) {
            $errors['start_time'] = "Start Time mustn't be blank.";
        }
        if(empty($end_time)) {
            $errors['end_time'] = "End Time mustn't be blank.";
        }
        // if(empty($errors) && ((new DateTime($start_time))->format('H:i:s') < (new DateTime())->format('H:i:s'))) {
        //     $errors['start_time'] = "Your requested time is behind the current time";
        // }
        if(empty($errors) && new DateTime($end_time) < new DateTime($start_time)) {
            $errors['end_time'] = "End Time can't be behind the start time";
        }            
        if(empty($errors)) {
            $booking_parking_space = get_booking_by_time_date($mysqli, $space_id, $start_time, $end_time, 'CURRENT_DATE');
            if($booking_parking_space) 
                $errors['booking_fail'] = "Your booking cannot be available at this time. Please select another time slots.";
        }
        if(!empty($errors)) {
            $response = array('status' => 'error', 'errors' => $errors);
        } else {
            $result = save_booking_current_date($mysqli, $space_id, $user['user_id'], $start_time, $end_time, 'CURRENT_DATE');
            if($result) {
                $booking = get_booking_by_user_start_time_date($mysqli, $user['user_id'], $start_time, 'CURRENT_DATE');
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
                     if($payment_result) $response = array('status'=> 'success','message' => 'Booking success!');
                } else $response = array('status'=> 'booking saving database error', 'message' => 'Booking fail!');
            }
            else $response = array('status'=> 'database error', 'message' => 'Booking fail!');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Handle if the request method is not POST (optional)
        $response = array('status' => 'error', 'message' => 'Invalid request method');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
?>