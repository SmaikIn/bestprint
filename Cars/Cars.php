<?php

require('../config/config.php');
require('../config/auth.php');
$id = $_GET['id'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Автопарк</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
<?
if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];
}
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];
}
$vehicleNum = $_POST['vehicleNum'];
$vehicleMod = $_POST['vehicleMod'];
$toDate = $_POST['toDate'];
$oilDate = $_POST['oilDate'];
$wheelDate = $_POST['wheelDate'];
$insurance = $_POST['insurance'];
switch ($_GET['status']) {
    case "save":
        $sql = "INSERT INTO `vehicles`(`id`, `vehicleNum`, `vehicleMod`, `toDate`, `oilDate`, `wheelDate`, `insurance`) VALUES (NULL,'$vehicleNum','$vehicleMod','$toDate','$oilDate','$wheelDate','$insurance')";
        mysqli_query($connect, $sql);
        break;
    case "redact":
        $sql = "UPDATE `vehicles` SET `vehicleNum`='$vehicleNum',`vehicleMod`='$vehicleMod',`toDate`='$toDate',
                `oilDate`='$oilDate',`wheelDate`='$wheelDate',`insurance`='$insurance' WHERE id = '$car_id'";
        mysqli_query($connect, $sql);
        break;
    case "delete":
        $sql = "DELETE FROM `vehicles` WHERE id = '$car_id'";
        mysqli_query($connect, $sql);
        ?>
        <script>
            alert("Машина удалена");
        </script>
        <?
        break;
}
?>

<div class="container mt-2">
    <center>
        <h1>Автопарк предприятия</h1>
    </center>
    <div class="row">
        <div class="col" style="text-align: left">
        </div>
        <div class="col" style="text-align: right;">
            <a class="btn btn-outline-danger" href="../Personal_Area/lk.php?id=<?= $id ?>">Вернуться в личный
                кабинет</a>
        </div>
        <br>
        <br>
        <div class="row" style="width: 1300px">
            <div class="table">
                <?
                $query = mysqli_query($connect, "SELECT * from `vehicles`");
                $query = mysqli_fetch_all($query);

                ?>
                <table class="table table-hover table-sm" style="text-align: center">
                    <thead>
                    <tr>
                        <th width="50">id</th>
                        <th width="150">Рег. №</th>
                        <th width="150">Марка</th>
                        <th width="150">Тех. осмотр</th>
                        <th width="200">Замена масла</th>
                        <th width="200">Замена резины</th>
                        <th width="200">Страховка</th>
                        <th width="50"></th>
                        <th width="50"></th>
                    </tr>
                    </thead>
                    <?

                    if (!empty($query)) {


                        foreach ($query

                                 as $query) {

                            ?>

                            <tr>
                                <form action="Cars.php?id=<?= $id ?>&status=redact" method="post"
                                      style="text-align: center;">
                                    <td>
                                        <input class="form-control" style="text-align: center;" type="text"
                                               value="<?= $query[0] ?>" name="car_id" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" style="text-align: center;"
                                               value="<?= $query[1] ?>" name="vehicleNum" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" style="text-align: center;"
                                               value="<?= $query[2] ?>" name="vehicleMod" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" style="text-align: center;"
                                               value="<?= $query[3] ?>" name="toDate" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" style="text-align: center;"
                                               value="<?= $query[4] ?>" name="oilDate" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" style="text-align: center;"
                                               value="<?= $query[5] ?>" name="wheelDate" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" style="text-align: center;"
                                               value="<?= $query[6] ?>" name="insurance" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </form>
                                <td>
                                    <a class="btn btn-outline-danger btn"
                                       href="Cars.php?id=<?= $id ?>&status=delete&car_id=<?= $query[0] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor"
                                             class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                            <?
                        }
                    }
                    ?>
                    <form method="post" action="Cars.php?id=<?= $id ?>&status=save">
                        <tr>
                            <td>
                                <input class="form-control" style="text-align: center;" type="text" name="car_id"
                                       value="x" disabled>
                            </td>
                            <td>
                                <input class="form-control" required type="text" style="text-align: center;"
                                       name="vehicleNum">
                            </td>
                            <td>
                                <input class="form-control" required type="text" style="text-align: center;"
                                       name="vehicleMod">
                            </td>
                            <td>
                                <input class="form-control" required type="date" style="text-align: center;"
                                       name="toDate">
                            </td>
                            <td>
                                <input class="form-control" required type="date" style="text-align: center;"
                                       name="oilDate">
                            </td>
                            <td>
                                <input class="form-control" required type="date" style="text-align: center;"
                                       name="wheelDate">
                            </td>
                            <td>
                                <input class="form-control" required type="date" style="text-align: center;"
                                       name="insurance">
                            </td>
                            <td>
                                <button class="btn btn-outline-success" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                         class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
