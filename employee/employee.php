<?php
require "../config/config.php";
require "../config/auth.php";
$id = $_GET['id'];
$empl = "montage";
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
<?
if (isset($_GET['delete'])) {
    $u_id = $_GET['delete'];
    $sql = "SELECT QR FROM users WHERE  id = '$u_id'";
    $sql = mysqli_query($connect, $sql);
    $sql = mysqli_fetch_all($sql);
    $unlink = "../" . $sql[0][0];
    unlink($unlink);
    $sql = "DELETE FROM `users` WHERE id = '$u_id'";
    mysqli_query($connect, $sql);
    ?>
    <script>
        alert("Сотрудник уволен");
    </script>
    <?
}
?>
<center>
    <div class="container mt-4">
        <h1>Монтажники</h1>
        <div class="row">
            <div class="col" style="text-align: left">
                <a class="btn btn-outline-success btn" href="../RegFun/RegForm.php?id=<?= $id ?>&empl=<?= $empl ?>">
                    Добавить нового сотрудника
                </a>
            </div>
            <div class="col" style="text-align: right">
                <a class="btn btn-outline-danger" href="../Personal_Area/lk.php?id=<?= $id ?>">
                    Вернуться в личный кабинет
                </a>
            </div>
        </div>
        <div class="row" style="width: 1300px">
            <table class="table table-hover table">
                <thead>
                <tr>
                    <th width="150">QR</th>
                    <th width="150">Фото</th>
                    <th width="250">ФИО</th>
                    <th width="300">Контакты</th>
                    <th width="200">День рождения</th>
                    <th width="80"></th>
                    <th width="80"></th>
                    <th width="80"></th>
                </tr>
                </thead>
                <?
                $date_1 = new DateTime('-15 days');
                $date_2 = new DateTime('+15 days');
                $date_1 = $date_1->format('Y-m-d');
                $date_2 = $date_2->format('Y-m-d');
                $query = mysqli_query($connect, "SELECT `name`, `image`, `phone`, `birthday`, `e-mail`, `id`, `QR`, messengerV, messengerW, messengerT FROM users WHERE catId = '5'");
                $query = mysqli_fetch_all($query);
                foreach ($query

                as $query) {
                ?>
                <tr>
                    <?
                    $Image = "../" . $query[6];
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='100' src='" . $Image . "'></img>") . "</td>";
                    ?>
                    <?
                    $Image = "../image/avatar/";
                    $Image = $Image . $query[1];
                    echo "<td>" . ($Image == "" ? "No image" : "<img width='100' src='" . $Image . "'></img>") . "</td>";
                    ?>
                    <td><a class="btn btn-light btn-lg" style="width: 230px; height: 78px"><?= $query[0] ?></a></td>
                    <td><a class="btn btn-light btn-lg" style="width: 280px; height: 78px"><?= $query[2] ?>
                            <br> <?= $query[4] ?> </a>
                        <br>
                        <div class="row">
                            <div class="col" style="text-align: right">
                                <?
                                if ($query[7] == true) {
                                    $Image = "../RegFun/css/viber.png";
                                    echo($Image == "" ? "No image" : "<img width='40' src='" . $Image . "'></img>");
                                } ?>
                            </div>
                            <div class="col">
                                <?
                                if ($query[8] == true) {
                                    $Image = "../RegFun/css/whatsapp.png";
                                    echo($Image == "" ? "No image" : "<img width='40' src='" . $Image . "'></img>");

                                }
                                ?>
                            </div>
                            <div class="col" style="text-align: left">
                                <?
                                if ($query[9] == true) {
                                    $Image = "../RegFun/css/telegram.png";
                                    echo($Image == "" ? "No image" : "<img width='40' src='" . $Image . "'></img>");
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-light btn-lg" style="width: 180px; height: 78px">
                            <? if (isset($query[3])) {
                                echo date("d-m-Y", strtotime($query[3]));
                            }
                            ?> </a>
                    </td>
                    <td>
                        <br>
                        <a class="btn btn-outline-primary btn-lg"
                           href="Stat/Stat.php?id=<?= $id ?>&redact=<?= $query[5] ?>&dateStart=<?= $date_1 ?>&dateEnd=<?= $date_2 ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                 class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                                <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <br>
                        <a class="btn btn-outline-secondary btn-lg"
                           href="../RegFun/UserUpdate.php?id=<?= $id ?>&redact=<?= $query[5] ?>&empl=<?= $empl ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                 fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <br>
                        <a class="btn btn-outline-danger btn-lg"
                           href="employee.php?id=<?= $id ?>&delete=<?= $query[5] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                 class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </a>
                    </td>
                    <? } ?>
            </table>
        </div>


</center>


</body>
</html>

