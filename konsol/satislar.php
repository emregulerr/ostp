<?php include_once("ust.php");?>
<?php
echo '<div class="welcomeBox"><b>Kafeterya</b></div>'; 
if(isset($_POST["urunSat"])){ 
	$adet=$_POST["urunAdet"];	
	$masa=$_POST["masa"];	
    $urun=$_POST["urun"];
    $query=$conn->query("SELECT * FROM masalar WHERE id='". $masa ."'")->fetch(PDO::FETCH_ASSOC);
    $masaAdi=$query["masaadi"];    
    $query=$conn->query("SELECT * FROM urunler WHERE id='". $urun ."'")->fetch(PDO::FETCH_ASSOC);
    $urunAdi=$query["urunadi"];
    $birFiyat=$query["fiyat"];
    $deger1=temizle($birFiyat); 
    $birimFiyat=number_format($deger1,1,",",".");
    $fiyat=getFloat($birFiyat)*$adet;
    $deger1=temizle($fiyat); 
    $satisFiyat=number_format($deger1,1,",",".");
    $query=$conn->query("SELECT * FROM asatislar WHERE masaid='". $masa ."' AND urunid='". $urun ."'")->fetch(PDO::FETCH_ASSOC);
    if($query){
        $eskiAdet=$query["adet"];
        $guncelle=$query["id"];
        $adet=$eskiAdet+$adet;
        $fiyat=getFloat($birFiyat)*$adet;
        $deger1=temizle($fiyat); 
        $satisFiyat=number_format($deger1,1,",",".");
        $guncelle=$conn->query("UPDATE asatislar SET adet='". $adet ."', fiyat='". $satisFiyat ."' WHERE id='". $guncelle ."'");
    }else{    
        $ekle=$conn->query("INSERT INTO asatislar (uid, masaid, urunid, urunadi, masaadi, adet, birfiyat, fiyat) VALUES ('$_SESSION[patron]', '$masa', '$urun', '$urunAdi', '$masaAdi', '$adet', '$birimFiyat', '$satisFiyat')");
        if(!$ekle){
             echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />'; 
        }
    }
}elseif(isset($_POST["satisGuncelle"])){
    $guncelle=$_POST["satisid"];
    $adet=$_POST["stokg"];
    $birFiyat=$_POST["bfiyat"];
    $deger1=temizle($birFiyat); 
    $birimFiyat=number_format($deger1,1,",",".");
    $fiyat=getFloat($birFiyat)*$adet;
    $deger1=temizle($fiyat); 
    $satisFiyat=number_format($deger1,1,",",".");
    $guncelle=$conn->query("UPDATE asatislar SET adet='". $adet ."', fiyat='". $satisFiyat ."' WHERE id='". $guncelle ."'");
}elseif(isset($_GET["sil"])){
	$silinecek=$_GET['sil'];
	$sil=$conn->query("DELETE FROM asatislar WHERE id='$silinecek'");
	$sec = $conn->query("SELECT COUNT(*) FROM asatislar");
	$say = $sec->fetchColumn();
	if($sil){
		$kaydir=$conn->query("UPDATE asatislar SET id=id-1 WHERE id>$silinecek");
		if($kaydir){
			$ayarla=$conn->query("ALTER TABLE asatislar AUTO_INCREMENT =$say");
			echo "<script>window.location.href = 'satislar.php';</script>";
		}
	}else{
        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />';
    }
	 
}
    echo '<form method="post"><div class="form-group form-group-lg"><select name="masa" required>
    <option value="" disabled hidden selected>Masa Seçiniz</option>';
        $query=$conn->query("SELECT * FROM masalar WHERE uid='$userid' AND durum=1")->fetchAll(PDO::FETCH_ASSOC);
        foreach($query as $row){
            if(isset($_GET["masa"]) && ($_GET["masa"]==$row["id"])){
               echo '<option value="'.$row["id"].'" selected>'.$row["masaadi"].'</option>'; 
            }else{
                echo '<option value="'.$row["id"].'">'.$row["masaadi"].'</option>';
            }
        }

    echo '</select></div><div class="form-group form-group-lg"><select name="urun" required>
    <option value="" disabled hidden selected>Ürün Seçiniz</option>';
        $query=$conn->query("SELECT * FROM urunler WHERE uid='$userid'")->fetchAll(PDO::FETCH_ASSOC);
        foreach($query as $row){
            echo '<option value="'.$row["id"].'">'.$row["urunadi"].'</option>'; 
        }
    echo'</select></div><input type="number" name="urunAdet" step="1" min="1" value="1" required><button name="urunSat" type="submit">SAT</button>';
    if(isset($_GET["masa"])){
        echo '<a href="masa.php?masa='. $_GET["masa"] .'"><button type="button">MASAYA DÖN</button></a>';
    }
    echo '</form>';
        $sql = "SELECT * FROM asatislar WHERE uid='".$_SESSION["patron"]."' AND urunid!='0'".((!empty($_GET['masa']))?" AND masaid='".$_GET['masa']."'":"");
        $query=$conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            echo'<div style="max-width:100% !important;">
            <table class="veri" id="records">
            <thead>
            <tr>
            <th>Masa Adı</th>
            <th>Ürün Adı</th>
            <th>Adet</th>
            <th>Birim Fiyatı (₺)</th>
            <th>Toplam Fiyat (₺)</th>
            <th></th><th></th>
            </tr></thead><tbody>';
            $tKafeterya=0;
            foreach($query as $row){
                $tKafeterya+=getFloat($row["fiyat"]);
                if((isset($_GET["ac"])) && ($_GET["ac"] == $row["id"])){
                   echo'<tr><td>'. $row["masaadi"] .'</td><td>'. $row["urunadi"] .'</td><td><input type="hidden" name="bfiyat'.$row["id"].'" value="'. $row["birfiyat"] .'"><input type="number" step="1"  value="'. $row["adet"] .'" placeholder="'. $row["adet"] .'" name="stokg'.$row["id"].'" size="10" autocomplete="on" min="1" required></td><td>'.$row["birfiyat"].'</td><td>'.$row["fiyat"].'</td><td><a href="#" class="satisGuncelle" name="satisGuncelle" data-satisid="'.$row["id"].'"><i class="fa fa-floppy-o fa-lg" aria-hidden="true" style="color:green;"></i></a></td><td><a href="satislar.php?sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr>'; 
                }else{
                    echo'
                    <tr><td>'. $row["masaadi"] .'</td><td>'. $row["urunadi"] .'</td><td>'. $row["adet"] .'</td><td>'. $row["birfiyat"] .'</td><td>'. $row["fiyat"] .'</td><td><a href="satislar.php?ac='. $row["id"] .'"><i style="color:black;" class="fa fa-pencil-square-o fa-lg"></i></a></td><td><a href="satislar.php?sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr>';
                }
            }
            echo'</tbody></table></div>';
?>
<script type="text/javascript">
$(document).ready( function () {
    $("#records").DataTable({
        select:false,
        pageLength:5,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 5 },
        ]
    });
    $("#records").on("click",".satisGuncelle",function(e){
        e.preventDefault();
        e.stopPropagation();
        var satisid = $(this).data("satisid");
        var stokg = $('input[name="stokg'+satisid+'"]').last().val();
        var bfiyat = $('input[name="bfiyat'+satisid+'"]').last().val();
        //console.log(satisid + " " + stokg + " " + bfiyat);
        $.post("satislar.php", {satisGuncelle: true, satisid: satisid,stokg: stokg, bfiyat: bfiyat},function(){window.location = window.location.href.split("?")[0];});
    });
} );
</script>
    <?php include_once("alt.php");?>
