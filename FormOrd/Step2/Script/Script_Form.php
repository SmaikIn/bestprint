<?php
require "../../../config/config.php";
require "../../../config/auth.php";
session_start();

$id = $_GET['id'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Step3.css">
    <title>Предпросмотр заявок</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col" style="text-align: left">
            <h2>Предпросмотр заявок</h2>
            <h3>Шаг №3</h3>
            <div class="row">

                <a class="btn btn-outline-success <?
                if ((isset($_SESSION['1 date print_order'])) || (isset($_SESSION['1 date poligrafy_order']))
                    || (isset($_SESSION['1 date process_order'])) || (isset($_SESSION['1 date frez_order']))
                    || (isset($_SESSION['1 date delivery_order'])) || (isset($_SESSION['1 date zav_order']))
                    || (isset($_SESSION['1 date montage_order']))) {
                    echo "btn";
                } else {
                    echo "disabled";
                }
                ?> " href="Order_Uploads.php?id=<?= $id ?>"> Ввод заявок в
                    систему</a>


            </div>

        </div>
        <div class="col" style="text-align: right">
            <form method="post" action="../../../Personal_Area/lk.php?id=<?= $id ?>">
                <button type="submit" class="btn btn-danger btn-sm">Вернуться в личный кабинет</button>
            </form>
            <br>
            <?
            $link = "../../Step2/FormOrd_" . $_SESSION['type_ord'] . "_Step2.php?id=" . $id;
            ?>
            <form method="post" action="<?= $link ?>">
                <button type="submit" class="btn btn-warning btn-sm">Назад К Шагу №2</button>
            </form>
        </div>
    </div>
</div>
<div class="container mt-5">
    <?
    if ((isset($_SESSION['1 date print_order'])) || (isset($_SESSION['1 date poligrafy_order']))
        || (isset($_SESSION['1 date process_order'])) || (isset($_SESSION['1 date frez_order']))
        || (isset($_SESSION['1 date delivery_order'])) || (isset($_SESSION['1 date zav_order']))
        || (isset($_SESSION['1 date montage_order']))) {
        echo "";
    } else {
        echo "<center><h1>Заявок пока нет</h1> <h2>Вернитесь на Шаг№2</h2> <br></center>";
    }
    if ($_SESSION['block_montage'] == "on") {
        if ($_SESSION['cnt_order_montage'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Монтаж</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="100">Номер</th>
                        <th width="300">Адрес</th>
                        <th width="200">Срок выполнения</th>
                        <th width="400">Техническое задание</th>
                        <th width="300">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_montage']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date montage_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time montage_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask montage_order";
                        $pointValue = "";
                        $pointValue = $pointValue . $j;
                        $pointValue = $pointValue . " point montage_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light "
                                       style="width: 200px"><? echo nl2br($_SESSION[$pointValue]); ?></a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style=" text-align: left; width: 400px;">
                                        <?
                                        echo nl2br($_SESSION[$techtaskValue]);
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $z;

                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) < 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }

                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Монтаж
    if ($_SESSION['block_process'] == "on") {
        if ($_SESSION['cnt_order_process'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Сборка и обработка</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="100">Номер</th>
                        <th width="300">Срок выполнения</th>
                        <th width="500">Техническое задание</th>
                        <th width="400">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_process']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date process_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time process_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask process_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        echo nl2br($_SESSION[$techtaskValue]);
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $z;


                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) < 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Сборка и обработка
    if ($_SESSION['block_zav'] == "on") {
        if ($_SESSION['cnt_order_zav'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Замеры</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="50">Номер</th>
                        <th width="200">Адрес</th>
                        <th width="200">Срок выполнения</th>
                        <th width="300">Техническое задание</th>
                        <th width="300">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_zav']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date zav_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time zav_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask zav_order";
                        $pointValue = "";
                        $pointValue = $pointValue . $j;
                        $pointValue = $pointValue . " point zav_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light " style="width: 200px"><?
                                        echo nl2br($_SESSION[$pointValue]);
                                        ?></a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        echo nl2br($_SESSION[$techtaskValue]);
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $z;

                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) < 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Замеры
    if ($_SESSION['block_delivery'] == "on") {
        if ($_SESSION['cnt_order_delivery'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Доставка</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="50">Номер</th>
                        <th width="200">Адрес</th>
                        <th width="200">Срок выполнения</th>
                        <th width="350">Техническое задание</th>
                        <th width="250">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_delivery']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date delivery_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time delivery_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask delivery_order";
                        $pointValue = "";
                        $pointValue = $pointValue . $j;
                        $pointValue = $pointValue . " point delivery_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light " style="width: 200px"><?
                                        echo nl2br($_SESSION[$pointValue]);
                                        ?>

                                    </a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 350px; text-align: left">
                                        <?
                                        echo nl2br($_SESSION[$techtaskValue]);
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 250px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $z;


                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) < 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Доставка
    if ($_SESSION['block_frez'] == "on") {
        if ($_SESSION['cnt_order_frez'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Фрезеровка</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="100">Номер</th>
                        <th width="300">Срок выполнения</th>
                        <th width="500">Техническое задание</th>
                        <th width="400">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_frez']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date frez_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time frez_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask frez_order";
                        $select_material = "";
                        $select_material = $select_material . $j;
                        $select_material = $select_material . " select_material frez_order";
                        $select_thickness = "";
                        $select_thickness = $select_thickness . $j;
                        $select_thickness = $select_thickness . " select_thickness frez_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="row" style="width: 400px;">
                                        <div class="col" style="width: 200px;">
                                            <a class="btn btn-light" style="width: 150px;">
                                                Материал
                                            </a>
                                            <br>
                                            <br>
                                            <a class="btn btn-light" style="width: 150px;">
                                                Толщина мм
                                            </a>
                                        </div>
                                        <div class="col" style="width: 200px;">
                                            <a class="btn btn-light" style="width: 250px;">
                                                <?= $_SESSION[$select_material] ?>
                                            </a>
                                            <br>
                                            <br>
                                            <a class="btn btn-light" style="width: 250px;">
                                                <?= $_SESSION[$select_thickness] ?>
                                            </a>
                                        </div>

                                    </div>


                                    <br>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        echo nl2br($_SESSION[$techtaskValue]);
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $z;


                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) < 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Фрезировка
    if ($_SESSION['block_print'] == "on") {
        if ($_SESSION['cnt_order_print'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Печать</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="100">Номер</th>
                        <th width="300">Срок выполнения</th>
                        <th width="500">Техническое задание</th>
                        <th width="400">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_print']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date print_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time print_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask print_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light"
                                       style="width: 300px; text-align: left;"><? echo nl2br($_SESSION[$techtaskValue]); ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $z;


                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) <= 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Печать
    if ($_SESSION['block_poligrafy'] == "on") {
        if ($_SESSION['cnt_order_poligrafy'] > 0) {
            ?>
            <div class="row" style="width: 1300px; text-align: center;">
                <div class="row" style="width: 500px; text-align: left;">
                    <h3>Полиграфия</h3>
                </div>
                <table class="table table-hover" style="text-align: center; width: 1300px; ">
                    <thead>
                    <tr>
                        <th width="100">Номер</th>
                        <th width="300">Срок выполнения</th>
                        <th width="500">Техническое задание</th>
                        <th width="400">Список файлов заявки</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $_SESSION['cnt_order_poligrafy']; $i++) {


                        $dateValue = "";
                        $j = $i + 1;
                        $dateValue = $dateValue . $j;
                        $dateValue = $dateValue . " date poligrafy_order";
                        $timeValue = "";
                        $timeValue = $timeValue . $j;
                        $timeValue = $timeValue . " time poligrafy_order";
                        $techtaskValue = "";
                        $techtaskValue = $techtaskValue . $j;
                        $techtaskValue = $techtaskValue . " techtask poligrafy_order";
                        if (isset($_SESSION[$dateValue])) {
                            ?>
                            <tr>
                                <td>
                                    <a class="btn btn-light" style="width: 50px;"><?= $i + 1 ?></a>
                                </td>
                                <td class="print">
                                    <a class="btn btn-light"
                                       style="width: 200px;"><?
                                        echo "Дата: ";
                                        echo date('d-m-Y', strtotime($_SESSION[$dateValue]));
                                        echo "<br>";
                                        if (isset($_SESSION[$timeValue])) {
                                            if (!empty($_SESSION[$timeValue])) {
                                                echo "Время: ";
                                                echo $_SESSION[$timeValue];
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        echo nl2br($_SESSION[$techtaskValue]);
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 300px;">
                                        <?
                                        $z = $i + 1;
                                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $z;

                                        $scan_dir = scandir($FILE_ID);
                                        if (count($scan_dir) < 2) {
                                            echo "Файлы не прекрелены";
                                        } else {
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                echo $scan_dir[$l];
                                                if (isset($scan_dir[$l + 1])) {
                                                    echo "<br>";
                                                }
                                            }
                                        }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
            <br>
            <?
        }
    }//Полиграфия


    ?>

    <div class="row">
        <a class="btn btn-outline-success <?
        if ((isset($_SESSION['1 date print_order'])) || (isset($_SESSION['1 date poligrafy_order']))
            || (isset($_SESSION['1 date process_order'])) || (isset($_SESSION['1 date frez_order']))
            || (isset($_SESSION['1 date delivery_order'])) || (isset($_SESSION['1 date zav_order']))
            || (isset($_SESSION['1 date montage_order']))) {
            echo "btn";
        } else {
            echo "disabled";
        }
        ?> " href="Order_Uploads.php?id=<?= $id ?>"> Ввод заявок в
            систему</a>
    </div>

</div>


</body>
</html>
