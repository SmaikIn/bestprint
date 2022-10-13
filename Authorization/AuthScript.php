<?php
require "../config/config.php";

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
$password = md5($password . "BestPrint");
$querry = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
$querry = mysqli_fetch_all($querry);
if (empty($querry)) {
    echo "Пользователь не найден";
    exit();
}
$userID = $querry[0][0];
$str = "Location: http://{$_SERVER['SERVER_NAME']}/Personal_Area/lk.php?id={$userID}";

$sql = mysqli_query($connect, "UPDATE `users` SET `auth`= '1' WHERE `id` = '$userID'");

header($str);
