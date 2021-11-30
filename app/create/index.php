<?php
$title = 'Загрузка документа';
include '/var/www/sad/src/core.php';
$url = $_SERVER['DOCUMENT_ROOT'] . "/documents/" . $user->id; 

if (!empty($_FILES)) {
    $name = pg_escape_string($_POST['name']);
    $filename = $_FILES['file']['name'];
    $format = explode(".", $filename)[1];
    $stage = 5 - $user->pos_id;
    if (!file_exists($url)) {
        mkdir($url);
    }
    if (checkFormat($filename)) {
        $id = $user->id;
        if (file_exists($url . "/$filename")) {
            $error = 'Документ с таким именем уже существует';
        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $url . "/$filename" )) {
                $result = $pdo->query("INSERT INTO documents(title, file, owner, stage, status_id) VALUES ('$name', '$filename', $id, $stage, 1);");
                if ($result) {
                    $query = $pdo->query("INSERT INTO mailbox (document_id, reciever_id, status) VALUES (
                        (SELECT id FROM documents WHERE file = '$filename' AND owner = $id), $id, False)");
                    if ($query) {
                        $success = 'Доумент успешно загружен';
                    } else {
                        $error = 'Ошибка отправки на подись';    
                        unlink($url . "/$filename");
                    }
                } else {
                    $error = 'Неизвестная ошибка';
                    unlink($url . "/$filename");
                }
            }
        }
    } else {
        $error = 'Неверный формат файла';
    }
}

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>
<main class="mt-5 pt-3 ">
    <form enctype="multipart/form-data" method="post" class="container-xxl col-md-8">
        <?php
        if (isset($error)) {
            includeTemplate('alert.php', ['message' => $error, 'type' => 'danger']);
        }
        if (isset($success)) {
            includeTemplate('alert.php', ['message' => $success, 'type' => 'success']);
        }
        ?>
        <h4 class="my-3">Загрузка Документа</h4>
        <div class="dropdown-divider"></div>
        <div class="mb-3">
            <label for="name" class="form-label">Название документа</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Файл документа</label>
            <input class="form-control" type="file" id="file" name='file'>
        </div>
        <div class="text-center">
            <button class="btn-lg btn-primary" type="submit"> Загрузить
                <span><i class="bi bi-plus-circle"></i></span>
            </button>
        </div>
    </form>
<?php 
includeTemplate('footer.php');

   