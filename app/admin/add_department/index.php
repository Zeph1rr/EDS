<?php
$title = 'Добавить отдел';
include '/var/www/sad/src/core.php';

if (!empty($_POST)) {
    $name = pg_escape_string($_POST['name']);
    $pdo->query("INSERT INTO departments (name) VALUES ('$name');");
    header("refresh:0, url =/");  
}

$departments = $pdo->getData("SELECT * from departments where id > 1");

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
            <label for="Name">Название отдела</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary btn-outline-light" type="submit">Добавить отдел</button>
    </form>
<?php 
includeTemplate('footer.php');
