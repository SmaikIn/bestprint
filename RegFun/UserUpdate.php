<?php
require "../config/config.php";
require "../config/auth.php";

$id = $_GET['id'];
$redact = $_GET['redact'];
$query = mysqli_query($connect, "SELECT * FROM users WHERE id = '$redact'");
$query = mysqli_fetch_all($query);
$empl = $_GET['empl'];

?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактирование профиля</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/RegStyle.css">
    <script src="../../../tel_Script/phoneinput.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector('input').focus();
        })
    </script>
</head>
<style>
    select {
        text-align: center;
    }

    input {
        text-align: center;
    }
</style>
<body>

<center>
    <div class="container mt-4">
        <h1>Редактирование профиля</h1>
        <?
        if (isset($_GET['dir'])) {
            ?>
            <a href="../employee/Direktor_Info/employ.php?<?= $_SERVER['QUERY_STRING'] ?>"
               class="btn btn-danger btn-sm">Вернуться к просмотру сотрудников</a>
            <?
        } else {
            ?>
            <a href="../employee/employee.php?<?= $_SERVER['QUERY_STRING'] ?>" class="btn btn-danger btn-sm">Вернуться к
                просмотру сотрудников</a>
            <?
        }
        ?>

        <br>
        <form action="UpdateScript.php?<?= $_SERVER['QUERY_STRING'] ?>" method="post"
              enctype="multipart/form-data">
            <br>
            <h6>Выберете должность сотрудника</h6>
            <?php
            switch ($empl) {
                case "montage":
                    $val = mysqli_query($connect, "SELECT * FROM `category` WHERE id = 5");
                    $val = mysqli_fetch_all($val);
                    break;
                case "manager":
                    $val = mysqli_query($connect, "SELECT * FROM `category` WHERE id = 2");
                    $val = mysqli_fetch_all($val);
                    break;
                case "empl" :
                    $val = mysqli_query($connect, "SELECT * FROM `category` WHERE id != 2 AND id != 5");
                    $val = mysqli_fetch_all($val);
                    break;
            }
            ?>
            <select name="category" class="form-select" size=1>
                <?php
                foreach ($val as $val) {
                    ?>
                    <option value= <?= $val[0] ?>> <?= $val[1] ?> </option>
                    <?php
                }
                ?>
            </select>
            <br>
            <?php
            if ($empl != "montage") {
                ?>
                <input type="text" class="form-control" name="login" id="login" required
                       placeholder="Введите логин (от 5 до 20 символов)" value="<?= $query[0][1] ?>" autocomplete="off">
                <br>
                <input type="text" class="form-control" name="password" id="password" required
                       placeholder="Введите новый пароль (если забыли) (от 5 до 20 символов)" autocomplete="off">
                <br>
            <? } ?>
            <input type="text" class="form-control" name="name" id="name" required
                   placeholder="Введите ФИО (От 2 до 30 символов)" value="<?= $query[0][4] ?>" autocomplete="off">
            <br>
            <input type="text" class="form-control" name="phonenum" id="phonenum" required maxlength="18" data-tel-input
                   placeholder="Введите номер телефона" value="<?= $query[0][7] ?>" autocomplete="off">
            <br>
            <input type="text" class="form-control" name="email" id="email" placeholder="Введите e-mail"
                   value="<?= $query[0][9] ?>"
                   autocomplete="off">
            <br>
            <h6>Контактные мессенджеры</h6>
            <div class="row">
                <div class="col">
                    <input type="checkbox" id="size" readonly
                        <?
                        if ($query[0][12] == 1) {
                            echo "checked";
                        }
                        ?>
                           name="Viber"><label>Viber</label><br>
                    <?
                    $Image = "css/viber.png";
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='50' src='" . $Image . "'></img>") . "</td>"; ?>
                </div>
                <div class="col">
                    <input type="checkbox" id="size"
                        <?
                        if ($query[0][13] == 1) {
                            echo "checked";
                        }
                        ?>
                           name="Whatsapp"><label>Whatsapp</label><br>
                    <?
                    $Image = "css/whatsapp.png";
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='50' src='" . $Image . "'></img>") . "</td>"; ?>
                </div>
                <div class="col">
                    <input type="checkbox"
                        <?
                        if ($query[0][14] == 1) {
                            echo "checked";
                        }
                        ?>
                           id="size" name="Telegram"><label>Telegram</label><br>
                    <?
                    $Image = "css/telegram.png";
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='50' src='" . $Image . "'></img>") . "</td>"; ?>
                </div>
            </div>
            <br>
            <div class="container">
                <div class="row">
                    <h6>Не обязательно</h6>
                    <div class="col">
                        <h6>Фото сотрудника</h6>
                        <input type="file" class="form-control" name="filename" accept="image/jpeg, image/png"> <br>
                    </div>
                    <div class="col">
                        <h6>День рождения</h6>
                        <input type="date" class="form-control" value="<?= $query[0][8] ?>" name="birthday"> <br>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
        </form>

    </div>
</center>


</body>
</html>