<?php
$title = 'Регистрация';
include '/var/www/sad/src/core.php';

if (!empty($_POST)) {
    $chars = 'qazxswedcvfrtgbnhyujmkiolp';
    $name = pg_escape_string($_POST['name']);
    $lastname = pg_escape_string($_POST['lastname']);
    $age = pg_escape_string($_POST['age']);
    $position = pg_escape_string($_POST['position']); 
    $login = pg_escape_string($_POST['login']);
    $password = generate_hash(pg_escape_string($_POST['password']));
    if (preg_match('/[a-z]/', $login)) {
        if (preg_match('/[A-Za-z0-9_]/', $password)) {
        $pdo->query("INSERT INTO users (last_name, first_name, age) VALUES ('$lastname', '$name', $age);");
        $pdo->query("INSERT INTO login_data (login, password, pos_id, session_id) VALUES ('$login', '$password', $position, NULL);");
        header("refresh:0, url =/login/");  
        } else {
            $error = 'Недопустимые символы в пароле';
        }
    } else {
        $error = 'Недопустимые символы в логине';
    }

}

includeTemplate('header.php', ['title' => $title]);
?>
<main class="container-xxl form-signing my-5 col-xxl-4 col-md-6 col-sm-8">
    <form method="post">
        <?php
        if (isset($error)) {
            includeTemplate('alert.php', ['message' => $error, 'type' => 'danger']);
        }
        if (isset($success)) {
            includeTemplate('alert.php', ['message' => $success, 'type' => 'success']);
        }
        ?>
        <h1 class="h3 mb-3 text-center">Регистрация <?=$test?></h1>
        <div class="form-floating my-1">
            <input type="text" class="form-control" id="Name" name="name" required>
            <label for="Name">Имя</label>
        </div>
        <div class="form-floating my-1">
            <input type="text" class="form-control" id="Last name" name="lastname" required>
            <label for="Last name">Фамилия</label>
        </div>
        <div class="form-floating my-1">
            <input type="number" class="form-control" id="Date" name="age" required>
            <label for="Date">Возраст</label>
        </div>
        <div class="form-floating my-1">
            <input type="text" class="form-control" id="Email" name="login" required>
            <label for="Email">Логин</label>
        </div>
        </div>
        <div class="form-floating my-1">
            <input type="password" class="form-control" id="password" name="password" required>
            <label for="password">Пароль</label>
        </div>
        <div class="form-floating my-1">
            <p>Начальник<input type="radio" id="position" name="position" value='2' required>&nbsp;
            Сотрудник<input type="radio" id="position" name="position" value='3' required></p>
        </div>

        <button class="w-100 btn btn-lg btn-primary btn-outline-light" type="submit">Зарегистрироваться</button>
        <button onclick="document.location='/login/'" class="w-100 btn btn-lg btn-primary btn-outline-light my-1" type="button">У меня уже есть аккаунт</button>
    </form>
<?php 
includeTemplate('footer.php');
