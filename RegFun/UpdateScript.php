<?php

require "../config/config.php";

$redact = $_POST['redact'];
$date = date("Y") . "/" . date("m") . "/" . date("d");
if (isset($_POST['login'])) {
    $login = filter_var(trim($_POST ['login']), FILTER_SANITIZE_STRING);
    if (isset($_POST['password'])){
        $password = filter_var(trim($_POST ['password']), FILTER_SANITIZE_STRING);
        $password = md5($password . "BestPrint");
    }
    if (mb_strlen($login) < 5 || mb_strlen($login) > 20) {
        echo "Недопустимая длина логина";
        exit();
    } else {
        if (mb_strlen($password) < 2 || mb_strlen($password) > 10) {
            echo "Недопустимая длина пароля";
            exit();
        }
    }
}
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

$query = "Update `users` SET `login` = '$login' , `password` = '$password', `catId` = '$category', `name` = '$name', `auth` = 0, `phone` = '$phonenum', `birthday` = NULL, `e-mail` = '$email', `messengerV` = '$messengerV', `messengerW` =  '$messengerW' , `messengerT` = '$messengerT' WHERE  id = '$redact'";
mysqli_query($connect, $query);
if (isset($birthday)) {
    mysqli_query($connect, "UPDATE `users` SET birthday = '$birthday' where name = '$name'");
}



header("Location: http://{$_SERVER['SERVER_NAME']}/employee/employee.php?id={$_POST['id']}");

