<?php
$title = 'Акаунт';
include '/var/www/sad/src/core.php';
$id = $user->id;

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>


<!-- Наполнение страницы -->
<main class="mt-5 pt-3">
  <div class="container-xxl col-md-12">
    <h4 class="mx-2 my-2">Акаунт пользователя <?=$user->login?></h4>
    <div class="card my-2">
      <h5 class="card-header">Фамилия и имя</h5>
      <div class="card-body">
      <?=$user->name?>
      </div>
    </div>
    <div class="card my-2">
      <h5 class="card-header">Возраст:</h5>
      <div class="card-body">
        <?=$user->age?>
      </div>
    </div>
    <div class="card my-2">
      <h5 class="card-header">Отдел:</h5>
      <div class="card-body">
        <?=$user->department?>
      </div>
    </div>
    <div class="card my-2">
      <h5 class="card-header">Должность:</h5>
      <div class="card-body">
        <?=$user->position?>
      </div>
    </div>
    <?php if ($user->head_id) { ?>
    <div class="card my-2">
      <h5 class="card-header">Начальник:</h5>
      <div class="card-body">
        <?=$_SESSION['head']?>
      </div>
    </div>
    <?php } ?>
    <a class="w-100 btn btn-primary btn-lg my-1" href="/changepass/">
      Cменить Пароль
    </a>
    <a class="w-100 btn btn-primary btn-lg my-1" href="/getkeys/">
      Сгенерировать пару ключей
    </a>
  </div>


<?php 
includeTemplate('footer.php');

