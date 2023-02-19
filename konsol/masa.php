<?php include_once("ust.php");

if(isset($_GET["masa"])){
    $masaid=$_GET["masa"];
    $query = $conn->query("SELECT * FROM masalar WHERE id = '$masaid'")->fetch(PDO::FETCH_ASSOC);
    $durum=$query["durum"];
	if($durum==0){echo "<script>window.location.href = 'index.php';</script>";}
	$resimurl=$query["resim"];
	$masaadi=$query["masaadi"];
	$tarife=$query["tarife"];
    $bzaman=$query["azaman"];  
	$query=$conn->query("SELECT * FROM tarifeler WHERE id='$tarife'")->fetch(PDO::FETCH_ASSOC);
    $tarifeadi=$query["tarifeadi"];
	$bfiyat=$query["bfiyat"];
	$fiyat=$query["fiyat"];
	$bfiyat = floatval(temizle($bfiyat)); 
	$fiyat = floatval(temizle($fiyat));
    $kafeterya=0;
    $query=$conn->query("SELECT * FROM asatislar WHERE masaid='". $masaid ."'")->fetchAll(PDO::FETCH_ASSOC);
    if($query){
        foreach($query as $row){
            $kafeterya+=getFloat($row["fiyat"]);
        }
    }
}else{

    echo "<script>window.location.href = 'index.php';</script>";

}

if(isset($_POST["satisGuncelle"])){

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

			echo "<script>window.location.href = 'masa.php?masa=$masaid';</script>";

		}

	}else{

        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />';

    }
}elseif(isset($_POST["tarifedegis"])){ 
    $hedefID=$_POST["tHedef"];
    $yeniZaman= date("Y-m-d H:i:00", time()); 
	$adet=1;
    $gzf=gzf(strtotime($bzaman),$bfiyat,$fiyat,$aYuvHas,$kafeterya);
    if($gzf["sure"]!="Az önce "){
        $urunAdi=$tarifeadi." - ".$gzf["sure"];
        $birFiyat=$gzf["masa"];
        $deger1=temizle($birFiyat); 
        $birimFiyat=number_format($deger1,1,",",".");
        $fiyat=getFloat($birFiyat)*$adet;
        $deger1=temizle($fiyat); 
        $satisFiyat=number_format($deger1,1,",",".");
        $ekle=$conn->query("INSERT INTO asatislar (uid, masaid, urunadi, masaadi, adet, birfiyat, fiyat) VALUES ('$_SESSION[patron]', '$masaid', '$urunAdi', '$masaadi', '$adet', '$birimFiyat', '$satisFiyat')");
    }else{$ekle=true;}
    if(!$ekle){
        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Bir hata oluştu!</span><br /><br />'; 
    }else{
        $nst = $conn->exec("UPDATE masalar set azaman ='".$yeniZaman."', tarife='".$hedefID."' where id = '". $masaid ."'");
        echo "<script>window.location.href = 'masa.php?masa=$masaid';</script>";
    }
    
}elseif(isset($_POST["newSTime"])){
    $yeniZaman= date("Y-m-d H:i:00", strtotime($_POST["newSTime"]));
    $nst = $conn->exec("UPDATE masalar set azaman ='".$yeniZaman."' where id = '". $masaid ."'");
    if(!$nst){
        echo '<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i>  Başlangıç saati değiştirilemedi!</span>';
    }else{
        echo "<script>window.location.href = 'masa.php?masa=$masaid';</script>";
    }

}

	echo"<div class=\"kutuContainer\">";

	echo"<div class=\"stdKutu\"><img src=\"$resimurl\">$masaadi</div>";

	echo"<a id=\"bsaat\" href=\"#\" class=\"stdKutu\"><i class=\"fa fa-clock-o fa-3x\" aria-hidden=\"true\"></i><br />".date_tr('j F \\| H:i', strtotime($bzaman))."</a>";

	$gzf=gzf(strtotime($bzaman),$bfiyat,$fiyat,$aYuvHas,$kafeterya);

	echo"<div class=\"stdKutu\"><i class=\"fa fa-hourglass fa-spin fa-3x\" aria-hidden=\"true\"></i><br /><span id=\"masaSure\">".$gzf["sure"]."</span></div>";

	echo"<a href=\"satislar.php?masa=$masaid\" class=\"stdKutu\"><i class=\"fa fa-coffee fa-3x\" aria-hidden=\"true\"></i><br />Kafeterya</a>";

//	echo"<div class=\"stdKutu aktif\"><i class=\"fa fa-try fa-3x\" aria-hidden=\"true\"></i><br /><span id=\"masaUcret\">".money_format('%!n',temizle($gzf["ucret"]))."</span></div>";

	echo"<a id=\"tarifeDB\" href=\"#\" class=\"stdKutu aktif\"><div class=\"priceTag\">Tarife: $tarifeadi</div><i class=\"fa fa-try fa-3x\" aria-hidden=\"true\"></i><br /><span id=\"masaUcret\">".money_format('%!n',temizle($gzf["ucret"]))."</span></a>";

	echo"<a id=\"mAktar\" href=\"#\" class=\"stdKutu masaAktar\"><i class=\"fa fa-exchange fa-3x\" aria-hidden=\"true\"></i><br />Aktar/Birleştir</a>";	

    echo"<a href=\"masa.php?masa=$masaid&kapat=1\" class=\"stdKutu masaKapat\"><i class=\"fa fa-close fa-3x\" aria-hidden=\"true\"></i><br />Masayı Kapat</a>";

	echo"</div> 

	<div id=\"masaSaatD\" class=\"stdKutu popUp\">

		<a href=\"#\" id=\"mSDKapat\" class=\"popUpKapat\"><i class=\"fa fa-close fa-2x\" aria-hidden=\"true\"></i></a>

		<br /> 

	<form method=\"post\">

	<div id=\"STContainer\" class=\"container\">

		<input type=\"text\" id=\"newSTime\" name=\"newSTime\" class=\"form-field js-datepicker\" value=\"".date("d-m-Y H:i:00",strtotime($bzaman))."\" required>
        <input type=\"hidden\" name=\"date\" id=\"date\"/>
        <input type=\"hidden\" name=\"time\" id=\"time\"/>
		<button name=\"degistir\" type=\"submit\" formaction=\"masa.php?masa=$masaid\">Değiştir</button>

	</div>

	</form>

		

	</div> 

	<div id=\"masaAB\" class=\"stdKutu popUp\">

		<a href=\"#\" id=\"mABKapat\" class=\"popUpKapat\"><i class=\"fa fa-close fa-2x\" aria-hidden=\"true\"></i></a>

		<br /> 

	<form method=\"post\">

	<div class=\"container\">
        <div class=\"form-group form-group-lg\">
        <select name=\"mHedef\" required>
        <option value=\"\" disabled hidden selected>Masa Seçiniz</option>";
        $query=$conn->query("SELECT * FROM masalar WHERE uid='$userid' AND id!='$masaid'")->fetchAll(PDO::FETCH_ASSOC);
        foreach($query as $row){
            echo '<option value="'.$row["id"].'">'.$row["masaadi"].'</option>'; 
        }
        echo"</select></div>

		<button name=\"aktar\" type=\"submit\" formaction=\"masa.php?masa=$masaid\">Aktar/Birleştir</button>

	</div>

	</form>

		

	</div>

	";
// FARKLI TARİFE İLE MASA AÇMA POPUP
echo "<div id=\"tarifeD\" class=\"stdKutu popUp\">

		<a href=\"#\" id=\"tDKapat\" class=\"popUpKapat\"><i class=\"fa fa-close fa-2x\" aria-hidden=\"true\"></i></a>

		<br /> 

	<form method=\"post\">

	<div class=\"container\">
        <div class=\"form-group form-group-lg\">
        <select name=\"tHedef\" required>
        <option value=\"\" disabled hidden selected>Tarife Seçiniz</option>";
        $query=$conn->query("SELECT * FROM tarifeler WHERE uid='$userid' AND id!='$tarife'")->fetchAll(PDO::FETCH_ASSOC);
        foreach($query as $row){
            echo '<option value="'.$row["id"].'">'.$row["tarifeadi"].'</option>'; 
        }
        echo"</select></div>

		<button name=\"tarifedegis\" type=\"submit\" formaction=\"masa.php?masa=$masaid\">Tarife Değiştir</button>

	</div>

	</form>

		

	</div>";



if(isset($_GET["kapat"])){

    if($durum==1){

        $kapat = $conn->exec("UPDATE masalar set durum ='0', azaman=NULL where id = '". $masaid ."'");

        if($kapat){
            if($gzf['ucret']!=0){
                $kzaman=date("Y-m-d H:i:s");

                $kaydet=$conn->query("INSERT INTO kayitlar (uid, masa, azaman, kzaman, ucret) VALUES ('$userid', '$masaadi', '$bzaman', '$kzaman', '".$gzf['ucret']."')");

                if($kaydet){
                    $sil=$conn->query("DELETE FROM asatislar WHERE masaid='". $masaid ."'");
                    // AKTİF SATIŞLAR İÇİN ID GÜNCELLEMESİ VE AUTO INCREMENT SIFIRLAMASI YAPILMADI 
                    if($sil){
                        echo "<script>window.location.href = 'index.php';</script>";
                    }else{
                       echo '<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i>  Kafeterya kayıtlarında hata oluştu!</span>';
                    }
                }else{
                    echo '<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i>  Masa bilgisi kaydedilemedi!</span>';
                }
            }else{
                echo "<script>window.location.href = 'index.php';</script>";
            }
        }else{

            echo '<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i>  Masa kapatılamadı!</span>';

        }
    }else{

        echo "<script>window.location.href = 'index.php';</script>";

    }

}



$query=$conn->query("SELECT * FROM asatislar WHERE masaid='". $masaid ."'")->fetchAll(PDO::FETCH_ASSOC);

if($query){

    echo'

    <table class="veri">

    <thead>

    <tr>

    <th colspan="6">Kafeterya Satışları</th>

    </tr>

    <tr>

    <th>Ürün Adı</th>

    <th>Adet</th>

    <th>Birim Fiyatı (₺)</th>

    <th>Toplam Fiyat (₺)</th>

    <th></th><th></th>

    </tr></thead><tbody>';

    foreach($query as $row){

        if((isset($_GET["ac"])) && ($_GET["ac"] == $row["id"])){

           echo'

            <form method="post"><input type="hidden" name="satisid" value="'. $row["id"] .'"><input type="hidden" name="bfiyat" value="'. $row["birfiyat"] .'"><tr><td>'. $row["urunadi"] .'</td><td><input type="number" step="1"  value="'. $row["adet"] .'" placeholder="'. $row["adet"] .'" name="stokg" size="10" autocomplete="on" min="1" required></td><td>'.$row["birfiyat"].'</td><td>'.$row["fiyat"].'</td><td><button name="satisGuncelle" type="submit" formaction="masa.php?masa='.$masaid.'"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i></button></td><td><a href="masa.php?masa='.$masaid.'&sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr></form>'; 

        }else{

            echo'

            <tr><td>'. $row["urunadi"] .'</td><td>'. $row["adet"] .'</td><td>'. $row["birfiyat"] .'</td><td>'. $row["fiyat"] .'</td><td><a href="masa.php?masa='.$masaid.'&ac='. $row["id"] .'"><i style="color:black;" class="fa fa-pencil-square-o fa-lg"></i></a></td><td><a href="masa.php?masa='.$masaid.'&sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr>';

        }

    }

    echo'

    </tbody>

     <tfoot><tr><tr><td colspan="3" style="text-align:right;"><b>Toplam:&emsp;</b></td><td><b>₺'. money_format('%!n', temizle($kafeterya)) .'</b></td><td></td><td></td></tfoot>

    </table>	

    ';

}
if(isset($_POST["aktar"])){
    $aHata=0;
    $hedefID=$_POST["mHedef"];
    $query = $conn->query("SELECT durum FROM masalar WHERE id = '$hedefID'")->fetch(PDO::FETCH_ASSOC);
    $hedefAdi=$query["masaadi"];
	if($query["durum"]==0){
        $zaman= date("Y-m-d H:i:s");
		$durum = $conn->query("UPDATE masalar SET durum='1', azaman='$zaman' WHERE id = '$hedefID'");
    }
    $fiyat=getFloat($gzf["masa"]);
    $deger1=temizle($fiyat); 
    $masaFiyat=number_format($deger1,1,",",".");
    if($fiyat!=0){
        $ekle=$conn->query("INSERT INTO asatislar (uid, masaid, urunadi, masaadi, adet, birfiyat, fiyat) VALUES ('$_SESSION[patron]', '$hedefID', '$masaadi', '$hedefAdi', '1', '$masaFiyat', '$masaFiyat')");
    }else{
        $ekle=true;
    }
    if(!$ekle){
        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Masa Aktarılamadı!</span><br /><br />';
    }else{
        $guncelle = $conn->exec("UPDATE asatislar SET masaid ='$hedefID', masaadi='$hedefAdi' WHERE masaid = '$masaid' AND urunid IS NULL");
        $query=$conn->query("SELECT * FROM asatislar WHERE masaid='$masaid'")->fetchAll(PDO::FETCH_ASSOC);
        foreach($query as $row){
            $aUrunID=$row["urunid"];
            $aUrunAdet=$row["adet"];
            $aBFiyat=getFloat($row["birfiyat"]);
            $query=$conn->query("SELECT * FROM asatislar WHERE urunid='$aUrunID' AND masaid='$hedefID'")->fetch(PDO::FETCH_ASSOC);
            if($query){
                $eAdet=$query["adet"];
                $yAdet=$eAdet+$aUrunAdet;
                $fiyat=$aBFiyat*$yAdet;
                $deger1=temizle($fiyat); 
                $satisFiyat=number_format($deger1,1,",",".");
                $guncelle = $conn->exec("UPDATE asatislar SET adet ='$yAdet', fiyat='$satisFiyat' WHERE masaid = '$hedefID' AND urunid='$aUrunID'");
                if($guncelle){
                    $sil=$conn->query("DELETE FROM asatislar WHERE masaid = '$masaid' AND urunid='$aUrunID'");
                    if(!$sil){
                        echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Satış aktarma hatası! Eski masadan silinemedi!</span><br /><br />';
                        $aHata=1;
                    }
                }else{
                    echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Satış aktarma hatası! Hedef satış güncellenemedi!</span><br /><br />';
                    $aHata=1;
                }
            }else{
                $gun2 = $conn->exec("UPDATE asatislar SET masaid ='$hedefID', masaadi = '$hedefAdi' WHERE masaid = '$masaid' AND urunid='$aUrunID'");
                if(!$gun2){
                    echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Benzersiz satış aktarılamadı!</span><br /><br />';
                    $aHata=1;
                }
            }
        }
        if($aHata==0){
            $kapat = $conn->exec("UPDATE masalar set durum ='0', azaman=NULL where id = '$masaid'");
            if($kapat){
                echo "<script>window.location.href = 'masa.php?masa=$hedefID';</script>";
            }else{
                echo'<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa fa-exclamation-triangle"></i> Masa Aktarıldı Ancak Eski Masa Kapatılamadı!</span><br /><br />'; 
            }
        }
    }
}

?>

<script type="text/javascript">
    $(document).ready(function() {
          var datepicker = $('#date').pickadate({
            container: '#masaSaatD',
            formatSubmit: 'dd-mm-yyyy',
            closeOnSelect: true,
            closeOnClear: false,
            onSet: function(item) {
              if ( 'select' in item ) setTimeout( timepicker.open, 0 );
            },
            onOpen: function() {
                $('#solMenu').hide();
            },
            onClose: function() {
                $('#solMenu').show();                
            }
          }).pickadate('picker');

          var timepicker = $('#time').pickatime({
            container: '#masaSaatD',
            format: 'HH:i:00',
            interval: 1, 
            onRender: function() {
              $('<button>Geri</button>').on('click', function() {
                timepicker.close();
                datepicker.open();
              }).prependTo( this.$root.find('.picker__box') );
            },
            onSet: function(item) {
              if ( 'select' in item ) setTimeout( function() {
                $('.js-datepicker.active').val( datepicker.get() + ' @ ' + timepicker.get() );
                $('.js-datepicker').removeClass('active');
                $('.active_name').val( $('input[name=date_submit]').val() +' '+ $('#time').val().replace(' ', '') ).removeClass('active_name');
              }, 0 )
            },
            onOpen: function() {
                $('#solMenu').hide();
            },
            onClose: function() {
                $('#solMenu').show();                
            }
          }).pickatime('picker');

          $('.js-datepicker').each(function(){  
            $(this).on('focus', function(event) {
              $(this).addClass('active');
              $('input[name=newSTime]').addClass('active_name');
            });
            $datetime = $(this).on('focus', datepicker.open).on('click', function(event) {
              event.stopPropagation();
              datepicker.open();
            });
          });
        setTimeout(function() {
            $('select[name="tHedef"]').select2({
                language:"tr",
                dropdownParent: $('#tarifeD')
            });
            $('select[name="mHedef"]').select2({
                language:"tr",
                dropdownParent: $('#masaAB')
            });
        }, 500);
        setInterval(function() {
            $('#masaUcret').load(document.URL + ' #masaUcret');
            $('#masaSure').load(document.URL + ' #masaSure');
        }, 10000);
    });

</script>

<?php include_once("alt.php");?>