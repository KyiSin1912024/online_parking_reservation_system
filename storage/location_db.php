<?php

function save_location($mysqli, $location_name, $total_space)
{
    $sql = "INSERT INTO `location`(`location_name`,`total_spaces`) VALUES ('$location_name',$total_space)";
    echo $sql;
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_locations($mysqli)
{
    $sql = "SELECT * FROM `location`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_location_by_id($mysqli, $id)
{
    $sql = "SELECT * FROM `location` WHERE `location_id`=$id";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function update_location($mysqli, $id, $name, $total_spaces)
{
    $sql = "UPDATE `location` SET `location_name`='$name', `total_spaces`='$total_spaces' WHERE `location_id`=$id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function delete_location($mysqli, $id)
{
    $sql = "DELETE FROM `location`  WHERE `location_id`=$id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
