<?php
require "../config/config.php";
$user = $_POST['u_id'];
date_default_timezone_set('Europe/Riga');
$today = date("Y/m/d");
$time = date("H:i:s");
$i = 0;
$cnt = 0;
$U_ID = "";
for ($i = 0; $i < strlen($user); $i++) {
    if ($user[$i] == ' ') {
        break;
    }
}
$U_ID = substr($user, $i + 1, strlen($user));
$alert = 0;

$query = "SELECT max(id) FROM `worktime` WHERE u_id = '$U_ID' ";
$query = mysqli_query($connect, $query);
$query = mysqli_fetch_all($query);

if (empty($query[0][0])) {
    mysqli_query($connect, "INSERT INTO `worktime`(`id`, `u_id`, `TimeStart`, `TimeEnd`, `Date`, `TimeResult`, OverTime) VALUES (NULL,'$U_ID','$time',NULL ,'$today',NULL,0)");
    $alert = 1;
} else {

    $id = $query[0][0];
    $query = "SELECT * FROM `worktime` WHERE  id = '$id'";
    $query = mysqli_query($connect, $query);
    $query = mysqli_fetch_all($query);
    if (empty($query[0][3])) {
        mysqli_query($connect, "Update `worktime` SET `TimeEnd` = '$time' WHERE id = '$id'");
        $alert = 2;
    } else {
        mysqli_query($connect, "INSERT INTO `worktime`(`id`, `u_id`, `TimeStart`, `TimeEnd`, `Date`, `TimeResult`, OverTime) VALUES (NULL,'$U_ID','$time',NULL ,'$today',NULL,0)");
        $alert = 1;
    }

}

header("Location: http://{$_SERVER['SERVER_NAME']}/Authorization/WorkTime.php?alert={$alert}");