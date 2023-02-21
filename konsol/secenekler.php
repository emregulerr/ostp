<?php include_once("ust.php");
if(!isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'yonetici.php';</script>";}
echo "<div class=\"welcomeBox\"><b>Seçenekler</b></div>";
if(isset($_POST["secKaydet"])){
    $yuvHas=$_POST["yuvHas"]; 
   $count = $conn->exec("UPDATE uyeler set yuvhas ='$yuvHas' where id = '$userid'");
    if ( $count ){
                $aYuvHas=$yuvHas;
				$yuvSon = '<span style="font-size:large;color:green;"><i class="fa-solid fa-thumbs-up"></i> Yuv. Has. Değiştirildi</span><br />';
			}else{
				$yuvSon= '<span style="font-size:large;color:red;"><i class="fa-solid fa-triangle-exclamation"></i> Yuv. Has. Değiştirilemedi!</span><br />';
			}
}
echo ' 
	<div class="container">
    <form method="post">
    <fieldset>
  <legend>Ücret Yuvarlama Hassasiyeti</legend>
        <input type="radio" name="yuvHas" id="yok" value="0"'.($aYuvHas==0 ? " checked "  : " ").'required>
        <label for="yok"'.($aYuvHas==0 ? " style=\"font-weight:bold;color:green;\""  : " ").'>Yuvarlama</label><br>
        <input type="radio" name="yuvHas" id="yarim" value="1"'.($aYuvHas==1 ? " checked " : " ").'>
        <label for="yarim"'.($aYuvHas==1 ? " style=\"font-weight:bold;color:green;\""  : " ").'>₺0,5</label><br>
        <input type="radio" name="yuvHas" id="bir" value="2"'.($aYuvHas==2 ? " checked " : " ").'>
        <label for="bir"'.($aYuvHas==2 ? " style=\"font-weight:bold;color:green;\""  : " ").'>₺1</label><br>
        <input type="radio" name="yuvHas" id="bes" value="3"'.($aYuvHas==3 ? " checked " : " ").'>
        <label for="bes"'.($aYuvHas==3 ? " style=\"font-weight:bold;color:green;\""  : " ").'>₺5</label>
        </fieldset>
        <button name=secKaydet type="submit">Kaydet</button>';
if(isset($yuvSon)) echo $yuvSon;
echo'	</form>  
    </div>
	
';

include_once("alt.php");?>
