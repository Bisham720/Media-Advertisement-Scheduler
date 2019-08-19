<?php
define("HNAME","localhost");
define("USER","root");
define("PWD","");
define("DBNAME","media_planning");


function executequery($query) {
	$link = mysqli_connect(HNAME,USER,PWD,DBNAME);
	$result = mysqli_query($link,$query);
	mysqli_close($link);
	return $result;
}
?>