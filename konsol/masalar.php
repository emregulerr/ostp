<?php include_once("ust.php"); 

if(!isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'yonetici.php';</script>";}

echo "<div class=\"welcomeBox\"><b>Masalar</b></div>";

if(isset($_POST["masaEkle"])){  

	$ekle=$conn->query("INSERT INTO masalar (uid, tarife, resim, masaadi) VALUES ('$userid', '$_POST[masaTarife]', '$_POST[masaresim]', '$_POST[masaAd]')"); 

	if(!$ekle){ echo'

<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa-solid fa-triangle-exclamation"></i> Bir hata oluştu!</span><br /><br />'; } }elseif(isset($_GET["sil"])){ $silinecek=$_GET['sil']; $sil=$conn->query("DELETE FROM masalar WHERE id='$silinecek'"); $sec = $conn->query("SELECT COUNT(*) FROM masalar"); $say = $sec->fetchColumn(); 

if($sil){

	$kaydir=$conn->query("UPDATE masalar SET id=id-1 WHERE id>$silinecek"); 

if($kaydir){

	$ayarla=$conn->query("ALTER TABLE masalar AUTO_INCREMENT =$say");

					 echo "<script>window.location.href = 'masalar.php';</script>";} 

				}else{ echo'

<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa-solid fa-triangle-exclamation"></i> Bir hata oluştu!</span><br /><br />'; } } $query=$conn->query("SELECT * FROM tarifeler WHERE uid='$userid'")->fetchAll(PDO::FETCH_ASSOC); 

if($query){?>

<form method="post">

    <div class="container">
        <div class="form-group form-group-lg">
        <select name="masaresim" required>

            <option value="" disabled selected hidden>Masa Türü</option>

			<option value="../images/konsol/pc.jpg">Bilgisayar</option>

			<option value="../images/konsol/ps3.jpg">PlayStation 3</option>

			<option value="../images/konsol/ps4.jpg">PlayStation 4</option>

			<option value="../images/konsol/ps4pro.jpg">PlayStation 4 Pro</option>

			<option value="../images/konsol/ps5.jpg">PlayStation 5</option>

			<option value="../images/konsol/psvr.jpg">PlayStation VR</option>

			<option value="../images/konsol/htcvr.jpg">HTC VIVE VR</option>
			
			<option value="../images/konsol/bilardo.jpg">Bilardo</option>
			
            <option value="../images/konsol/lngrt.jpg">Langırt</option>
            
            <option value="../images/konsol/dart.jpg">Dart</option>  
                      
            <option value="../images/konsol/pinpon.jpg">Masa Tenisi</option>   
                      
            <option value="../images/konsol/hockey.jpg">Hava Hokeyi</option> 
   
		</select>
        </div>
        <div class="form-group form-group-lg">
        <?php 

		echo'<select name="masaTarife" required>

        <option value="" disabled selected hidden>Tarife</option>';

			foreach($query as $row){

				echo'<option value="'.$row["id"].'">'. $row["tarifeadi"] .'</option>';

			}

		echo '</select>';

		?>
        </div>
        <input type="text" placeholder="Masa Adı" name="masaAd" size="10" autocomplete="on" required>

        <button name="masaEkle" type="submit">MASA EKLE</button>

    </div>

</form>

<?php

$query=$conn->query("SELECT * FROM masalar WHERE uid='$userid'")->fetchAll(PDO::FETCH_ASSOC);

echo'<div style="max-width:100% !important;"><table class="veri" id="records"><thead>
    <tr>
    <th></th>
    <th>Masa Adı</th>
    <th></th>
    </tr></thead><tbody>';
    foreach($query as $row){
        echo'<tr><td width="5%" style="min-width:50px;max-width:150px;"><img src="'. $row["resim"] .'" width="100%"></td><td>'. $row["masaadi"] .'</td><td><a href="masalar.php?sil='. $row["id"] .'"><i style="color:red;" class="fa-solid fa-trash-can fa-lg"></i></a></td></tr>';
    }
echo'</tbody></table></div>';
}else{
    echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa-solid fa-triangle-exclamation"></i> Tarife bulunamadı! Lütfen önce <a href="tarifeler.php">tarife ekleyin.</a></span><br /><br />';
}
?>
<script type="text/javascript">$("#records").DataTable({pageLength:5});</script>
<?php include_once("alt.php"); ?>
