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
                if ($_SESSION['block_poligrafy'] == "on") {
                    ?>
                    <button class="btn btn-dark btn-lg" style="width: 400px;">Блок Полиграфии</button>
                    <a class="btn btn-outline-danger btn-lg"
                       href="FormOrd_poligrafy_Step2.php?id=<?= $id ?>&block_poligrafy=off">Удалить
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
                       href="FormOrd_poligrafy_Step2.php?id=<?= $id ?>&block_poligrafy=on">Добавить
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
                <form method="get" action="FormOrd_poligrafy_Step2.php">
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
                    <form name="block_poligrafy" method="post" action="FormOrd_poligrafy_Step2.php?id=<?= $id ?>"
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
                                    <a href="FormOrd_poligrafy_Step2.php?id=<?= $id ?>&cnt_order_poligrafy=delete&order_num=<?= $i + 1 ?>"
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
                                                   href="FormOrd_poligrafy_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=all&file_type=poligrafy">
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
                                                       href="FormOrd_poligrafy_Step2.php?id=<?= $id ?>&file_ord=<?= $i + 1 ?>&file_num=<?= $l ?>&file_type=poligrafy">
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