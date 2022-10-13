<?php
require('../../config/config.php');
require('../../config/auth.php');
$id = $_GET['id'];
$dateStart = $_GET['dateStart'];
$dateEnd = $_GET['dateEnd'];


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
    <title>Табель цеха</title>
</head>
<body>

<center>
    <div class="container mt-4">
        <h1>Монтажники</h1>
        <div class="row">
            <div class="col-3">
                <form method="get" action="TabelM.php">
                    <div class="row">
                        <center>
                            <br>
                            <h3> Выберите период: </h3>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="date" class="form-control" name="dateStart" value="<?= $dateStart ?>"
                                   style="width: 250px;" required>
                            <input type="date" class="form-control" name="dateEnd" value="<?= $dateEnd ?>"
                                   style="width: 250px;" required>
                            <button type="submit" class="btn btn-success btn" style="width: 250px;">Выбрать период
                            </button>
                        </center>
                    </div>
                </form>
                <br>
                <div class="row" style="width: 250px;">
                    <a class="btn btn-warning btn-sm"
                       href="TabelM.php?id=<?= $id ?>&dateStart=<?= date('Y-m-01'); ?>&dateEnd=<?= date("Y-m-20"); ?>">C
                        1 по 20</a>
                </div>
                <br>
                <div class="row" style="width: 250px;">
                    <a class="btn btn-warning btn-sm"
                       href="TabelM.php?id=<?= $id ?>&dateStart=<?= date('Y-m-01'); ?>&dateEnd=<?= date("Y-m-30"); ?>">
                        С 1 по 30</a>
                </div>
                <br>

            </div>

            <div class="col-8">
                <?
                $query = mysqli_query($connect, "SELECT users.name, sum(worktime.TimeResult), sum(worktime.OverTime) 
                                                        FROM users INNER JOIN worktime on users.id = worktime.u_id 
                                                        WHERE users.catId = 5 AND worktime.date
                                                        BETWEEN '$dateStart' AND '$dateEnd' 
                                                        GROUP BY users.name");
                if ($query == NULL) {
                    echo "<h2>За выбранный период отчёт не сформирован</h2>";
                    exit();
                }
                $query = mysqli_fetch_all($query);

                ?>
                <table class="table table-hover" style="text-align: center; width: 800px;">
                    <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Раб. часы</th>
                        <th>Доп. часы</th>
                        <th>Итого</th>
                        <th>
                            <a class="btn btn-warning btn-sm" target="_blank"
                               href="TabelM_Print.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-printer-fill" viewBox="0 0 16 16">
                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                </svg>
                                Печать табеля</a>
                        </th>
                    </tr>
                    </thead>
                    <?
                    $a = 0;
                    $z1 = 0;
                    $b = 0;
                    $z2 = 0;
                    $c = 0;
                    $z3 = 0;
                    foreach ($query as $query) {
                        ?>
                        <tr>
                            <td style="text-align: left">
                                <a class="btn btn-light" style="width: 300px;"><?= $query[0] ?></a>
                            </td>
                            <td><a class="btn btn-light" style="width: 100px;">
                                    <?
                                    $a = round($query[1] / 3600, 0);
                                    echo $a;
                                    $z1 = $z1 + $a;
                                    ?>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-light" style="width: 50px;">
                                    <?
                                    $b = round($query[2] / 3600, 0);
                                    echo $b;
                                    $z2 = $z2 + $a;
                                    ?>
                                </a>
                            </td>
                            <td><a class="btn btn-light" style="width: 50px;">
                                    <?
                                    $c = $a + $b;
                                    echo $c;
                                    $z3 = $z3 + $a;

                                    ?>
                                </a>
                            </td>
                        </tr>
                    <? } ?>
                    <tr style="background: gray">
                        <td><a class="btn btn-light"
                               style="width: 300px;">ИТОГО</a></td>
                        <td><a class="btn btn-light"
                               style="width: 50px;"><?= $z1 ?></a></td>
                        <td><a class="btn btn-light"
                               style="width: 50px;"><?= $z2 ?></a></td>
                        <td><a class="btn btn-light"
                               style="width: 50px;"><?= $z3 ?></a></td>


                    </tr>
                </table>
            </div>
        </div>


</center>

</body>
</html>

