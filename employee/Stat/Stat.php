<?php
require '../../config/config.php';
require '../../config/auth.php';
$id = $_GET['id'];
$redact = $_GET['redact'];
$dateStart = $_GET['dateStart'];
$dateEnd = $_GET['dateEnd'];
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

    <title>Статистика Сотрудника</title>
</head>
<body>
<div class="container" style="width: 1300px;">


    <?

    $sql = "SELECT catID FROM users WHERE id = " . $id;
    $sql = mysqli_query($connect, $sql);
    $sql = mysqli_fetch_all($sql);
    switch ($sql[0][0]) {
        case 1 :
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case "delete":
                        $query = "DELETE FROM `worktime` WHERE id = " . $_POST['w_id'];
                        mysqli_query($connect, $query);
                        unset($_POST['w_id']);
                        break;
                    case "redact":
                        $query = "UPDATE `worktime` SET `OverTime`= " . $_POST['over_time'] . " WHERE id = " . $_POST['w_id'];
                        mysqli_query($connect, $query);
                        unset($_POST['w_id']);
                        unset($_POST['over_time']);
                        break;
                }
            }
            ?>
            <center>
                <div class="row" style="width: 600px; text-align: center;">
                    <?
                    $query = "SELECT name FROM users WHERE id = " . $redact;
                    $query = mysqli_query($connect, $query);
                    $query = mysqli_fetch_all($query);
                    ?>
                    <h4>Табель Сотрудника / <?= $query[0][0] ?></h4>
                    <h5>Задайте Период</h5>
                    <form method="get" action="Stat.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="redact" value="<?= $redact ?>">
                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="date" value="<?= $dateStart ?>" required
                                       name="dateStart"/>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" value="<?= $dateEnd ?>" required
                                       name="dateEnd"/>
                            </div>
                            <br>
                            <br>
                        </div>
                        <div class="row">
                            <center>
                                <button type='submit' style="width: 550px;" class="btn btn-success btn-sm">Поиск
                                </button>
                            </center>
                        </div>
                    </form>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="container">
                        <div class="row">
                            <center>
                                <a class="btn btn-danger btn-sm" style="width: 550px;" onclick="window.close()"> Закрыть
                                    вкладку </a>
                            </center>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="container">
                        <div class="row">
                            <center>
                                <a class="btn btn-warning btn-sm" style="width: 550px;" target="_blank"
                                   href="Print.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                    </svg>
                                    Печать Табеля
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <table class="table table-hover" style="text-align: center;">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Начало смены</th>
                            <th>Конец смены</th>
                            <th>Сумма часов за смену</th>
                            <th>Дополнительные часы</th>
                            <th>Удалить смену</th>
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
                                    echo date("h:i", strtotime($query[2]));
                                    ?></td>
                                <td><?
                                    if (!empty($query[3])) {
                                        echo date("h:i", strtotime($query[3]));
                                    } else {
                                        echo "Смена не закончена";
                                    }


                                    ?></td>
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
                                <td>
                                    <center>
                                        <form method="post" action="Stat_Script.php" class="overtime">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="time">
                                                        <input type="hidden" name="id" value="<?= $id ?>">
                                                        <input type="hidden" name="redact" value="<?= $redact ?>">
                                                        <input type="hidden" name="dateStart" value="<?= $dateStart ?>">
                                                        <input type="hidden" name="dateEnd" value="<?= $dateEnd ?>">
                                                        <input type="hidden" name="action"
                                                               value="<?= $action = "redact" ?>">
                                                        <input type="hidden" name="num" value="<?= $query[0] ?>">
                                                        <input type="time" class="form-control" name="overtime"
                                                               value="<?= $query[6] ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                            style="height: 35px">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                             fill="currentColor" class="bi bi-pencil-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <form method="post" action="Stat_Script.php">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="redact" value="<?= $redact ?>">
                                            <input type="hidden" name="dateStart" value="<?= $dateStart ?>">
                                            <input type="hidden" name="dateEnd" value="<?= $dateEnd ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="num" value="<?= $query[0] ?>">
                                            <input type="hidden" name="overtime" value="<?= $query[6] ?>">
                                            <center>
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1s" height="16"
                                                         fill="currentColor"
                                                         class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                                    </svg>
                                                </button>
                                            </center>
                                        </form>
                                    </center>

                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>

                </div>
            </center>
            <?
            break;
        case 3 :
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case "delete":
                        $query = "DELETE FROM `worktime` WHERE id = " . $_POST['w_id'];
                        mysqli_query($connect, $query);
                        unset($_POST['w_id']);
                        break;
                    case "redact":
                        $query = "UPDATE `worktime` SET `OverTime`= " . $_POST['over_time'] . " WHERE id = " . $_POST['w_id'];
                        mysqli_query($connect, $query);
                        unset($_POST['w_id']);
                        unset($_POST['over_time']);
                        break;
                }
            }
            ?>
            <center>
                <div class="row" style="width: 600px; text-align: center;">
                    <?
                    $query = "SELECT name FROM users WHERE id = " . $redact;
                    $query = mysqli_query($connect, $query);
                    $query = mysqli_fetch_all($query);
                    ?>
                    <h4>Табель Сотрудника / <?= $query[0][0] ?></h4>
                    <h5>Задайте Период</h5>
                    <form method="get" action="Stat.php">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="redact" value="<?= $redact ?>">
                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="date" value="<?= $dateStart ?>" required
                                       name="dateStart"/>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" value="<?= $dateEnd ?>" required
                                       name="dateEnd"/>
                            </div>
                            <br>
                            <br>
                        </div>
                        <div class="row">
                            <center>
                                <button type='submit' style="width: 550px;" class="btn btn-success btn-sm">Поиск
                                </button>
                            </center>
                        </div>
                    </form>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="container">
                        <div class="row">
                            <center>
                                <a class="btn btn-danger btn-sm" style="width: 550px;"
                                   href="../employee.php?id=<?= $id ?>&empl=montage"> Вернуться к
                                    списку
                                    сотрудников </a>
                            </center>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="container">
                        <div class="row">
                            <center>
                                <a class="btn btn-warning btn-sm" style="width: 550px;" target="_blank"
                                   href="Print.php?<?= $_SERVER['QUERY_STRING'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                    </svg>
                                    Печать Табеля
                                </a>
                            </center>
                        </div>
                    </div>
                </div>

                <div class="table">
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
                    ?>
                    <table class="table table-hover" style="text-align: center;">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Начало смены</th>
                            <th>Конец смены</th>
                            <th>Сумма часов за смену</th>
                            <th>Дополнительные часы</th>
                            <th>Удалить смену</th>

                        </tr>
                        </thead>
                        <?
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
                                    echo date("h:i", strtotime($query[2]));
                                    ?></td>
                                <td><?
                                    if (!empty($query[3])) {
                                        echo date("h:i", strtotime($query[3]));
                                    } else {
                                        echo "Смена не закончена";
                                    }


                                    ?></td>
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
                                <td>
                                    <center>
                                        <form method="post" action="Stat_Script.php" class="overtime">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="time">
                                                        <input type="hidden" name="id" value="<?= $id ?>">
                                                        <input type="hidden" name="redact" value="<?= $redact ?>">
                                                        <input type="hidden" name="dateStart" value="<?= $dateStart ?>">
                                                        <input type="hidden" name="dateEnd" value="<?= $dateEnd ?>">
                                                        <input type="hidden" name="action"
                                                               value="<?= $action = "redact" ?>">
                                                        <input type="hidden" name="num" value="<?= $query[0] ?>">
                                                        <input type="time" class="form-control" name="overtime"
                                                               value="<?= $query[6] ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                            style="height: 35px">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                             fill="currentColor" class="bi bi-pencil-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <form method="post" action="Stat_Script.php">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="redact" value="<?= $redact ?>">
                                            <input type="hidden" name="dateStart" value="<?= $dateStart ?>">
                                            <input type="hidden" name="dateEnd" value="<?= $dateEnd ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="num" value="<?= $query[0] ?>">
                                            <input type="hidden" name="overtime" value="<?= $query[6] ?>">
                                            <center>
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1s" height="16"
                                                         fill="currentColor"
                                                         class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                                    </svg>
                                                </button>
                                            </center>
                                        </form>
                                    </center>

                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>

                </div>
            </center>
            <?
            break;
    }

    ?>

</div>

</body>
</html>