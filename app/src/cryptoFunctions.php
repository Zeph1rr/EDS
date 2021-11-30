<?php
function generate_hash($value, $cost=8) 
{
    $salt=substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
    $salt=str_replace("+",".",$salt);
    $param='$'.implode('$',array(
            "2y",
            str_pad($cost,2,"0",STR_PAD_LEFT),
            $salt 
    ));
    return crypt($value,$param);
}

function validate_hash($value, $hash) 
{
    return crypt($value, $hash) == $hash;
}

function generate_key_pair($id) 
{
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    $new_key_pair = openssl_pkey_new($config);
    openssl_pkey_export($new_key_pair, $private_key_pem);

    $details = openssl_pkey_get_details($new_key_pair);
    $public_key_pem = $details['key'];

    openssl_free_key($new_key_pair);

    $file = fopen("/var/www/sad/keys/$id.pem", 'w');
    fwrite($file, $public_key_pem);
    fclose($file);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=private_key.pem");
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($private_key_pem));
    print($private_key_pem);
}

function get_signature($private_key_pem, $filename, $id, $direction)
{
    $private_key = openssl_pkey_get_private($private_key_pem);
    if (!$private_key) {
        return "Загруженный файл - не приватный ключ в формате pem";
    }
    $result = openssl_sign($filename, $signature, $private_key);
    openssl_free_key($private_key);
    if ($result) {
        file_put_contents("$direction/signature_" . $filename . "_" . $id . ".dat", $signature);
        return True;
    } else {
        return "Неизвестная ошибка";
    }
}

function check_signature($id, $signature, $filename)
{
    $signature = file_get_contents($signature);
    $public_key_pem = file_get_contents("/var/www/sad/keys/$id.pem");
    $public_key = openssl_pkey_get_public($public_key_pem);
    $r = openssl_verify($filename, $signature, $public_key);
    openssl_free_key($public_key);
    return $r;
}