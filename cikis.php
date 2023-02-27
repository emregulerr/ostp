<?php 
	require_once("baglan.php");
	session_start();
	session_destroy();
	if (!empty($_GET['to'])) {
		echo "<script>window.location.href = '".$_GET['to']."';</script>";
	}else{
		echo "<script>window.location.href = 'psct.php';</script>";
	}
?>
