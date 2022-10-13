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
    <title>Спец. точки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
<?
if (isset($_POST['point_id'])) {
    $point_id = $_POST['point_id'];
}
if (isset($_GET['point_id'])) {
    $point_id = $_GET['point_id'];
}
$point_name = $_POST['point_name'];
switch ($_GET['status']) {
    case "save":
        $sql = "INSERT INTO `Special_points`(`id`, `name`, `QR`) VALUES (NULL,'$point_name', NULL )";
        mysqli_query($connect, $sql);
        $sql = "SELECT id FROM Special_points WHERE name = '" . $point_name . "'";
        $sql = mysqli_query($connect, $sql);
        $sql = mysqli_fetch_all($sql);
        require_once '../QR/phpqrcode/qrlib.php';
        $point = "point_" . $sql[0][0];
        $file_constant = "../QR/special_point_QR/" . $point . ".png";
        $QR = "QR/special_point_QR/" . $point . ".png";
        QRcode::png($point, $file_constant, 'H', 8);
        mysqli_query($connect, "UPDATE `Special_points` SET QR = '$QR' WHERE name = '$point_name'");
        break;
    case "delete":
        $sql = "DELETE FROM `Special_points` WHERE id = '$point_id'";
        $point = "point_" . $point_id;
        $file_constant = "../QR/special_point_QR/" . $point . ".png";
        unlink($file_constant);
        mysqli_query($connect, $sql);
        ?>
        <script>
            alert("Предприятие удалено");
        </script>
        <?
        break;
}
?>

<div class="container mt-2">
    <center>
        <h1>Список специальных магазинов</h1>
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
    </div>
    <div class="row" style="text-align: center;">
        <center>
            <div class="row" style="width: 800px">
                <div class="table">
                    <?
                    $query = mysqli_query($connect, "SELECT * from `Special_points`");
                    $query = mysqli_fetch_all($query);

                    ?>
                    <table class="table table-hover table-sm" style="text-align: center">
                        <thead>
                        <tr>
                            <th width="150">id</th>
                            <th width="200">Название спец. точки</th>
                            <th width="200">QR</th>
                            <th width="50"></th>
                        </tr>
                        </thead>
                        <?

                        if (!empty($query)) {


                            foreach ($query

                                     as $query) {

                                ?>

                                <tr>
                                    <td>
                                        <input class="form-control" style="text-align: center;" type="text" disabled
                                               value="<?= $query[0] ?>" name="point_id" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" style="text-align: center;" disabled
                                               value="<?= $query[1] ?>" name="point_name" required>
                                    </td>
                                    <td>
                                        <?
                                        $Image = "../" . $query[2];
                                        echo($Image == "" ? "No image" : "<img width='100' src='" . $Image . "'></img>");
                                        ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-danger btn"
                                           href="Special_points.php?id=<?= $id ?>&status=delete&point_id=<?= $query[0] ?>">
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
                        <form method="post" action="Special_points.php?id=<?= $id ?>&status=save">
                            <tr>
                                <td>
                                    <input class="form-control" style="text-align: center;" type="text" name="point_id"
                                           value="x" disabled>
                                </td>
                                <td>
                                    <input class="form-control" required type="text" style="text-align: center;" autocomplete="off" placeholder="Пример: Европа"
                                           name="point_name">
                                </td>
                                <td>
                                </td>
                                <td>
                                    <button class="btn btn-outline-success" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor"
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
        </center>

    </div>
</div>
</body>
</html>
