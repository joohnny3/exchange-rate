<?php
$content = file_get_contents('https://tw.rter.info/capi.php');
echo json_encode($content);
?>