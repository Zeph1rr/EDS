<?php
$title = 'Все пользователи';
include '/var/www/sad/src/core.php';
$department = $user->department;


if (array_key_exists('delete', $_GET)) {
	$id = $_GET['delete'];
	if (is_numeric($id)) {
		$pdo->query("DELETE FROM departments WHERE id = $id");
	}
	
}

$departments = $pdo->getData("select * from departments where id > 1;");

$true_fields = array_keys($departments[0]);

$fields = ['&nbsp;','Название', 'Количество сотрудников', 'Начальник'];

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
	       foreach ($departments as $department) { 
	       		echo '<tr>';
	       		$department_id = $department['id'];
	       		$info = $pdo->getData("select department($department_id)")[0]['department'];
	       		$info = str_replace(['"', '(', ')'], '', $info);
	       		$info = explode(',', $info);
	       		$count = $info[0];
	       		$head = $info[1];
	       		if (!$head) {
	       			$head = 'Нет';
	       		}
?>
<td>
<div class="container-xxl text-center">
	<button onclick="location.href = '?delete=<?=$department_id?>'" class="btn btn-primary"><i class="bi bi-clipboard-x"></i></button>
</div>
</td>
<?php
	       		foreach ($true_fields as $field) {
	       			if ($field != 'id') {
?>
<td><?=$department[$field]?></td>
<?php
							}
	        	}
	        	echo "<td>$count</td><td>$head</td>";
	        	echo '</tr>';
	        }
	    ?>
	    </tbody>
	</table>
<?php 
includeTemplate('footer.php');
