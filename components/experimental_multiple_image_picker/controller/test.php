<?php
$temp = array();
foreach ($_FILES as $key => $value) {
	array_push($temp, $value);
}
echo json_encode($temp,JSON_PRETTY_PRINT);
?>