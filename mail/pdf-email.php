<?php

header("Content-type: application/pdf");
$file = readfile($url);

echo $file;

?>