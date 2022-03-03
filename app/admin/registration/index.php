<?php
$title = 'Добавить пользователя';
include '/var/www/sad/src/core.php';

if (!empty($_POST)) {
    $name = pg_escape_string($_POST['name']);
    $lastname = pg_escape_string($_POST['lastname']);
    $age = pg_escape_string($_POST['age']);
    $position = pg_escape_string($_POST['position']); 
    $login = pg_escape_string($_POST['login']);
    $password = generate_hash(pg_escape_string($_POST['password']));
    $department_id = pg_escape_string($_POST['department']);
    if (preg_match('/[a-z]/', $login)) {
        if (preg_match('/[A-Za-z0-9_]/', $password)) {
        $pdo->query("INSERT INTO users (last_name, first_name, age) VALUES ('$lastname', '$name', $age);");
        $pdo->query("INSERT INTO login_data (login, password, pos_id, department_id) VALUES ('$login', '$password', $position, $department_id);");
        header("refresh:0, url=/admin/all_users");  
        } else {
            $error = 'Недопустимые символы в пароле';
        }
    } else {
        $error = 'Недопустимые символы в логине';
    }

}

$departments = $pdo->getData("SELECT * from departments");
$positions = $pdo->getData("SELECT id, name FROM positions where id > 1");

includeTemplate('admin.php', ['title' => $title]);
?>
<main class="mt-5 pt-3 ">
    <form method="post" class="container-xxl col-md-8">
        <?php
        if (isset($error)) {
            includeTemplate('alert.php', ['message' => $error, 'type' => 'danger']);
        }
        if (isset($success)) {
            includeTemplate('alert.php', ['message' => $success, 'type' => 'success']);
        }
        ?>
        <h1 class="h3 mb-3 text-center"><?=$title?></h1>
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
            <p>
            <?php foreach ($positions as $pos) { ?>
            <?=$pos['name']?> <input type="radio" id="position" name="position" value="<?=$pos['id']?>" required>&nbsp;
            <?php } ?>
            </p>
        </div>
        <div class="form-floating my-1">
            <p>
            <?php foreach ($departments as $department) { ?>
            <?=$department['name']?> <input type="radio" id="department" name="department" value="<?=$department['id']?>" required>&nbsp;
            <?php } ?>
            </p>
        </div>

        <button class="w-100 btn btn-lg btn-primary btn-outline-light" type="submit">Добавить пользователя</button>
    </form>
<?php 
includeTemplate('footer.php');
