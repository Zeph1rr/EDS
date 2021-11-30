<?php

include_once '/var/www/sad/src/core.php';

$id = $user->id;

if (file_exists("/var/www/sad/keys/$id.pem")) {
	unlink("/var/www/sad/keys/$id.pem");
} 

generate_key_pair($id);