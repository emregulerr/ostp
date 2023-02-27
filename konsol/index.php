<?php include_once("ust.php");

if(isset($_GET["ac"])){

    $acilacakMasa=$_GET["ac"];

    $query = $conn->query("SELECT * FROM masalar WHERE id = '$acilacakMasa'")->fetch(PDO::FETCH_ASSOC);

    if($query["uid"] == $userid && $query["durum"]==0){

        $zaman= date("Y-m-d H:i:s");

        $durum = $conn->query("UPDATE masalar SET durum='1', azaman='$zaman' WHERE id = '$acilacakMasa'");
        $musteriip = GetIP();
        //$ekle=$conn->query("INSERT INTO islemkayitlari (ip, uid, masa, zaman) VALUES ('$musteriip', '$_SESSION[patron]', '$acilacakMasa', '$zaman')");
        echo "<script>window.location.href = 'index.php';</script>";

    }else{

        echo "<script>window.location.href = 'masa.php?masa=$acilacakMasa';</script>";

    }

}

$query = $conn->query("SELECT * FROM uyeler WHERE id = '$userid'")->fetch(PDO::FETCH_ASSOC);

echo '<div class="welcomeBox"><b>'.$query['firma'].'</b></div>';

?>


<?php     $query = $conn->query("SELECT * FROM masalar WHERE uid = '$userid'")->fetchAll(PDO::FETCH_ASSOC);

if($query){

    echo'<div id="kutuContainerK"><div id="kutuContainer" class="kutuContainer">';

    foreach($query as $masa){

        $masaid=$masa["id"];

        $durum=$masa["durum"];

        $masaadi=$masa["masaadi"];

        $resim=$masa["resim"];

        $tarife=$masa["tarife"];

        if($durum==1){

            $bzaman=$masa["azaman"];

            $kafeterya=0;

            $query=$conn->query("SELECT * FROM asatislar WHERE masaid='". $masaid ."'")->fetchAll(PDO::FETCH_ASSOC);
            if($query){
                foreach($query as $row){
                    $kafeterya+=getFloat($row["fiyat"]);
                }
            }

            $getirT=$conn->query("SELECT * FROM tarifeler WHERE id='$tarife'")->fetch(PDO::FETCH_ASSOC);

            $bfiyat=$getirT["bfiyat"];

            $fiyat=$getirT["fiyat"];

            $bfiyat = floatval(temizle($bfiyat));

            $fiyat = floatval(temizle($fiyat));

            $gzf=gzf(strtotime($bzaman),$bfiyat,$fiyat,$aYuvHas,$kafeterya);

            echo '<a href="masa.php?masa='.$masaid.'" class="stdKutu aktif"><img src="'.$resim.'">'.$masaadi.'<div class="priceTag"><i class="fa-solid fa-try"></i>&ensp;'.money_format('%!n',temizle($gzf["ucret"])).'</div><div class="timeTag"><i class="fa-solid fa-clock"></i>&ensp;'.$gzf["sure"].'</div></a>';

        }else{

            echo '<a href="index.php?ac='.$masaid.'" class="stdKutu"><img src="'.$resim.'">'.$masaadi.'</a>';

            }

    }

    echo'</div></div>';

}else{

    echo '<br /><br /><span style="width:100%;padding:10px;font-size:large;color:red;"><i class="fa-solid fa-triangle-exclamation"></i>  Masa bulunamadı! Lütfen önce <a href="masalar.php">masa ekleyin</a>.</span>';

}

?>

<script type="text/javascript">
    $(document).ready(function() {

        setInterval(function() {

            $('#kutuContainerK').load(document.URL + ' #kutuContainer');

        }, 10000);

    });

</script>

<?php include_once("alt.php");?>
