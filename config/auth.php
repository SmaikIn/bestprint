<?php
require 'config.php';

$ID = $_GET['id'];
$info = $_GET['info'];
if(empty($ID)) {
 echo 'EROR 404';
 exit();
}

$querry = mysqli_query($connect, "SELECT `auth` FROM `users` WHERE id = '$ID'");
$querry = mysqli_fetch_all($querry);
if ($querry[0][0] == 0){
    ?>
    <center>
        <h1>Перейдите на страницу авторизации</h1>
        <br>
        <a href ="../index.html">Клик сюда</a>
    </center>
    <?php
    exit();
}
?>
