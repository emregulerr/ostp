<?php include_once("ust.php"); 

if(!isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'yonetici.php';</script>";}

echo "<div class=\"welcomeBox\"><b>Tarifeler</b></div>"; 

if(isset($_POST["tarifeEkle"])){

	$deger1=temizle($_POST["fiyat"]);

	$tarifeFiyat=number_format($deger1,1,",",".");	$deger1=temizle($_POST["bfiyat"]);

	$tarifeBFiyat=number_format($deger1,1,",",".");

	$ekle=$conn->query("INSERT INTO tarifeler (uid, tarifeadi, bfiyat, fiyat) VALUES ('$_SESSION[patron]', '$_POST[tarife]', '$tarifeBFiyat', '$tarifeFiyat')");

	if(!$ekle){

		echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa-solid fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />';

	}

}elseif(isset($_GET["sil"])){

	$silinecek=$_GET['sil'];

	$sil=$conn->query("DELETE FROM tarifeler WHERE id='$silinecek'");

	$sec = $conn->query("SELECT COUNT(*) FROM tarifeler");

	$say = $sec->fetchColumn();

	if($sil){

		$kaydir=$conn->query("UPDATE tarifeler SET id=id-1 WHERE id>$silinecek");

		if($kaydir){

			$ayarla=$conn->query("ALTER TABLE tarifeler AUTO_INCREMENT =$say");

			echo "<script>window.location.href = 'tarifeler.php';</script>";

		}

	}else{

        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa-solid fa-triangle-exclamation"></i> Bir hata oluştu!</span><br /><br />';

    }

	

}

?>

<form method="post">

    <div class="container">

        <input type="text" placeholder="Tarife Adı" name="tarife" size="10" autocomplete="on" required>

        <input type="number" step="0.50" placeholder="En Düşük Ücret" name="bfiyat" size="10" min="0" autocomplete="on" required>

        <input type="number" step="0.50" placeholder="Saatlik Ücret" name="fiyat" size="10" min="0" autocomplete="on" required>

        <button name="tarifeEkle" type="submit">TARİFE EKLE</button>

    </div>

</form>

<?php
$query=$conn->query("SELECT * FROM tarifeler WHERE uid='".$_SESSION["patron"]."'")->fetchAll(PDO::FETCH_ASSOC);
echo'<div style="max-width:100% !important;"><table id="records" class="veri">
<thead>
<tr>
<th>Tarife Adı</th>
<th>En Düşük &Uuml;cret (₺)</th>
<th>Saatlik &Uuml;cret (₺)</th>
<th></th>
</tr></thead><tbody>';

foreach($query as $row){
	echo'<tr><td>'. $row["tarifeadi"] .'</td><td>'. $row["bfiyat"] .'</td><td>'. $row["fiyat"] .'</td><td><a href="tarifeler.php?sil='. $row["id"] .'"><i style="color:red;" class="fa-solid fa-trash-can fa-lg"></i></a></td></tr>';
}

echo'</tbody></table></div>';
?>
<script type="text/javascript">$("#records").DataTable({pageLength:5});</script>
    <?php include_once("alt.php"); ?>
