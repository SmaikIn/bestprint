<?php
require "../config/config.php";
require "../config/auth.php";
$id = $_GET['id'];
$category = 5;
?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Список монтажников</title>
</head>
<style>
    table {
        border: 1px solid #f6f6f6;
        table-layout: fixed;
        margin-bottom: 20px;
        text-align: center;
    }

    body {
        font: 13px/1.5 ‘Helvetica Neue’, Arial, ‘Liberation Sans’, FreeSans, sans-serif;
        background: #ffffff;
    }
</style>
<body>
<center>
    <div class="container mt-4">
        <h1>Монтажники</h1>
        <div class="row">
            <div class="col">
                <form method="post" action="../RegFun/RegForm.php?id=<?= $id ?>&category=5 ">
                    <button type="submit" class="btn btn-success btn-sm">Добавить нового сотрудника</button>
                </form>
            </div>
            <div class="col">
                <form method="post" action="../Personal_Area/lk.php?id=<?= $id ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Вернуться в личный кабинет</button>
                </form>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Фото</th>
                <th>ФИО</th>
                <th width="250">Контакты</th>
                <th>День рождения</th>
                <th width="125">Табель</th>
                <th width="200">Редактирование Профиля</th>
                <th width="100">Уволить</th>
            </tr>
            </thead>
            <?
            $query = mysqli_query($connect, "SELECT `name`, `image`, `phone`, `birthday`, `e-mail`, `id` FROM users WHERE catId = '5'");
            $query = mysqli_fetch_all($query);
            foreach ($query as $query) {
            ?>
            <tr>
                <?
                $Image = "../image/avatar/";
                $Image = $Image . $query[1];
                echo "<td>" . ($Image == "" ? "No image" : "<img width='100' src='" . $Image . "'></img>") . "</td>";
                ?>
                <td><h5><?= $query[0] ?></h5></td>
                <td><h5><? echo $query[2]; ?> <br><br> <? echo $query[4]; ?> </h5></td>
                <td><h5><? if (isset($query[3])){
                            echo date("d-m-Y", strtotime($query[3]));
                        }
                        ?></h5></td>
                <td>
                    <form method="get" action="Stat/Stat.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="redact" value="<?= $query[5] ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Табель</button>
                    </form>
                </td>
                <td>
                    <form method="get" action="../RegFun/UserUpdate.php?">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="category" value="<?= $category ?>">
                        <input type="hidden" name="redact" value="<?= $query[5] ?>">
                        <button type="submit" class="btn btn-secondary btn-sm">Редактировать</button>
                    </form>
                </td>
                <td>
                    <button type="submit" class="btn btn-danger btn-sm">Уволить</button>
                </td>
                <? } ?>
        </table>

</center>


</body>
</html>

