<?php

require_once('config/application.php');

$authorization = new Authorization();
$authorization->restrictAccess();

if (!isset($_POST['printer_path'])) {
  header('HTTP/1.0 400 Bad Request', true, 400);
  die();
}

if ((!isset($_FILES['receipt'])) || (!isset($_FILES['receipt']['name']))) {
  header('HTTP/1.0 400 Bad Request', true, 400);
  die();
}

$printer_path = $_POST['printer_path'];
$port = (isset($_POST['port']) ? $_POST['port'] : 'lpt1');

$printer = new LPTPrinter($port, $printer_path);

header('Content-Type: application/json');
echo json_encode($printer->print($_FILES['receipt']['tmp_name']));

?>
