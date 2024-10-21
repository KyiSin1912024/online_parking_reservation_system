<?php
if(isset($_GET['logout'])) {
        setcookie("user", "", -1, "/");
        header("Location:./login.php");
}