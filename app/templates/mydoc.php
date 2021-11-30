<?php
$filename = $document['file'];
$title = $document['title'];
$fileID = $document['id'];
$aproverName = $aprover['name'];
$aproverID = $aprover['id'];

if (isset($signature)) {
    $result = check_signature($aproverID, "/var/www/sad/documents/$id/$signature", explode('.', $filename)[0]);
    if ($result) {
        $icon = 'bi bi-check-circle';
    }
}
if ($document['status_id'] == 3) {
    $icon = 'bi bi-dash-circle';
}
if (!isset($icon)) {
    $icon = 'bi bi-info-circle';
}


$file = explode('.', $filename)[0];
?>
<div class="col-sm-4">
    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title"><?=$title?> <?=isset($icon) ? "<i class='$icon'></i>" : ''?></h5>
            <p class="card-text"><?=$filename?></p>
            <p class="card-text">
                Статус: <?=$document['status']?> <?=$aproverName ? "($aproverName)" : ''?>
                <?php if ($document['stage'] != 4 && $document['status_id'] != 3) { ?>
                    <br>
                    Стадия: <?=$document['stage']?>
                <?php } ?>
            </p>
            <button class="btn btn-primary my-1" onclick="location.href = '/download?filename=<?=$filename?>&owner=<?=$id?>'">
                <span><i class="bi bi-cloud-download"></i></span>
            </button>
            <button class="btn btn-primary my-1" onclick="if (confirm('Вы действительно хотите удалить этот документ?')) { location.href = '?delete=<?=$filename?>'; }">
                <span><i class="bi bi-bucket"></i></span>
            </button>
        </div>
    </div>
</div>