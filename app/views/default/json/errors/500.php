<?php
$context = \Context::getInstance();
echo json_encode($context->error->ToObject());
?>

