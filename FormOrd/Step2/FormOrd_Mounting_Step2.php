<?php
require "../../config/config.php";
require "../../config/auth.php";

session_start();

$id = $_GET['id'];
$cnt = $_POST['cnt'];
$cnt_order = $_POST['cnt_order'];
if (empty($cnt)) {
    $cnt_order = 1;
}
if ($cnt == "plus") {
    $cnt_order = $cnt_order + 1;
}
if ($cnt == "minus") {
    if ($cnt_order > 1) {
        $cnt_order = $cnt_order - 1;
    }
}
if ($_GET['step1'] == 1) {
    $_SESSION['company'] = $_POST['company'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['Full_name'] = $_POST['Full_name'];
    $_SESSION['number'] = $_POST['number'];
    $_SESSION['Full_name_2'] = $_POST['Full_name_2'];
    $_SESSION['number_2'] = $_POST['number_2'];
}

$save = $_GET['save'];

?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Создание заявки </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="Step2.css">
</head>
<body>

<div class="container mt-5  ">
    <div class="row">
        <div class="col" style="text-align: left">
            <h1>Заявка на монтаж</h1>
        </div>
        <div class="col" style="text-align: right">
            <form method="post" action="../FormOrd_Mounting.php?id=<?= $id ?>">
                <button type="submit" class="btn btn-danger btn-sm">Назад К Шагу №1</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-1">
    <div class="name">
        <fieldset class="step_1" disabled>
            <form action="FormOrd_Mounting_Step2.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="row">
                    <div class="col">
                        <h5>Заказчик</h5>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="company" id="company" required
                               value="<?= $_SESSION['company'] ?>" autocomplete="on">
                    </div>
                </div>
            </form>
        </fieldset>
        <br>
        <div class="row">
            <div class="col">
                <h5>Количество заявок</h5>
            </div>
            <div class="col">
                <div class="row">
                    <form method="post" action="FormOrd_Mounting_Step2.php?id=<?= $id ?>" style="width: 65px;">
                        <input type="hidden" name="company" value="<?= $_SESSION['company'] ?>">
                        <input type="hidden" name="cnt" value="plus">
                        <input type="hidden" name="cnt_order" value="<?= $cnt_order ?>">
                        <button type="submit" class="btn btn-success btn-sm" style="width: 40px; height: 38px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                            </svg>
                        </button>
                    </form>
                    <input style="width: 80px; text-align: center;" type="text" class="form-control"
                           value="<?= $cnt_order ?>"
                           disabled="disabled">
                    <form method="post" action="FormOrd_Mounting_Step2.php?id=<?= $id ?>" style="width: 50px;">
                        <input type="hidden" name="company" value="<?= $_SESSION['company'] ?>">
                        <input type="hidden" name="cnt" value="minus">
                        <input type="hidden" name="cnt_order" value="<?= $cnt_order ?>">
                        <button type="submit" class="btn btn-danger btn-sm" style="width: 40px; height: 38px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                            </svg>
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="step2">
            <div class="table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="30">Номер</th>
                        <th width="250">Адрес места монтажа</th>
                        <th width="190">Дата монтажа</th>
                        <th width="150">Время монтажа</th>
                        <th>Описание</th>
                        <th width="160">Загрузить Файлы</th>
                    </tr>
                    </thead>
                    <?
                    for ($i = 0; $i < $cnt_order; $i++) {
                        ?>
                        <tr>
                            <td>
                                <?= $i + 1 ?>
                                <form method="post" action="FormOrd_Mounting_Step2.php">
                                    <button type="submit" class="btn-success btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                </form>
                                <form method="post" action="FormOrd_Mounting_Step2.php">
                                    <button type="submit" class="btn-danger btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </button>
                                </form>

                            </td>
                            <form method="post" action="../Script/Script_Form.php?id=<?= $id ?>&techTask=Монтаж">
                                <td>
                                    <textarea class="form-control" name="address" id="address" required
                                              placeholder="Пример: г. Калининград, Ленинский проспект 16"
                                              autocomplete="on"
                                              rows="4"></textarea>
                                </td>
                                <td>
                                    <input class="form-control" type="date" required name="date" id="date"
                                           autocomplete="off">
                                </td>
                                <td>
                                    <input class="form-control" type="time" name="time" id="time" autocomplete="off">
                                </td>
                                <td>
                                    <textarea class="form-control" name="techtask" id="techtask" required
                                              placeholder="Описание Технического Задания" autocomplete="off"
                                              rows="4"></textarea>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="filename" required
                                           id="inputGroupFile02" multiple>
                                    <br>
                                    <button type="submit" class="btn-primary btn-sm" style="width: 150px">
                                        Сохранить
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-file-earmark-arrow-up-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
                                        </svg>
                                    </button>
                                </td>
                            </form>
                        </tr>
                    <? } ?>
                </table>
                <br>
                <button style="width: 900px;" type="submit" class="btn btn-success btn-sm btn-block">
                    <?
                    if ($cnt_order > 1) {
                        ?>Оформить завки<?
                    } else {
                        ?>Оформить заявку<?
                    }
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>