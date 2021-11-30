<?php
$title = 'Мои документы';
include '/var/www/sad/src/core.php';
$id = $user->id;
$documents = $pdo->getData("SELECT documents.id as id, documents.title as title, documents.file as file, documents.owner as owner, 
    users.last_name || ' ' || users.first_name as owner_name, statuses.id as status, mailbox.status as sign_status 
    FROM mailbox 
    inner join documents on mailbox.document_id = documents.id 
    inner join users on documents.owner = users.id 
    inner join statuses on statuses.id = documents.status_id
    WHERE reciever_id = $id AND (mailbox.status OR documents.status_id = 3)");

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>

<main class="mt-5 pt-3">
    <div class="container-xxl row">
        <?php
        
        foreach ($documents as $document) {
            $doc_id = $document['id'];
            if($document['sign_status']) {
                $signature = $pdo->getData("SELECT signature from signatures where document_id = $doc_id and signature like '%_$id.dat'")[0]['signature'];
            } else {
                $signature = null;
            } 
            includeTemplate('signed.php', ['document' => $document, 'id' => $id, 'signature' => $signature]);
        }
        ?>
    </div>
<?php 
includeTemplate('footer.php');
