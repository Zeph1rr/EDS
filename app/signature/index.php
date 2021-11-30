<?php
$title = 'Подпись документа';
include '/var/www/sad/src/core.php';
$url = $_SERVER['DOCUMENT_ROOT'] . "/signature/"; 

if ($_GET) {
    $file = $_GET['filename'];
    $docName = explode('.', $file)[0];
    $docTitle = $_GET['title'];
    $docID = $_GET['docid'];
    $owner = $pdo->getData("SELECT owner FROM documents where id = $docID")[0]['owner'];
    $id = $user->id;
    $head = $user->head_id;


if (!empty($_FILES)) {
    $filename = $_FILES['file']['name'];
    $format = explode(".", $filename)[1];
    if (!file_exists($url)) {
        mkdir($url);
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $url . $filename )) {
        $private_key_pem = file_get_contents($url . $filename);
        $result = get_signature($private_key_pem, $docName, $id, "/var/www/sad/documents/$owner");
        unlink($url . $filename);
        if ($result === True) {
            $query1 = $pdo->query("UPDATE documents SET stage = stage + 1 where id = $docID");
            $query2 = $pdo->query("UPDATE mailbox SET status = True WHERE document_id = $docID AND reciever_id = $id");
            $query3 = $pdo->query("INSERT INTO signatures (document_id, signature) VALUES ($docID, 'signature_" . $docName . "_" . $id . ".dat')");
            if ($user->position != 'Директор') {
                $query4 = $pdo->query("INSERT INTO mailbox (document_id, reciever_id, status) VALUES ($docID, $head, False)");
            } else {
                $query4 = $pdo->query("UPDATE documents SET status_id = 2 where id = $docID");
            }
            if ($query1 && $query2 && $query3 && $query4) {
                header("refresh:1, url=/onsign/");
                includeTemplate('messagePage.php', ['title' => 'Документ успешно подписан']);
                exit;
            } else {
                $error = 'Ошибка бд';
            }
        } else {
            $error = $result;
        }
    } else {
        $error = $url . "$filename";
    }
}

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>
<main class="mt-5 pt-3 ">
    <form enctype="multipart/form-data" method="post" class="container-xxl col-md-8">
        <?php
        if (isset($error)) {
            includeTemplate('alert.php', ['message' => $error]);
        }
        ?>
        <h4 class="my-3">Подпись документа <?=$docTitle?></h4>
        <div class="dropdown-divider"></div>
        <div class="mb-3">
            <p for="name" class="form-label">Название документа: <?=$file?></p>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Файл приватного ключа</label>
            <input class="form-control" type="file" id="file" name='file'>
        </div>
        <div class="text-center">
            <button class="btn-lg btn-primary" type="submit"> Подписать
                <span><i class="bi bi-plus-circle"></i></span>
            </button>
        </div>
    </form>
<?php 
includeTemplate('footer.php');
} else {
    header("refresh:0, url=/mydocs/");
    exit;
}
