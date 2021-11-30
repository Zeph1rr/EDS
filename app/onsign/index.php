<?php
$title = 'Мои документы';
include '/var/www/sad/src/core.php';
if (isset($_GET['cancel'])) {
    $doc_id = $_GET['cancel'];
    $pdo->query("UPDATE documents SET status_id = 3 WHERE id = $doc_id");
    header("refresh:0, url=/onsign");
    exit;
}
$id = $user->id;
$documents = $pdo->getData("SELECT documents.id as id, documents.title as title, documents.file as file, documents.owner as owner, 
    users.last_name || ' ' || users.first_name as owner_name 
    FROM mailbox 
    inner join documents on mailbox.document_id = documents.id 
    inner join users on documents.owner = users.id 
    WHERE reciever_id = $id AND NOT mailbox.status AND NOT documents.status_id = 3");

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>

<main class="mt-5 pt-3">
    <div class="container-xxl row">
        <?php
        foreach ($documents as $document) {
            includeTemplate('onsign.php', ['document' => $document, 'id' => $id]);
        }
        ?>
    </div>
<?php 
includeTemplate('footer.php');
