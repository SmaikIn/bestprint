<?php
require "../config/config.php";
$date = date("Y") . "/" . date("m") . "/" . date("d");
if (isset($_POST['login'])) {
    $login = filter_var(trim($_POST ['login']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST ['password']), FILTER_SANITIZE_STRING);


    if (mb_strlen($login) < 5 || mb_strlen($login) > 20) {
        echo "Недопустимая длина логина";
        exit();
    } else {
        if (mb_strlen($password) < 5 || mb_strlen($password) > 20) {
            echo "Недопустимая длина пароля";
            exit();
        }
    }
}
$password = md5($password . "BestPrint");
$category = $_POST['category'];
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);

if (empty($_FILES['filename']['name'])) {
    $filename = 'Profile.png';
} else {
    move_uploaded_file($_FILES['filename']['tmp_name'], '../image/avatar/' . $_FILES['filename']['name']);
    $filename = $_FILES['filename']['name'];
}

$birthday = $_POST['birthday'];
if ($birthday == "") {
    $birthday = NULL;
} else {
    $birthday = $_POST['birthday'];
    for ($i = 0; $i <= strlen($birthday); $i++) {
        if ($birthday[$i] == "-") {
            $birthday[$i] = "/";
        }
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    $email = NULL;
}
$phonenum = $_POST['phonenum'];
$messengerV = $_POST['Viber'];
if (isset($messengerV)) {
    $messengerV = 1;
} else {
    $messengerV = 0;
}
$messengerW = $_POST['Whatsapp'];
if (isset($messengerW)) {
    $messengerW = 1;
} else {
    $messengerW = 0;
}
$messengerT = $_POST['Telegram'];
if (isset($messengerT)) {
    $messengerT = 1;
} else {
    $messengerT = 0;
}
if (empty($_POST['login'])) {
    $login = NULL;
    $password = NULL;
}

$query = "INSERT INTO `users`(`id`, `login`, `password`, `catId`, `name`, `auth`, `image`, `phone`, `birthday`, `e-mail`, `Date_of_registration`, `QR`, `messengerV`, `messengerW`, `messengerT`) VALUES (NULL ,'$login','$password','$category','$name',0,'$filename','$phonenum',NULL,'$email','$date',NULL ,'$messengerV','$messengerW','$messengerT')";
mysqli_query($connect, $query);
if (isset($birthday)) {
    mysqli_query($connect, "UPDATE `users` SET birthday = '$birthday' where name = '$name'");
}

$query = mysqli_query($connect, "SELECT id FROM users where `name` = '$name'");
$query = mysqli_fetch_all($query);

if ($_GET['empl'] == "montage") {
    require_once '../QR/phpqrcode/qrlib.php';
    $u_id = "User " . $query[0][0];
    $file_constant = "../QR/employeeQR/" . $u_id . ".png";
    $QR = "QR/employeeQR/" . $u_id . ".png";
    QRcode::png($u_id, $file_constant, 'H', 8);
    mysqli_query($connect, "UPDATE `users` SET QR = '$QR' where name = '$name'");

}
switch ($_GET['dir']) {
    case "dir":
        $header = "Location: http://{$_SERVER['SERVER_NAME']}/employee/Direktor_Info/employ.php?id={$_GET['id']}&empl={$_GET['empl']}";
        break;
    default:
        $header = "Location: http://{$_SERVER['SERVER_NAME']}/employee/employee.php?id={$_GET['id']}&empl={$_GET['empl']}";
        break;
}
header($header);

