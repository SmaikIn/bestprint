<?php

require('../config/config.php');
require('../config/auth.php');
require('filter/filter.php');
$id = $_GET['id'];
$time = date('d-m-Y');
$query = mysqli_query($connect, "SELECT `catID` FROM `users` WHERE id = '$id'");
$query = mysqli_fetch_all($query);
$catId = $query[0][0];
$query = mysqli_query($connect, "SELECT `name` FROM `category` WHERE id = '$catId'");
$query = mysqli_fetch_all($query);
$poswork = $query[0][0];


?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orders</title>
    <link rel="stylesheet" href="css/Ordercss.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container mt-1">
    <center>
        <h1>Список заявок</h1>
    </center>
    <div class="row">
        <div class="col">
            <h4>Форма поиска</h4>
            <div class="container mt-2">
                <form method="get" action="Orders.php">
                    <div class="row">
                        <h5>Статус заявки</h5>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <select name="status" size=1>
                            <option value="1">Все статусы заявок</option>
                            <option value="Выполнен"> Выполненые</option>
                            <option value="В обработке"> В обработке</option>
                        </select>
                        <h5>Вид Заявки</h5>
                        <select name="view" size=1>
                            <option value="1"> Все виды заявок</option>
                            <option value="Монтаж"> Монтаж</option>
                            <option value="Доставка"> Доставка</option>
                        </select>
                        <h5>Номер заявки</h5>
                        <input type="text" name="numorder" autocomplete="off" placeholder="Пример: 2123">
                        <h5>Компания заявитель</h5>
                        <input type="text" name="nameorder" autocomplete="off" placeholder="Пример: DNS">
                        <h5>Поиск по дате: крайний срок</h5>
                        <input type="date" name="date"/>
                    </div>
                    <br>
                    <div class="row">
                        <button type='submit' class="btn btn-success btn-sm">Поиск</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col">
            <div class="row">
                <div class="col">
                    <form method="get" action="Orders.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="date" value="<?= $time ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Обновить таблицу</button>
                    </form>
                </div>
                <div class="col">
                    <center>
                        <form method="get" action="../Personal_Area/lk.php">
                            <button name="id" type="submit" class="btn btn-danger btn-sm" value="<?= $id ?>">Вернуться в
                                личный кабинет
                            </button>
                        </form>
                    </center>

                </div>
            </div>

            <?
            switch ($poswork) {
                case "Менеджер":
                    ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Номер Заявки</th>
                            <th>Заказчик</th>
                            <th>Вид Заявки</th>
                            <th>Cрок выполнения</th>
                            <th>Статус Заявки</th>
                            <th>Распечатать</th>
                            <th>Файлы Зявки</th>
                        </tr>
                        </thead>
                        <?

                        /* $strquery = "SELECT * FROM orders WHERE ";
                         $cnt = 0;
                         if (isset($status)){
                             $strquery.="Result = ";
                             $strquery.="'";
                             $strquery.=$_GET['status'];
                             $strquery.="'";
                             $cnt++;
                         }
                         if (isset($view)){
                             if($cnt>0){
                                 $strquery.=" AND typeTask = ";
                             }else{
                                 $strquery.="typeTask = ";
                             }
                             $strquery.="'";
                             $strquery.=$_GET['view'];
                             $strquery.="'";
                             $cnt++;
                         }
                         if (isset($nameorder)){
                             if($cnt>0){
                                 $strquery.=" AND castomer = ";
                             }else{
                                 $strquery.="castomer = ";
                             }
                             $strquery.="'";
                             $strquery.=$_GET['nameorder'];
                             $strquery.="'";
                             $cnt++;
                         }
                         if (isset($date)){
                             if($cnt>0){
                                 $strquery.=" AND deadline = ";
                             }else{
                                 $strquery.="deadline = ";
                             }
                             $strquery.="'";
                             $strquery.= $date;
                             $strquery.="'";
                             $cnt++;
                         }
                         if (isset($numorder)){
                             $strquery = "SELECT * FROM orders WHERE id = '$numorder' ";
                             $cnt++;
                         }
                         if ($cnt == 0){
                             $strquery = "SELECT * FROM orders ";
                         }
                         $query = mysqli_query($connect,$strquery);
                         if (empty($query)){
                             echo "<center> <h1>По заданным параметрам ничего не найдено</h1> </center>";
                             exit();
                         }
                         $query =  mysqli_fetch_all($query);*/

                        $infuser = mysqli_query($connect, "SELECT oId FROM uorders WHERE uID = '$id'");
                        $infuser = mysqli_fetch_all($infuser);
                        foreach ($infuser as $infuser) {
                            $query2 = mysqli_query($connect, "SELECT * FROM orders WHERE id = '$infuser[0]'");
                            $query2 = mysqli_fetch_all($query2);
                            foreach ($query2 as $query2) {
                                ?>
                                <tr>
                                    <?
                                    ?>
                                    <td><?= $query2[0] ?></td>
                                    <td><?= $query2[1] ?></td>
                                    <td><?= $query2[7] ?></td>
                                    <td><?= $query2[6] ?></td>
                                    <td><?= $query2[10] ?></td>
                                    <td>
                                        <? switch ($query2[11]) {
                                            case 0:
                                                ?>
                                                <button type="button" class="btn btn-secondary btn-sm">Распечатать
                                                </button>

                                                <? break;
                                            case 1:
                                                ?>
                                                <button type="button" class="btn btn-secondary btn-sm">Распечатать
                                                    повторно
                                                </button>
                                                <? break;
                                        }
                                        ?></td>
                                    <td>
                                        <form method="post" action="FileOrd/FileScript.php?id=<?= $id ?>&ord_id=<?=$query2[0]?>">
                                            <button type="submit" class="btn btn-secondary btn-sm">Файлы</button>
                                        </form>
                                    </td>
                                </tr>
                                <?
                            }
                        } ?>
                    </table>
                    <?

                    break;

                case "Начальник цеха":
                    ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Номер Заявки</th>
                            <th>Заказчик</th>
                            <th>Вид Заявки</th>
                            <th>Менеджер</th>
                            <th>Крайний срок</th>
                            <th>Статус Заявки</th>
                            <th>Распечатать</th>
                            <th>Файлы Зявки</th>
                        </tr>
                        </thead>
                        <?
                        $strquery = "SELECT * FROM orders WHERE ";
                        $cnt = 0;
                        if (isset($status)) {
                            $strquery .= "Result = ";
                            $strquery .= "'";
                            $strquery .= $_GET['status'];
                            $strquery .= "'";
                            $cnt++;
                        }
                        if (isset($view)) {
                            if ($cnt > 0) {
                                $strquery .= " AND typeTask = ";
                            } else {
                                $strquery .= "typeTask = ";
                            }
                            $strquery .= "'";
                            $strquery .= $_GET['view'];
                            $strquery .= "'";
                            $cnt++;
                        }
                        if (isset($nameorder)) {
                            if ($cnt > 0) {
                                $strquery .= " AND castomer = ";
                            } else {
                                $strquery .= "castomer = ";
                            }
                            $strquery .= "'";
                            $strquery .= $_GET['nameorder'];
                            $strquery .= "'";
                            $cnt++;
                        }
                        if (isset($date)) {
                            if ($cnt > 0) {
                                $strquery .= " AND deadline = ";
                            } else {
                                $strquery .= "deadline = ";
                            }
                            $strquery .= "'";
                            $strquery .= $date;
                            $strquery .= "'";
                            $cnt++;
                        }
                        if (isset($numorder)) {
                            $strquery = "SELECT * FROM orders WHERE id = '$numorder' ";
                            $cnt++;
                        }
                        if ($cnt == 0) {
                            $strquery = "SELECT * FROM orders ";
                        }
                        $query = mysqli_query($connect, $strquery);
                        if (empty($query)) {
                            echo "<center> <h1>По заданным параметрам ничего не найдено</h1> </center>";
                            exit();
                        }
                        $query = mysqli_fetch_all($query);

                        foreach ($query as $query) {
                            ?>
                            <tr>
                                <td><?= $query[0] ?></td>
                                <td><?= $query[1] ?></td>
                                <td><?= $query[7] ?></td>
                                <td><?
                                    $infuser = mysqli_query($connect, "SELECT uID FROM uorders WHERE oId = '$query[0]'");
                                    $infuser = mysqli_fetch_all($infuser);
                                    $infuid = $infuser[0][0];
                                    $infuser = mysqli_query($connect, "SELECT `name` FROM users WHERE id = '$infuid'");
                                    $infuser = mysqli_fetch_all($infuser);
                                    $findme = " ";
                                    $pos = strpos($infuser[0][0], $findme);
                                    for ($i = 0; $i <= $pos; $i++) {
                                        echo $infuser[0][0][$i];
                                    }
                                    ?></td>
                                <td><?= $query[6] ?></td>
                                <td><?= $query[10] ?></td>
                                <td>
                                    <? switch ($query[11]) {
                                        case 0:
                                            ?>
                                            <button type="button" class="btn btn-secondary btn-sm">Распечатать</button>

                                            <? break;
                                        case 1:
                                            ?>
                                            <button type="button" class="btn btn-secondary btn-sm">Распечатать
                                                повторно
                                            </button>
                                            <? break;
                                    }
                                    ?></td>
                                <td>
                                    <button type="button" class="btn btn-secondary btn-sm">Файлы</button>
                                </td>
                            </tr>
                            <?
                        } ?>
                    </table>
                    <? break;
            }
            ?>


        </div>
    </div>
</div>

</body>
</html>