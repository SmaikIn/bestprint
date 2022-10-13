<?php

require('../../../../config/config.php');
require('../../../../config/auth.php');
$id = $_GET['id'];
$u_id = $_GET['u_id'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Информация о заявках</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

<div class="container mt-2">
    <center>
        <h1>Выполненые заявки сотрудника</h1>
        <h1><?= $_GET['name'] ?></h1>
    </center>
    <div class="row">
        <div class="col" style="text-align: left">
        </div>
        <div class="col" style="text-align: right;">
            <a class="btn btn-outline-danger" style="width: 300px;" onclick="window.close()"> Закрыть вкладку </a>
        </div>
        <br>
        <br>
        <div class="row" style="width: 1300px">
            <div class="table">
                <?
                $stringQuery = "SELECT orders.id, orders.company, orders.typeTask FROM
                                orders INNER JOIN ordstatus on ordstatus.oId = orders.id 
                                INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId 
                                WHERE users.id = " . $u_id . " AND ordstatus.status = 2";

                $query = mysqli_query($connect, $stringQuery);
                $query = mysqli_fetch_all($query);

                ?>
                <table class="table table-hover table-sm" style="text-align: center">
                    <thead>
                    <tr>
                        <th width="50">id</th>
                        <th width="150">Компания</th>
                        <th width="150">Тип заявки</th>
                        <th width="150">Отчёт</th>
                    </tr>
                    </thead>
                    <?

                    if (!empty($query)) {
                        foreach ($query
                                 as $query) {
                            ?>

                            <tr>
                                <td>
                                    <input class="form-control" style="text-align: center;" type="text" readonly
                                           value=" <?= $query[0] ?>" name="car_id" required>
                                </td>
                                <td>
                                    <input class="form-control" type="text" style="text-align: center;" readonly
                                           value="<?= $query[1] ?>" name="vehicleNum">
                                </td>
                                <td>
                                    <input class="form-control" type="text" style="text-align: center;" readonly
                                           value="<?= $query[2] ?>" name="vehicleMod">
                                </td>
                                <td>
                                    <a class="btn btn-outline-primary btn-lg" target="_blank"
                                       href="../../../../Orders/info/info.php?id=<?= $id ?>&ord_id=<?= $query[0] ?>&info=1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-info-circle-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                            <?
                        }
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
