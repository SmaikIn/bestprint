<?php
require "../../config/config.php";
require "../../config/auth.php";
$id = $_GET['id'];
$ord_id = $_GET['ord_id'];

$dir = "../../dir";

$scan_dir = scandir($dir);
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
    <link rel="stylesheet" href="StatStyle.css">
    <title>Файлы заявки</title>
</head>
<body>
<center>
    <div class="row">
        <div class="container mt-2">
            <h4>Файлы заявки №<?= $ord_id ?></h4>
        </div>
    </div>
    <form method="post" action="#">
        <button type="submit" class="btn btn-success btn-sm">Добавить Новый файл</button>
    </form>
    <div class="table">
        <table class="table table-hover" style="width: 600px; text-align: center;">
            <thead>
            <tr>
                <th>Номер</th>
                <th>Имя Файла</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <?
            $i = 2;
            do {
                ?>
                <tr>
                    <td><?= $i - 1; ?></td>
                    <td><? echo $scan_dir[$i] ?></td>
                    <td>
                        <form method="post" action="#">
                            <button type="submit" class="btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                <?
                $i++;
            } while ($i < count($scan_dir))
            ?>
        </table>

    </div>
</center>


</body>
</html>
