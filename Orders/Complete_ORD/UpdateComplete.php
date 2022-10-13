<?php
require('../../config/config.php');


if (count($_POST) == 0) {
    echo "<h1>Вы не прикрепили ни одного сотрудника</h1>";
    echo "<h1>Вернитесь назад</h1>"; ?>
    <a href="complete_ord.php?<?= $_SERVER['QUERY_STRING'] ?>">Вернуться назад</a>
    <?php
    exit();
}
$ord_id = $_GET['ord_id'];
$id = $_GET['id'];
$sql = "SELECT max(id) FROM users";
$sql = mysqli_query($connect, $sql);
$sql = mysqli_fetch_all($sql);
$cnt = 1;
for ($j = 1; $j <= $sql[0][0]; $j++) {
    if (isset($_POST[$j])) {
        $i[$cnt] = $_POST[$j];
        $cnt++;
    }
}

$query = "INSERT INTO `uorders`(`oId`, `uId`) VALUES ";

for ($j = 1; $j <= count($i); $j++) {
    $u_id = $i[$j];
    $query = $query . "(" . $ord_id . " , " . $u_id . ") ";
    if ($j < count($i)) {
        $query = $query . ", ";
    }
}
mysqli_query($connect, $query);
$ord_id = $_GET['ord_id'];
$sql = "UPDATE `ordstatus` SET status = 2 WHERE oId = '$ord_id' ";
mysqli_query($connect, $sql);
$ord_status = "UPDATE ordstatus SET print = 1 WHERE oID = " . $ord_id;
mysqli_query($connect, $ord_status);

$date_1 = new DateTime('+7 days');
$date_2 = new DateTime('-7 days');
$date_1 = $date_1->format('Y-m-d');
$date_2 = $date_2->format('Y-m-d');
header("Location: http://{$_SERVER['SERVER_NAME']}/Orders/Orders.php?{$_SERVER['QUERY_STRING']}&start=1&date_start={$date_2}&date_end={$date_1}");
?>