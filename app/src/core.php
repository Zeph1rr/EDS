<?php

include 'ORM.php';
include 'Pg_Pdo.php';
include 'cryptoFunctions.php';
include 'otherFunctions.php';

session_start();
$pdo = new PG_PDO();
$pdo->connect('postgres', 'sad', 'sadpasswd', 'sad');

if (array_key_exists('needRelogin', $_GET)) {
		session_destroy();
		header('refresh:0, url=/login/');
}

if ($_SESSION) {
	$user = $_SESSION['user'];
	if (!validate_hash($_COOKIE['PHPSESSID'], $user->session_id) || !$pdo->getData("SELECT id FROM users WHERE id = " . $user->id)) {
		header("refresh:0, url=/?needRelogin=1");
	}
	if ($_SERVER['REQUEST_URI'] == '/login/' || $_SERVER['REQUEST_URI'] == '/registration/') {
		header("refresh:1, url=/");
		includeTemplate('messagePage.php', ['title' => 'Вы уже авторизированны']);
		exit(200);
	}
}

if (!$_SESSION && $_SERVER['REQUEST_URI'] != '/login/' && $_SERVER['REQUEST_URI'] != '/registration/') {
	header("refresh:1, url=/login/");
	includeTemplate('messagePage.php', ['title' => 'Требуется авторизация']);
	exit(200);
}