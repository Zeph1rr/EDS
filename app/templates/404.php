<?php
include '/var/www/sad/src/otherFunctions.php';
includeTemplate('header.php', ['title' => 'Страница не найдена']);
?>

<main class="container-xxl form-signing my-5 col-xxl-4 col-md-6 col-sm-8">
    <h1 class="h3 mb-3 text-center">Запрашиваемая вами страница не найдена :(</h1>
    <button onclick="document.location='/'" class="w-100 btn btn-lg btn-primary btn-outline-light my-1" type="button">Вернуться на главную</button>
    <img src="/assets/images/logo.png" height="50%" width="100%">
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<script src="/js/jquery-3.5.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap5.min.js"></script>
<script src="/js/script.js"></script>
</body>
</html>