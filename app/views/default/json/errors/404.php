<?php
header("HTTP/1.0 404 Not Found");

$context = \Context::getInstance();
echo json_encode((object) array('error' => '404'));
?>

