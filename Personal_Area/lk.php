<?php
session_start();
?>
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
<?
session_destroy();

date_default_timezone_set('Europe/Riga');
require('../config/config.php');
$id = $_GET['id'];
require('../config/auth.php');
?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Добро пожаловать</h1>
            <h2>Сегодня: <?
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
                ?></h2>
            <?php

            $query = mysqli_query($connect, "SELECT `name`, `catID` FROM `users` WHERE id = '$id'");
            $query = mysqli_fetch_all($query);
            $catId = $query[0][1];
            ?>
            <h3>ФИО: <?= $query[0][0] ?> </h3>
            <?php
            $query = mysqli_query($connect, "SELECT `name` FROM `category` WHERE id = '$catId'");
            $query = mysqli_fetch_all($query);
            $poswork = $query[0][0];
            ?>
            <h3>Должность: <?= $query[0][0] ?></h3>
            <?php
            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            switch ($poswork) {
                case 'Менеджер':
                    ?>
                    <h4>Работа с заявками:</h4>
                    <div class="container mt-2" style="text-align: center">
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../Orders/Orders.php?id=<?= $id ?>&start=1&date_start=<?= $date_2 ?>&date_end=<?= $date_1 ?>">Список
                            составленных заявок</a>
                    </div>
                    <h4>Форма заявки:</h4>
                    <div class="container mt-2" style="text-align: center">
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=Combined&config_file=1">Комбинированная</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=montage&config_file=1">Монтаж</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=frez&config_file=1">Фрезеровка</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=print&config_file=1">Печать</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=poligrafy&config_file=1">Полиграфия</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=zav&config_file=1">Замеры</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=delivery&config_file=1">Доставка</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=process&config_file=1">Сборка и
                            обработка</a>
                        <br>
                        <br>
                    </div>
                    <?
                    break;
                case 'Начальник цеха сборки и обработки' :
                    ?>
                    <h4>Работа с заявками:</h4>
                    <div class="container mt-0" style="text-align: right">
                        <? $time = date('d-m-Y'); ?>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../Orders/Orders.php?id=<?= $id ?>&start=1&date_start=<?= $date_2 ?>&date_end=<?= $date_1 ?>">
                            Список заявок</a>
                        <br>
                    </div>
                    <h4>Сотрудники:</h4>
                    <div class="container mt-2" style="text-align: right">
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../employee/employee.php?id=<?= $id ?>&empl=montage">Список Монтажников</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" target="_blank" style="width: 500px;"
                           href="../employee/TabelM/TabelM.php?id=<?= $id ?>">Табель Цеха</a>
                        <br>
                        <br>
                    </div>
                    <h4>Спец. точки</h4>
                    <div class="container mt-2" style="text-align: right;">
                        <a href="../Special_points/Special_points.php?id=<?= $id ?>" style="width: 500px;"
                           class="btn btn-outline-primary btn">Список
                            специальных магазинов
                        </a>
                        <br>
                        <br>
                    </div>
                    <h4>Автопарк предприятия:</h4>
                    <div class="container mt-2" style="text-align: right">
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../Cars/Cars.php?id=<?= $id ?>">Список автомобилей</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="#">График работы автовышки</a>
                        <br>
                    </div>
                    <h4>Склад:</h4>
                    <div class="container mt-2" style="text-align: right">
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../banner/banner.php?id=<?= $id ?>">Баннера взятые на хранение</a>
                        <br>
                    </div>


                    <?
                    break;
                case 'Директор':

                    ?>
                    <h4>Работа с заявками:</h4>
                    <div class="container mt-0" style="text-align: right">
                        <? $time = date('d-m-Y'); ?>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../Orders/Orders.php?id=<?= $id ?>&start=1&date_start=<?= $date_2 ?>&date_end=<?= $date_1 ?>">
                            Список заявок</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../FormOrd/FormOrd_Combined.php?id=<?= $id ?>&type_ord=Combined&config_file=1">Комбинированная</a>
                        <br>
                        <br>
                        <a class="btn btn-outline-primary btn" style="width: 500px;" target="_blank"
                           href="../Delete_Orders/Delete_Orders.php?id=<?= $id ?>">Сервис удаления заявок</a>
                        <br>
                        <br>
                    </div>
                    <h4>Работа с персоналом:</h4>
                    <div class="container mt-2" style="text-align: right">
                        <a href="../employee/Direktor_Info/employ.php?id=<?= $id ?>&empl=montage" style="width: 500px;"
                           class="btn btn-outline-primary btn">Список
                            монтажников
                        </a>
                        <br>
                        <br>
                        <a href="../employee/Direktor_Info/employ.php?id=<?= $id ?>&empl=manager" style="width: 500px;"
                           class="btn btn-outline-primary btn">Список менеджеров
                        </a>
                        <br>
                        <br>
                        <a href="../employee/Direktor_Info/employ.php?id=<?= $id ?>&empl=empl" style="width: 500px;"
                           class="btn btn-outline-primary btn">Список сотрудников
                        </a>
                        <br>
                        <br>
                    </div>
                    <h4>Спец. точки</h4>
                    <div class="container mt-2" style="text-align: right;">
                        <a href="../Special_points/Special_points.php?id=<?= $id ?>" style="width: 500px;"
                           class="btn btn-outline-primary btn">Список
                            специальных магазинов
                        </a>
                        <br>
                        <br>
                    </div>
                    <h4>Автопарк предприятия:</h4>
                    <div class="container mt-2" style="text-align: right">
                        <a href="../Cars/Cars.php?id=<?= $id ?>" style="width: 500px;"
                           class="btn btn-outline-primary btn">Список
                            автомобилей
                        </a>
                        <br>
                        <br>
                        <form method="post" action="#">
                            <button style="width: 500px;" type="submit" class="btn btn-outline-primary btn"> График
                                работы автовышки
                            </button>
                            <br>
                            <br>
                        </form>
                    </div>
                    <?
                    break;
                default :
                    ?>
                    <h4>Работа с заявками:</h4>
                    <div class="container mt-0" style="text-align: right">
                        <? $time = date('d-m-Y'); ?>
                        <a class="btn btn-outline-primary btn" style="width: 500px;"
                           href="../Orders/Orders.php?id=<?= $id ?>&start=1&date_start=<?= $date_2 ?>&date_end=<?= $date_1 ?>">
                            Список заявок</a>
                        <br>
                    </div>
                    <?
                    break;
            }
            ?>
        </div>
        <div class="col">
            <center>
                <div class="row">
                    <form method="post" action="../config/relog.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button type="submit" style="width: 300px;" class="btn btn-outline-danger btn">Выйти из
                            системы
                        </button>
                    </form>
                    <br>
                    <br>
                </div>
                <img width='300' src='../png/logo.png'><br>
                <?php
                $query = mysqli_query($connect, "SELECT `image` FROM `users` WHERE id = '$id'");
                $query = mysqli_fetch_all($query);
                $Image = "../image/avatar/";
                $Image = $Image . $query[0][0];
                echo "<td>" . ($Image == "" ? "No image" : "<img width='300' src='" . $Image . "'></img>") . "</td>";
                ?>
                <br>
                <br>
                <h5>Календарь:</h5>
                <input type="date" class="form-control" style="width: 300px; text-align: center;" name="date"
                       value="<? echo date('Y-m-d'); ?>"/>
                <h5>Время:</h5>
                <input type="time" class="form-control" style="width: 300px; text-align: center;" name="time"
                       value="<? echo date('H:i'); ?>"/>


            </center>
        </div>
    </div>
</div>
</body>
</html>
<?php
exit();
?>
