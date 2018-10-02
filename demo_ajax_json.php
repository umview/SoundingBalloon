<?php
//$json = array('LNG'=>87.61792,'LAT'=>43.793308); //【关联数组】
$json = array('LNG'=>time()%50,'LAT'=>time()%20); //【关联数组】//test data!!!
echo json_encode($json);
?>
