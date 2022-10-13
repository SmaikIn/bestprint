<?php
require "../../config/config.php";
require "../../config/auth.php";

$id = $_GET['id'];
$ord_id = $_GET['ord_id'];
if (isset($_GET['delete'])) {
    $sql = "DELETE FROM `orders` WHERE id = " . $ord_id;
    mysqli_query($connect, $sql);
    $FILE_ID = "../../files/File_ORD/" . $ord_id;
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($j = 2; $j < count($scan_dir); $j++) {
            $FILE_ID = "../../files/File_ORD/" . $ord_id . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$j];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $ord_id;
        rmdir($FILE_ID);
    }
    ?>
    <script>
        window.close();
    </script>
    <?php
}
if (isset($_GET['save'])) {
    $save = "UPDATE orders SET ";
    if (isset($_POST['company'])) {
        $save = $save . " `company` = '" . $_POST['company'] . "',";
    }
    if (isset($_POST['adress'])) {
        $save = $save . " `address` =  '" . $_POST['adress'] . "',";
    }
    if (isset($_POST['contact'])) {
        $save = $save . " `contact` = '" . $_POST['contact'] . "',";
    }
    if (isset($_POST['date'])) {

        $save = $save . " `deadline` = '" . $_POST['date'] . "',";
    }
    if (isset($_POST['select_material'])) {
        $save = $save . " `material` = '" . $_POST['select_material'] . "',";
    }
    if (isset($_POST['contact'])) {
        $save = $save . " `thickness` = '" . $_POST['select_thickness'] . "',";
    }
    if (isset($_POST['techtask'])) {
        $save = $save . " `techTask` = '" . $_POST['techtask'] . "'";
    }
    $save = $save . " WHERE id = " . $ord_id;
    mysqli_query($connect, $save);

}
if (isset($_GET['redact'])) {
    $WHAT = "redact";
}
if (isset($_GET['info'])) {
    $WHAT = "info";
}
if (isset($_GET['print'])) {
    $WHAT = "print";
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Информация о заявке № <?= $ord_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    .label {
        text-align: left;
    }

    .form-control {
        font-size: 18px;
    }

    .pattern {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 78px;
    }

    .object {
        width: 1000px;
    }

    input:invalid {
        border-color: red;
    }

    input:valid {
        border-color: green;
    }

    textarea:valid {
        border-color: green;
    }

    textarea:invalid {
        border-color: red;
    }

    select:invalid {
        border-color: red;
    }

    select:valid {
        border-color: green;
    }
</style>
<body>
<?
$sql = "SELECT catid FROM users WHERE id = " . $id;
$sql = mysqli_query($connect, $sql);
$sql = mysqli_fetch_all($sql);
$cat_id = $sql[0][0];
$sql = "SELECT * FROM orders WHERE id = '$ord_id'";
$query = mysqli_query($connect, $sql);
$query = mysqli_fetch_all($query);
$sql = "SELECT status FROM ordstatus WHERE oId = '$ord_id'";
$sql = mysqli_query($connect, $sql);
$sql = mysqli_fetch_all($sql);
$query_users = "SELECT category.name, users.name, users.id, users.phone FROM uorders INNER JOIN users on users.id = uorders.uId 
                    INNER JOIN category on users.catId = category.id  WHERE uorders.oId = '$ord_id' AND category.name = 'Менеджер' ";
$query_users = mysqli_query($connect, $query_users);
$query_users = mysqli_fetch_all($query_users);
$q_u = $query_users[0][2];

$query_users = "SELECT category.name, users.name, users.id, users.phone FROM uorders INNER JOIN users on users.id = uorders.uId 
                    INNER JOIN category on users.catId = category.id  WHERE uorders.oId = '$ord_id'";
$query_users = mysqli_query($connect, $query_users);
$query_users = mysqli_fetch_all($query_users);

switch ($cat_id) {
case 1:
switch ($WHAT) {
case "print":
    ?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                        <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес" name="adress"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {

                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>
        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>

        <br> <br>

    </div>
    <script>
        window.print();
    </script>

<?
break;
case "info":
?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                        <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled name="adress"
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {
                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>

        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>

        <br> <br>

    </div>

<?
break;
case "redact":

?>
    <form action="info.php?id=<?= $id ?>&ord_id=<?= $ord_id ?>&redact=1&save=1" method="post"
          id="block_frez"
          name="block_frez">

        <div class="container mt-2" style="width: 1000px;">
            <div class="row">
                <div class="col-10">
                    <div class="row" style="width: 800px">
                        <div class="col">
                            <h1>Заявка № <?= $ord_id ?> </h1>
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-primary btn-lg" type="sumbit" style="width: 300px;">
                                Сохранить изменения
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     fill="currentColor" class="bi bi-pencil-fill"
                                     viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <div class="row object">
                        <div class="row" style="width: 500px;">
                            <input class="form-control" style="width: 200px; text-align: center;"
                                   value="Статус заявки"
                                   readonly>
                            <?
                            switch ($sql[0][0]) {
                                case 0 :
                                    $inf = "Не выполнена";
                                    break;
                                case 1:
                                    $inf = "В обработке";
                                    break;

                                case 2:
                                    $inf = "Выполнена";
                                    break;
                            }
                            ?>
                            <input class="btn btn-<?
                            switch ($sql[0][0]) {
                                case 0 :
                                    echo "danger";
                                    break;
                                case 1:
                                    echo "warning";
                                    break;
                                case 2:
                                    echo "success";
                                    break;
                            } ?>" type="text" style="width: 200px; text-align: center;" readonly
                                   value="<?= $inf ?>">
                            <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="row object">
                        <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                               readonly>
                        <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                               required
                               style="width: 200px; text-align: center;">
                    </div>
                    <div class="row">
                        <input readonly class="form-control" type="text" value="Контакты"
                               style="width: 200px; text-align: center;">
                        <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                                  required
                                  rows="1"><?= $query[0][3] ?></textarea>
                    </div>

                    <?
                    if (isset($query[0][2])) {
                        if (!empty($query[0][2])) {
                            ?>
                            <div class="row">
                                <input readonly class="form-control" type="text" value="Адрес"
                                       style="width: 200px; text-align: center;">
                                <textarea class="form-control" name="adress"
                                          style="width: 630px; text-align: center;" required
                                          rows="1"><?= $query[0][2] ?></textarea>
                            </div>
                            <?
                        }
                    }
                    ?>
                </div>
                <div class="col-2" style="text-align: left;">
                    <?
                    $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                    ?>
                    <img width='200' src="<?= $Image ?>">
                </div>

            </div>


            <div class="row object">
                <input readonly class="form-control" type="text" value="Дата подачи"
                       style="width: 200px; text-align: center;">
                <input readonly class="form-control" style="width: 800px; text-align: center;"
                       value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
            </div>
            <div class="row object">
                <input readonly class="form-control" type="text" value="Дата исполнения"
                       style="width: 200px; text-align: center;">
                <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                       required name="date"
                       value="<?= $query[0][5] ?>">
            </div>
            <div class="row object">
                <input readonly class="form-control" type="text" value="Тип заявки"
                       style="width: 200px; text-align: center;">
                <input readonly class="form-control" style="width: 800px; text-align: center;"
                       value="<?= $query[0][6] ?>">
            </div>
            <?
            if (isset($query[0][10])) {
                if (!empty($query[0][10])) {
                    ?>
                    <div class="row object">
                        <script>
                            function get() {
                                let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                                console.log(data);
                                switch (data) {
                                    case "ПВХ (мягкий)" :
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                            '<option value="1" selected>1</option>' +
                                            '</select>'
                                        )
                                        break;
                                    case "Орг. Стекло (прозрачное)" :
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                            '<option value="0,3">0,3</option>' +
                                            '<option value="0,5" >0,5</option>' +
                                            '<option value="0,75">0,75</option>' +
                                            '<option value="1">1</option>' +
                                            '<option value="2">2</option>'
                                        )
                                        break;
                                    case "Композит" :
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                            '<option value="3" >3</option>' +
                                            '<option value="4">4</option>'
                                        )
                                        break;
                                    case "Фанера" :
                                        document.getElementById("thickness").innerHTML = (
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
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="">Указывается в т.з.</option>'
                                        )
                                        break;
                                    case "Другое" :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="">Указывается в т.з.</option>'
                                        )
                                        break;
                                    default :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="">Выберите материал</option>'
                                        )
                                        break;
                                }
                            }
                        </script>
                        <div class="col">
                            <div class="row">
                                <input readonly class="form-control" type="text" value="Материал"
                                       style="width: 200px; text-align: center;">
                                <select class="form-select" id=select_material name="select_material"
                                        required style="width: 300px; text-align: center"
                                        onchange="get()">
                                    <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                        <div class="col">
                            <div class="row">
                                <input readonly class="form-control" type="text" value="Толщина"
                                       style="width: 200px; text-align: center;">

                                <select class="form-select" name="select_thickness" id="thickness"
                                        required style="width: 300px; text-align: center">
                                    <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                                </select>
                            </div>

                        </div>


                    </div>

                    <?
                }
            }
            ?>
            <div class="row object">
                <input readonly class="form-control" type="text" value="Тех. задание"
                       style="width: 200px; text-align: center;">
                <textarea wrap="soft" class="form-control pattern" name="techtask"
                          style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
            </div>
            <br>
            <?

            $files = $query[0][8];
            $files = str_replace('../', '', $files);
            $files = "../../" . $files;
            $dir = scandir($files);
            var_dump($dir);
            echo "<img src='" . $files . "/" . $dir[2] . "' alt='альтернативный текст'>";
            $cnt = 0;
            if ($dir > 2) {
                for ($i = 2; $i < count($dir); $i++) {
                    $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                    $png = $ord_id . ".png";
                    if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG" || $type_file == "tif") {
                        //echo "<div class='row' style='width: 1000px; height:700px'>";
                        echo "<center>";
                        $image = $files . "/" . $dir[$i];
                        echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                        echo "<br>";
                        echo "<br>";
                        echo "</center>";
                        //  echo "</div>";

                    }
                }
            }

            ?>
            <br>
            <center>
                <div class="row" style="text-align: center; width: 1000px;">
                    <table class="table table-hover table-sm" style="text-align: center; ">
                        <h3>Ответственные сотрудники</h3>
                        <thead>
                        <tr>
                            <th width="300">Должность</th>
                            <th width="700">ФИО</th>
                        </tr>
                        </thead>
                        <?
                        foreach ($query_users as $query_users) {
                            ?>
                            <tr>
                                <td><input class="form-control" style="text-align: center;" readonly
                                           value="<?= $query_users[0] ?>">
                                </td>
                                <td><input class="form-control" style="text-align: center" readonly
                                           value="<?
                                           echo $query_users[1];
                                           if ($query_users[0] == "Менеджер") {
                                               echo "     телефон ";
                                               echo $query_users[3];
                                           }

                                           ?>">
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>


                </div>
            </center>
            <br> <br>
        </div>
    </form>
    <center>
        <a class="btn btn-danger btn-lg"
           href="info.php?<?= $_SERVER['QUERY_STRING'] ?>&delete=1">
            УДАЛИТЬ ЗАЯВКУ
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill"
                 viewBox="0 0 16 16">
                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
            </svg>
        </a>
        <br>
        <br>
    </center>

<?
break;
}
break;
case 2:
switch ($WHAT) {
case "print":
?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                        <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес" name="adress"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {

                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>
        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>

        <br> <br>

    </div>
    <script>
        window.print();
    </script>

<?
break;
case "info":
?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                        <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled name="adress"
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {

                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>

        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>

        <br> <br>

    </div>

<?
break;
case "redact":

?>
    <form action="info.php?id=<?= $id ?>&ord_id=<?= $ord_id ?>&redact=1&save=1" method="post"
          id="block_frez"
          name="block_frez">

        <div class="container mt-2" style="width: 1000px;">
            <div class="row">
                <div class="col-10">
                    <div class="row" style="width: 800px">
                        <div class="col">
                            <h1>Заявка № <?= $ord_id ?> </h1>
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-primary btn-lg <?
                            if ($id != $q_u) {
                                echo "disabled";
                            }
                            ?>" type="sumbit" style="width: 300px;">
                                Сохранить изменения
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     fill="currentColor" class="bi bi-pencil-fill"
                                     viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <div class="row object">
                        <div class="row" style="width: 500px;">
                            <input class="form-control" style="width: 200px; text-align: center;"
                                   value="Статус заявки"
                                   readonly>
                            <?
                            switch ($sql[0][0]) {
                                case 0 :
                                    $inf = "Не выполнена";
                                    break;
                                case 1:
                                    $inf = "В обработке";
                                    break;

                                case 2:
                                    $inf = "Выполнена";
                                    break;
                            }
                            ?>
                            <input class="btn btn-<?
                            switch ($sql[0][0]) {
                                case 0 :
                                    echo "danger";
                                    break;
                                case 1:
                                    echo "warning";
                                    break;
                                case 2:
                                    echo "success";
                                    break;
                            } ?>" type="text" style="width: 200px; text-align: center;" readonly
                                   value="<?= $inf ?>">
                            <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="row object">
                        <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                               readonly>
                        <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                               required
                               style="width: 200px; text-align: center;">
                    </div>
                    <div class="row">
                        <input readonly class="form-control" type="text" value="Контакты"
                               style="width: 200px; text-align: center;">
                        <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                                  required
                                  rows="1"><?= $query[0][3] ?></textarea>
                    </div>

                    <?
                    if (isset($query[0][2])) {
                        if (!empty($query[0][2])) {
                            ?>
                            <div class="row">
                                <input readonly class="form-control" type="text" value="Адрес"
                                       style="width: 200px; text-align: center;">
                                <textarea class="form-control" name="adress"
                                          style="width: 630px; text-align: center;" required
                                          rows="1"><?= $query[0][2] ?></textarea>
                            </div>
                            <?
                        }
                    }
                    ?>
                </div>
                <div class="col-2" style="text-align: left;">
                    <?
                    $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                    ?>
                    <img width='200' src="<?= $Image ?>">
                </div>

            </div>


            <div class="row object">
                <input readonly class="form-control" type="text" value="Дата подачи"
                       style="width: 200px; text-align: center;">
                <input readonly class="form-control" style="width: 800px; text-align: center;"
                       value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
            </div>
            <div class="row object">
                <input readonly class="form-control" type="text" value="Дата исполнения"
                       style="width: 200px; text-align: center;">
                <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                       required name="date"
                       value="<?= $query[0][5] ?>">
            </div>
            <div class="row object">
                <input readonly class="form-control" type="text" value="Тип заявки"
                       style="width: 200px; text-align: center;">
                <input readonly class="form-control" style="width: 800px; text-align: center;"
                       value="<?= $query[0][6] ?>">
            </div>
            <?
            if (isset($query[0][10])) {
                if (!empty($query[0][10])) {
                    ?>
                    <div class="row object">
                        <script>
                            function get() {
                                let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                                console.log(data);
                                switch (data) {
                                    case "ПВХ (мягкий)" :
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                            '<option value="1" selected>1</option>' +
                                            '</select>'
                                        )
                                        break;
                                    case "Орг. Стекло (прозрачное)" :
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                            '<option value="0,3">0,3</option>' +
                                            '<option value="0,5" >0,5</option>' +
                                            '<option value="0,75">0,75</option>' +
                                            '<option value="1">1</option>' +
                                            '<option value="2">2</option>'
                                        )
                                        break;
                                    case "Композит" :
                                        document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                            '<option value="3" >3</option>' +
                                            '<option value="4">4</option>'
                                        )
                                        break;
                                    case "Фанера" :
                                        document.getElementById("thickness").innerHTML = (
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
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="">Указывается в т.з.</option>'
                                        )
                                        break;
                                    case "Другое" :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="">Указывается в т.з.</option>'
                                        )
                                        break;
                                    default :
                                        document.getElementById("thickness").innerHTML = (
                                            '<option value="">Выберите материал</option>'
                                        )
                                        break;
                                }
                            }
                        </script>
                        <div class="col">
                            <div class="row">
                                <input readonly class="form-control" type="text" value="Материал"
                                       style="width: 200px; text-align: center;">
                                <select class="form-select" id=select_material name="select_material"
                                        required style="width: 300px; text-align: center"
                                        onchange="get()">
                                    <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                        <div class="col">
                            <div class="row">
                                <input readonly class="form-control" type="text" value="Толщина"
                                       style="width: 200px; text-align: center;">

                                <select class="form-select" name="select_thickness" id="thickness"
                                        required style="width: 300px; text-align: center">
                                    <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                                </select>
                            </div>

                        </div>


                    </div>

                    <?
                }
            }
            ?>
            <div class="row object">
                <input readonly class="form-control" type="text" value="Тех. задание"
                       style="width: 200px; text-align: center;">
                <textarea wrap="soft" class="form-control pattern" name="techtask"
                          style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
            </div>
            <br>
            <?

            $files = $query[0][8];
            $files = str_replace('../', '', $files);
            $files = "../../" . $files;
            $dir = scandir($files);
            $cnt = 0;
            if ($dir > 2) {
                for ($i = 2; $i < count($dir); $i++) {

                    $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                    $png = $ord_id . ".png";
                    if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                        //echo "<div class='row' style='width: 1000px; height:700px'>";
                        echo "<center>";
                        $image = $files . "/" . $dir[$i];
                        echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                        echo "<br>";
                        echo "<br>";
                        echo "</center>";
                        //  echo "</div>";

                    }
                }
            }

            ?>
            <br>
            <center>
                <div class="row" style="text-align: center; width: 1000px;">
                    <table class="table table-hover table-sm" style="text-align: center; ">
                        <h3>Ответственные сотрудники</h3>
                        <thead>
                        <tr>
                            <th width="300">Должность</th>
                            <th width="700">ФИО</th>
                        </tr>
                        </thead>
                        <?
                        foreach ($query_users as $query_users) {
                            ?>
                            <tr>
                                <td><input class="form-control" style="text-align: center;" readonly
                                           value="<?= $query_users[0] ?>">
                                </td>
                                <td><input class="form-control" style="text-align: center" readonly
                                           value="<?
                                           echo $query_users[1];
                                           if ($query_users[0] == "Менеджер") {
                                               echo "     телефон ";
                                               echo $query_users[3];
                                           }

                                           ?>">
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>


                </div>
            </center>
            <br> <br>
        </div>

    </form>
<?
break;
}
break;
case 3:
switch ($WHAT) {
case "print":

?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                        <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес" name="adress"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {

                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>
        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>

        <br> <br>

    </div>
    <script>
        window.print();
    </script>


<?
$str = "UPDATE ordstatus SET print = 1 WHERE oID = " . $ord_id;
mysqli_query($connect, $str);
break;
case "info":
?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                        <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес" name="adress"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {

                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>

        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>

        <br> <br>

    </div>

<?
break;
}
break;
default:
switch ($WHAT) {
case "info":
?>
    <div class="container mt-2" style="width: 1000px;">
        <div class="row">
            <div class="col-10">
                <div class="row" style="width: 800px">
                    <div class="col">
                        <h1>Заявка № <?= $ord_id ?> </h1>
                    </div>
                </div>
                <div class="row object">
                    <div class="row" style="width: 500px;">
                        <input class="form-control" style="width: 200px; text-align: center;"
                               value="Статус заявки"
                               readonly>
                        <?
                        switch ($sql[0][0]) {
                            case 0 :
                                $inf = "Не выполнена";
                                break;
                            case 1:
                                $inf = "В обработке";
                                break;

                            case 2:
                                $inf = "Выполнена";
                                break;
                        }
                        ?>
                        <input class="btn btn-<?
                        switch ($sql[0][0]) {
                            case 0 :
                                echo "danger";
                                break;
                            case 1:
                                echo "warning";
                                break;
                            case 2:
                                echo "success";
                                break;
                        } ?>" type="text" style="width: 200px; text-align: center;" readonly
                               value="<?= $inf ?>">
                    </div>
                    <a class="btn btn-outline-warning btn" style="width: 50px;" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                    </a>
                </div>
                <div class="row object">
                    <input class="form-control" style="width: 200px; text-align: center;" value="Заказчик"
                           disabled>
                    <input class="form-control" type="text" name="company" value="<?= $query[0][1] ?>"
                           disabled
                           style="width: 200px; text-align: center;">
                </div>
                <div class="row">
                    <input disabled class="form-control" type="text" value="Контакты"
                           style="width: 200px; text-align: center;">
                    <textarea class="form-control" style="width: 630px; text-align: center;" name="contact"
                              disabled
                              rows="1"><?= $query[0][3] ?></textarea>
                </div>

                <?
                if (isset($query[0][2])) {
                    if (!empty($query[0][2])) {
                        ?>
                        <div class="row">
                            <input readonly class="form-control" type="text" value="Адрес" name="adress"
                                   style="width: 200px; text-align: center;">
                            <textarea class="form-control"
                                      style="width: 630px; text-align: center;" disabled
                                      rows="1"><?= $query[0][2] ?></textarea>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="col-2" style="text-align: left;">
                <?
                $Image = "../../" . $query[0][8] . "/" . $ord_id . ".png";
                ?>
                <img width='200' src="<?= $Image ?>">
            </div>

        </div>


        <div class="row object">
            <input disabled class="form-control" type="text" value="Дата подачи"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= date("d-m-Y H:i", strtotime($query[0][4])) ?>">
        </div>
        <div class="row object">
            <input readonly class="form-control" type="text" value="Дата исполнения"
                   style="width: 200px; text-align: center;">
            <input class="form-control" type="datetime-local" style="width: 800px; text-align: center;"
                   disabled name="date"
                   value="<?= $query[0][5] ?>">
        </div>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тип заявки"
                   style="width: 200px; text-align: center;">
            <input disabled class="form-control" style="width: 800px; text-align: center;"
                   value="<?= $query[0][6] ?>">
        </div>
        <?
        if (isset($query[0][10])) {
            if (!empty($query[0][10])) {
                ?>
                <div class="row object">
                    <script>
                        function get() {
                            let data = block_frez.select_material[block_frez.select_material.selectedIndex].text;
                            console.log(data);
                            switch (data) {
                                case "ПВХ (мягкий)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<select name = "thickness_select" style = "width: 200px" class="form-select" required>' +
                                        '<option value="1" selected>1</option>' +
                                        '</select>'
                                    )
                                    break;
                                case "Орг. Стекло (прозрачное)" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
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
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="0,3">0,3</option>' +
                                        '<option value="0,5" >0,5</option>' +
                                        '<option value="0,75">0,75</option>' +
                                        '<option value="1">1</option>' +
                                        '<option value="2">2</option>'
                                    )
                                    break;
                                case "Композит" :
                                    document.getElementById("thickness").innerHTML = ('<option value="">Не выбрано</option>' +
                                        '<option value="3" >3</option>' +
                                        '<option value="4">4</option>'
                                    )
                                    break;
                                case "Фанера" :
                                    document.getElementById("thickness").innerHTML = (
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
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                case "Другое" :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Указывается в т.з.</option>'
                                    )
                                    break;
                                default :
                                    document.getElementById("thickness").innerHTML = (
                                        '<option value="">Выберите материал</option>'
                                    )
                                    break;
                            }
                        }
                    </script>
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Материал"
                                   style="width: 200px; text-align: center;">
                            <select class="form-select" id=select_material name="select_material"
                                    disabled style="width: 300px; text-align: center"
                                    onchange="get()">
                                <option value="<?= $query[0][9] ?>"><?= $query[0][9] ?></option>
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
                    <div class="col">
                        <div class="row">
                            <input disabled class="form-control" type="text" value="Толщина"
                                   style="width: 200px; text-align: center;">

                            <select class="form-select" name="select_thickness" id="thickness"
                                    disabled style="width: 300px; text-align: center">
                                <option value="<?= $query[0][10] ?>"><?= $query[0][10] ?></option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row object">

                </div>
                <?
            }
        }
        ?>
        <div class="row object">
            <input disabled class="form-control" type="text" value="Тех. задание" name="techtask"
                   style="width: 200px; text-align: center;">
            <textarea wrap="soft" class="form-control pattern" disabled
                      style="width: 800px; height: 150px; text-align: left;"><?= $query[0][7]; ?></textarea>
        </div>
        <br>
        <?

        $files = $query[0][8];
        $files = str_replace('../', '', $files);
        $files = "../../" . $files;
        $dir = scandir($files);
        $cnt = 0;
        if ($dir > 2) {
            for ($i = 2; $i < count($dir); $i++) {

                $type_file = $dir[$i][strlen($dir[$i]) - 3] . $dir[$i][strlen($dir[$i]) - 2] . $dir[$i][strlen($dir[$i]) - 1];
                $png = $ord_id . ".png";
                if ($type_file == "jpg" || $type_file == "png" && $dir[$i] != $png || $type_file == "JPG" || $type_file == "PNG" || $type_file == "peg" || $type_file == "PEG") {
                    //echo "<div class='row' style='width: 1000px; height:700px'>";
                    echo "<center>";
                    $image = $files . "/" . $dir[$i];
                    echo $image == "" ? "No image" : "<img style =' width: 450px;' src='" . $image . "'></img>";
                    echo "<br>";
                    echo "<br>";
                    echo "</center>";
                    //  echo "</div>";

                }
            }
        }

        ?>

        <br>
        <center>
            <div class="row" style="text-align: center; width: 1000px;">
                <table class="table table-hover table-sm" style="text-align: center; ">
                    <h3>Ответственные сотрудники</h3>
                    <thead>
                    <tr>
                        <th width="300">Должность</th>
                        <th width="700">ФИО</th>
                    </tr>
                    </thead>
                    <?
                    foreach ($query_users as $query_users) {
                        ?>
                        <tr>
                            <td><input class="form-control" style="text-align: center;" readonly
                                       value="<?= $query_users[0] ?>">
                            </td>
                            <td><input class="form-control" style="text-align: center" readonly
                                       value="<?
                                       echo $query_users[1];
                                       if ($query_users[0] == "Менеджер") {
                                           echo "     телефон ";
                                           echo $query_users[3];
                                       }

                                       ?>">
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>


            </div>
        </center>


        <br> <br>

    </div>

    <?
    break;
}
    break;
}

?>


</body>
</html>
