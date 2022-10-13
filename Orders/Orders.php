<?php
require('../config/config.php');
require('../config/auth.php');
$id = $_GET['id'];
$time = date('d-m-Y');
$query = mysqli_query($connect, "SELECT `catID` FROM `users` WHERE id = '$id'");
$query = mysqli_fetch_all($query);
$catId = $query[0][0];
$query = mysqli_query($connect, "SELECT `name` FROM `category` WHERE id = '$catId'");
$query = mysqli_fetch_all($query);
$poswork = $query[0][0];
require('filter/filter.php');
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список заявок</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<div class="container mt-1">
    <div class="row" style="text-align: center">
        <h1>Список заявок</h1>
    </div>
</div>
<?php
switch ($poswork) {
case "Менеджер":
    ?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <h4>Менеджер</h4>
                        <?
                        $sql_manager = "SELECT id, name FROM users WHERE catid = 2 or catid = 1";
                        $sql_manager = mysqli_query($connect, $sql_manager);
                        $sql_manager = mysqli_fetch_all($sql_manager);
                        $sql_now_manager = "SELECT name FROM users WHERE id = " . $id;
                        $sql_now_manager = mysqli_query($connect, $sql_now_manager);
                        $sql_now_manager = mysqli_fetch_all($sql_now_manager);
                        ?>
                        <select class="form-select" name="Manager" required>
                            <?
                            $a = 0;
                            $k = 0;
                            foreach ($sql_manager as $sql_manager) {
                                $option = "<option ";
                                if (empty($_GET['Manager'])) {
                                    if ($sql_manager[0] == $id) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                } else {
                                    if ($sql_manager[0] == $_GET['Manager']) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                }
                            }
                            ?>
                            <option <? if ($a == 0) {
                                echo "selected ";
                            } ?> value="ALL_Manager">Все менеджеры
                            </option>
                        </select>
                        <br>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input montage" type="checkbox" role="switch" <?
                            if (isset($_GET['montage']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="montage"
                                   id="montage">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="montage">Монтаж</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input process" type="checkbox" role="switch" <?
                            if (isset($_GET['process']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="process"
                                   id="process">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="process">Сборка и обработка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input delivery" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['delivery']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="delivery"
                                   id="delivery">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="delivery">Доставка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input measurements" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['measurements']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="measurements"
                                   id="measurements">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="measurements">Замеры</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input poligrafy" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['poligrafy']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="poligrafy"
                                   id="poligrafy">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="poligrafy">Полиграфия</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input print" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['print']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="print"
                                   id="print">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="print">Печать</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input frez" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['frez']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="frez"
                                   id="frez">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="frez">Фрезеровка</label>
                        </div>

                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.montage').checked = true;
                                    document.querySelector('.process').checked = true;
                                    document.querySelector('.delivery').checked = true;
                                    document.querySelector('.measurements').checked = true;
                                    document.querySelector('.poligrafy').checked = true;
                                    document.querySelector('.frez').checked = true;
                                    document.querySelector('.print').checked = true;
                                } else {
                                    document.querySelector('.montage').checked = false;
                                    document.querySelector('.process').checked = false;
                                    document.querySelector('.delivery').checked = false;
                                    document.querySelector('.measurements').checked = false;
                                    document.querySelector('.poligrafy').checked = false;
                                    document.querySelector('.frez').checked = false;
                                    document.querySelector('.print').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.poligrafy').forEach((element) => {
                                element.onclick = poligrafyFunction;
                            });

                            function poligrafyFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.frez').forEach((element) => {
                                element.onclick = frezFunction;
                            });

                            function frezFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.print').forEach((element) => {
                                element.onclick = printFunction;
                            });

                            function printFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.process').forEach((element) => {
                                element.onclick = processFunction;
                            });

                            function processFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.delivery').forEach((element) => {
                                element.onclick = deliveryFunction;
                            });

                            function deliveryFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.measurements').forEach((element) => {
                                element.onclick = measurementsFunction;
                            });

                            function measurementsFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">
                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="150">Вид</th>
                            <th width="150">Заказчик</th>
                            <th width="150">Дата</th>
                            <th width="100">Менеджер</th>
                            <th width="150">Статус</th>
                            <th width="200"></th>
                        </tr>
                        </thead>
                        <?


                        foreach ($query as $query) {


                            ?>
                            <tr <? if ($query[7] == -1) {
                                ?>
                                style="background: #bea8ec"
                                <?
                                mysqli_query($connect, "UPDATE ordstatus SET print = 0 WHERE oID = {$query[0]}");
                            }
                            ?>>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center; width: 80px"
                                           type="text"><?= $query[0] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[1] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[2] ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= date("d-m-Y H:i", strtotime($query[3])) ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text">
                                            <?
                                            $count_symbols = 0;
                                            for ($i = 0; $i < strlen($query[5]); $i++) {
                                                if ($query[5][$i] == " ") {
                                                    $count_symbols++;
                                                }
                                                if ($count_symbols != 2) {
                                                    echo $query[5][$i];
                                                }
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-<?
                                        switch ($query[4]) {
                                            case 0 :
                                                echo "danger";
                                                break;
                                            case 1:
                                                echo "warning";
                                                break;
                                            case 2:
                                                echo "success";
                                                break;
                                        }
                                        ?> btn-lg" style="text-align: center;width: 70px; height: 50px">

                                            <?
                                            switch ($query[4]) {
                                                case 0 :
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-dash-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 1:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-clock-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 2:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-check-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-warning btn-lg" target="_blank"
                                               href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&print=1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor"
                                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                </svg>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-lg"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <?
                                            if ($query[4] != 2) {
                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&redact=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-pencil-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                    </svg>
                                                </a>
                                                <?
                                            } else {
                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-info-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                    </svg>
                                                </a>
                                                <?
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?

break;
case "Директор":

?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <h4>Менеджер</h4>
                        <?
                        $sql_manager = "SELECT id, name FROM users WHERE catid = 2 or catid = 1";
                        $sql_manager = mysqli_query($connect, $sql_manager);
                        $sql_manager = mysqli_fetch_all($sql_manager);
                        $sql_now_manager = "SELECT name FROM users WHERE id = " . $id;
                        $sql_now_manager = mysqli_query($connect, $sql_now_manager);
                        $sql_now_manager = mysqli_fetch_all($sql_now_manager);
                        ?>
                        <select class="form-select" name="Manager" required>
                            <?
                            $a = 0;
                            $k = 0;
                            foreach ($sql_manager as $sql_manager) {
                                $option = "<option ";
                                if (empty($_GET['Manager'])) {
                                    if ($sql_manager[0] == $id) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                } else {
                                    if ($sql_manager[0] == $_GET['Manager']) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                }
                            }
                            ?>
                            <option <? if ($a == 0) {
                                echo "selected ";
                            } ?> value="ALL_Manager">Все менеджеры
                            </option>
                        </select>
                        <br>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input montage" type="checkbox" role="switch" <?
                            if (isset($_GET['montage']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="montage"
                                   id="montage">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="montage">Монтаж</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input process" type="checkbox" role="switch" <?
                            if (isset($_GET['process']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="process"
                                   id="process">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="process">Сборка и обработка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input delivery" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['delivery']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="delivery"
                                   id="delivery">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="delivery">Доставка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input measurements" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['measurements']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="measurements"
                                   id="measurements">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="measurements">Замеры</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input poligrafy" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['poligrafy']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="poligrafy"
                                   id="poligrafy">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="poligrafy">Полиграфия</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input print" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['print']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="print"
                                   id="print">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="print">Печать</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input frez" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['frez']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="frez"
                                   id="frez">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="frez">Фрезеровка</label>
                        </div>

                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.montage').checked = true;
                                    document.querySelector('.process').checked = true;
                                    document.querySelector('.delivery').checked = true;
                                    document.querySelector('.measurements').checked = true;
                                    document.querySelector('.poligrafy').checked = true;
                                    document.querySelector('.frez').checked = true;
                                    document.querySelector('.print').checked = true;
                                } else {
                                    document.querySelector('.montage').checked = false;
                                    document.querySelector('.process').checked = false;
                                    document.querySelector('.delivery').checked = false;
                                    document.querySelector('.measurements').checked = false;
                                    document.querySelector('.poligrafy').checked = false;
                                    document.querySelector('.frez').checked = false;
                                    document.querySelector('.print').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.poligrafy').forEach((element) => {
                                element.onclick = poligrafyFunction;
                            });

                            function poligrafyFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.frez').forEach((element) => {
                                element.onclick = frezFunction;
                            });

                            function frezFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.print').forEach((element) => {
                                element.onclick = printFunction;
                            });

                            function printFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.process').forEach((element) => {
                                element.onclick = processFunction;
                            });

                            function processFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.delivery').forEach((element) => {
                                element.onclick = deliveryFunction;
                            });

                            function deliveryFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.measurements').forEach((element) => {
                                element.onclick = measurementsFunction;
                            });

                            function measurementsFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">
                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="150">Вид</th>
                            <th width="150">Заказчик</th>
                            <th width="150">Дата</th>
                            <th width="100">Менеджер</th>
                            <th width="150">Статус</th>
                            <th width="200"></th>
                        </tr>
                        </thead>
                        <?


                        foreach ($query as $query) {


                            ?>
                            <tr <? if ($query[7] == -1) {
                                ?>
                                style="background: #bea8ec"
                                <?
                                mysqli_query($connect, "UPDATE ordstatus SET print = 0 WHERE oID = {$query[0]}");
                            }
                            ?>>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center; width: 80px"
                                           type="text"><?= $query[0] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[1] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[2] ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= date("d-m-Y H:i", strtotime($query[3])) ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text">
                                            <?
                                            $count_symbols = 0;
                                            for ($i = 0;
                                                 $i < strlen($query[5]);
                                                 $i++) {
                                                if ($query[5][$i] == " ") {
                                                    $count_symbols++;
                                                }
                                                if ($count_symbols != 2) {
                                                    echo $query[5][$i];
                                                }
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-<?
                                        switch ($query[4]) {
                                            case 0 :
                                                echo "danger";
                                                break;
                                            case 1:
                                                echo "warning";
                                                break;
                                            case 2:
                                                echo "success";
                                                break;
                                        }
                                        ?> btn-lg" style="text-align: center;width: 70px; height: 50px">

                                            <?
                                            switch ($query[4]) {
                                                case 0 :
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-dash-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 1:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-clock-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 2:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-check-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-warning btn-lg" target="_blank"
                                               href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&print=1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor"
                                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                </svg>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-lg"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <?
                                            if ($query[4] != 2) {
                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&redact=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-pencil-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                    </svg>
                                                </a>
                                                <?
                                            } else {
                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-info-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                    </svg>
                                                </a>
                                                <?
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?

break;
case "Полиграфия":
if (isset($_POST['ord_id'])) {
    $ord_id = $_POST['ord_id'];
    if (isset($_POST['print'])) {
        $sql = "UPDATE `ordstatus` SET status = 1 WHERE oId = '$ord_id' ";
        mysqli_query($connect, $sql);
        $ord_status = "UPDATE ordstatus SET print = 1 WHERE oID = " . $ord_id;
        mysqli_query($connect, $ord_status);
    }
    if (isset($_POST['complete'])) {
        $sql = "UPDATE `ordstatus` SET status = 2 WHERE oId = '$ord_id' ";
        mysqli_query($connect, $sql);
        $query = "INSERT INTO `uorders`(`oId`, `uId`) VALUES (" . $ord_id . ", " . $id . ")";
        mysqli_query($connect, $query);
        $ord_status = "UPDATE ordstatus SET print = 2 WHERE oID = " . $ord_id;
        mysqli_query($connect, $ord_status);
    }
    unset($_POST);
}
?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <h4>Менеджер</h4>
                        <?
                        $sql_manager = "SELECT id, name FROM users WHERE catid = 2 or catid = 1";
                        $sql_manager = mysqli_query($connect, $sql_manager);
                        $sql_manager = mysqli_fetch_all($sql_manager);
                        $sql_now_manager = "SELECT name FROM users WHERE id = " . $id;
                        $sql_now_manager = mysqli_query($connect, $sql_now_manager);
                        $sql_now_manager = mysqli_fetch_all($sql_now_manager);
                        ?>
                        <select class="form-select" name="Manager" required>
                            <?
                            $a = 0;
                            $k = 0;
                            foreach ($sql_manager as $sql_manager) {
                                $option = "<option ";
                                if (empty($_GET['Manager'])) {
                                    if ($sql_manager[0] == $id) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                } else {
                                    if ($sql_manager[0] == $_GET['Manager']) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                }
                            }
                            ?>
                            <option <? if ($a == 0) {
                                echo "selected ";
                            } ?> value="ALL_Manager">Все менеджеры
                            </option>
                        </select>
                        <br>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input poligrafy" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['poligrafy']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="poligrafy"
                                   id="poligrafy">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="poligrafy">Полиграфия</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.poligrafy').checked = true;
                                } else {
                                    document.querySelector('.poligrafy').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.poligrafy').forEach((element) => {
                                element.onclick = poligrafyFunction;
                            });

                            function poligrafyFunction() {
                                if (document.querySelector('.poligrafy').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">
                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="200">Заказчик</th>
                            <th width="380 ">Техническое задание</th>
                            <th width="150">Менеджер</th>
                            <th width="180"></th>
                        </tr>
                        </thead>
                        <?

                        foreach ($query as $query) {
                            ?>
                            <tr
                                <?
                                if ($query[7] == 1) {
                                    echo "style='background: #fff538'";
                                }
                                if ($query[7] == 2) {
                                    echo "style='background: #7dff74'";
                                }
                                ?>
                            >
                                <td>
                                    <a class="btn btn-light"><?= $query[0] ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light"><?= $query[2] ?></a>
                                </td>

                                <td>
                                    <a class="btn btn-light" style="width: 380px"><?= $query[8] ?>
                                        <br> Дата <?= date("d-m-Y H:i", strtotime($query[3])) ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light " style="text-align: center;width: 120px"
                                       type="text">
                                        <?
                                        $count_symbols = 0;
                                        for ($i = 0;
                                             $i <= strlen($query[5]);
                                             $i++) {
                                            if ($query[5][$i] == " ") {
                                                $count_symbols++;
                                            }
                                            if ($count_symbols != 2) {
                                                echo $query[5][$i];
                                            }

                                        }
                                        ?>
                                    </a>
                                </td>

                                <td>
                                    <div class="row">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-secondary btn"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill"
                                                     viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <? switch ($query[7]) {
                                                case 0 :
                                                    ?>
                                                    <form method="post"
                                                          action="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                                        <input type="hidden" name="print" value="1">
                                                        <input type="hidden" name="ord_id" value="<?= $query[0] ?>">
                                                        <button class="btn btn-outline-warning btn" type="submit"
                                                                style="width: 95px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20"
                                                                 fill="currentColor"
                                                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <?
                                                    break;
                                                case 1:
                                                    ?>
                                                    <form method="post"
                                                          action="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                                        <input type="hidden" name="complete" value="1">
                                                        <input type="hidden" name="ord_id" value="<?= $query[0] ?>">
                                                        <button class="btn btn-outline-success btn" type="submit"
                                                                style="width: 95px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20"
                                                                 fill="currentColor" class="bi bi-check-circle-fill"
                                                                 viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <?
                                                    break;
                                                case 2:
                                                    ?>
                                                    <a class="btn btn-outline-info btn" target="_blank"
                                                       href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             fill="currentColor" class="bi bi-info-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                        </svg>
                                                    </a>
                                                    <?
                                                    break;
                                            } ?>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <?
                                            switch ($query[4]) {
                                                case 0:
                                                    ?>
                                                    <a class="btn btn-danger" style="text-align: center;">
                                                        Не выполнена
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-dash-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                        </svg>
                                                    </a>
                                                    <? break;
                                                case 1:
                                                    ?>

                                                    <a class="btn btn-warning" style="text-align: center;">
                                                        В обработке
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-clock-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                        </svg>
                                                    </a>

                                                    <?
                                                    break;
                                                case 2:
                                                    ?>
                                                    <a class="btn btn-success" style="text-align: center;">
                                                        Выполнена
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-check-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                        </svg>
                                                    </a>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?
break;
case "Начальник цеха сборки и обработки":

?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <h4>Менеджер</h4>
                        <?
                        $sql_manager = "SELECT id, name FROM users WHERE catid = 2 or catid = 1";
                        $sql_manager = mysqli_query($connect, $sql_manager);
                        $sql_manager = mysqli_fetch_all($sql_manager);
                        $sql_now_manager = "SELECT name FROM users WHERE id = " . $id;
                        $sql_now_manager = mysqli_query($connect, $sql_now_manager);
                        $sql_now_manager = mysqli_fetch_all($sql_now_manager);
                        ?>
                        <select class="form-select" name="Manager" required>
                            <?
                            $a = 0;
                            $k = 0;
                            foreach ($sql_manager as $sql_manager) {
                                $option = "<option ";
                                if (empty($_GET['Manager'])) {
                                    if ($sql_manager[0] == $id) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                } else {
                                    if ($sql_manager[0] == $_GET['Manager']) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                }
                            }
                            ?>
                            <option <? if ($a == 0) {
                                echo "selected ";
                            } ?> value="ALL_Manager">Все менеджеры
                            </option>
                        </select>
                        <br>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input montage" type="checkbox" role="switch" <?
                            if (isset($_GET['montage']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="montage"
                                   id="montage">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="montage">Монтаж</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input process" type="checkbox" role="switch" <?
                            if (isset($_GET['process']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="process"
                                   id="process">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="process">Сборка и обработка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input delivery" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['delivery']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="delivery"
                                   id="delivery">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="delivery">Доставка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input measurements" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['measurements']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="measurements"
                                   id="measurements">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="measurements">Замеры</label>
                        </div>


                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.montage').checked = true;
                                    document.querySelector('.process').checked = true;
                                    document.querySelector('.delivery').checked = true;
                                    document.querySelector('.measurements').checked = true;
                                } else {
                                    document.querySelector('.montage').checked = false;
                                    document.querySelector('.process').checked = false;
                                    document.querySelector('.delivery').checked = false;
                                    document.querySelector('.measurements').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.process').forEach((element) => {
                                element.onclick = processFunction;
                            });

                            function processFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.delivery').forEach((element) => {
                                element.onclick = deliveryFunction;
                            });

                            function deliveryFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.measurements').forEach((element) => {
                                element.onclick = measurementsFunction;
                            });

                            function measurementsFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>

                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">

                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="150">Вид</th>
                            <th width="150">Заказчик</th>
                            <th width="150">Дата</th>
                            <th width="100">Менеджер</th>
                            <th width="150">Статус</th>
                            <th width="200"></th>
                        </tr>
                        </thead>
                        <?

                        foreach ($query as $query) {


                            ?>
                            <tr
                                <? if ($query[7] == 1) {
                                    echo "style='background: #9ce774'";
                                } ?>
                            >
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center; width: 80px"
                                           type="text"><?= $query[0] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[1] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[2] ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= date("d-m-Y H:i", strtotime($query[3])) ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text">
                                            <?
                                            $count_symbols = 0;
                                            for ($i = 0;
                                                 $i < strlen($query[5]);
                                                 $i++) {
                                                if ($query[5][$i] == " ") {
                                                    $count_symbols++;
                                                }
                                                if ($count_symbols != 2) {
                                                    echo $query[5][$i];
                                                }
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-<?
                                        switch ($query[4]) {
                                            case 0 :
                                                echo "danger";
                                                break;
                                            case 1:
                                                echo "warning";
                                                break;
                                            case 2:
                                                echo "success";
                                                break;
                                        }
                                        ?> btn-lg" style="text-align: center;width: 70px; height: 50px">

                                            <?
                                            switch ($query[4]) {
                                                case 0 :
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-dash-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 1:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-clock-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 2:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-check-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-warning btn-lg" target="_blank"
                                               href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&print=1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor"
                                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                </svg>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-lg"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <?
                                            if ($query[4] != 2) {
                                                ?>
                                                <a class="btn btn-outline-success btn-lg"
                                                   href="Complete_ORD/complete_ord.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-check-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                </a>
                                                <?
                                            } else {

                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-info-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                    </svg>
                                                </a>
                                                <?
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?
break;
case "Печатник":
if (isset($_POST['ord_id'])) {
    $ord_id = $_POST['ord_id'];
    if (isset($_POST['print'])) {
        $sql = "UPDATE `ordstatus` SET status = 1 WHERE oId = '$ord_id' ";
        mysqli_query($connect, $sql);
        $ord_status = "UPDATE ordstatus SET print = 1 WHERE oID = " . $ord_id;
        mysqli_query($connect, $ord_status);
    }
    if (isset($_POST['complete'])) {
        $sql = "UPDATE `ordstatus` SET status = 2 WHERE oId = '$ord_id' ";
        mysqli_query($connect, $sql);
        $query = "INSERT INTO `uorders`(`oId`, `uId`) VALUES (" . $ord_id . ", " . $id . ")";
        mysqli_query($connect, $query);
        $ord_status = "UPDATE ordstatus SET print = 2 WHERE oID = " . $ord_id;
        mysqli_query($connect, $ord_status);
    }
    unset($_POST);
}
?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <br>
                        <h4>Менеджер</h4>
                        <?
                        $sql_manager = "SELECT id, name FROM users WHERE catid = 2 or catid = 1";
                        $sql_manager = mysqli_query($connect, $sql_manager);
                        $sql_manager = mysqli_fetch_all($sql_manager);
                        $sql_now_manager = "SELECT name FROM users WHERE id = " . $id;
                        $sql_now_manager = mysqli_query($connect, $sql_now_manager);
                        $sql_now_manager = mysqli_fetch_all($sql_now_manager);
                        ?>
                        <select class="form-select" name="Manager" required>
                            <?
                            $a = 0;
                            $k = 0;
                            foreach ($sql_manager as $sql_manager) {
                                $option = "<option ";
                                if (empty($_GET['Manager'])) {
                                    if ($sql_manager[0] == $id) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                } else {
                                    if ($sql_manager[0] == $_GET['Manager']) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                }
                            }
                            ?>
                            <option <? if ($a == 0) {
                                echo "selected ";
                            } ?> value="ALL_Manager">Все менеджеры
                            </option>
                        </select>
                        <br>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input print" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['print']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="print"
                                   id="print">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="print">Печать</label>
                        </div>

                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.print').checked = true;
                                } else {
                                    document.querySelector('.print').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.print').forEach((element) => {
                                element.onclick = printFunction;
                            });

                            function printFunction() {
                                if (document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>

                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">

                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="200">Заказчик</th>
                            <th width="380 ">Техническое задание</th>
                            <th width="150">Менеджер</th>
                            <th width="180"></th>
                        </tr>
                        </thead>
                        <?

                        foreach ($query as $query) {
                            ?>
                            <tr
                                <?
                                if ($query[7] == 1) {
                                    echo "style='background: #fff538'";
                                }
                                if ($query[7] == 2) {
                                    echo "style='background: #7dff74'";
                                }
                                ?>
                            >
                                <td>
                                    <a class="btn btn-light"><?= $query[0] ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light"><?= $query[2] ?></a>
                                </td>

                                <td>
                                    <a class="btn btn-light" style="width: 380px"><?= $query[8] ?>
                                        <br> Дата <?= date("d-m-Y H:i", strtotime($query[3])) ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light " style="text-align: center;width: 120px"
                                       type="text">
                                        <?
                                        $count_symbols = 0;
                                        for ($i = 0;
                                             $i <= strlen($query[5]);
                                             $i++) {
                                            if ($query[5][$i] == " ") {
                                                $count_symbols++;
                                            }
                                            if ($count_symbols != 2) {
                                                echo $query[5][$i];
                                            }

                                        }
                                        ?>
                                    </a>
                                </td>

                                <td>
                                    <div class="row">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-secondary btn"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill"
                                                     viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <? switch ($query[7]) {
                                                case 0 :
                                                    ?>
                                                    <form method="post"
                                                          action="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                                        <input type="hidden" name="print" value="1">
                                                        <input type="hidden" name="ord_id" value="<?= $query[0] ?>">
                                                        <button class="btn btn-outline-warning btn" type="submit"
                                                                style="width: 95px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20"
                                                                 fill="currentColor"
                                                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <?
                                                    break;
                                                case 1:
                                                    ?>
                                                    <form method="post"
                                                          action="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                                        <input type="hidden" name="complete" value="1">
                                                        <input type="hidden" name="ord_id" value="<?= $query[0] ?>">
                                                        <button class="btn btn-outline-success btn" type="submit"
                                                                style="width: 95px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20"
                                                                 fill="currentColor" class="bi bi-check-circle-fill"
                                                                 viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <?
                                                    break;
                                                case 2:
                                                    ?>
                                                    <a class="btn btn-outline-info btn" target="_blank"
                                                       href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             fill="currentColor" class="bi bi-info-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                        </svg>
                                                    </a>
                                                    <?
                                                    break;
                                            } ?>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <?
                                            switch ($query[4]) {
                                                case 0:
                                                    ?>
                                                    <a class="btn btn-danger" style="text-align: center;">
                                                        Не выполнена
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-dash-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                        </svg>
                                                    </a>
                                                    <? break;
                                                case 1:
                                                    ?>

                                                    <a class="btn btn-warning" style="text-align: center;">
                                                        В обработке
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-clock-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                        </svg>
                                                    </a>

                                                    <?
                                                    break;
                                                case 2:
                                                    ?>
                                                    <a class="btn btn-success" style="text-align: center;">
                                                        Выполнена
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-check-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                        </svg>
                                                    </a>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?
break;
case "Фрезеровщик":
if (isset($_POST['ord_id'])) {
    $ord_id = $_POST['ord_id'];
    if (isset($_POST['print'])) {
        $sql = "UPDATE `ordstatus` SET status = 1 WHERE oId = '$ord_id' ";
        mysqli_query($connect, $sql);
        $ord_status = "UPDATE ordstatus SET print = 1 WHERE oID = " . $ord_id;
        mysqli_query($connect, $ord_status);
    }
    if (isset($_POST['complete'])) {
        $sql = "UPDATE `ordstatus` SET status = 2 WHERE oId = '$ord_id' ";
        mysqli_query($connect, $sql);
        $query = "INSERT INTO `uorders`(`oId`, `uId`) VALUES (" . $ord_id . ", " . $id . ")";
        mysqli_query($connect, $query);
        $ord_status = "UPDATE ordstatus SET print = 2 WHERE oID = " . $ord_id;
        mysqli_query($connect, $ord_status);
    }
    unset($_POST);
}
?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php" name="block_frez">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <br>
                        <h4>Менеджер</h4>
                        <?
                        $sql_manager = "SELECT id, name FROM users WHERE catid = 2 or catid = 1";
                        $sql_manager = mysqli_query($connect, $sql_manager);
                        $sql_manager = mysqli_fetch_all($sql_manager);
                        $sql_now_manager = "SELECT name FROM users WHERE id = " . $id;
                        $sql_now_manager = mysqli_query($connect, $sql_now_manager);
                        $sql_now_manager = mysqli_fetch_all($sql_now_manager);
                        ?>
                        <select class="form-select" name="Manager" required>
                            <?
                            $a = 0;
                            $k = 0;
                            foreach ($sql_manager as $sql_manager) {
                                $option = "<option ";
                                if (empty($_GET['Manager'])) {
                                    if ($sql_manager[0] == $id) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                } else {
                                    if ($sql_manager[0] == $_GET['Manager']) {
                                        $option = $option . "selected ";
                                        $a++;
                                    }
                                    $option = $option . "value='" . $sql_manager[0] . "'>" . $sql_manager[1] . "</option>";
                                    echo $option;
                                }
                            }
                            ?>
                            <option <? if ($a == 0) {
                                echo "selected ";
                            } ?> value="ALL_Manager">Все менеджеры
                            </option>
                        </select>
                        <br>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input frez" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['frez']) || isset($_GET['start'])) {
                                    echo "checked";
                                }
                                ?>
                                   name="frez"
                                   id="frez">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="frez">Фрезеровка</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.frez').checked = true;

                                } else {

                                    document.querySelector('.frez').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.frez').forEach((element) => {
                                element.onclick = frezFunction;
                            });

                            function frezFunction() {
                                if (document.querySelector('.frez').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <br>
                        <script>
                            function get() {
                                let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                                console.log(data);
                                switch (data) {
                                    case "ПВХ (мягкий)" :
                                        document.getElementById("thickness").innerHTML = ('<option value="Все виды толщины" selected>Все виды толщины</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="1" selected>1</option>')
                                        break;
                                    case "Орг. Стекло (прозрачное)" :
                                        document.getElementById("thickness").innerHTML = ('<option value="Все виды толщины" selected>Все виды толщины</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="Все виды толщины" selected>Все виды толщины</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="3" selected>3</option>'
                                        )
                                        break;

                                    case "ПЭТ" :
                                        document.getElementById("thickness").innerHTML = ('<option value="Все виды толщины" selected>Все виды толщины</option>' +
                                            '<option value="0,3">0,3</option>' +
                                            '<option value="0,5" >0,5</option>' +
                                            '<option value="0,75">0,75</option>' +
                                            '<option value="1">1</option>' +
                                            '<option value="2">2</option>'
                                        )
                                        break;
                                    case "Композит" :
                                        document.getElementById("thickness").innerHTML = ('<option value="Все виды толщины" selected>Все виды толщины</option>' +
                                            '<option value="3" >3</option>' +
                                            '<option value="4">4</option>'
                                        )
                                        break;
                                    case "Фанера" :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="Все виды толщины" selected>Все виды толщины</option>' +
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
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="Указывается в т.з." selected >Указывается в т.з.</option>'
                                        )
                                        break;
                                    case "Другое" :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="Указывается в т.з.">Указывается в т.з.</option>'
                                        )
                                        break;
                                    default :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="Все виды толщины">Все виды толщины</option>'
                                        )
                                        break;
                                }
                            }
                        </script>
                        <h4><label for="">Материал</label></h4>
                        <div class="row">
                            <select class="form-select" id=select_material name="select_material" required
                                    onchange="get()" style="text-align: center;">
                                <?
                                if (isset($_GET['select_material'])) {
                                    ?>
                                    <option value="<?= $_GET['select_material'] ?>"
                                            selected><?= $_GET['select_material'] ?></option>
                                    <?
                                }
                                ?>
                                <option value="Все виды материала">Все виды материала</option>
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
                        <br>
                        <h4><label for="">Толщина (в мм)</label></h4>
                        <div class="row">
                            <select class="form-select" name="select_thickness" id="thickness"
                                    style="text-align: center;"
                                    required>
                                <?
                                if (isset($_GET['select_thickness'])) {
                                    ?>
                                    <option selected
                                            value="<?= $_GET['select_thickness'] ?>"><?= $_GET['select_thickness'] ?></option>
                                    <?
                                    switch ($_GET['select_material']) {
                                        case "ПВХ (мягкий)" :
                                            ?>
                                            <option value="Все виды толщины">Все виды толщины</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="8">8</option>
                                            <option value="10">10</option>
                                            <?
                                            break;
                                        case "ПВХ (твёрдый)" :
                                            ?>
                                            <option value="1" selected>1</option>
                                            <?
                                            break;
                                        case "Орг. Стекло (прозрачное)" :
                                            ?>
                                            <option value="Все виды толщины">Все виды толщины</option>
                                            <option value="1">1</option>
                                            <option value="1,5">1,5</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="8">8</option>
                                            <option value="10">10</option>
                                            <?
                                            break;
                                        case "Орг. Стекло (молочное)" :
                                            ?>
                                            <option value="Все виды толщины"> Все виды толщины</option>
                                            <option value="1"> 1</option>
                                            <option value="1,5"> 1,5</option>
                                            <option value="2"> 2</option>
                                            <option value="3"> 3</option>
                                            <option value="4"> 4</option>
                                            <option value="5"> 5</option>
                                            <option value="6"> 6</option>
                                            <option value="8"> 8</option>
                                            <option value="10"> 10</option>
                                            <?
                                            break;
                                        case "Орг. Стекло (цветное)" :
                                            ?>
                                            <option value="3">3</option>
                                            <?
                                            break;
                                        case "ПЭТ" :
                                            ?>
                                            <option value="Все виды толщины">Все виды толщины</option>
                                            <option value="0,3">0,3</option>
                                            <option value="0,5">0,5</option>
                                            <option value="0,75">0,75</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <?
                                            break;
                                        case "Композит" :
                                            ?>
                                            <option value="Все виды толщины"> Все виды толщины</option>
                                            <option value="3"> 3</option>
                                            <option value="4"> 4</option>
                                            <?
                                            break;
                                        case "Фанера" :
                                            ?>
                                            <option value="Все виды толщины">Все виды толщины</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="12">12</option>
                                            <option value="15">15</option>
                                            <option value="18">18</option>
                                            <option value="21">21</option>
                                            <?
                                            break;
                                        case "Поликарбонат литой" :
                                            ?>
                                            <option value="Указывается в т.з.">Указывается в т.з.</option>
                                            <?
                                            break;
                                        case "Другое" :
                                            ?>
                                            <option value="Указывается в т.з.">Указывается в т.з.</option>
                                            <?
                                            break;
                                        default :
                                            ?>
                                            <option value="Все виды толщины">Все виды толщины</option>
                                            <?
                                            break;
                                    }
                                } else {
                                    ?>
                                    <option value="Все виды толщины">Все виды толщины</option>
                                    <?
                                }
                                ?>

                            </select>
                        </div>
                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>

                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">
                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="200">Заказчик</th>
                            <th width="380 ">Техническое задание</th>
                            <th width="150">Менеджер</th>
                            <th width="180"></th>
                        </tr>
                        </thead>
                        <?


                        foreach ($query as $query) {


                            ?>
                            <tr
                                <?
                                if ($query[7] == 1) {
                                    echo "style='background: #fff538'";
                                }
                                if ($query[7] == 2) {
                                    echo "style='background: #7dff74'";
                                }
                                ?>
                            >
                                <td>
                                    <a class="btn btn-light"><?= $query[0] ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light"><?= $query[2] ?></a>
                                </td>
                                <td>
                                    <a class="btn btn-light" style="width: 380px"><?= $query[10] ?>
                                        <br> Материал: "<?= $query[8] ?>" <br> Толщина: <?= $query[9] ?> мм
                                        <br> Дата <?= date("d-m-Y H:i", strtotime($query[3])) ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-light " style="text-align: center;width: 120px"
                                       type="text">
                                        <?
                                        $count_symbols = 0;
                                        for ($i = 0;
                                             $i <= strlen($query[5]);
                                             $i++) {
                                            if ($query[5][$i] == " ") {
                                                $count_symbols++;
                                            }
                                            if ($count_symbols != 2) {
                                                echo $query[5][$i];
                                            }

                                        }
                                        ?>
                                    </a>
                                </td>

                                <td>
                                    <div class="row">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-secondary btn"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill"
                                                     viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <? switch ($query[7]) {
                                                case 0 :
                                                    ?>
                                                    <form method="post"
                                                          action="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                                        <input type="hidden" name="print" value="1">
                                                        <input type="hidden" name="ord_id" value="<?= $query[0] ?>">
                                                        <button class="btn btn-outline-warning btn" type="submit"
                                                                style="width: 95px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20"
                                                                 fill="currentColor"
                                                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <?
                                                    break;
                                                case 1:
                                                    ?>
                                                    <form method="post"
                                                          action="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                                        <input type="hidden" name="complete" value="1">
                                                        <input type="hidden" name="ord_id" value="<?= $query[0] ?>">
                                                        <button class="btn btn-outline-success btn" type="submit"
                                                                style="width: 95px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20"
                                                                 fill="currentColor" class="bi bi-check-circle-fill"
                                                                 viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <?
                                                    break;
                                                case 2:
                                                    ?>
                                                    <a class="btn btn-outline-info btn" target="_blank"
                                                       href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             fill="currentColor" class="bi bi-info-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                        </svg>
                                                    </a>
                                                    <?
                                                    break;
                                            } ?>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <?
                                            switch ($query[4]) {
                                                case 0:
                                                    ?>
                                                    <a class="btn btn-danger" style="text-align: center;">
                                                        Не выполнена
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-dash-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                        </svg>
                                                    </a>
                                                    <? break;
                                                case 1:
                                                    ?>

                                                    <a class="btn btn-warning" style="text-align: center;">
                                                        В обработке
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-clock-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                        </svg>
                                                    </a>

                                                    <?
                                                    break;
                                                case 2:
                                                    ?>
                                                    <a class="btn btn-success" style="text-align: center;">
                                                        Выполнена
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="20"
                                                             fill="currentColor" class="bi bi-check-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                        </svg>
                                                    </a>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?
break;
default:

?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 120000);
    </script>
    <div class="container mt-1" style="width: 1300px;">
        <div class="row">
            <div class="col-1" style="width: 300px">
                <h3>Форма поиска</h3>
                <form method="get" action="Orders.php">
                    <div class="container mt-2">
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" name="ALL_MANAGER" type="checkbox" id="pop2"
                                    <?
                                    if (isset($_GET['ALL_MANAGER'])) {
                                        echo "checked";
                                    }
                                    ?>
                                       aria-label="Checkbox for following text input">
                            </div>
                            <label class="form-control" aria-label="Text input with checkbox" for="pop2"
                            >Показать все заявки</label>
                        </div>
                        <h4>Статус заявки</h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL"
                                   id="ALL">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="ALL">Все
                                статусы заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input not_yet" type="checkbox" role="switch" <?
                            if (isset($_GET['Not_yet']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Not_yet"
                                   id="Not_yet">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px"
                                   for="Not_yet">Не
                                выполненные</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input loading" type="checkbox" role="switch" <?
                            if (isset($_GET['Loading']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="Loading"
                                   id="Loading">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Loading">В
                                обработке</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input complete" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['Complete']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="Complete"
                                   id="Complete">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="Complete">Выполненые</label>
                        </div>
                        <script>
                            document.querySelectorAll('.all').forEach((element) => {
                                element.onclick = allFunction;
                            });

                            function allFunction() {
                                if (document.querySelector('.all').checked) {
                                    document.querySelector('.not_yet').checked = true;
                                    document.querySelector('.loading').checked = true;
                                    document.querySelector('.complete').checked = true;
                                } else {
                                    document.querySelector('.not_yet').checked = false;
                                    document.querySelector('.loading').checked = false;
                                    document.querySelector('.complete').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.loading').forEach((element) => {
                                element.onclick = loadingFunction;
                            });

                            function loadingFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.not_yet').forEach((element) => {
                                element.onclick = not_yetFunction;
                            });

                            function not_yetFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.complete').forEach((element) => {
                                element.onclick = completeFunction;
                            });

                            function completeFunction() {
                                if (document.querySelector('.not_yet').checked && document.querySelector('.loading').checked && document.querySelector('.complete').checked) {
                                    document.querySelector('.all').checked = true;
                                } else {
                                    document.querySelector('.all').checked = false;
                                }
                            }
                        </script>
                        <br>

                        <h4><label for="techtask">Вид Заявки</label></h4>
                        <div class="form-check form-switch">
                            <input class="form-check-input all_ord" type="checkbox" role="switch" <?
                            if (isset($_GET['ALL_ord']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="ALL_ord"
                                   id="ALL_ord">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="ALL_ord">Все виды
                                заявок</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input montage" type="checkbox" role="switch" <?
                            if (isset($_GET['montage']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="montage"
                                   id="montage">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="montage">Монтаж</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input process" type="checkbox" role="switch" <?
                            if (isset($_GET['process']) || isset($_GET['start'])) {
                                echo "checked";
                            } ?> name="process"
                                   id="process">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="process">Сборка и обработка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input delivery" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['delivery']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="delivery"
                                   id="delivery">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="delivery">Доставка</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input measurements" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['measurements']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="measurements"
                                   id="measurements">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="measurements">Замеры</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input poligrafy" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['poligrafy']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="poligrafy"
                                   id="poligrafy">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="poligrafy">Полиграфия</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input print" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['print']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="print"
                                   id="print">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="print">Печать</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input frez" type="checkbox" role="switch"
                                <?
                                if (isset($_GET['frez']) || isset($_GET['start'])) {
                                    echo "checked";
                                } ?>
                                   name="frez"
                                   id="frez">
                            <label class="form-check-label btn btn-outline-dark btn-sm" style="width: 200px;"
                                   for="frez">Фрезеровка</label>
                        </div>

                        <script>
                            document.querySelectorAll('.all_ord').forEach((element) => {
                                element.onclick = all_ordFunction;
                            });

                            function all_ordFunction() {
                                if (document.querySelector('.all_ord').checked) {
                                    document.querySelector('.montage').checked = true;
                                    document.querySelector('.process').checked = true;
                                    document.querySelector('.delivery').checked = true;
                                    document.querySelector('.measurements').checked = true;
                                    document.querySelector('.poligrafy').checked = true;
                                    document.querySelector('.frez').checked = true;
                                    document.querySelector('.print').checked = true;
                                } else {
                                    document.querySelector('.montage').checked = false;
                                    document.querySelector('.process').checked = false;
                                    document.querySelector('.delivery').checked = false;
                                    document.querySelector('.measurements').checked = false;
                                    document.querySelector('.poligrafy').checked = false;
                                    document.querySelector('.frez').checked = false;
                                    document.querySelector('.print').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.poligrafy').forEach((element) => {
                                element.onclick = poligrafyFunction;
                            });

                            function poligrafyFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.frez').forEach((element) => {
                                element.onclick = frezFunction;
                            });

                            function frezFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.print').forEach((element) => {
                                element.onclick = printFunction;
                            });

                            function printFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>


                        <script>
                            document.querySelectorAll('.montage').forEach((element) => {
                                element.onclick = montageFunction;
                            });

                            function montageFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>

                        <script>
                            document.querySelectorAll('.process').forEach((element) => {
                                element.onclick = processFunction;
                            });

                            function processFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.delivery').forEach((element) => {
                                element.onclick = deliveryFunction;
                            });

                            function deliveryFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <script>
                            document.querySelectorAll('.measurements').forEach((element) => {
                                element.onclick = measurementsFunction;
                            });

                            function measurementsFunction() {
                                if (document.querySelector('.process').checked && document.querySelector('.montage').checked && document.querySelector('.delivery').checked && document.querySelector('.measurements').checked && document.querySelector('.poligrafy').checked && document.querySelector('.frez').checked && document.querySelector('.print').checked) {
                                    document.querySelector('.all_ord').checked = true;
                                } else {
                                    document.querySelector('.all_ord').checked = false;
                                }
                            }
                        </script>
                        <br>
                        <h5><label for="numorder"> ID заявки </label></h5>
                        <input type="text" class="form-control" id="numorder" name="numorder" autocomplete="off"
                               placeholder="Поле для сканера">
                        <br>
                        <h5><label for="company"> Компания заявитель </label></h5>
                        <input type="text" class="form-control" id="company" value="<?= $_GET['company'] ?>"
                               name="company" autocomplete="off"
                               placeholder="Пример: DNS">
                        <br>
                        <h5><label for="date"> Срок исполнения </label></h5>
                        <input type="date" id="date" class="form-control" value="<?= $_GET['date'] ?>"
                               name="date"/>
                        <br>
                        <h5><label for="date_start"> За период </label></h5>
                        <input type="date" id="date_start" class="form-control" value="<?= $_GET['date_start'] ?>"
                               name="date_start" required/>
                        <input type="date" id="date_end" class="form-control" value="<?= $_GET['date_end'] ?>"
                               name="date_end" required/>
                        <br>
                        <div class="row">
                            <button type='submit' class="btn btn-outline-success btn-sm">
                                Поиск
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-12" style="width: 1000px;">
                <div class="row">
                    <div class="col" style="text-align: left">
                        <a class="btn btn-outline-primary btn-sm" style="width: 250px;"
                           href="Orders.php?<?= $_SERVER['QUERY_STRING'] ?>">Обновить
                            информацию</a>
                    </div>
                    <div class="col">
                        <div class="row" style="text-align: center">
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_start'])); ?></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-warning btn-sm"
                                   style="width: 100px;"><?= date("d-m-Y", strtotime($_GET['date_end'])); ?></a>
                            </div>
                        </div>

                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-outline-danger btn-sm" href="../Personal_Area/lk.php?id=<?= $id ?>"
                           style="width: 250px;">Вернуться
                            в личный кабинет</a>
                    </div>
                </div>
                <div class="row">
                    <?
                    $query = mysqli_query($connect, $stringQuery);
                    if ($query == false) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    $query = mysqli_fetch_all($query);
                    if (empty($query)) {
                        echo "<pre>";
                        echo "<h2 style='text-align: center'>По данному запросу, заявки в базе данных отсутствуют</h2>";
                        echo "<h2 style='text-align: center'>Выберите другие параметры для поиска</h2>";
                        echo "</pre>";
                        exit();
                    }
                    ?>
                    <table class="table table-hover table-sm" style="text-align: center;">
                        <thead>
                        <tr>
                            <th width="100">id</th>
                            <th width="150">Вид</th>
                            <th width="150">Заказчик</th>
                            <th width="150">Дата</th>
                            <th width="100">Менеджер</th>
                            <th width="150">Статус</th>
                            <th width="200"></th>
                        </tr>
                        </thead>
                        <?


                        foreach ($query as $query) {


                            ?>
                            <tr>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center; width: 80px"
                                           type="text"><?= $query[0] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[1] ?></a>
                                    </div>

                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= $query[2] ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text"><?= date("d-m-Y H:i", strtotime($query[3])) ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-light " style="text-align: center;width: 120px"
                                           type="text">
                                            <?
                                            $count_symbols = 0;
                                            for ($i = 0;
                                                 $i < strlen($query[5]);
                                                 $i++) {
                                                if ($query[5][$i] == " ") {
                                                    $count_symbols++;
                                                }
                                                if ($count_symbols != 2) {
                                                    echo $query[5][$i];
                                                }
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <a class="btn btn-<?
                                        switch ($query[4]) {
                                            case 0 :
                                                echo "danger";
                                                break;
                                            case 1:
                                                echo "warning";
                                                break;
                                            case 2:
                                                echo "success";
                                                break;
                                        }
                                        ?> btn-lg" style="text-align: center;width: 70px; height: 50px">

                                            <?
                                            switch ($query[4]) {
                                                case 0 :
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-dash-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 1:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-clock-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                                case 2:
                                                    ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-check-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <?
                                                    break;
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="row"
                                         style="height: 5em; display: flex; align-items: center; justify-content: center;">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-warning btn-lg" target="_blank"
                                               href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&print=1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor"
                                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                </svg>
                                            </a>
                                            <a class="btn btn-outline-secondary btn-lg"
                                               href="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     fill="currentColor" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                                    <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                                </svg>
                                            </a>
                                            <?
                                            if ($query[4] != 2) {
                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&redact=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-pencil-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                    </svg>
                                                </a>
                                                <?
                                            } else {
                                                ?>
                                                <a class="btn btn-outline-primary btn-lg" target="_blank"
                                                   href="info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         fill="currentColor" class="bi bi-info-circle-fill"
                                                         viewBox="0 0 16 16">
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                                    </svg>
                                                </a>
                                                <?
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <?
    break;

}
?>


</body>
</html>