<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WorkTime</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    input {
        text-align: center;
    }

    form {
        width: 1000px;
    }
</style>
<body>
<center>
    <?
    $alert = 0;
    $alert = $_GET['alert'];
    switch ($alert) {
    case 1:
        ?>
        <script>
            alert("Вы успешно начали рабочую смену");
        </script><?
    break;
    case 2:
    ?>
        <script>
            alert("Вы закончили рабочию смену");
        </script><?
        break;
    }
    ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <form method="post" action="WorkTime_Script.php">
        <h1>Добро пожаловать</h1>
        <br>
        <input class="form-control" name="u_id" type="text" required autocomplete="off">
        <br>
        <button type="submit" class="btn btn-success btn-lg">Начать смену</button>
    </form>

</center>

</body>
</html>
<?php
