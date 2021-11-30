<?php
$title = $document['title'];
$filename = $document['file'];
$owner = $document['owner'];
$docID = $document['id'];
$file = explode('.', $filename)[0];

if (isset($signature)) {
    
}
if ($signature) {
    $result = check_signature($id, "/var/www/sad/documents/$owner/$signature", explode('.', $filename)[0]);
    if ($result) {
        $icon = 'bi bi-check-circle';
    }
}
if ($document['status'] == 3) {
    $icon = 'bi bi-dash-circle';
}
if (!isset($icon)) {
    $icon = 'bi bi-info-circle';
}

?>
<div class="col-sm-4">
    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title"><?=$title?> <?=isset($icon) ? "<i class='$icon'></i>" : ''?></h5>
            <p class="card-text"><?=$filename?></p>
            <p class="card-text">Владелец: <?=$document['owner_name']?></p>

            <button class="btn btn-primary my-1" onclick="location.href = '/download?filename=<?=$filename?>&owner=<?=$id?>'">
                <span><i class="bi bi-cloud-download"></i></span>
            </button>
        </div>
    </div>
</div>