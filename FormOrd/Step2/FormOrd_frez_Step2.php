<?php
require "../../config/config.php";
require "../../config/auth.php";
require "Script/global_settings.php";
session_start();
$id = $_GET['id'];
?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новая Заявка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Step2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        window.onload = function () {
            scrollTo(sessionStorage.getItem('pointX'), sessionStorage.getItem('pointY'));
        }
    </script>
</head>
<style>
    input:invalid {
        border-color: red;
    }

    input:valid {
        border-color: green;
    }

    textarea:invalid {
        border-color: red;
    }

    textarea:valid {
        border-color: green;
    }

    select:invalid {
        border-color: red;
    }

    select:valid {
        border-color: green;
    }
</style>
<body>
<script>
    window.onclick = function () {
        sessionStorage.setItem('pointX', window.pageXOffset);
        sessionStorage.setItem('pointY', window.pageYOffset);
    }
</script>
<div class="container mt-5  ">
    <div class="row">
        <div class="col" style="text-align: left">
            <h2>Комбинированная заявка</h2>
            <h3>Шаг №2</h3>
        </div>
        <div class="col" style="text-align: right">
            <form method="post" action="../../Personal_Area/lk.php?id=<?= $id ?>">
                <button type="submit" class="btn btn-danger btn-sm">Вернуться в личный кабинет</button>
            </form>
            <br>
            <form method="post" action="../FormOrd_Combined.php?id=<?= $id ?>">
                <button type="submit" class="btn btn-warning btn-sm">Назад К Шагу №1</button>
            </form>
        </div>
    </div>
</div>
<div class="container mt-1">
    <div class="name">
        <fieldset class="step_1" disabled>
            <div class="row">
                <div class="col">
                    <h5>Заказчик</h5>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="company" id="company" required
                           value="<?= $_SESSION['company'] ?>" autocomplete="on">
                </div>
            </div>
        </fieldset>
        <br>
        <div class="row">
            <a class="btn btn-outline-success" href="Script/Script_Form.php?id=<?= $id ?>"> Предпросмотр
                ввода заявок
                в систему</a>
        </div>
        <br>
    </div>
</div>

<div class="container mt-1">
    <br>
    <div class="row">
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">
                <?
                if ($_SESSION['block_frez'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Фрезировки</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_frez_Step2.php?id=<?= $id ?>&block_frez=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Фрезировки</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_frez_Step2.php?id=<?= $id ?>&block_frez=on">Добавить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd"
                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </a>
                    <?
                }
                ?>
            </div>
        </center>
    </div>
    <br>
    <?
    if ($_SESSION['block_frez'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_frez_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_frez" name="cnt_order_frez"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_frez'] ?>">
                        <button type="submit" class="btn btn-outline-primary" style="width: 100px;">шт</button>
                    </div>
                </form>
            </center>
        </div>

        <div class="table">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="50">Номер</th>
                    <th width="230">Фрезеровка</th>
                    <th width="500">Описание характеристик заявки</th>
                    <th width="500">Загрузить Файлы</th>
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

                    ?>
                    <form name="block_frez<?= $i + 1 ?>" id="block_frez<?= $i + 1 ?>" method="post"
                          action="FormOrd_frez_Step2.php?id=<?= $id ?>"
                          enctype="multipart/form-data">
                        <tr>
                            <td>
                                <center>
                                    <input name="id" id="id" class="id form-control"
                                           style=" width: 50px; text-align: center" type="text" disabled
                                           value="<?= $i + 1; ?>">
                                </center>
                                <br>
                                <br>
                                <div class="container">
                                    <a href="FormOrd_frez_Step2.php?id=<?= $id ?>&cnt_order_frez=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_frez" value="1">
                                <input type="hidden" name="order_num" value="<?= $i + 1 ?>">
                                <div class="input-group input-group mb-3">
                                    <span class="input-group-text" style="width: 70px; text-align: left;"
                                          id="inputGroup-sizing">Дата</span>
                                    <input type="date" class="form-control" name="date" required
                                           value="<?= $_SESSION[$dateValue]; ?>"
                                           min="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="input-group input-group mb-3" style="text-align: left">
                                    <span class="input-group-text" id="inputGroup-sizing"
                                          style="width: 70px; text-align: left;">Время</span>
                                    <input class="form-control" type="time" name="time"
                                           value="<?= $_SESSION[$timeValue] ?>">
                                </div>
                            </td>
                            <td>
                                <center>
                                    <div class="row" style="width: 450px;">
                                        <script>
                                            function get<?=$i + 1?>() {
                                                let data1 = block_frez<?=$i + 1?>.select_material<?=$i + 1?>[block_frez<?=$i + 1?>.select_material<?=$i + 1?>.selectedIndex].text;
                                                console.log(data1);
                                                let data = block_frez<?=$i + 1?>.select_material<?=$i + 1?>[block_frez<?=$i + 1?>.select_material<?= $i + 1 ?>.selectedIndex].text;
                                                console.log(data);
                                                switch (data) {
                                                    case "ПВХ (мягкий)" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="">Не выбрано</option>' +
                                                            '<option value="1">1</option>' +
                                                            '<option value="2">2</option>' +
                                                            '<option value="3">3</option>' +
                                                            '<option value="4">4</option>' +
                                                            '<option value="5">5</option>' +
                                                            '<option value="6">6</option>' +
                                                            '<option value="8">8</option>' +
                                                            '<option value="10">10</option>'
                                                        )
                                                        break;
                                                    case "ПВХ (твёрдый)" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="1" selected>1</option>'
                                                        )
                                                        break;
                                                    case "Орг. Стекло (прозрачное)" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="">Не выбрано</option>' +
                                                            '<option value="1">1</option>' +
                                                            '<option value="1,5" >1,5</option>' +
                                                            '<option value="2">2</option>' +
                                                            '<option value="3">3</option>' +
                                                            '<option value="4">4</option>' +
                                                            '<option value="5">5</option>' +
                                                            '<option value="6">6</option>' +
                                                            '<option value="8">8</option>' +
                                                            '<option value="10">10</option>'
                                                        )
                                                        break;
                                                    case "Орг. Стекло (молочное)" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="">Не выбрано</option>' +
                                                            '<option value="1">1</option>' +
                                                            '<option value="1,5" >1,5</option>' +
                                                            '<option value="2">2</option>' +
                                                            '<option value="3">3</option>' +
                                                            '<option value="4">4</option>' +
                                                            '<option value="5">5</option>' +
                                                            '<option value="6">6</option>' +
                                                            '<option value="8">8</option>' +
                                                            '<option value="10">10</option>'
                                                        )
                                                        break;
                                                    case "Орг. Стекло (цветное)" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="3" selected>3</option>'
                                                        )
                                                        break;

                                                    case "ПЭТ" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="">Не выбрано</option>' +
                                                            '<option value="0,3">0,3</option>' +
                                                            '<option value="0,5" >0,5</option>' +
                                                            '<option value="0,75">0,75</option>' +
                                                            '<option value="1">1</option>' +
                                                            '<option value="2">2</option>'
                                                        )
                                                        break;
                                                    case "Композит" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = ('<option value="">Не выбрано</option>' +
                                                            '<option value="3" >3</option>' +
                                                            '<option value="4">4</option>'
                                                        )
                                                        break;
                                                    case "Фанера" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = (
                                                            '<option value="">Не выбрано</option>' +
                                                            '<option value="4">4</option>' +
                                                            '<option value="5" >5</option>' +
                                                            '<option value="6">6</option>' +
                                                            '<option value="8">8</option>' +
                                                            '<option value="9">9</option>' +
                                                            '<option value="10">10</option>' +
                                                            '<option value="12">12</option>' +
                                                            '<option value="15">15</option>' +
                                                            '<option value="18">18</option>' +
                                                            '<option value="21">21</option>'
                                                        )
                                                        break;
                                                    case "Поликарбонат литой" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = (
                                                            '<option value="т.з">Указывается в т.з.</option>'
                                                        )
                                                        break;
                                                    case "Другое" :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = (
                                                            '<option value="т.з">Указывается в т.з.</option>'
                                                        )
                                                        break;
                                                    default :
                                                        document.getElementById("thickness<?=$i + 1?>").innerHTML = (
                                                            '<option value="">Выберите материал</option>'
                                                        )
                                                        break;
                                                }
                                            }
                                        </script>
                                        <div class="col" style="width: 220px;">
                                            <div class="input-group">
                                                <input class="form-control" style="text-align: center" disabled
                                                       value="Материал">
                                            </div>
                                            <div class="input-group">
                                                <select class="form-select" id=select_material<?= $i + 1 ?>
                                                        name="select_material"
                                                        required style="width: 200px; text-align: left"
                                                        onchange="get<?= $i + 1 ?>()">
                                                    <?

                                                    if (isset($_SESSION[$select_material])) {
                                                        ?>
                                                        <option value="<?= $_SESSION[$select_material] ?>"><?= $_SESSION[$select_material] ?>
                                                        </option>
                                                        <?
                                                    }
                                                    ?>
                                                    <option value="">Не выбрано</option>
                                                    <option value="ПВХ (мягкий)">ПВХ (мягкий)</option>
                                                    <option value="ПВХ (твёрдый)">ПВХ (твёрдый)</option>
                                                    <option value="Орг. Стекло (прозрачное)">Орг. Стекло (прозрачное)
                                                    </option>
                                                    <option value="Орг. Стекло (цветное)">Орг. Стекло (цветное)</option>
                                                    <option value="Орг. Стекло (молочное)">Орг. Стекло (молочное)
                                                    </option>
                                                    <option value="ПЭТ">ПЭТ</option>
                                                    <option value="Композит">Композит</option>
                                                    <option value="Фанера">Фанера</option>
                                                    <option value="Поликарбонат литой">Поликарбонат литой</option>
                                                    <option value="Другое">Другое</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col" style="width: 220px;">
                                            <div class="input-group" style="width: 200px;">
                                                <input class="form-control" style="text-align: center" disabled
                                                       value="Толщина (мм)">
                                            </div>
                                            <div class="input-group" style="width: 200px;">
                                                <select class="form-select" name="select_thickness"
                                                        id="thickness<?= $i + 1 ?>"
                                                        required>
                                                    <?
                                                    if (isset($_SESSION[$select_thickness])) {
                                                        ?>
                                                        <option value="<?= $_SESSION[$select_thickness] ?>"><?= $_SESSION[$select_thickness] ?>
                                                        </option>
                                                        <?
                                                    }
                                                    ?>
                                                    <option value="">Выберите материал</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </center>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="5"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $file_cnt;
                                if (is_dir($FILE_ID)) {
                                    $file_cnt = scandir($FILE_ID);
                                    if (count($file_cnt) == 2) {
                                        $file_cnt = 0;
                                    }
                                } else {
                                    $file_cnt = 0;
                                }
                                if ($file_cnt == 0) {
                                    ?>
                                    <input class="form-control btn btn-outline-dark btn-sm" type="file" name="files[]"
                                           multiple>
                                    <br> <br>
                                    <h6>ОБЯЗАТЕЛЬНО СОХРАНИТЬ!</h6>
                                    <button type="submit" class="save btn btn-outline-primary btn-sm"
                                            style="width: 250px">
                                        Сохранить заявку
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-file-earmark-arrow-up-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
                                        </svg>
                                    </button>
                                    <?
                                } else {
                                    echo "<h6>Список загруженых файлов:</h6>";
                                    $z = $i + 1;
                                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $z;
                                    $scan_dir = scandir($FILE_ID);
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_frez_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=frez">
                                                    Удалить все
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-x-octagon-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <?
                                            for ($l = 2; $l < count($scan_dir); $l++) {
                                                ?>

                                                <div class="input-group input-group-sm"
                                                     style="width: 200px;">
                                                    <input class="form-control" disabled value="  <?= $l - 1 ?>">
                                                    <input type="text" style="width: 100px;  text-align: center;"
                                                           class="form-control"
                                                           value="<?= $scan_dir[$l] ?>"
                                                           disabled>
                                                    <a class="btn btn-outline-danger"
                                                       href="FormOrd_frez_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=frez">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-x-octagon-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                                        </svg>
                                                    </a>
                                                </div>


                                                <?
                                            }
                                            ?>
                                        </div>
                                        <div class="col">
                                            <h6>Добавить файлы</h6>
                                            <input class="btn btn-outline-dark btn-sm" type="file" name="files[]"
                                                   style="width: 131px;"
                                                   multiple>
                                            <br>
                                            <br>
                                            <h6>ОБЯЗАТЕЛЬНО СОХРАНИТЬ</h6>
                                            <h6>ПРИ ДОБАВЛЕНИИ ФАЙЛОВ!</h6>
                                            <br>
                                            <button type="submit" class="save btn btn-success active btn-sm"
                                                    style="width: 250px">
                                                Сохранить заявку повторно
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-file-earmark-arrow-up-fill"
                                                     viewBox="0 0 16 16">
                                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
                                                </svg>
                                            </button>
                                        </div>

                                    </div>

                                    <?
                                }
                                ?>
                            </td>
                        </tr>
                    </form>
                    <?
                }
                ?>
            </table>
            <br>
        </div>
        <?
    }
    ?>
</div><? //Блок Фрезировки?>


<div class="container mt-1">
    <br>
    <div class="row">
        <a class="btn btn-outline-success btn-lg" href="Script/Script_Form.php?id=<?= $id ?>">
            Предпросмотр ввода
            заявок в систему</a>
    </div>
    <br>
    <br>
    <br>
</div><? //Ввод заявок в систему?>


</body>
</html>