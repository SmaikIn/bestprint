<?php
require('../../config/config.php');
require('../../config/auth.php');
$id = $_GET['id'];
$ord_id = $_GET['ord_id'];
$sql = "SELECT `catId` FROM `users` WHERE id = " . $id;
$sql = mysqli_query($connect, $sql);
$sql = mysqli_fetch_all($sql);
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
    <title>Заявка № <?= $ord_id ?></title>
</head>
<body>
<?
switch ($sql[0][0]) {
    case 3:
        ?>
        <div class="container mt-2" style="width: 1000px; text-align: center">
            <div class="row" style="text-align: center; width: 1000px;">
                <center>
                    <h2>Прикрепление сотрудников</h2>
                    <table class="table table-hover" style="text-align: center">
                        <thead>
                        <tr>
                            <th width="90">ID</th>
                            <th width="250">Выбрать</th>
                            <th width="600">ФИО</th>
                        </tr>
                        </thead>
                        <?
                        $sql = "SELECT id, name FROM users WHERE catId = 5";
                        $sql = mysqli_query($connect, $sql);
                        $sql = mysqli_fetch_all($sql);
                        ?>
                        <form method="post" action="UpdateComplete.php?id=<?= $id ?>&ord_id=<?= $ord_id ?>">
                            <button type="submit" class="btn btn-outline-success"> Прикрепить к заявке</button>
                            <?
                            foreach ($sql as $sql) {
                                ?>
                                <tr>
                                    <td><input class="form-control" type="text" style="text-align: center; width: 80px;"
                                               readonly
                                               value=" <?= $sql[0] ?>">
                                    </td>
                                    <td>
                                        <div class="form-check form-switch" style="text-align: center">
                                            <input class="form-check-input all" type="checkbox" role="switch"
                                                   name="<?= $sql[0] ?>" value="<?= $sql[0] ?>"
                                                   id="<?= $sql[0] ?>">
                                            <label class="form-check-label btn btn-outline-dark btn-sm"
                                                   style="width: 100px"
                                                   for="<?= $sql[0] ?>">Выбрать</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="form-control" style="text-align: center" type="text" readonly
                                               value="<?= $sql[1] ?>">
                                    </td>
                                </tr>
                                <?
                            }
                            ?>
                        </form>
                    </table>
                </center>

            </div>
        </div>
        <?
        break;
}
?>

</body>
</html>
