<?php 
function includeTemplate($templatePath, $data = [])
{
    extract($data);
    include '/var/www/sad/templates/' . ltrim($templatePath, '/');
}

function generatePassword()
{
    $length = 8;
    $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP'; 
    $size = strlen($chars) - 1; 
    $password = ''; 
    while($length--) {
        $password .= $chars[random_int(0, $size)]; 
    }
    return $password;
}

function checkFormat(string $str): bool
{
    return preg_match('/.doc|.pdf/', $str);
}

function file_force_download($file) {
  if (file_exists($file)) {
    if (ob_get_level()) {
      ob_end_clean();
    }
    header('Content-Description: File Transfer');
    header('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename=' . end(explode('/', $file)));
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    if ($fd = fopen($file, 'rb')) {
      while (!feof($fd)) {
        print fread($fd, 1024);
      }
      fclose($fd);
    }
    return True;
  }
  exit;
}

function get_report($report)
{
  $filename = $_SERVER['DOCUMENT_ROOT'] . '/report-' . time() . '.csv';
  $file = fopen("$filename", 'w');
  fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
  foreach ($report as $fields) {
    fputcsv($file, $fields, ';');
  }
  fclose($file);
}
