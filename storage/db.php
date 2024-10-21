<?php
$mysqli = new mysqli("localhost", "root", "");

//check connection error
if ($mysqli->connect_error) {
    echo "Connection Error.";
}

//create database
function create_db($mysqli)
{
    $sql = "create database IF NOT EXISTS parking_lots";
    if ($mysqli->query($sql)) return true;
    return false;
}

function select_db($mysqli)
{
    if ($mysqli->select_db("parking_lots")) return true;
    return false;
}

function create_tables($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS users (
        user_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        ph_no VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        image VARCHAR(255) NULL,
        is_admin BOOLEAN DEFAULT FALSE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS car_space_type (
        space_type_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        space_type_name VARCHAR(255) NOT NULL,
        charge_price DECIMAL NULL
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS location (
      location_id BIGINT AUTO_INCREMENT PRIMARY KEY,
      location_name VARCHAR(100) NOT NULL,
      total_spaces INT NOT NULL
    )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS parking_space (
        space_id BIGINT PRIMARY KEY AUTO_INCREMENT,
        space_name VARCHAR(255) NOT NULL,
        space_type_id BIGINT NOT NULL,
        location_id BIGINT NOT NULL,
        price_per_hour DECIMAL NOT NULL,
        is_available BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (space_type_id) REFERENCES car_space_type(space_type_id),
        FOREIGN KEY (location_id) REFERENCES location(location_id)      
      )";
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS booking (
      booking_id BIGINT PRIMARY KEY AUTO_INCREMENT,
      booking_start_time TIME NOT NULL,
      booking_end_time TIME NULL,
      parking_space_id BIGINT NOT NULL,
      user_id BIGINT NOT NULL,
      booking_date DATE DEFAULT CURRENT_DATE,
      is_charged BOOLEAN DEFAULT FALSE,
      FOREIGN KEY (user_id) REFERENCES users(user_id),
      FOREIGN KEY (parking_space_id) REFERENCES parking_space(space_id)
    )";    
    if (!$mysqli->query($sql)) return false;

    $sql = "CREATE TABLE IF NOT EXISTS payment (
      payment_id BIGINT PRIMARY KEY AUTO_INCREMENT,
      booking_id BIGINT NOT NULL,
      amount DECIMAL(10, 2) NOT NULL,
      payment_date_time DATETIME NOT NULL,
      FOREIGN KEY (booking_id) REFERENCES booking(booking_id)
    )";
    if (!$mysqli->query($sql)) return false;

    return true;
}

function insert_space_type($mysqli, $name, $charge_price) {
  $sql = "INSERT INTO `car_space_type` (`space_type_name`, `charge_price`) VALUES ('$name', $charge_price)";
  $mysqli->query($sql);
}

function insert_location($mysqli, $name, $total_spaces) {
  $sql = "INSERT INTO `location` (`location_name`, `total_spaces`) VALUES ('$name', $total_spaces)";
  $mysqli->query($sql);
}
function insert_parking_space($mysqli, $name) {
  $ql = "INSERT INTO `parking_space` (`space_id`, `space_name`, `space_type_id`, `location_id`, `price_per_hour`, `is_available`) VALUES (NULL,'$name', '1', '1', '1000', '0')";
  $mysqli->query($ql);
}

create_db($mysqli);
select_db($mysqli);
create_tables($mysqli);

// require_once("./parking_space_db.php");
// require_once("./space_type_db.php");
// require_once("./location_db.php");
// $space_types = get_all_space_types($mysqli);
// if($space_types->num_rows < 1) {
//   insert_space_type($mysqli, 'EV', '20000');
// }
// $locations = get_all_locations($mysqli);
// if($locations->num_rows < 1) {
//   insert_location($mysqli, '1st floor', 30);
// }
// $parking_spaces = get_all_parking_spaces($mysqli);
// if($parking_spaces->num_rows < 1) {
//   for ($i = 1; $i < 31; $i++) {
//     insert_parking_space($mysqli, 'S00'.$i);
//   }
// }

