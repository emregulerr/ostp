<?php include_once("ust.php");
if(isset($_GET['kapat'])){
    unset($_SESSION['bigboss']);
    echo "<script>window.location.href = 'yonetici.php';</script>";
}elseif(!isset($_SESSION['bigboss'])){
	if(isset($_POST['mpw']))
	{
		$ysifre=pass($_POST['mpw']);
		$query = $conn->query("SELECT * FROM uyeler WHERE id = '". $userid ."'")->fetch(PDO::FETCH_ASSOC);
		if ( $query ){
			if($ysifre==nl2br($query['mpw'])){
				$_SESSION['bigboss'] = $query['id'];
			}
			else{
				echo "<script>window.location.href = 'yonetici.php';</script>";
			}
		}
		else{
			echo "<script>window.location.href = 'yonetici.php';</script>";
		}
	}else{
		echo "<script>window.location.href = 'yonetici.php';</script>";
	}
}
echo "<div class=\"welcomeBox\"><b>Ayarlar</b></div>";?>
<a href="masalar.php" class="stdKutu"><i class="fa fa-gamepad fa-3x" aria-hidden="true"></i><br />Masalar</a>
<a href="tarifeler.php" class="stdKutu"><i class="fa fa-tags fa-3x" aria-hidden="true"></i><br />Tarifeler</a>
<a href="kafeterya.php" class="stdKutu"><i class="fa fa-coffee fa-3x" aria-hidden="true"></i><br />Kafeterya</a>
<a href="kayitlar.php" class="stdKutu"><i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i><br />Kayıtlar</a>
<a href="secenekler.php" class="stdKutu"><i class="fa fa-cogs fa-3x" aria-hidden="true"></i><br />Seçenekler</a>
<a href="hesap.php" class="stdKutu"><i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i><br />Hesap</a>
<a href="ayar.php?kapat=1" class="stdKutu yotkap"><i class="fa fa-power-off fa-3x" aria-hidden="true"></i><br />Yönetici Oturumunu Kapat</a>
<?php include_once("alt.php");?>
