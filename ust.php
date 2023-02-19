<?php
require_once 'baglan.php';
require_once "konsol/functions.php";
setlocale(LC_ALL, 'tr_TR');
date_default_timezone_set('Europe/Istanbul');
$uyesayisi = $conn->query("SELECT COUNT(*) FROM uyeler")->fetchColumn();
$masasayisi = $conn->query("SELECT COUNT(*) FROM masalar")->fetchColumn();
$adisyonsayisi = $conn->query("SELECT COUNT(*) FROM kayitlar")->fetchColumn();
?>
<!DOCTYPE html>
<html>
	<head>
	    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RL6DT40SJL"></script>
	    <script>
	      window.dataLayer = window.dataLayer || [];
	      function gtag(){dataLayer.push(arguments);}
	      gtag('js', new Date());
	      gtag('config', 'G-RL6DT40SJL');
	    </script>
	    <meta charset="utf-8">
	    <title>OSTP - Oyun Salonu Takip Programı</title>
	    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	    <meta name="keywords" content="playstation,ps,oyun,game,kafe,cafe,internet,program,yazılım,takip,kontrol">
	    <meta name="description" content="PlayStation Cafe Yönetim Programı - Oyun Salonu Takip Programı - OSTP - Online PlayStation Cafe Yönetim Sistemi">
	    <link rel="stylesheet" href="css/animate.min.css">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	    <link rel="stylesheet" href="css/templatemo-style.css?v=<?=time();?>">
	</head>
	<body>
		<div class="container-fluid m-0 p-0" data-bs-spy="scroll" data-bs-target="#navbarNav" tab-index="0">
		<div class="preloader"><div class="sk-spinner sk-spinner-rotating-plane"></div></div>
		<nav class="navbar fixed-top navbar-expand-lg bg-light">
		    <div class="container-fluid">
		        <a class="navbar-brand" href="index.php">
		          <img src="images/logo.png" alt="OSTP Logo" title="OSTP - Oyun Salonu Takip Programı">
		        </a>
		        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Menü">
		            <span class="navbar-toggler-icon"></span>
		        </button>
		        <div class="collapse navbar-collapse justify-content-lg-end" id="navbarNav">
		          <ul class="navbar-nav text-center">
		            <li class="nav-item">
		              <a class="nav-link" href="index.php#nedir">NEDİR?</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" href="index.php#ozellikler">ÖZELLİKLER</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" href="index.php#istatistikler">İSTATİSTİKLER</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" href="index.php#iletisim">İLETİŞİM</a>
		            </li>
		            <li class="nav-item mx-lg-2 my-2 my-lg-0">
		                <button onclick="window.location.href = 'rehber.php';" class="btn btn-warning text-uppercase"><i class="fa fa-book"></i> REHBER</button>
		            </li>
		            <li class="nav-item mx-lg-2 my-2 my-lg-0">
		                <button onclick="window.location.href = 'kaydet.php';" class="btn btn-success text-uppercase"><i class="fa fa-user-plus"></i> ÜCRETSİZ ÜYE OL</button>
		            </li>
		            <li class="nav-item mx-lg-2 my-2 my-lg-0">
		                <button onclick="window.location.href = 'konsol';" class="btn btn-primary text-uppercase"><i class="fa fa-sign-in"></i> GİRİŞ YAP</button>
		            </li>
		          </ul>
		        </div>
		    </div>
		</nav>