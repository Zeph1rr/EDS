<?php
$title = 'Вход';
include '/var/www/sad/src/core.php';

if (!empty($_POST)) {
    $login = pg_escape_string($_POST['login']);
    $password = pg_escape_string($_POST['password']);
    $true_password = $pdo->getData("SELECT password FROM login_data WHERE login = '$login'")[0]['password'];
    if ($true_password) {
        if (validate_hash($password, $true_password)) {

            $user = $pdo->getData("SELECT login_data.id as id, users.first_name || ' ' || users.last_name as ln, users.age as age,
            login_data.login as login, positions.name as pos, login_data.pos_id as pos_id, departments.name as department
            FROM login_data
            inner join positions on login_data.pos_id = positions.id 
            inner join users on login_data.id = users.id
            inner join departments on departments.id = login_data.department_id 
            WHERE login_data.login = '$login'")[0];
            if ($user['pos_id'] == 3) {
                $head = $pdo->getData("SELECT login_data.id as id, last_name || ' ' || first_name || ' (' || name || ')' as head FROM login_data
                inner join users on users.id = login_data.id
                inner join positions on login_data.pos_id = positions.id
                WHERE pos_id = 2")[0];
            } else if ($user['pos_id'] == 4) {
                $head = $pdo->getData("SELECT login_data.id as id, last_name || ' ' || first_name || ' (' || name || ')' as head FROM login_data 
                    inner join users on users.id = login_data.id
                    inner join positions on login_data.pos_id = positions.id
                    WHERE pos_id = (select pos_id - 1 from login_data where login = '$login') AND 
                    department_id = (SELECT department_id FROM login_data WHERE login = '$login')")[0];
            } else {
                $head = ['id' => null, 'head' => 'Нет'];
            }
            $sessid = generate_hash($_COOKIE['PHPSESSID']);
            $pdo->query("UPDATE login_data set session_id = '$sessid' WHERE login = '$login'");
            $auth = new User(
                $user['id'],
                $user['ln'],
                $user['login'],
                $user['pos'],
                $sessid,
                $user['age'],
                $user['department'],
                $head['id'],
                $user['pos_id']);
            $_SESSION['user'] = $auth;
            $_SESSION['head'] = $head['head'];
            header('refresh:0, url=/');
        } else {
            $error = 'Неверный логин или пароль';
        }
    } else {
        $error = 'Неверный логин или пароль';
    }
}
includeTemplate('header.php', ['title' => $title]);
?>

<main class="container-xxl form-signing my-5 col-xxl-4 col-md-6 col-sm-8">
    <form method="post">
        <?php
        if (isset($error)) {
            includeTemplate('alert.php', ['message' => $error]);
        }
        ?>
        <h1 class="h3 mb-3 text-center">Авторизация</h1>
        <div class="form-floating my-1">
            <input type="text" class="form-control" id="email" name='login' value="<?=isset($_POST['login']) ? $_POST['login'] : ''?>" required>
            <label for="email">Логин</label>
        </div>
        <div class="form-floating my-1">
            <input type="password" class="form-control" id="password" name='password' value="<?=isset($_POST['password']) ? $_POST['password'] : ''?>" required>
            <label for="password">Пароль</label>
        </div>
            <button class="w-100 btn btn-lg btn-primary btn-outline-light" type="submit">Войти</button>
    </form>
<?php 
includeTemplate('footer.php');
