<?php
require "../config/config.php";
$redact = $_GET['redact'];
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
if (isset($_POST['password'])) {
    $password = md5($password . "BestPrint");
} else {
    unset($password);
}

$category = $_POST['category'];
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);

if (!empty($_FILES['filename']['name'])) {
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
if (isset($filename)) {
    $query = "UPDATE `users` SET `image`= '$filename' WHERE id = $redact";
    mysqli_query($connect, $query);
}

if ($_GET['empl'] == "montage") {
    $query = "UPDATE `users` SET  `name`= '$name',`phone`='$phonenum',`birthday`='$birthday',`e-mail`='$email',`messengerV`='$messengerV',`messengerW`='$messengerW',`messengerT`='$messengerT' WHERE id = $redact";
    mysqli_query($connect, $query);
} else {
    if (isset($password)) {
        $query = "UPDATE `users` SET `login`='$login',`password`= '$password',`name`='$name',`phone`='$phonenum',`birthday`='$birthday',`e-mail`='$email',`messengerV`='$messengerV',`messengerW`='$messengerW',`messengerT`='$messengerT' WHERE id = $redact";
    } else {
        $query = "UPDATE `users` SET `login`='$login',`name`='$name',`phone`='$phonenum',`birthday`='$birthday',`e-mail`='$email',`messengerV`='$messengerV',`messengerW`='$messengerW',`messengerT`='$messengerT' WHERE id = $redact";
    }
    mysqli_query($connect, $query);
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

