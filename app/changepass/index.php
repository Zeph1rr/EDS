<?php
$title = 'Сменить пароль';
include '/var/www/sad/src/core.php';
$login = $user->login;

if (!empty($_POST)) {
	$oldPassword = pg_escape_string($_POST['old']);
	$newPassword = pg_escape_string($_POST['new']);
	$passwordConfirmation = pg_escape_string($_POST['confirm']);
	$true_password = $pdo->getData("SELECT password FROM login_data WHERE login = '$login'")[0]['password'];
    if ($true_password) {
    	if (validate_hash($oldPassword, $true_password)) {
    		if ($newPassword == $passwordConfirmation) {
    			if ($newPassword != $oldPassword) {
    				$password = generate_hash($newPassword);
    				$result = $pdo->query("UPDATE login_data SET password = '$password' where login = '$login'");
    				if ($result) {
    					header('refresh:1, url=/?needRelogin=1');
    					includeTemplate('messagePage.php', ['title' => 'Требуется реавторизация']);
						exit(200);
    				} else {
    					$error = 'Ошибка базы данных';
    				}
    			} else {
    				$error = 'Нельзя использовать старый пароль';
    			}
    		} else {
    			$error = 'Пароли не совпадают';
    		}
    	} else {
    		$error = 'Неверный пароль';
    	}
    } else {
    	$error = 'Неизвестная ошибка';
    }
}

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>
<br \><br \><br \><br \>  
<main class="container-xxl offset-lg-5 form-signing my-5 col-xxl-4 col-md-6 col-sm-8">
    <form method="post">
    	<?php
        if ($error) {
            includeTemplate('alert.php', ['message' => $error]);
        }
        ?>
        <h1 class="h3 text-center">Смена пароля для <?=$login?></h1>
        <div class="form-floating my-1">
            <input type="password" class="form-control" id="old" name="old" required>
            <label for="old">Старый пароль</label>
        </div>
        <div class="form-floating my-1">
            <input type="password" class="form-control" id="new" name="new" required>
            <label for="new">Новый пароль</label>
        </div>
        <div class="form-floating my-1">
            <input type="password" class="form-control" id="confirm" name="confirm" required>
            <label for="confirm">Подтверждение пароля</label>
        </div>
            <button class="w-100 btn btn-lg btn-dark my-3" type="submit">Сменить Пароль</button>
    </form>
<?php 
includeTemplate('footer.php');