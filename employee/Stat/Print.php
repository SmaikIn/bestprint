<?php

require '../../config/config.php';
require '../../config/auth.php';

$id = $_GET['id'];
$redact = $_GET['redact'];
$dateStart = $_GET['dateStart'];
$dateEnd = $_GET['dateEnd'];

if (empty($dateStart)) {
    echo "<h1>Задайте кооректный период и нажмите поиск</h1>";
    exit();
}

if (empty($dateEnd)) {
    echo "<h1>Задайте корректный период и нажмите поиск</h1>";
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="StatStyle.css" rel="stylesheet">
    <title>Печать табеля</title>
</head>
<body>
<center>
    <div class="row">
        <div class="container mt-2">
            <h2>Табель Сотрудника:</h2>
            <h2> <?
                $query = mysqli_query($connect, "SELECT name FROM users WHERE id = '$redact'");
                $query = mysqli_fetch_all($query);
                echo $query[0][0];
                $query = NULL;
                ?>
            </h2>
            <br>
            <div class="row">
                <div class="col">
                    <h4>C <?
                        echo date("d-m-Y", strtotime($dateStart));
                        ?>
                    </h4>
                </div>
                <div class="col">
                    <h4>По <?
                        echo date("d-m-Y", strtotime($dateEnd));
                        ?></h4>
                </div>

            </div>
        </div>
    </div>

    <br>
    <div class="print">
        <table class="table" style="text-align: center; width: 800px;">
            <thead>
            <tr>
                <th width="150">Дата</th>
                <th width="180">Смена</th>
                <th width="180">Всего за смену</th>
                <th width="200">Доп. часы</th>
                <th width="180">Итоговая сумма</th>
            </tr>
            </thead>
            <?
            if ((empty($dateEnd)) && (empty($dateStart))) {
                $query = mysqli_query($connect, "SELECT * FROM worktime WHERE u_id = '$redact'");
                $query = mysqli_fetch_all($query);
            } else {
                $query = mysqli_query($connect, "SELECT * FROM worktime WHERE u_id = '$redact' AND `Date` between '$dateStart' and '$dateEnd'");
                $query = mysqli_fetch_all($query);
                if ($query == NULL) {
                    echo "<br>";
                    echo "<h1>В данный промежуток времени сотрудник не работал</h1>";
                    exit();
                }
            }
            $i = 0;
            foreach ($query as $query) {
                ?>

                <tr>
                    <td><?
                        echo $query[4][8];
                        echo $query[4][9];
                        echo "-";
                        echo $query[4][5];
                        echo $query[4][6];
                        echo "-";
                        echo $query[4][0];
                        echo $query[4][1];
                        echo $query[4][2];
                        echo $query[4][3];
                        ?></td>
                    <td><?
                        echo "Начало " . date("h:i", strtotime($query[2]));
                        echo "<br>";
                        if (!empty($query[3])) {
                            echo "Конец " . date("h:i", strtotime($query[3]));
                        } else {
                            echo "Смена не закончена";
                        }
                        ?>
                    </td>
                    <td><?
                        $hour_1 = date("h", strtotime($query[2]));
                        $hour_2 = date("h", strtotime($query[3]));
                        $minute_1 = date("i", strtotime($query[2]));
                        $minute_2 = date("i", strtotime($query[3]));
                        $d1 = $hour_2 - $hour_1;
                        $d2 = $minute_2 - $minute_1;
                        echo $d1 . " часов ";
                        echo $d2 . " минут";
                        ?></td>
                    <td><?= $query[6][0] . $query[6][1] . $query[6][2] . $query[6][3] . $query[6][4] ?></td>
                    <td><?
                        $hour_3 = $query[6][0] . $query[6][1];
                        $minute_3 = $query[6][3] . $query[6][4];
                        $d1 = $d1 + $hour_3;
                        $d2 = $d2 + $minute_3;
                        $d3[$i][0] = $d1;
                        $d3[$i][1] = $d2;
                        echo $d1 . " часа(ов) ";
                        echo "<br>";
                        echo $d2 . " минут";
                        ?></td>
                </tr>
                <?
                $i++;
            }
            ?>
            <tr>

                <td colspan="3"><strong>ИТОГО за период</strong></td>
                <td colspan="2">
                    <strong>  <?
                        $t1 = 0;
                        $t2 = 0;
                        for ($i = 0; $i <= count($d3); $i++) {
                            $d1 = $d3[$i][0];
                            $d2 = $d3[$i][1];
                            $t1 = $t1 + $d1;
                            $t2 = $t2 + $d2;
                        }
                        $result = $t1 . " часа(ов) " . $t2 . " минут";
                        echo $result;
                        ?>      </strong>
                </td>
            </tr>
        </table>
    </div>
</center>
<script>
    window.print();
</script>
</body>
</html>