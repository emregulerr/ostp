<?php
error_reporting(0);
setlocale(LC_ALL, 'tr_TR');
date_default_timezone_set('Europe/Istanbul');
require_once "../baglan.php";
require_once "functions.php";
session_start();
if (!isset($_SESSION['patron'])) {
	if (isset($_POST['pw'])) {
		$sifre = pass($_POST['pw']);
		$query = $conn->query("SELECT * FROM uyeler WHERE tel = '" . $_POST['tel'] . "'")->fetch(PDO::FETCH_ASSOC);
		if ($query) {
			if ($sifre == $query['pw']) {
				$_SESSION['patron'] = $query['id'];
                if (!empty($_POST['to']) && $_POST['to'] != "no-redirect") {
                    if (empty($query['mail'])) {
                        $mailError = true;
                    }else{
                        echo '
                        <form id="redirectForm" action="'.$_POST['to'].'" method="post">';
                            foreach ($query as $a => $b) {
                                echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
                            }
                        echo '<input type="hidden" name="loginWithOSTP" value="true">';
                        echo '</form>
                        <script type="text/javascript">
                            document.getElementById(\'redirectForm\').submit();
                        </script>';
                        exit();
                    }
                }
			} else {
				echo "<script>window.location.href = '../psct.php?giris=basarisiz&skipdonate=true';</script>";
			}
		} else {
			echo "<script>window.location.href = '../psct.php?giris=basarisiz&skipdonate=true';</script>";
		}
	} else {
		echo "<script>window.location.href = '../psct.php';</script>";
	}
}else{
    $query = $conn->query("SELECT * FROM uyeler WHERE id = '" . $_SESSION['patron'] . "'")->fetch(PDO::FETCH_ASSOC);
    if ($query) {
        if (!empty($_POST['to']) && $_POST['to'] != "no-redirect") {
            if (empty($query['mail'])) {
                $mailError = true;
            }else{
                echo '
                <form id="redirectForm" action="'.$_POST['to'].'" method="post">';
                    foreach ($query as $a => $b) {
                        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
                    }
                echo '<input type="hidden" name="loginWithOSTP" value="true">';
                echo '</form>
                <script type="text/javascript">
                    document.getElementById(\'redirectForm\').submit();
                </script>';
                exit();
            }
        }
    }else{
        echo "<script>window.location.href = '../psct.php?giris=basarisiz&skipdonate=true';</script>";
    }
}
$userid = $_SESSION['patron']??'0';
$ip = getIPNew();
$ipGuncelle = $conn->query("UPDATE uyeler SET ip='" . $ip . "' WHERE id = '" . $userid . "'");
$query = $conn->query("SELECT * FROM uyeler WHERE id = '" . $userid . "'")->fetch(PDO::FETCH_ASSOC);
if(!$query){echo "<script>window.location.href = '../psct.php';</script>";die();}
$aYuvHas = $query["yuvhas"];
$uyelikSonu = strtotime($query["dtarih"]);
$gunumuz = time();
$sayfamiz = substr($_SERVER['SCRIPT_FILENAME'], ($pos??0) + 7);
switch (true) {
case stristr($sayfamiz, 'psct'):
	$title = 'Giri?? - ';
	break;
case stristr($sayfamiz, 'satislar'):
	$title = 'Kafeterya - ';
	break;
case stristr($sayfamiz, 'rokayitlar'):
	$title = 'Kay??tlar - ';
	break;
case stristr($sayfamiz, 'yonetici'):
	$title = 'Y??netici Giri??i - ';
	break;
case stristr($sayfamiz, 'ayar.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'masalar.php'):
	$title = 'Masa Ayarlar?? - ';
	break;
case stristr($sayfamiz, 'tarifeler.php'):
	$title = 'Tarife Ayarlar?? - ';
	break;
case stristr($sayfamiz, 'kafeterya.php'):
	$title = 'Kafeterya Ayarlar?? - ';
	break;
case stristr($sayfamiz, 'kayitlar.php'):
	$title = 'Adisyonlar - ';
	break;
case stristr($sayfamiz, 'secenekler.php'):
	$title = 'Se??enekler - ';
	break;
case stristr($sayfamiz, 'hesap.php'):
	$title = 'Hesap Ayarlar?? - ';
	break;
case stristr($sayfamiz, 'masa.php'):
	$title = 'Masa - ';
	break;
default:
	$title = '';
	break;
}
?>
<html>
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RL6DT40SJL"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-RL6DT40SJL');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" type="text/css" href="../css/select2-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/picker/default.css" />
    <link rel="stylesheet" type="text/css" href="../css/picker/default.date.css" />
    <link rel="stylesheet" type="text/css" href="../css/picker/default.time.css" />
    <link rel="stylesheet" type="text/css" href="../css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="../css/stil.css?v=<?=time()?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/fh-3.1.8/r-2.2.7/sl-1.3.2/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-latest.min.js" ></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="../js/select2tr.js"></script>
    <script type="text/javascript" src="../js/formatter.min.js"></script>
    <script type="text/javascript" src="../js/picker/picker.js"></script>
    <script type="text/javascript" src="../js/picker/picker.date.js"></script>
    <script type="text/javascript" src="../js/picker/picker.time.js"></script>
    <script type="text/javascript" src="../js/picker/legacy.js"></script>
    <script type="text/javascript" src="../js/picker/tr_TR.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/fh-3.1.8/r-2.2.7/sl-1.3.2/datatables.min.js"></script>
    <script >
        $.extend( true, $.fn.dataTable.defaults, {
            dom: "Bfrtip",
            responsive:true,
            select:true,
            buttons: {
                "dom": {
                  container: {className: 'dt-buttons btn-group'},
                  button: {className: 'btn btn-sm'}
                },
                buttons:["copy","excel","print","pdf"]
            },
            "language": {
                "emptyTable": "Tabloda herhangi bir veri mevcut de??il",
                "info": "_TOTAL_ kay??ttan _START_ - _END_ aras??ndaki kay??tlar g??steriliyor",
                "infoEmpty": "Kay??t yok",
                "infoFiltered": "(_MAX_ kay??t i??erisinden bulunan)",
                "infoThousands": ".",
                "lengthMenu": "_MENU_",
                "loadingRecords": "Y??kleniyor...",
                "processing": "????leniyor...",
                "search": "_INPUT_",
                "searchPlaceholder": "Ara",
                "zeroRecords": "E??le??en kay??t bulunamad??",
                "paginate": {
                    "first": "??lk",
                    "last": "Son",
                    "next": "Sonraki",
                    "previous": "??nceki"
                },
                "aria": {
                    "sortAscending": ": artan s??tun s??ralamas??n?? aktifle??tir",
                    "sortDescending": ": azalan s??tun s??ralamas??n?? aktifle??tir"
                },
                "select": {
                    "rows": {
                        "_": "%d kay??t se??ildi",
                        "1": "1 kay??t se??ildi",
                        "0": "-"
                    },
                    "0": "-",
                    "1": "%d sat??r se??ildi",
                    "2": "-",
                    "_": "%d sat??r se??ildi",
                    "cells": {
                        "1": "1 h??cre se??ildi",
                        "_": "%d h??cre se??ildi"
                    },
                    "columns": {
                        "1": "1 s??tun se??ildi",
                        "_": "%d s??tun se??ildi"
                    }
                },
                "autoFill": {
                    "cancel": "??ptal",
                    "fillHorizontal": "H??creleri yatay olarak doldur",
                    "fillVertical": "H??creleri dikey olarak doldur",
                    "info": "-",
                    "fill": "B??t??n h??creleri <i>%d<\/i> ile doldur"
                },
                "buttons": {
                    "collection": "Koleksiyon <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "S??tun g??r??n??rl??????",
                    "colvisRestore": "G??r??n??rl?????? eski haline getir",
                    "copySuccess": {
                        "1": "1 sat??r panoya kopyaland??",
                        "_": "%d sat??r panoya kopyaland??"
                    },
                    "copyTitle": "Panoya kopyala",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "B??t??n sat??rlar?? g??ster",
                        "1": "-",
                        "_": "%d sat??r g??ster"
                    },
                    "pdf": "PDF",
                    "print": "Yazd??r",
                    "copy": "Kopyala",
                    "copyKeys": "Tablodaki veriyi kopyalamak i??in CTRL veya u2318 + C tu??lar??na bas??n??z. ??ptal etmek i??in bu mesaja t??klay??n veya escape tu??una bas??n."
                },
                "infoPostFix": "-",
                "searchBuilder": {
                    "add": "Ko??ul Ekle",
                    "button": {
                        "0": "Arama Olu??turucu",
                        "_": "Arama Olu??turucu (%d)"
                    },
                    "condition": "Ko??ul",
                    "conditions": {
                        "date": {
                            "after": "Sonra",
                            "before": "??nce",
                            "between": "Aras??nda",
                            "empty": "Bo??",
                            "equals": "E??ittir",
                            "not": "De??ildir",
                            "notBetween": "D??????nda",
                            "notEmpty": "Dolu"
                        },
                        "number": {
                            "between": "Aras??nda",
                            "empty": "Bo??",
                            "equals": "E??ittir",
                            "gt": "B??y??kt??r",
                            "gte": "B??y??k e??ittir",
                            "lt": "K??????kt??r",
                            "lte": "K??????k e??ittir",
                            "not": "De??ildir",
                            "notBetween": "D??????nda",
                            "notEmpty": "Dolu"
                        },
                        "string": {
                            "contains": "????erir",
                            "empty": "Bo??",
                            "endsWith": "??le biter",
                            "equals": "E??ittir",
                            "not": "De??ildir",
                            "notEmpty": "Dolu",
                            "startsWith": "??le ba??lar"
                        },
                        "array": {
                            "contains": "????erir",
                            "empty": "Bo??",
                            "equals": "E??ittir",
                            "not": "De??ildir",
                            "notEmpty": "Dolu",
                            "without": "Hari??"
                        }
                    },
                    "data": "Veri",
                    "deleteTitle": "Filtreleme kural??n?? silin",
                    "leftTitle": "Kriteri d????ar?? ????kart",
                    "logicAnd": "ve",
                    "logicOr": "veya",
                    "rightTitle": "Kriteri i??eri al",
                    "title": {
                        "0": "Arama Olu??turucu",
                        "_": "Arama Olu??turucu (%d)"
                    },
                    "value": "De??er",
                    "clearAll": "Filtreleri Temizle"
                },
                "searchPanes": {
                    "clearMessage": "Hepsini Temizle",
                    "collapse": {
                        "0": "Arama B??lmesi",
                        "_": "Arama B??lmesi (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown}\/{total}",
                    "emptyPanes": "Arama B??lmesi yok",
                    "loadMessage": "Arama B??lmeleri y??kleniyor ...",
                    "title": "Etkin filtreler - %d"
                },
                "searchPlaceholder": "Ara",
                "thousands": ".",
                "datetime": {
                    "amPm": [
                        "????",
                        "??s"
                    ],
                    "hours": "Saat",
                    "minutes": "Dakika",
                    "next": "Sonraki",
                    "previous": "??nceki",
                    "seconds": "Saniye",
                    "unknown": "Bilinmeyen"
                },
                "decimal": ",",
                "editor": {
                    "close": "Kapat",
                    "create": {
                        "button": "Yeni",
                        "submit": "Kaydet",
                        "title": "Yeni kay??t olu??tur"
                    },
                    "edit": {
                        "button": "D??zenle",
                        "submit": "G??ncelle",
                        "title": "Kayd?? d??zenle"
                    },
                    "error": {
                        "system": "Bir sistem hatas?? olu??tu (Ayr??nt??l?? bilgi)"
                    },
                    "multi": {
                        "info": "Se??ili kay??tlar bu alanda farkl?? de??erler i??eriyor. Se??ili kay??tlar??n hepsinde bu alana ayn?? de??eri atamak i??in buraya t??klay??n; aksi halde her kay??t bu alanda kendi de??erini koruyacak.",
                        "noMulti": "Bu alan bir grup olarak de??il ancak tekil olarak d??zenlenebilir.",
                        "restore": "De??i??iklikleri geri al",
                        "title": "??oklu de??er"
                    },
                    "remove": {
                        "button": "Sil",
                        "confirm": {
                            "_": "%d adet kayd?? silmek istedi??inize emin misiniz?",
                            "1": "Bu kayd?? silmek istedi??inizden emin misiniz?"
                        },
                        "submit": "Sil",
                        "title": "Kay??tlar?? sil"
                    }
                }
            },
        } );
    </script>
    <title><?php echo $title."OSTP - Oyun Salonu Takip Program??";?></title>
</head>
<body>
    <div id="anaSayfa">
        <div id="solMenu">
            <img class="menuBtn" title="OSTP - Oyun Salonu Takip Program??" src="../images/logow.png" alt="logo" />
            <a href="index.php" class="menuBtn" title="Masalar"><i class="fa-solid fa-gamepad fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="satislar.php" class="menuBtn" title="Kafeterya"><i class="fa-solid fa-mug-saucer fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="rokayitlar.php" class="menuBtn" title="Kay??tlar"><i class="fa-solid fa-file-lines fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="yonetici.php" class="menuBtn" title="Ayarlar"><i class="fa-solid fa-gears fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="../destek" id="supportBtn" class="menuBtn" title="Destek" style="color:#ffda6a" target="_blank"><i class="fa-solid fa-circle-question fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="../cikis.php" id="logoutBtn" class="menuBtn" title="????k???? Yap"><i class="fa-solid fa-power-off fa-2x fa-fw" aria-hidden="true"></i></a>
        </div>
        <div id="icerik">
            <div id="ustBar" class="ustBar">
                <?php echo '<div><i class="fa-solid fa-calendar fa-fw" aria-hidden="true"></i>&nbsp;<span id="tarihim">' . date_tr('j F Y', strtotime('now')) . '</span></div>
                <div><i class="fa-solid fa-clock fa-fw"></i>&nbsp;<span id="saatim">' . date('H:i') . '</span></div>'; ?>
            </div>
            <?php
                try {
                    $duyurular = $conn->query("SELECT * FROM duyurular")->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo '<script>console.log("Bir sorun olu??tu!");</script>';
                }
                if (isset($mailError) && $mailError == true) {
                    echo '<div class="alert alert-danger" role="alert">
                        <strong>Hata!</strong> OSTP Destek\'e giri?? yapabilmek i??in hesab??n??za e-posta adresinizi eklemeniz gerekmektedir. Hesap ayarlar??ndan eposta adresinizi ekledikten sonra tekrar deneyin.
                    </div>';
                }
                if ($duyurular) {
                    foreach ($duyurular as $duyuru) {
                        echo '<div class="alert alert-'.$duyuru['tip'].'" role="alert">';
                        if ($duyuru['baslik']) {
                            echo '<h4 class="alert-heading">'.$duyuru['baslik'].'</h4>';
                        }
                        if ($duyuru['ikon']) {
                            echo '<i class="fa fa-'.$duyuru['ikon'].'"></i>&emsp;';
                        }
                        echo $duyuru['icerik'].'</div>';
                    }
                }
            ?>