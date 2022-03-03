<?php 
includeTemplate('header.php', ['title' => $title]);
?>

<!-- Навбар -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="/">СКО "Коммунизм"</a>
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
        <li class="my-4"> <hr class="dropdown-divider bg-light"/></li>
        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">Пользователи</div>
        <li>
          <a href="/admin/all_users" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-people"></i></span>
            <span>Все пользователи</span>
          </a>
        </li>
        <li>
          <a href="/admin/registration/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-person-plus"></i></span>
            <span>Добавить пользователя</span>
          </a>
        </li>
        <li class="my-4"> <hr class="dropdown-divider bg-light"/></li>
        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">Отделы</div>
        <li>
          <a href="/admin/departments/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-clipboard"></i></span>
            <span>Все отделы</span>
          </a>
        </li>
        <li>
          <a href="/admin/add_department/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-clipboard-plus"></i></span>
            <span>Добавить отдел</span>
          </a>
        </li>
        <li class="my-4"> <hr class="dropdown-divider bg-light"/></li>
        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">Документы</div>
        <li>
          <a href="/report/" class="nav-link px-3">
            <span class="me-2"><i class="bi bi-file-earmark-zip"></i></span>
            <span>Отчетность</span>
          </a>
        </li>

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