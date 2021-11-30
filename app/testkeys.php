<pre>
<?php
// $config = array(
//     "digest_alg" => "sha512",
//     "private_key_bits" => 4096,
//     "private_key_type" => OPENSSL_KEYTYPE_RSA,
// );
//   $data = 'my data';

// //Создаём новую пару открытый/закрытый ключ
// $new_key_pair = openssl_pkey_new($config);
// openssl_pkey_export($new_key_pair, $private_key_pem);
// echo $private_key_pem;

// $details = openssl_pkey_get_details($new_key_pair);
// $public_key_pem = $details['key'];
// echo $public_key_pem;

// //Вычисляем подпись
// openssl_sign($data, $signature, $private_key_pem, OPENSSL_ALGO_SHA256);

// //Сохраняем
// file_put_contents('private_key.pem', $private_key_pem);
// file_put_contents('public_key.pem', $public_key_pem);
// file_put_contents('signature.dat', $signature);

// //Сверяем подпись
// $r = openssl_verify($data, $signature, $public_key_pem, "sha256WithRSAEncryption");
// var_dump($r); 

// $pkeyid = openssl_pkey_get_private("file://key");
// $public_key = openssl_pkey_get_public("file://keys/1.pem");

// $data = 'hui';

// // Вычисляем подпись
// openssl_sign($data, $signature, $pkeyid);

// // Высвобождаем ресурс ключа
// openssl_free_key($pkeyid);

// file_put_contents('signature.dat', $signature);


// var_dump($signature);

// $sign = file_get_contents('signature.dat');

// $r = openssl_verify($data, $sign, $public_key);
// var_dump($r); 

// include '/var/www/sad/src/cryptoFunctions.php';

// generate_key_pair(1);

// openssl_sign($data, $signature, $pkeyid);

// $string = '/var/www/sad/keys/1.pem';

// var_dump(implode('/',explode('/', $string, -1)) . '/');

include '/var/www/sad/src/Pg_Pdo.php';

$pdo = new PG_PDO();
$pdo->connect('postgres', 'sad', 'sadpasswd', 'sad');

$fields = ['Фамилия и имя', 'Всего', 'На согласовании', 'Подписано', 'Отказано'];
$info = explode(',', str_replace(['(', ')'], '', $pdo->getData("select report(3)")[0]['report']));
var_dump($fields, $info);

// if (!empty($_FILES)) {
// 	$id = 1;
// 	$private_key_pem = $_SERVER['DOCUMENT_ROOT'] . "/" . $_FILES['file']['name'];
// 	move_uploaded_file($_FILES['file']['tmp_name'],  $private_key_pem);
// 	$filename = "лаба антоновой 2";
// 	get_signature($private_key_pem, $filename, $id);
// 	$res = check_signatue($id, file_get_contents("/var/www/sad/documents/$id/signature_" . $filename . "_" . $id . ".dat"), $filename);

// 	// $public_key = openssl_pkey_get_public("file://keys/$id.pem");
// 	// $sign = file_get_contents('signature.dat');
// 	// $r = openssl_verify($data, $sign, $public_key);
// }

// foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/documents/1/*лаба антоновой 2*.*") as $filename) {
//     echo "$filename размер " . filesize($filename) . "\n";
// }



?>
</pre>

<table>
    <tr>
    <?php
    foreach ($fields as $field) {
        echo "<th>$field</th>";
    }
    ?>
    </tr>
    <?php
       for ($i=0; $i < 5; $i++) { 
        	echo '<tr>';
        	$info = explode(',', str_replace(['(', ')'], '', $pdo->getData("select report($i)")[0]['report']));
        	for ($k=0; $k < count($fields); $k++) { 
        		$cell = $info[$k];
        		echo "<td>$cell</td>";
        	}
        	echo '</tr>';
        }
    ?>
</table>
<!-- <form enctype="multipart/form-data" method="post">
	<input type="file" name="file">
	<button type='submit'>hui</button>
</form> -->