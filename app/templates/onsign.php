<?php
$title = $document['title'];
$filename = $document['file'];
$owner = $document['owner'];
$docID = $document['id'];
$file = explode('.', $filename)[0];

?>
<div class="col-sm-4">
    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title"><?=$title?>
</h5>
            <p class="card-text"><?=$filename?></p>
            <p class="card-text">Владелец: <?=$document['owner_name']?></p>

            <button class="btn btn-primary my-1" onclick="location.href = '/download?filename=<?=$filename?>&owner=<?=$id?>'">
                <span><i class="bi bi-cloud-download"></i></span>
            </button>
            <button class="btn btn-primary my-1" onclick="location.href = '/signature?title=<?=$title?>&filename=<?=$filename?>&docid=<?=$docID?>'">
                <span><i class="bi bi-pen"></i></span>
            </button>
            <button class="btn btn-primary my-1" onclick="location.href = '/onsign?cancel=<?=$docID?>'">
                <span><i class="bi bi-dash-circle"></i></span>
            </button>
        </div>
    </div>
</div>