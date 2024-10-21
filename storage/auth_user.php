<?php
$user = null;
if (isset($_COOKIE['user'])) {
   $user = json_decode($_COOKIE['user'], true);
}

if (!$user) {
   header("Location:../auth/login.php");
}