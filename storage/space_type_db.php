<?php

function save_space_type($mysqli, $space_type_name, $charge_price)
{
    $sql = "INSERT INTO `car_space_type`(`space_type_name`,`charge_price`) VALUES ('$space_type_name',$charge_price)";
    echo $sql;
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_space_types($mysqli)
{
    $sql = "SELECT * FROM `car_space_type`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_space_type_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `car_space_type` WHERE `space_type_id`=$id";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function update_space_type($mysqli, $id, $name, $charge_price)
{
    $sql = "UPDATE `car_space_type` SET `space_type_name`='$name', `charge_price`='$charge_price' WHERE `space_type_id`=$id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function delete_space_type($mysqli, $id)
{
    $sql = "DELETE FROM `car_space_type`  WHERE `space_type_id`=$id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_space_type_by_name($mysqli, $space_type_name) {
    $sql = "SELECT * FROM `car_space_type` WHERE `space_type_name`='$space_type_name'";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}
