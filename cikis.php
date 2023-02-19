<?php 
	require_once("baglan.php");
	session_start();
	session_destroy();
	echo "<script>window.location.href = 'psct.php';</script>";
?>
