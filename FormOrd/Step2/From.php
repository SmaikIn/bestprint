<?php
require "../../config/config.php";
require "../../config/auth.php";
//require "Script/global_settings.php";
session_start();
$id = $_GET['id'];/*
echo "<pre>";
var_dump($_SESSION);
echo "<br>";
var_dump($_FILES);
echo "</pre>";*/
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
                if ($_SESSION['block_print'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Печати</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_print=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Печати</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_print=on">Добавить
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
    if ($_SESSION['block_print'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_print" name="cnt_order_print"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_print'] ?>">
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
                    <th width="250">Дата и время</th>
                    <th width="450">Описание характеристик заявки</th>
                    <th width="550">Загрузить Файлы</th>
                </tr>
                </thead>
                <?
                for ($i = 0; $i < $_SESSION['cnt_order_print']; $i++) {
                    $j = $i + 1;
                    $dateValue = "";
                    $dateValue = $dateValue . $j;
                    $dateValue = $dateValue . " date print_order";
                    $timeValue = "";
                    $timeValue = $timeValue . $j;
                    $timeValue = $timeValue . " time print_order";
                    $techtaskValue = "";
                    $techtaskValue = $techtaskValue . $j;
                    $techtaskValue = $techtaskValue . " techtask print_order";

                    ?>
                    <form id="upload_form" name="block_print" method="post" enctype="multipart/form-data">
                        <tr>
                            <td>
                                <center>
                                    <input class="form-control" style=" width: 50px; text-align: center" type="text"
                                           value="<?= $j ?>" name="ord"
                                           id="<?= "print_id_ord_" . $j ?>"
                                           disabled>
                                    <br>
                                    <a class="btn btn-outline-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <div class="row">
                                        <div class="input-group input-group mb-3" style="width: 240px;">
                                    <span class="input-group-text" style="width: 70px; text-align: left;"
                                          id="inputGroup-sizing">Дата</span>
                                            <input type="date" class="form-control" name="date" required
                                                   value="<?= $_SESSION[$dateValue] ?>" id="<?= "print_date_" . $j ?>"
                                                   min="<?= date('Y-m-d') ?>">
                                        </div>
                                        <br>
                                        <div class="input-group input-group mb-3" style="width: 240px;">
                                    <span class="input-group-text" style="width: 70px; text-align: left;"
                                          id="inputGroup-sizing">Время</span>
                                            <input type="time" class="form-control" name="time"
                                                   value="<?= $_SESSION[$timeValue] ?>" id="<?= "print_time_" . $j ?>"
                                                   min="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <div class="row">
                                     <textarea class="form-control" name="techtask" id="<?= "print_techtask_" . $j ?>"
                                               required
                                               placeholder="Описание Технического Задания" autocomplete="off"
                                               rows="5"><?= $_SESSION[$techtaskValue] ?></textarea>
                                    </div>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <div class="row" style="width: 450px;">
                                        <input class="form-control" type="file" name="file[]"
                                               id="<?= "print_file_" . $j ?>" multiple>
                                    </div>
                                    <br>
                                    <div class="row"
                                         style="width: 450px; text-align: center;display: flex; justify-content: center; align-items: center;">
                                        <button style="width: 450px;"
                                                class="btn btn-outline-primary btn" onclick="uploadFile()"
                                                id="<?= "print_upload_" . $j ?>">Сохранить
                                            заявку
                                        </button>
                                    </div>
                                </center>
                            </td>
                            <script>
                                function _(el) {
                                    return document.getElementById(el);
                                }

                                function uploadFile() {
                                    var file = _("<?= "print_file_" . $j ?>").files[0];
                                    console.log(file);
                                    var name = _("name").value;
                                    // alert(file.name+" | "+file.size+" | "+file.type);
                                    var formdata = new FormData();
                                    formdata.append("file", file);
                                    formdata.append("name", name);
                                    var ajax = new XMLHttpRequest();
                                    ajax.upload.addEventListener("progress", progressHandler, false);
                                    ajax.addEventListener("load", completeHandler, false);
                                    ajax.addEventListener("error", errorHandler, false);
                                    ajax.addEventListener("abort", abortHandler, false);
                                    ajax.open("POST", "Form_Upload.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
                                    //use file_upload_parser.php from above url
                                    ajax.send(formdata);
                                }

                                function progressHandler(event) {
                                    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
                                    var percent = (event.loaded / event.total) * 100;
                                    _("progressBar").value = Math.round(percent);
                                    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                                }

                                function completeHandler(event) {
                                    _("status").innerHTML = event.target.responseText;
                                    _("progressBar").value = 0; //wil clear progress bar after successful upload
                                }

                                function errorHandler(event) {
                                    _("status").innerHTML = "Upload Failed";
                                }

                                function abortHandler(event) {
                                    _("status").innerHTML = "Upload Aborted";
                                }
                            </script>
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
</div><? //Блок Печати?>


<div class="container mt-1">
    <br>
    <div class="row">
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">

                <?
                if ($_SESSION['block_print'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Печати</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_print=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Печати</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_print=on">Добавить
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
    if ($_SESSION['block_print'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_print" name="cnt_order_print"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_print'] ?>">
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
                    <th width="100">Дата и время</th>
                    <th width="600">Описание характеристик заявки</th>
                    <th width="550">Загрузить Файлы</th>
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

                    ?>
                    <form name="block_print" method="post" action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_print=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_print" value="1">
                                <input type="hidden" name="order_num" value="<?= $i + 1 ?>">
                                <input type="hidden" name="cnt_order" value="<?= $i ?>">
                                <input class="form-control" type="date" name="date" required
                                       value="<?= $_SESSION[$dateValue]; ?>"
                                       min="<?= date('Y-m-d') ?>">
                                <br>
                                <input class="form-control" type="time" name="time"
                                       value="<?= $_SESSION[$timeValue] ?>">
                            </td>
                            <td>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="5"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $file_cnt;
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
                                       id="<?
                                       $a = $i + 1;
                                       $a = "file" . $a;
                                       echo $a;
                                       ?>" multiple>
                                <br>
                                <br>
                                    <progress id="<? $a = $i + 1;
                                    $a = "progressBar" . $a;
                                    echo $a; ?>" value="0" max="100" style="width:300px;"></progress>
                                    <h3 id="<? $a = $i + 1;
                                    $a = "status" . $a;
                                    echo $a; ?>"></h3>
                                    <p id="<? $a = $i + 1;
                                    $a = "loaded_n_total" . $a;
                                    echo $a; ?>"></p>
                                    <script>
                                        function _(el) {
                                            return document.getElementById(el);
                                        }

                                        function uploadFile() {
                                            var file = _("file<?=$i + 1?>").files[0];
                                            // alert(file.name+" | "+file.size+" | "+file.type);
                                            var formdata = new FormData();
                                            formdata.append("file<?=$i + 1?>", file);
                                            var ajax = new XMLHttpRequest();
                                            ajax.upload.addEventListener("progress", progressHandler, false);
                                            ajax.addEventListener("load", completeHandler, false);
                                            ajax.addEventListener("error", errorHandler, false);
                                            ajax.addEventListener("abort", abortHandler, false);
                                            ajax.open("POST", "Script/global_settings.php");
                                            //use file_upload_parser.php from above url
                                            ajax.send(formdata);
                                        }

                                        function progressHandler(event) {
                                            _("loaded_n_total<?=$i + 1?>").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
                                            var percent = (event.loaded / event.total) * 100;
                                            _("progressBar<?=$i + 1?>").value = Math.round(percent);
                                            _("status<?=$i + 1?>").innerHTML = Math.round(percent) + "% загружено... ожидайте";
                                        }

                                        function completeHandler(event) {
                                            _("status<?=$i + 1?>").innerHTML = event.target.responseText;
                                            _("progressBar<?=$i + 1?>").value = 0; //wil clear progress bar after successful upload
                                        }

                                        function errorHandler(event) {
                                            _("status<?=$i + 1?>").innerHTML = "Upload Failed";
                                        }

                                        function abortHandler(event) {
                                            _("status<?=$i + 1?>").innerHTML = "Upload Aborted";
                                        }
                                    </script>
                                <br> <br>
                                    <h6>ОБЯЗАТЕЛЬНО СОХРАНИТЬ!</h6>
                                    <button type="submit" class="save btn btn-outline-primary btn-sm"
                                            onclick="uploadFile()"
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
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $z;
                                $scan_dir = scandir($FILE_ID);
                                ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=print">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=print">
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
</div><? //Блок Печати?>
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
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_frez=off">Удалить
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
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_frez=on">Добавить
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
                <form method="get" action="FormOrd_Combined_Step2.php">
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
                          action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_frez=delete&order_num=<?= $i + 1 ?>"
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
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=frez">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=frez">
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
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">

                <?
                if ($_SESSION['block_process'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Обработки</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_process=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Обработки</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_process=on">Добавить
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
    if ($_SESSION['block_process'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_process" name="cnt_order_process"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_process'] ?>">
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
                    <th width="100">Дата и время</th>
                    <th width="600">Описание характеристик заявки</th>
                    <th width="550">Загрузить Файлы</th>
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

                    ?>
                    <form method="post" action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_process=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_process" value="1">
                                <input type="hidden" name="order_num" value="<?= $i + 1 ?>">
                                <input class="form-control" type="date" name="date"
                                       value="<?= $_SESSION[$dateValue]; ?>" required
                                       min="<?= date('Y-m-d') ?>">
                                <br>
                                <input class="form-control" type="time" name="time"
                                       value="<?= $_SESSION[$timeValue] ?>">
                            </td>
                            <td>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="5"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $file_cnt;
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
                                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $z;
                                    $scan_dir = scandir($FILE_ID);
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=process">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=process">
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
</div><? //Блок Обработки?>
<div class="container mt-1">
    <br>
    <div class="row">
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">

                <?
                if ($_SESSION['block_poligrafy'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Полиграфии</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_poligrafy=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Полиграфии</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_poligrafy=on">Добавить
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
    if ($_SESSION['block_poligrafy'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_poligrafy" name="cnt_order_poligrafy"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_poligrafy'] ?>">
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
                    <th width="100">Дата и время</th>
                    <th width="600">Описание характеристик заявки</th>
                    <th width="550">Загрузить Файлы</th>
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

                    ?>
                    <form name="block_poligrafy" method="post" action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_poligrafy=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_poligrafy" value="1">
                                <input type="hidden" name="order_num" value="<?= $i + 1 ?>">
                                <input class="form-control" type="date" name="date" required
                                       value="<?= $_SESSION[$dateValue]; ?>"
                                       min="<?= date('Y-m-d') ?>">
                                <br>
                                <input class="form-control" type="time" name="time"
                                       value="<?= $_SESSION[$timeValue] ?>">
                            </td>
                            <td>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="5"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $file_cnt;
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
                                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $z;
                                    $scan_dir = scandir($FILE_ID);
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=poligrafy">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=poligrafy">
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
</div><? //Блок Полиграфии?>
<div class="container mt-1">
    <br>
    <div class="row">
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">

                <?
                if ($_SESSION['block_montage'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Монтажа</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_montage=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Монтажа</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_montage=on">Добавить
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
    if ($_SESSION['block_montage'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_montage" name="cnt_order_montage"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_montage'] ?>">
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
                    <th width="250">Монтаж</th>
                    <th width="400">Техническое задание</th>
                    <th width="550">Загрузить Файлы</th>
                </tr>
                </thead>
                <?
                for ($i = 0; $i < $_SESSION['cnt_order_montage']; $i++) {
                    $j = $i + 1;
                    $pointValue = "";
                    $pointValue = $pointValue . $j;
                    $pointValue = $pointValue . " point montage_order";
                    $dateValue = "";
                    $dateValue = $dateValue . $j;
                    $dateValue = $dateValue . " date montage_order";
                    $timeValue = "";
                    $timeValue = $timeValue . $j;
                    $timeValue = $timeValue . " time montage_order";
                    $techtaskValue = "";
                    $techtaskValue = $techtaskValue . $j;
                    $techtaskValue = $techtaskValue . " techtask montage_order";
                    ?>
                    <form name="block_montage" method="post" action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_montage=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>

                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_montage" value="1">
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
                                <div class="input-group">
                                    <span class="input-group-text" style="width: 70px;">Адрес</span>
                                    <textarea class="form-control" name="point" id="point"
                                              placeholder="Пример: г. Калининград, Ленинский проспект 16"
                                              autocomplete="off" required
                                              rows="4"><?= $_SESSION[$pointValue] ?></textarea>
                                </div>
                            </td>
                            <td>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="8"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $file_cnt;
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
                                    <button type="submit" class="save btn btn-outline-primary btn"
                                            style="width: 250px">
                                        Сохранить заявку
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-file-earmark-arrow-up-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
                                        </svg>
                                    </button>
                                    <?
                                } else {
                                    echo "<h6>Список загруженых файлов:</h6>";
                                    $z = $i + 1;
                                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $z;
                                    $scan_dir = scandir($FILE_ID);
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=montage">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=montage">
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
</div><? //Блок Монтажа?>
<div class="container mt-1">
    <br>
    <div class="row">
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">

                <?
                if ($_SESSION['block_zav'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Замеров</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_zav=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Замеров</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_zav=on">Добавить
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
    if ($_SESSION['block_zav'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_zav" name="cnt_order_zav"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_zav'] ?>">
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
                    <th width="250">Замеры</th>
                    <th width="400">Техническое задание</th>
                    <th width="550">Загрузить Файлы</th>
                </tr>
                </thead>
                <?
                for ($i = 0; $i < $_SESSION['cnt_order_zav']; $i++) {
                    $j = $i + 1;
                    $pointValue = "";
                    $pointValue = $pointValue . $j;
                    $pointValue = $pointValue . " point zav_order";
                    $dateValue = "";
                    $dateValue = $dateValue . $j;
                    $dateValue = $dateValue . " date zav_order";
                    $timeValue = "";
                    $timeValue = $timeValue . $j;
                    $timeValue = $timeValue . " time zav_order";
                    $techtaskValue = "";
                    $techtaskValue = $techtaskValue . $j;
                    $techtaskValue = $techtaskValue . " techtask zav_order";
                    ?>
                    <form name="block_zav" method="post" action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_zav=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>

                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_zav" value="1">
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
                                <div class="input-group">
                                    <span class="input-group-text" style="width: 70px;">Адрес</span>
                                    <textarea class="form-control" name="point" id="point"
                                              placeholder="Пример: г. Калининград, Ленинский проспект 16"
                                              autocomplete="off" required
                                              rows="4"><?= $_SESSION[$pointValue] ?></textarea>
                                </div>
                            </td>
                            <td>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="8"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $file_cnt;
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
                                    <button type="submit" class="save btn btn-outline-primary btn"
                                            style="width: 250px">
                                        Сохранить заявку
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-file-earmark-arrow-up-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
                                        </svg>
                                    </button>
                                    <?
                                } else {
                                    echo "<h6>Список загруженых файлов:</h6>";
                                    $z = $i + 1;
                                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $z;
                                    $scan_dir = scandir($FILE_ID);
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=zav">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=zav">
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
</div><? //Блок Замеры?>
<div class="container mt-1">
    <br>
    <div class="row">
        <center>
            <div class="btn-group" role="group" aria-label="Basic mixed styles example" style="width: 600px;">

                <?
                if ($_SESSION['block_delivery'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Доставки</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_delivery=off">Удалить
                        блок
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </a>

                    <?
                } else {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;" disabled>Блок Доставки</button>
                    <a class="btn btn-outline-success btn-lg"
                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&block_delivery=on">Добавить
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
    if ($_SESSION['block_delivery'] == "on") {
        ?>
        <div class="row">
            <center>
                <form method="get" action="FormOrd_Combined_Step2.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="input-group" role="group" aria-label="Basic example"
                         style="width: 400px;">
                        <a class="btn btn-dark" style="width: 200px;">Количество заявок</a>
                        <input type="number" class="form-control" id="cnt_order_delivery" name="cnt_order_delivery"
                               min="1" max="100"
                               style="text-align: center; width: 100px;"
                               value="<?= $_SESSION['cnt_order_delivery'] ?>">
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
                    <th width="250">Доставка</th>
                    <th width="400">Техническое задание</th>
                    <th width="550">Загрузить Файлы</th>
                </tr>
                </thead>
                <?
                for ($i = 0; $i < $_SESSION['cnt_order_delivery']; $i++) {
                    $j = $i + 1;
                    $pointValue = "";
                    $pointValue = $pointValue . $j;
                    $pointValue = $pointValue . " point delivery_order";
                    $dateValue = "";
                    $dateValue = $dateValue . $j;
                    $dateValue = $dateValue . " date delivery_order";
                    $timeValue = "";
                    $timeValue = $timeValue . $j;
                    $timeValue = $timeValue . " time delivery_order";
                    $techtaskValue = "";
                    $techtaskValue = $techtaskValue . $j;
                    $techtaskValue = $techtaskValue . " techtask delivery_order";
                    ?>
                    <form name="block_delivery" method="post" action="FormOrd_Combined_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_Combined_Step2.php?id=<?= $id ?>&cnt_order_delivery=delete&order_num=<?= $i + 1 ?>"
                                       class="btn btn-outline-danger btn-sm ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>

                                    </a>
                                </div>

                            </td>
                            <td>
                                <input type="hidden" name="save_delivery" value="1">
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
                                <div class="input-group">
                                    <span class="input-group-text" style="width: 70px;">Адрес</span>
                                    <textarea class="form-control" name="point" id="point"
                                              placeholder="Пример: г. Калининград, Ленинский проспект 16"
                                              autocomplete="off" required
                                              rows="4"><?= $_SESSION[$pointValue] ?></textarea>
                                </div>
                            </td>
                            <td>
                                <textarea class="form-control" name="techtask" id="techtask" required
                                          placeholder="Описание Технического Задания" autocomplete="off"
                                          rows="8"><?= $_SESSION[$techtaskValue] ?></textarea>
                            </td>
                            <td>
                                <?
                                $file_cnt = $i + 1;
                                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $file_cnt;
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
                                    <button type="submit" class="save btn btn-outline-primary btn"
                                            style="width: 250px">
                                        Сохранить заявку
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-file-earmark-arrow-up-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
                                        </svg>
                                    </button>
                                    <?
                                } else {
                                    echo "<h6>Список загруженых файлов:</h6>";
                                    $z = $i + 1;
                                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $z;
                                    $scan_dir = scandir($FILE_ID);
                                    ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group" style="width: 200px; text-align: center; ">
                                                <a class="btn btn-outline-danger btn-sm" style="width: 200px;"
                                                   href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=delivery">
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
                                                       href="FormOrd_Combined_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=delivery">
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
</div><? //Блок Доставки?>

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