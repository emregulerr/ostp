<?php include_once("ust.php"); 
if(!isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'yonetici.php';</script>";}
echo "<div class=\"welcomeBox\"><b>Kafeterya</b></div>"; 
if(isset($_POST["urunEkle"])){
	$urunAdet=$_POST["stok"];	
    $deger1=temizle($_POST["fiyat"]);
    $urunFiyat=number_format($deger1,1,",",".");
	$ekle=$conn->query("INSERT INTO urunler (uid, urunadi, adet, fiyat) VALUES ('$_SESSION[patron]', '$_POST[urun]', '$urunAdet', '$urunFiyat')");
	if(!$ekle){
		echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />';
	}

}elseif(isset($_POST["urunGuncelle"])){
    $guncelle=$_POST["urunid"];
    $stok=$_POST["stokg"];
    $deger1=temizle($_POST["fiyatg"]);
	$fiyat=number_format($deger1,1,",",".");
    $guncelle=$conn->query("UPDATE urunler SET adet='". $stok ."', fiyat='". $fiyat ."' WHERE id='". $guncelle ."'");
}elseif(isset($_GET["sil"])){
	$silinecek=$_GET['sil'];
	$sil=$conn->query("DELETE FROM urunler WHERE id='$silinecek'");
	$sec = $conn->query("SELECT COUNT(*) FROM urunler");
	$say = $sec->fetchColumn();
	if($sil){
		$kaydir=$conn->query("UPDATE urunler SET id=id-1 WHERE id>$silinecek");
		if($kaydir){
			$ayarla=$conn->query("ALTER TABLE urunler AUTO_INCREMENT =$say");
			echo "<script>window.location.href = 'kafeterya.php';</script>";
		}
	}else{
        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />';
    }
	 
}
?>
<form method="post">
    <div class="container">
        <input type="text" placeholder="Ürün Adı" name="urun" size="10" autocomplete="on" required>
        <input type="number" step="1" placeholder="Stok Adedi" name="stok" size="10" autocomplete="on" min="1" required>
        <input type="number" step="0.5" placeholder="Birim Fiyatı" name="fiyat" size="10" autocomplete="on" min="0" required>
        <button name="urunEkle" type="submit">ÜRÜN EKLE</button>
    </div>
</form>
<?php
$query=$conn->query("SELECT * FROM urunler WHERE uid='".$_SESSION["patron"]."'")->fetchAll(PDO::FETCH_ASSOC);
echo'<div style="max-width:100% !important;"><table id="records" class="veri">
<thead>
<tr>
<th>Ürün Adı</th>
<th>Stok Adedi</th>
<th>Birim Fiyatı (₺)</th>
<th></th><th></th>
</tr></thead><tbody>';
foreach($query as $row){
    if((isset($_GET["ac"])) && ($_GET["ac"] == $row["id"]) ){
       echo'<tr><td>'. $row["urunadi"] .'</td><td><input type="number" step="1"  value="'. $row["adet"] .'" placeholder="'. $row["adet"] .'" name="stokg'. $row["id"] .'" size="10" autocomplete="on" min="1" required></td><td><input type="number" step="0.5" value="'.getFloat($row["fiyat"]).'" placeholder="'.$row["fiyat"].'" name="fiyatg'. $row["id"] .'" size="10" autocomplete="on" min="0" required></td><td><a href="#" class="urunGuncelle" data-urunid="'. $row["id"] .'"><i class="fa fa-floppy-o fa-lg" style="color:green;" aria-hidden="true"></i></a></td><td><a href="kafeterya.php?sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr>'; 
    }else{
        echo'<tr><td>'. $row["urunadi"] .'</td><td>'. $row["adet"] .'</td><td>'. $row["fiyat"] .'</td><td><a href="kafeterya.php?ac='. $row["id"] .'"><i style="color:black;" class="fa fa-pencil-square-o fa-lg"></i></a></td><td><a href="kafeterya.php?sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr>';
    }
}
echo'</tbody></table></div>';?>
<script type="text/javascript">
$(document).ready( function () {
    $("#records").DataTable({
    	select:false,
    	pageLength:5,
	    columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
        ]
    });
    $("#records").on("click",".urunGuncelle",function(e){
    	e.preventDefault();
    	e.stopPropagation();
    	var urunid = $(this).data("urunid");
    	var stokg = $('input[name="stokg'+urunid+'"]').last().val();
    	var fiyatg = $('input[name="fiyatg'+urunid+'"]').last().val();
    	$.post("kafeterya.php", {urunGuncelle: true, urunid: urunid,stokg: stokg, fiyatg: fiyatg},function(){window.location = window.location.href.split("?")[0];});
    });
} );
</script>
<?php include_once("alt.php"); ?>
