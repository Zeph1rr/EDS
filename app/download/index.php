<?php

include_once '/var/www/sad/src/core.php';
if ($_GET) {
	$filename = $_GET['filename'];
	$owner = $_GET['owner'];

	file_force_download($_SERVER['DOCUMENT_ROOT'] . "/documents/$owner/$filename");
} else {
	file_force_download($_SERVER['DOCUMENT_ROOT'] . '/report-' . time() . '.csv');
	unlink($_SERVER['DOCUMENT_ROOT'] . '/report-' . time() . '.csv');
}
?>