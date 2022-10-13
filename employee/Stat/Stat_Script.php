<?php
require "../../config/config.php";
$action = $_POST['action'];
$id = $_POST['id'];
$redact = $_POST['redact'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$num = $_POST['num'];
$overtime = $_POST['overtime'];
switch ($action){
    case "redact":
        mysqli_query($connect,"UPDATE worktime SET OverTime = '$overtime' WHERE id = '$num'");
        break;
    case "delete":
        mysqli_query($connect,"DELETE FROM `worktime` WHERE `id` = '$num'");
        break;
}
header("Location: http://{$_SERVER['SERVER_NAME']}/employee/Stat/Stat.php?id={$id}&redact={$redact}&dateStart={$dateStart}&dateEnd={$dateEnd}");
