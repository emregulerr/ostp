<?php

 function pass($sifre){
    $sifrele = sha1(base64_encode(md5(base64_encode($sifre))));
    $sonuc = substr($sifrele, 5, 32);
    return $sonuc;
 }

function GetIP(){
    if(getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode (',', $ip);
            $ip = trim($tmp[0]);
        }
    } else {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

/*
*
*   IP adresini bul
*
*/
function getIPNew() {
    $ipaddress = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(!empty($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

function temizle($veri){//float değeri para formatına uydurma fonk.
    $veri1=substr($veri,0,-3); //Virgülden önceki değeri veri1 değişkenine alıyoruz.
    $veri2=substr($veri,-3,3); //virgül dahil son 3 karakteri veri2 değişkenine alıyoruz.

    $veri1=str_replace(",","",$veri1); //veri1 deki varsa ,(virgül) karakterini sildiriyoruz.
    $veri1=str_replace(".","",$veri1); //veri1 deki varsa .(nokta) karakterini sildiriyoruz.

    $veri2=str_replace(",",".",$veri2); //veri2 deki varsa ,(virgül) karakterini noktaya çeviriyoruz.
    $son=$veri1.$veri2; //ayarları yaptıktan sonra iki sayıyı birleştirip son değişkeninde yolluyoruz.
    return $son;
}

function getFloat($val) { //parayı float formatına uydurma fonk.
    $number = str_replace(array('.', ','), array('', '.'), $val);
    return $number;
}

function gzf($zaman,$bfiyat,$fiyat,$yuvHas=0,$kafeterya=0){//HERŞEYi YAPAN FONKSİYONUM
    $day = 60 * 60 * 24;//varsayılan-referans
    $fark=(time() - $zaman);
    $dakikam=round($fark/60);
    $sec = $day / 24 / 60 / 60 ;
    $min = $day / 24 / 60 ;
    $hour = $day / 24 ;
    $day = $day ;
    $week = $day * 7 ;
    $month = $day * 30 ;
    $year = $day * 365 ;
    if(floor($fark / $year) > 0){$ayear= floor($fark / $year);$fark=$fark -(floor($fark / $year) * $year);}else{$ayear=0;}
    if(floor($fark / $month) > 0){$amonth= floor($fark / $month);$fark=$fark -(floor($fark / $month) * $month);}else{$amonth=0;}
    if(floor($fark / $week) > 0){$aweek= floor($fark / $week);$fark=$fark -(floor($fark / $week) * $week);}else{$aweek=0;}
    if(floor($fark / $day) > 0){$aday= floor($fark / $day);$fark=$fark -(floor($fark / $day) * $day);}else{$aday=0;}
    if(floor($fark / $hour) > 0){$ahour= floor($fark / $hour);$fark=$fark -(floor($fark / $hour) * $hour);}else{$ahour=0;}
    if(floor($fark / $min) > 0){$amin= floor($fark / $min);$fark=$fark -(floor($fark / $min) * $min);}else{$amin=0;}
    //if(floor($fark / $sec) > 0){$asec= floor($fark / $sec);$fark=$fark -(floor($fark / $sec) * $sec);}else{$asec=0;}

    $print = "";
    $ayear > 0 ? $print.=$ayear." yıl ": "";
    $amonth > 0 ? $print.=$amonth." ay ": "";
    $aweek > 0 ? $print.=$aweek." hafta ": "";
    $aday > 0 ? $print.=$aday." gün ": "";
    $ahour > 0 ? $print.=$ahour." saat ": "";
    $amin > 0 ? $print.=$amin." dakika ": "";
    ($amin<=0 && $ahour<=0 && $aday<=0 && $aweek<=0 && $amonth<=0)? $print.="Az önce ": "";

    $gzf["sure"]=$print;

    $dakikafiyat = $fiyat/60;
    $ucret=max($dakikam*$dakikafiyat,$bfiyat); 

    switch($yuvHas){
        case 1:
            $ucret=round($ucret*2)/2;
            break;
        case 2:
            $ucret=round($ucret);
            break;
        case 3:
        
            /**
             * $kalan=fmod($ucret, 5.0);
             * $ucret = ($kalan>=2.5) ? ($ucret+(5-$kalan)) : ($ucret-$kalan);
             **/

            /**
             * son saatlik donguyu de tamamlarsa ne kadar odeyecek? 
             * @var saatlik
             **/
            $masaSuresi = time() - $zaman;
            $saatlik = ceil($masaSuresi/3600)*$fiyat;
            $kalan=fmod($ucret, 5.0);
            $usteYuvarlanmis = $ucret + (5-$kalan);
            $altaYuvarlanmis = $ucret - $kalan;
            /**
             *
             * aşağıdaki formül
             * 5'in katlarına yuvarlarken 
             * saatlik ücret 5in katı değil ise
             * yakın olan değere yuvarlar (saatlik ücrete veya 5 in katına)
             * bu durum kullanıcı tarafından belirlenen 
             * saatlik ücretin yuvarlanmasını önler
             *
             * örneğin;
             * saatlik ücret 17 TL ise,
             * yuvarlama hassasiyeti 5 TL iken
             * 53 dk. ücretini 20 TL yapmasını önler 
             * (17 TL yapar)
             * 
             **/
            if ($kalan >= 2.5) {
                $ucret = (abs($usteYuvarlanmis - $ucret) < abs($saatlik - $ucret)) ? $usteYuvarlanmis : $saatlik;
            }else{
                $ucret = (abs($altaYuvarlanmis - $ucret) < abs($saatlik - $ucret)) ? $altaYuvarlanmis : $saatlik;
            }
            break;
    }

    $toplam=0;
    $toplam+=$kafeterya+$ucret;

    $gzf["ucret"]=sprintf("%4.2f",$toplam);
    $gzf["masa"]=sprintf("%4.2f",$ucret);

    if($ayear>=1){
        $gzf["sure"]="Masa Unutulmuş";
        $gzf["ucret"]=0;
        $gzf["masa"]=0;
    }

    return $gzf;
}

function date_tr($f, $zt = 'now'){ // TÜRKÇE TARİH YAZDIRMA FONKSİYONU
    $z = date("$f", $zt);
    $donustur = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'    => 'Salı',
        'Wednesday'    => 'Çarşamba',
        'Thursday'    => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'    => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'    => 'Ocak',
        'February'    => 'Şubat',
        'March'        => 'Mart',
        'April'        => 'Nisan',
        'May'        => 'Mayıs',
        'June'        => 'Haziran',
        'July'        => 'Temmuz',
        'August'    => 'Ağustos',
        'September'    => 'Eylül',
        'October'    => 'Ekim',
        'November'    => 'Kasım',
        'December'    => 'Aralık',
        'Mon'        => 'Pts',
        'Tue'        => 'Sal',
        'Wed'        => 'Çar',
        'Thu'        => 'Per',
        'Fri'        => 'Cum',
        'Sat'        => 'Cts',
        'Sun'        => 'Paz',
        'Jan'        => 'Oca',
        'Feb'        => 'Şub',
        'Mar'        => 'Mar',
        'Apr'        => 'Nis',
        'Jun'        => 'Haz',
        'Jul'        => 'Tem',
        'Aug'        => 'Ağu',
        'Sep'        => 'Eyl',
        'Oct'        => 'Eki',
        'Nov'        => 'Kas',
        'Dec'        => 'Ara',
    );
    foreach($donustur as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
}

function MASGSM($Url, $body = null){
    $API_KEY = "cvHwlwTl6TCgusbCuCKQrhLJ6kweyIbpySjeihXaFLKV";

    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"Authorization: Key {$API_KEY}"));
    if($body):
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    endif;
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function SMSSonuc($respArr){
    $smssonucode = $respArr['status']['code'];
    switch($smssonucode){
        case '200':
            $smssonuc = "İşlem Başarılı";
            break;
        case '400':
            $smssonuc = "İstemci hatası (Numara girilmemiş, mesaj girilmemiş, başlık geçersiz)";
            break;
        case '401':
            $smssonuc = "API Key Hatalı";
            break;
        case '402':
            $smssonuc = "Yetersiz kredi";
            break;
        case '403':
            $smssonuc = "Yapmak istediğiniz işlem için yetkiniz yok";
            break;
        case '406':
            $smssonuc = "Verilen numaraya SMS atılamıyor";
            break;
        case '407':
            $smssonuc = "Hesap aktif değil";
            break;
        case '413':
            $smssonuc = "Mesaj metni izin verilen boyuttan daha büyüktür";
            break;
        default:
            $smssonuc = "Sunucu hatası";
            break;
    }
    return $smssonuc;
}

?>
