<?php
require "../config/config.php";
require "../config/auth.php";
$id = $_GET['id'];
$sql = "SELECT catid FROM users WHERE id = " . $id;
$sql = mysqli_query($connect, $sql);
$sql = mysqli_fetch_all($sql);
if ($sql[0][0] != 1) {
    echo "Ты чего здесь лазиешь а?";
    exit();
}
$ord_id = $_POST['ord_id'];
if (isset($ord_id)) {
    $sql = "DELETE FROM orders WHERE id = " . $ord_id;
    mysqli_query($connect, $sql);
    $file = "../files/File_ORD/" . $ord_id;
    $dir = scandir($file);
    for ($i = 2; $i <= count($dir); $i++) {
        unlink($file . "/" . $dir[$i]);
    }
    unlink($file);
}


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
    <title>Удаление заявок</title>
</head>
<body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?
if (isset($ord_id)) {
    ?>
    <script>
        alert("Заявка № <?=$ord_id?> была удалена)
    </script>
    <?
    unset($_POST['ord_id']);
    unset($ord_id);
}
?>
<center>
    <form method="post" action="Delete_Orders.php?id=<?= $id ?>" style="width: 1000px; text-align: center">
        <h1>Удаление заявок</h1>
        <br>
        <input class="form-control" type="number" name="ord_id" placeholder="Введите № заявки"
               style="text-align: center;">
        <br>
        <button type="submit" class="btn btn-danger btn">Удалить заявку</button>
    </form>
</center>
</body>
</html>