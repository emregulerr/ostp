<?php include_once("ust.php");
if(!isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'yonetici.php';</script>";}
if(isset($_POST['cpw'])){
	unset($bos);
	if(empty($_POST['firma']) && empty($_POST['npw'])){
		$bos='<span style="font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Form bomboş dostum n\'aptın?!</span>';
	}{
		if(!empty($_POST['firma'])){
			$firma=$_POST["firma"];
			$count = $conn->exec("UPDATE uyeler set firma ='$firma' where id = '$userid'");
			if ( $count ){
				$firmaSonucu = '<span style="font-size:large;color:green;"><i class="fa fa-thumbs-o-up"></i> Firma Adı Değiştirildi</span><br />';
			}else{
				$firmaSonucu= '<span style="font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Firma Adı Değiştirilemedi!</span><br />';
			}
		}
		if(!empty($_POST['npw'])){
			$sifre = pass(addslashes($_POST['npw']));
			$count = $conn->exec("UPDATE uyeler set pw ='$sifre' where id = '$userid'");
			if ( $count ){
				$sifreSonucu = '<span style="font-size:large;color:green;"><i class="fa fa-thumbs-o-up"></i> Şifre Değiştirildi.<br /> Yeni şifreniz: '.$_POST['npw'].'</span><br />';
			}else{
				$sifreSonucu= '<span style="font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Şifre Değiştirilemedi!</span><br />';
			}
		}
	}
}
$query = $conn->query("SELECT * FROM uyeler WHERE id = '$userid'")->fetch(PDO::FETCH_ASSOC);
$firma=$query["firma"];
$isim=$query["isim"];
$bitis=$query["dtarih"];
echo '
<div class="welcomeBox">Hesap: <b>'.$isim.'</b></div>
			<form method="post" autocomplete="false">
				<div class="container">
				<input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
<input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
					<input type="text" placeholder="'.$firma.'" name="firma" maxlength="100" autocomplete="new-password" value=""  title="Firma Adı">
					<input pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" type="password" value="" placeholder="Yeni Şifre" name="npw" size="10" autocomplete="new-password" title="En az; 8 karakter, 1 büyük harf, 1 küçük harf, 1 rakam">
					<button name="cpw" type="submit">Ayarları Kaydet</button>
					';

if(isset($bos)) echo $bos;
if(isset($firmaSonucu)) echo $firmaSonucu;
if(isset($sifreSonucu)) echo $sifreSonucu;
echo'
				</div>
			</form>
'; 
include_once("alt.php"); ?>
