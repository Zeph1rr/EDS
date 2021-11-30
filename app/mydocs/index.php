<?php
$title = 'Мои документы';
include '/var/www/sad/src/core.php';
$id = $user->id;
$documents = $pdo->getData("SELECT documents.id as id, title, file, statuses.status as status, documents.stage as stage, 
    status_id
    FROM  documents 
    inner join statuses on statuses.id = documents.status_id 
    WHERE owner = $id");


if (array_key_exists('delete', $_GET)) {
    $filename = $_GET['delete'];
    $file = explode('.', $filename)[0];
    $pdo->query("DELETE FROM documents WHERE owner = $id AND file = '$filename'");
    array_map('unlink', glob($_SERVER['DOCUMENT_ROOT'] . "/documents/$id/*$file*.*"));
    header("refresh:0, url=/mydocs");
    exit;
}

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>

<main class="mt-5 pt-3">
    <div class="container-xxl row">
        <?php
        foreach ($documents as $document) {
            $doc_id = $document['id'];
            $aprover = $pdo->getData("select reciever_id as id, users.first_name || ' ' || users.last_name as name 
                from users 
                full join mailbox on users.id = mailbox.reciever_id 
                inner join login_data on login_data.id = users.id 
                where document_id = $doc_id and (not status OR login_data.pos_id = 2)")[0];
            if($document['status_id'] == '2') {
                $signature = $pdo->getData("SELECT signature from signatures where id = (select max(id) from signatures where document_id = $doc_id)")[0]['signature'];
            } else {
                $signature = null;
            } 
            includeTemplate('mydoc.php', ['document' => $document, 'id' => $id, 'aprover' => $aprover, 'signature' => $signature]);
        }
        ?>
    </div>

    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <h4 class="text-center my-4">Выбрать новую версию документа?</h4>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Выбрать документ
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Документ 1</a></li>
                            <li><a class="dropdown-item" href="#">Документ 2</a></li>
                            <li><a class="dropdown-item" href="#">Документ 3</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" >Отправить</button>
                </div>
            </div>
        </div>
    </div>
<?php 
includeTemplate('footer.php');
