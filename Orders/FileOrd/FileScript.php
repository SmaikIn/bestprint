<?php
require "../../config/config.php";
require "../../config/auth.php";
$id = $_GET['id'];
$ord_id = $_GET['ord_id'];


$dir = "../../files/File_ORD/" . $ord_id;


if (isset($_POST['upload'])) {
    if (!empty($_POST['upload'])) {

        $FILE_ID = "../../files/File_ORD/" . $ord_id . "/";
        for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
            move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
        }
    }
}

if (isset($_GET['delete'])) {
    $FILE_ID = "../../files/File_ORD/" . $ord_id . "/" . $_POST['ord_name'];
    if (@fopen($FILE_ID, "r")) {
        unlink($FILE_ID);
    }
    unset($_POST['ord_name']);
}

if (scandir($dir) == false) {
    echo "<pre>";
    echo "<h1>Если вы видите это сообщение, то ответственный менеджер не прикрепил к данной заявке файлов</h1>";
    echo "<h1>Ошибка, не удалось найти дирректорию с файлами заявки</h1>";
    echo "<h1>Закройте данную страницу</h1>";
    echo "</pre>";
    exit();
} else {
    $scan_dir = scandir($dir);
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
    <title>Файлы заявки №<?= $ord_id ?></title>
</head>
<body>
<center>

    <div class="row">
        <div class="container mt-2">
            <h4>Файлы заявки №<?= $ord_id ?></h4>
        </div>
    </div>
    <form method="post" action="FileScript.php?id=<?= $id ?>&ord_id=<?= $ord_id ?>" enctype="multipart/form-data"
          style="width: 600px;">
        <div class="row">
            <div class="col">
                <input type="hidden" name="upload" value="upload">
                <input type="hidden" name="ord_id" value="upload">
                <input class="form-control" type="file" name="files[]" required multiple>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-outline-success">Добавить Новый файл</button>
            </div>
        </div>
    </form>
    <div class="table table-hover">
        <table class="table table-hover" style="width: 600px; text-align: center;">
            <thead>
            <tr>
                <th>Номер</th>
                <th>Имя Файла</th>
                <th>Скачать</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <?
            for ($i = 2;
                 $i < count($scan_dir);
                 $i++) {
                ?>
                <tr>
                    <td><a class="btn btn-light btn" style="width: 50px;"><?= $i - 1; ?></a></td>
                    <td><a class="btn btn-light btn" style="width: 250px;"><? echo $scan_dir[$i] ?></a></td>
                    <td>
                        <a class="btn btn-success btn-sm"
                           href="../../files/File_ORD/<?= $ord_id ?>/<?= $scan_dir[$i] ?>"
                           download>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                 class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <form method="post"
                              action="FileScript.php?id=<?= $id ?>&ord_id=<?= $ord_id ?>&delete=1">
                            <button class="btn btn-danger btn-sm" type="submit">
                                <input type="hidden" name="ord_name" value="<?= $scan_dir[$i] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </button>
                        </form>


                    </td>
                </tr>
                <?

            }
            ?>
        </table>
    </div>
    <br>
</center>
</body>
</html>
