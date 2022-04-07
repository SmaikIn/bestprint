<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Личный Кабинет</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/lkCss.css">
</head>
<body>
<?php
date_default_timezone_set('Europe/Riga');
require('../config/config.php');
$id = $_GET['id'];
require('../config/auth.php');

?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Добро пожаловать</h1>
            <h3>Сегодня: <?
                $time = date('l');
                switch ($time) {
                    case 'Monday':
                        echo 'Понедельник ';
                        break;
                    case 'Tuesday':
                        echo 'Вторник ';
                        break;
                    case 'Wednesday':
                        echo 'Среда ';
                        break;
                    case 'Thursday':
                        echo 'Четверг ';
                        break;
                    case 'Friday':
                        echo 'Пятница ';
                        break;
                    case 'Saturday':
                        echo 'Суббота ';
                        break;
                    case 'Sunday':
                        echo 'Воскресенье ';
                        break;
                }
                echo date('d-m-Y');
                ?></h3> <br>
            <?php

            $query = mysqli_query($connect, "SELECT `name`, `catID` FROM `users` WHERE id = '$id'");
            $query = mysqli_fetch_all($query);
            $catId = $query[0][1];
            ?>
            <h5>ФИО: <?= $query[0][0] ?> </h5>
            <?php
            $query = mysqli_query($connect, "SELECT `name` FROM `category` WHERE id = '$catId'");
            $query = mysqli_fetch_all($query);
            $poswork = $query[0][0];
            ?>
            <h5>Должность: <?= $query[0][0] ?></h5>
            <?php
            switch ($poswork) {
                case 'Менеджер': //редактирование файлов в заявке
                    ?>
                    <h5>Форма заявки:</h5>
                    <div class="container mt-2">
                        <h6><a href="../FormOrd/FormOrd_Manufacturing_and_processing.php?id=<?= $id ?>"> Сборка и
                                обработка </a></h6>
                        <h6><a href="../FormOrd/FormOrd_Mounting.php?id=<?= $id ?>">Монтаж</a></h6>
                        <h6><a href="../FormOrd/FormOrd_Measurements.php?id=<?= $id ?>">Замеры</a></h6>
                        <h6><a href="../FormOrd/FormOrd_Polygraphy.php?id=<?= $id ?>">Полиграфия </a></h6>
                        <h6><a href="../FormOrd/FormOrd_Delivery.php?id=<?= $id ?>">Доставка </a></h6>
                    </div>
                    <h5><a href="../Orders/Orders.php?id=<?= $id ?>">Список составленных заявок</a></h5>
                    <?
                    break;
                case 'Начальник цеха':
                    ?>
                    <h5>Работа с заявками:</h5>
                    <div class="container mt-0">
                        <? $time = date('d-m-Y'); ?>
                        <h6><a href="../Orders/Orders.php?id=<?= $id ?>&date=<?= $time ?>">Список заявок</a></h6>
                    </div>
                    <h5>Сотрудники:</h5>
                    <div class="container mt-2">
                        <h6><a href="../employee/employee.php?id=<?= $id ?>">Список Монтажников</a></h6>
                        <h6><a href="../employee/TabelM/TabelM.php?id=<?= $id ?>" target="_blank">Табели сотрудников</a></h6>
                    </div>
                    <h5>Информация о машинах:</h5>
                    <div class="container mt-2">
                        <h6><a href="..">Список автомобилей</a></h6>
                        <h6><a href="..">Автовышка</a></h6>
                    </div>
                    <h5>Склад:</h5>
                    <div class="container mt-2">
                        <h6><a href="">Баннера взятые на хранение</a></h6>
                    </div>
                    <?
                    break;
            } ?>
        </div>
        <div class="col">
            <center>
                <img width='200' src='../png/logo.png'> <br>
                <?php
                $query = mysqli_query($connect, "SELECT `image` FROM `users` WHERE id = '$id'");
                $query = mysqli_fetch_all($query);
                $Image = "../image/avatar/";
                $Image = $Image . $query[0][0];
                echo "<td>" . ($Image == "" ? "No image" : "<img width='200' src='" . $Image . "'></img>") . "</td>";
                ?>
                <br>
                <h5>Календарь:</h5>
                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"/>
                <div class="row">
                    <form method="post" action="../config/relog.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Выйти из системы</button>
                    </form>
                </div>


            </center>
        </div>
    </div>
</div>
</body>
</html>
<?php
exit();
?>
