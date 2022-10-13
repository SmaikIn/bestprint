<?php
require "config.php";
$relog = $_POST['id'];

mysqli_query($connect,"UPDATE users SET auth = 0 WHERE id = '$relog'");
header("Location: http://{$_SERVER['SERVER_NAME']}/index.html");