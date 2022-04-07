<?php
require('../../config/config.php');
require('../../config/auth.php');
$id = $_GET['id'];
$dateStart = date('Y-m-01');
$dateEnd = date("Y-m-01", strtotime("+1 month"));



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
            <div class="col">
                <h4>C <?
                    echo date('01-m-Y');;
                    ?>
                </h4>
            </div>
            <div class="col">
                <h4>По <?
                    echo date("01-m-Y", strtotime("+1 month"));
                    ?></h4>
            </div>
        </div>
        <table class="table table-hover" style="text-align: center; width: 1000px;">
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Сумма часов за период</th>
                <th>Дополнительные часы</th>
                <th>Итого</th>
                <th>
                    <button type="button" class="btn btn-warning btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        <a href="#" onClick="window.print()">Печать табеля</a>
                    </button>
                </th>
            </tr>
            </thead>
            <?
            $query = mysqli_query($connect, "SELECT id , `name` FROM users WHERE catId = '5' ");
            $query = mysqli_fetch_all($query);
            $OverTime = 0; $TimeResult = 0;
            for ($i = 0; $i < count($query); $i++) {
                $User = $query[$i][0];
                $query_2 = mysqli_query($connect, "SELECT TimeResult, `OverTime` FROM worktime WHERE u_id = '$User' AND `Date` between '$dateStart' and '$dateEnd'");
                $query_2 = mysqli_fetch_all($query_2);
                for ($j = 0; $j < count($query_2); $j++) {
                    $query[$i][$j+2]["TimeResult"] = $query_2[$j][0];
                    $query[$i][$j+2]["OverTime"] = $query_2[$j][1];
                    //$OverTime[$i] = $OverTime[$i] + $query_2[$j][1] ;
                   // $TimeResult[$i] = $TimeResult[$i] + $query_2[$j][0];
                }
            }
            foreach ($query as $query) {
                ?>
                <tr>
                    <td><h5><?= $query[1] ?></h5></td>
                    <td>160</td>
                    <td>7</td>
                    <td>167</td>
                </tr>
            <? } ?>
        </table>

</center>

</body>
</html>

