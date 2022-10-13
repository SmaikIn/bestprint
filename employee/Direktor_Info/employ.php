<?php
require "../../config/config.php";
require "../../config/auth.php";
$id = $_GET['id'];
$category = 5;

if (isset($_GET['empl'])) {
    $empl = $_GET['empl'];
}
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
    <title>Рабочие Предприятия</title>
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
<script>
    setTimeout(function () {
        location.reload();
    }, 15000);
</script>
<?

switch ($empl) {
    case "montage":
        $query = mysqli_query($connect, "SELECT `name`, `image`, `id` FROM users WHERE catId = '5' ");
        $query = mysqli_fetch_all($query);
        echo "<center>";
        echo "<div class='container mt-4'>";
        echo "<h1>Список монтажников</h1>";
        break;
    case "manager":
        $query = mysqli_query($connect, "SELECT `name`, `image`, `id` FROM users WHERE catId = '2' ");
        $query = mysqli_fetch_all($query);
        echo "<center>";
        echo "<div class='container mt-4'>";
        echo "<h1>Список менеджеров</h1>";
        break;
        ?>


    <?
    case "empl":
        $query = mysqli_query($connect, "SELECT users.`name`, users.`image`, users.`id`, users.`catId`, category.name FROM users INNER JOIN category on category.id = users.catId  WHERE catId != '5' AND catId != '2'");
        $query = mysqli_fetch_all($query);
        echo "<center>";
        echo "<div class='container mt-4'>";
        echo "<h1>Список сотрудников</h1>";
        break;


}
?>
<div class="row" style="width: 1000px;">
    <div class="col" style="text-align: left">
        <a class="btn btn-outline-success btn" style="width: 250px"
           href="../../RegFun/RegForm.php?id=<?= $id ?>&empl=<?= $empl ?>&dir=dir">
            Добавить нового сотрудника
        </a>
    </div>
    <?
    if ($empl == "montage") {
        ?>
        <div class="col" style="text-align: center;">
            <a class="btn btn-outline-warning btn" target="_blank" style="width: 250px"
               href="../../employee/TabelM/TabelM.php?id=<?= $id ?>">Табель рабочего времени</a>
        </div>
        <?
    }
    ?>

    <div class="col" style="text-align: right">
        <a class="btn btn-outline-danger" style="width: 250px" href="../../Personal_Area/lk.php?id=<?= $id ?>">
            Вернуться в личный кабинет
        </a>
    </div>
</div>
<div class="row" style="width: 1000px">


    <table class="table table-hover table-responsive-xxl">
        <thead>
        <tr>
            <th>Фото</th>
            <th>ФИО</th>
            <?
            if ($empl == "empl") {
                ?>
                <th>Должность</th>
                <?
            }
            ?>
            <th>Информация</th>

        </tr>
        </thead>
        <?

        foreach ($query

        as $query) {
        ?>
        <tr>
            <?
            $Image = "../../image/avatar/";
            $Image = $Image . $query[1];
            echo "<td>" . ($Image == "" ? "No image" : "<img width='100' src='" . $Image . "'></img>") . "</td>";
            ?>
            <td><a class="btn btn-light btn-lg"
                   style="width: 230px; height: 78px"><?= $query[0] ?></a>
            </td>
            <?
            if ($empl == "empl") {
                ?>
                <td><a class="btn btn-light btn-lg"
                       style="width: 230px; height: 78px"><?= $query[4] ?></td>
                <?
            }
            ?>
            <td><a class="btn btn-outline-info btn-lg"
                   style="width: 78px;height: 78px; "
                   href="profile/profile.php?id=<?= $id ?>&u_id=<?= $query[2] ?>&empl=<?= $empl ?>"
                   target="_blank">
                    <svg
                            xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                            fill="currentColor"
                            class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                </a></td>
            <? } ?>
    </table>
</div>
</div>

</center>
</body>
</html>

