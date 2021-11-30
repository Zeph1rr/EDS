<?php
if (!isset($type)) {
	$type = "danger";
}
?>

<div class="alert alert-<?=$type?> text-center" role="alert">
<?=$message?>
</div>