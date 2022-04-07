<?php
require "../config/config.php";
require "../config/auth.php";

$id = $_GET['id'];
$category = $_GET['category'];
$redact = $_GET['redact'];
$query = mysqli_query($connect, "SELECT * FROM users WHERE id = '$redact'");
$query = mysqli_fetch_all($query);
?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация нового пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/RegStyle.css">
</head>
<body>
<center>
    <div class ="container mt-4">
        <h1>Редактирование информации</h1>
        <form method="post" action="../employee/employee.php?id=<?=$id?>">
            <button type="submit" class="btn btn-danger btn-sm">Вернуться к просмотру сотрудников</button>
        </form>
        <br>
        <form action="UpdateScript.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="redact" value="<?=$redact?>">
            <h6>Выберете должность сотрудника</h6>
            <?php
            if (empty($_GET['category'])){
                $val = mysqli_query($connect, "SELECT * FROM `category`");
                $val = mysqli_fetch_all($val);
            }else{
                $val = mysqli_query($connect, "SELECT * FROM `category` WHERE id = 5");
                $val = mysqli_fetch_all($val);
            }
            ?>
            <select name="category" size=1>
                <?php
                foreach ($val as $val) {
                    ?>
                    <option value= <?= $val[0] ?>> <?= $val[1] ?> </option>
                    <?php
                }
                ?>
            </select>
            <br><br>
            <?php
            if (empty($_GET['category'])){
                ?>
                <h6>Изменить Логин</h6>
                <input type="text" class="form-control" name="login" id="login" required placeholder="Логин" autocomplete= "off" value="<?=$query[0][1]?>">
                <h6>Изменить Пароль</h6>
                <input type="text" class="form-control" name="password" id="password" required placeholder="Введите новый пароль (от 2 до 10 символов)" autocomplete= "off">
                <br>
            <?}?>
            <h6>Изменить ФИО</h6>
            <input type="text" class="form-control" name="name" id="name" required placeholder="Введите ФИО (От 2 до 30 символов)" autocomplete= "off" value="<?=$query[0][4]?>">
            <h6>Изменить Телефон</h6>
            <input type="text" class="form-control" name="phonenum" id="phonenum" required placeholder="Введите номер телефона" autocomplete= "off" value="<?=$query[0][7]?>">
            <h6>Изменить e-mail</h6>
            <input type="text" class="form-control" name="email" id="email" placeholder="Введите e-mail" autocomplete= "off" value="<?=$query[0][9]?>" >
            <br>
            <h6>Контактные мессенджеры</h6>
            <div class="row">
                <div class="col">
                    <? if ($query[0][12] == true){
                    ?>
                    <input type="checkbox" id="size" name="Viber" checked > <label>Viber</label><br>
                    <?}else{?>
                        <input type="checkbox" id="size" name="Viber" > <label>Viber</label><br>
                    <?}
                    $Image = "css/viber.png";
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='50' src='" . $Image . "'></img>") . "</td>";?>
                </div>
                <div class="col">
                    <? if ($query[0][13] == true){
                        ?>
                        <input type="checkbox" id="size" name="Whatsapp" checked><label>Whatsapp</label><br>
                    <?}else{?>
                        <input type="checkbox" id="size" name="Whatsapp" ><label>Whatsapp</label><br>
                    <?}
                    $Image = "css/whatsapp.png";
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='50' src='" . $Image . "'></img>") . "</td>";?>
                </div>
                <div class="col">
                    <? if ($query[0][14] == true){
                        ?>
                        <input type="checkbox" id="size" name="Telegram" checked><label>Telegram</label><br>
                    <?}else{?>
                        <input type="checkbox" id="size" name="Telegram"><label>Telegram</label><br>
                    <?}
                    $Image = "css/telegram.png";
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='50' src='" . $Image . "'></img>") . "</td>";?>
                </div>
            </div>
            <br>
            <div class ="container">
                <div class="row">
                    <h6>Не обязательно</h6>
                        <h6>День рождения</h6>
                        <input type="date" name = "birthday" value="<?=$query[0][8]?>"> <br>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
        </form>

    </div>
</center>


</body>
</html>