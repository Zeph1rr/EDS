<?php
$title = 'Все пользователи';
include '/var/www/sad/src/core.php';
$department = $user->department;


if (array_key_exists('delete', $_GET)) {
	$id = $_GET['delete'];
	if (is_numeric($id)) {
		$pdo->query("DELETE FROM users WHERE id = $id");
	}
	
}

$employees = $pdo->getData("SELECT users.id as id, login, first_name || ' ' || last_name as name, departments.name as department, positions.name as position
from login_data
inner join users on users.id = login_data.id
inner join positions on login_data.pos_id = positions.id
inner join departments on login_data.department_id = departments.id
where pos_id > 2");

$true_fields = array_keys($employees[0]);

$fields = ['&nbsp;','Логин', 'Фамилия и имя', 'Отдел', 'Должность'];

includeTemplate('admin.php', ['title' => $title, 'pos_id' => $user->pos_id]);
?>

<main class="mt-5 pt-3">
	<h1 class="text-center">Все пользователи</h1>
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
?>
<td>
<div class="container-xxl text-center">
	<button onclick="location.href = '?delete=<?=$employee['id']?>'" class="btn btn-primary"><i class="bi bi-person-x"></i></button>
</div>
</td>
<?php
	       		foreach ($true_fields as $field) {
	       			if ($field != 'id') {
?>
<td><?=$employee[$field]?></td>
<?php
							}
	        	}
	        	echo '</tr>';
	        }
	    ?>
	    </tbody>
	</table>
<?php 
includeTemplate('footer.php');
