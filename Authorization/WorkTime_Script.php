<?php
require "../config/config.php";

$data = $_POST['data'];
if ($data[0] == "U") {

    $user = $data;
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
            mysqli_query($connect, "Update `worktime` SET `TimeResult` = `TimeEnd` - `TimeStart` WHERE id = '$id'");
            $alert = 2;

        } else {
            mysqli_query($connect, "INSERT INTO `worktime`(`id`, `u_id`, `TimeStart`, `TimeEnd`, `Date`, `TimeResult`, OverTime) VALUES (NULL,'$U_ID','$time',NULL ,'$today',NULL,0)");
            $alert = 1;
        }

    }
    $header = "Location: http://{$_SERVER['SERVER_NAME']}/Authorization/WorkTime.php?alert={$alert}";
    header($header);
}
if (strlen($data) <= 6) {
    $string = trim($data);
    $query = "SELECT id FROM orders WHERE id = " . $string;
    $query = mysqli_query($connect, $query);
    $query = mysqli_fetch_all($query);
    if (is_null($query) || empty($query)) {
        echo "<center>";
        echo "<h1>Ошибка, Такой заявки в системе нет</h1>";
        echo "<a href='WorkTime.php' ><h1>Вернитесь на стартовую станицу</h1></a>";
        echo "<h1>Обратитесь к Начальнику Цеха</h1>";
        echo "</center>";
        exit();
    }
    $query = "SELECT status FROM ordstatus WHERE oId = " . $string;
    $query = mysqli_query($connect, $query);
    $query = mysqli_fetch_all($query);
    switch ($query[0][0]) {
        case 0:
            $string_query = "UPDATE ordstatus SET status = 1 WHERE oid = " . $string;
            mysqli_query($connect, $string_query);
            $header = "Location: http://{$_SERVER['SERVER_NAME']}/Authorization/WorkTime.php?alert=ord0";
            break;
        case 1:
            echo "<center>";
            echo "<h1>Заявка находится в обработке</h1>";
            echo "<h1>Для того чтобы выполнить заявку прикрепите монтажника</h1>";
            echo "<a href='WorkTime.php' ><h1>Вернитесь на стартовую станицу</h1></a>";
            echo "</center>";
            $header = "Location: http://{$_SERVER['SERVER_NAME']}/Authorization/WorkTime.php";
            break;
        case 2:
            echo "<center>";
            echo "<h1>Заявка уже была выполнена</h1>";
            echo "<a href='WorkTime.php' ><h1>Вернитесь на стартовую станицу</h1></a>";
            echo "<h1>Обратитесь к Начальнику Цеха</h1>";
            echo "</center>";
            exit();
    }
    header($header);
} else {
    $format = str_replace('User', '', $data);
    $string = "";
    $cnt = 0;
    for ($i = 0; $i <= strlen($format); $i++) {
        if ($format[$i] == " ") {
            $mass[$cnt] = $string;
            $string = "";
            $cnt++;
        }
        $string = $string . $format[$i];
    }
    $mass[$cnt] = $string;
    $cnt++;
    $query = "SELECT id FROM orders WHERE id =" . $mass[0];
    $query = mysqli_query($connect, $query);
    $query = mysqli_fetch_all($query);
    if (is_null($query) || empty($query)) {
        echo "<center>";
        echo "<h1>Ошибка, Такой заявки в системе нет</h1>";
        echo "<a href='WorkTime.php' ><h1>Вернитесь на стартовую станицу</h1></a>";
        echo "<h1>Обратитесь к Начальнику Цеха</h1>";
        echo "</center>";
        exit();
    }
    $query = "SELECT status FROM ordstatus WHERE oid = " . $mass[0];
    $query = mysqli_query($connect, $query);
    $query = mysqli_fetch_all($query);
    if ($query[0][0] == 1 || $query[0][0] == 0) {
        if (count($mass) < 2) {
            echo "<center>";
            echo "<h1>Вы не прикрепили ни одного монтажника к заявке</h1>";
            echo "<a href='WorkTime.php' ><h1>Вернитесь на стартовую станицу</h1></a>";
            echo "<h1>Прикрепите отвественных сотрудников</h1>";
            echo "</center>";
            exit();
        }
        $string_query = "UPDATE ordstatus SET status = 2, print = 2 WHERE oid = " . $mass[0];
        mysqli_query($connect, $string_query);
        $string_query = "INSERT INTO `uorders`(`oId`, `uId`) VALUES ";
        for ($i = 1; $i < count($mass); $i++) {
            $string_query = $string_query . "( " . $mass[0] . ", " . $mass[$i] . " ),";
        }
        $string_query[strlen($string_query) - 1] = " ";
        mysqli_query($connect, $string_query);
        $header = "Location: http://{$_SERVER['SERVER_NAME']}/Authorization/WorkTime.php?alert=ord1";
    } else {
        echo "<center>";
        echo "<h1>Заявка уже была выполнена</h1>";
        echo "<a href='WorkTime.php' ><h1>Вернитесь на стартовую станицу</h1></a>";
        echo "<h1>Обратитесь к Начальнику Цеха</h1>";
        echo "</center>";
        exit();
    }


    header("$header");

}

