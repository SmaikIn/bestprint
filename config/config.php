<?php

    define('HOST', '127.0.0.1');
    define('DATABASE', 'bestprint');
    define('USER', 'root1');
    define('PASSWORD', 'root1');
    $connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (!$connect) {
        die('Непральный Логин или Пароль');
    }
     mysqli_set_charset($connect, 'utf8');