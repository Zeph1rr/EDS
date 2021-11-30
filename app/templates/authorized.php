<?php 
includeTemplate('header.php', ['title' => $title]);
?>

<!-- Навбар -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="/">СЭД</a>
    <div class="collapse navbar-collapse" id="topNavBar"></div>
  </div>
</nav>

<!-- Боковая Панель -->
<div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
  <div class="offcanvas-body p-0">
    <nav class="navbar-dark">
      <ul class="navbar-nav">
        <!-- Главная -->
        <li>
          <div class="text-muted small fw-bold text-uppercase px-3"> Главная </div> </li>
        <li> <a href="/" class="nav-link px-3 active">
          <span class="me-2"><i class="bi bi-person"></i></span>
          <span>Акаунт</span> </a>
        </li>

        <!-- Документы -->
        <li class="my-4"> <hr class="dropdown-divider bg-light"/></li>
        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">Документы</div>
        <li>
          <a href="/mydocs/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
            <span>Мои документы</span>
          </a>
        </li>
        <li>
          <a href="/create/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-file-earmark-plus"></i></span>
            <span>Загрузить документ</span>
          </a>
        </li>
        <li>
          <a href="/onsign/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-file-earmark-lock"></i></span>
            <span>На подпись</span>
          </a>
        </li>
        <li>
          <a href="/signed/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-file-earmark-check"></i></span>
            <span>Подписанные</span>
          </a>
        </li>
        <?php if ($pos_id != 4) { ?>
        <li>
          <a href="/report/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-file-earmark-zip"></i></span>
            <span>Отчетность</span>
          </a>
        </li>
        <?php } ?>
        <!-- Выход -->
        <li class="my-4"> <hr class="dropdown-divider bg-light"/></li>
        <li>
          <a href="?needRelogin=1" class="nav-link px-3 my-5">
            <span class="me-2"><i class="bi bi-arrow-bar-left"></i></span>
            <span>Выйти</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>