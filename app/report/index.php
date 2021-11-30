<?php
$title = 'Отчет';
include '/var/www/sad/src/core.php';
$department = $user->department;

if ($user->pos_id < 3) {
	$description = "всем сотрудникам";
	$employees = $pdo->getData("select users.id as id, first_name || ' ' || last_name as employee
		from users
		inner join login_data on users.id = login_data.id
		where pos_id > 2
		order by employee");
} else if ($user->pos_id == 3) {
	$description = "отделу '$department'";
	$employees = $pdo->getData("select users.id as id, first_name || ' ' || last_name as employee
	from users
	inner join login_data on users.id = login_data.id
	inner join departments on departments.id = login_data.department_id
	where pos_id = 4 AND departments.name = '$department'
	order by employee");
} else {
	header("refresh:0, url=/");
	exit;
}
$fields = ['Фамилия и имя', 'Всего', 'На согласовании', 'Подписано', 'Отказано'];

$reporting = [$fields];

includeTemplate('authorized.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>

<main class="mt-5 pt-3">
	<h1 class="text-center">Отчетность по <?=$description?></h1>
	<table class="table text-center">
	     <thead class="table-active">
	    <?php
	    foreach ($fields as $field) {
	        echo "<th>$field</th>";
	    }
	    ?>
	    </thead>
      	<tbody>
	    <?php
	       foreach ($employees as $employee) { 
	       		echo '<tr>';
	       		$id = $employee['id'];
	       		$name = $employee['employee'];
	        	echo "<td>$name</td>";
	        	$report = $pdo->getData("select report($id)");
	        	if ($report) {
	        		$info = explode(',', str_replace(['(', ')', '"'], '', $report[0]['report']));
	        	} else {
	        		$info = ['0, 0, 0, 0'];
	        	}
	        	$array = [$name];
	        	for ($k=0; $k < count($fields) - 1; $k++) { 
	        		$cell = $info[$k];
	        		$array[] = $cell;
?>
<td><?=$cell?></td>
<?php
	        	}
	        	$reporting[] = $array;
	        	echo '</tr>';
	        }
	    ?>
	    </tbody>
	</table>
	<div class="container-xxl text-center">
  		<button onclick="location.href = '?report=1'" class="btn btn-primary"><i class="bi bi-arrow-down"></i>Выгрузить отчет</button>
  	</div>
<?php 
if (array_key_exists('report', $_GET)) {
	get_report($reporting);
	header("refresh:0, url=/download/");
}
includeTemplate('footer.php');
