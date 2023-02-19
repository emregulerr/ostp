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
			} else {
				echo "<script>window.location.href = '../psct.php?giris=basarisiz';</script>";
			}
		} else {
			echo "<script>window.location.href = '../psct.php?giris=basarisiz';</script>";
		}
	} else {
		echo "<script>window.location.href = '../psct.php';</script>";
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
	$title = 'Giriş - ';
	break;
case stristr($sayfamiz, 'satislar'):
	$title = 'Kafeterya - ';
	break;
case stristr($sayfamiz, 'rokayitlar'):
	$title = 'Kayıtlar - ';
	break;
case stristr($sayfamiz, 'yonetici'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'ayar.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'masalar.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'tarifeler.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'kafeterya.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'kayitlar.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'secenekler.php'):
	$title = 'Ayarlar - ';
	break;
case stristr($sayfamiz, 'hesap.php'):
	$title = 'Ayarlar - ';
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
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
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
                "emptyTable": "Tabloda herhangi bir veri mevcut değil",
                "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "infoEmpty": "Kayıt yok",
                "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                "infoThousands": ".",
                "lengthMenu": "_MENU_",
                "loadingRecords": "Yükleniyor...",
                "processing": "İşleniyor...",
                "search": "_INPUT_",
                "searchPlaceholder": "Ara",
                "zeroRecords": "Eşleşen kayıt bulunamadı",
                "paginate": {
                    "first": "İlk",
                    "last": "Son",
                    "next": "Sonraki",
                    "previous": "Önceki"
                },
                "aria": {
                    "sortAscending": ": artan sütun sıralamasını aktifleştir",
                    "sortDescending": ": azalan sütun sıralamasını aktifleştir"
                },
                "select": {
                    "rows": {
                        "_": "%d kayıt seçildi",
                        "1": "1 kayıt seçildi",
                        "0": "-"
                    },
                    "0": "-",
                    "1": "%d satır seçildi",
                    "2": "-",
                    "_": "%d satır seçildi",
                    "cells": {
                        "1": "1 hücre seçildi",
                        "_": "%d hücre seçildi"
                    },
                    "columns": {
                        "1": "1 sütun seçildi",
                        "_": "%d sütun seçildi"
                    }
                },
                "autoFill": {
                    "cancel": "İptal",
                    "fillHorizontal": "Hücreleri yatay olarak doldur",
                    "fillVertical": "Hücreleri dikey olarak doldur",
                    "info": "-",
                    "fill": "Bütün hücreleri <i>%d<\/i> ile doldur"
                },
                "buttons": {
                    "collection": "Koleksiyon <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "Sütun görünürlüğü",
                    "colvisRestore": "Görünürlüğü eski haline getir",
                    "copySuccess": {
                        "1": "1 satır panoya kopyalandı",
                        "_": "%d satır panoya kopyalandı"
                    },
                    "copyTitle": "Panoya kopyala",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Bütün satırları göster",
                        "1": "-",
                        "_": "%d satır göster"
                    },
                    "pdf": "PDF",
                    "print": "Yazdır",
                    "copy": "Kopyala",
                    "copyKeys": "Tablodaki veriyi kopyalamak için CTRL veya u2318 + C tuşlarına basınız. İptal etmek için bu mesaja tıklayın veya escape tuşuna basın."
                },
                "infoPostFix": "-",
                "searchBuilder": {
                    "add": "Koşul Ekle",
                    "button": {
                        "0": "Arama Oluşturucu",
                        "_": "Arama Oluşturucu (%d)"
                    },
                    "condition": "Koşul",
                    "conditions": {
                        "date": {
                            "after": "Sonra",
                            "before": "Önce",
                            "between": "Arasında",
                            "empty": "Boş",
                            "equals": "Eşittir",
                            "not": "Değildir",
                            "notBetween": "Dışında",
                            "notEmpty": "Dolu"
                        },
                        "number": {
                            "between": "Arasında",
                            "empty": "Boş",
                            "equals": "Eşittir",
                            "gt": "Büyüktür",
                            "gte": "Büyük eşittir",
                            "lt": "Küçüktür",
                            "lte": "Küçük eşittir",
                            "not": "Değildir",
                            "notBetween": "Dışında",
                            "notEmpty": "Dolu"
                        },
                        "string": {
                            "contains": "İçerir",
                            "empty": "Boş",
                            "endsWith": "İle biter",
                            "equals": "Eşittir",
                            "not": "Değildir",
                            "notEmpty": "Dolu",
                            "startsWith": "İle başlar"
                        },
                        "array": {
                            "contains": "İçerir",
                            "empty": "Boş",
                            "equals": "Eşittir",
                            "not": "Değildir",
                            "notEmpty": "Dolu",
                            "without": "Hariç"
                        }
                    },
                    "data": "Veri",
                    "deleteTitle": "Filtreleme kuralını silin",
                    "leftTitle": "Kriteri dışarı çıkart",
                    "logicAnd": "ve",
                    "logicOr": "veya",
                    "rightTitle": "Kriteri içeri al",
                    "title": {
                        "0": "Arama Oluşturucu",
                        "_": "Arama Oluşturucu (%d)"
                    },
                    "value": "Değer",
                    "clearAll": "Filtreleri Temizle"
                },
                "searchPanes": {
                    "clearMessage": "Hepsini Temizle",
                    "collapse": {
                        "0": "Arama Bölmesi",
                        "_": "Arama Bölmesi (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown}\/{total}",
                    "emptyPanes": "Arama Bölmesi yok",
                    "loadMessage": "Arama Bölmeleri yükleniyor ...",
                    "title": "Etkin filtreler - %d"
                },
                "searchPlaceholder": "Ara",
                "thousands": ".",
                "datetime": {
                    "amPm": [
                        "öö",
                        "ös"
                    ],
                    "hours": "Saat",
                    "minutes": "Dakika",
                    "next": "Sonraki",
                    "previous": "Önceki",
                    "seconds": "Saniye",
                    "unknown": "Bilinmeyen"
                },
                "decimal": ",",
                "editor": {
                    "close": "Kapat",
                    "create": {
                        "button": "Yeni",
                        "submit": "Kaydet",
                        "title": "Yeni kayıt oluştur"
                    },
                    "edit": {
                        "button": "Düzenle",
                        "submit": "Güncelle",
                        "title": "Kaydı düzenle"
                    },
                    "error": {
                        "system": "Bir sistem hatası oluştu (Ayrıntılı bilgi)"
                    },
                    "multi": {
                        "info": "Seçili kayıtlar bu alanda farklı değerler içeriyor. Seçili kayıtların hepsinde bu alana aynı değeri atamak için buraya tıklayın; aksi halde her kayıt bu alanda kendi değerini koruyacak.",
                        "noMulti": "Bu alan bir grup olarak değil ancak tekil olarak düzenlenebilir.",
                        "restore": "Değişiklikleri geri al",
                        "title": "Çoklu değer"
                    },
                    "remove": {
                        "button": "Sil",
                        "confirm": {
                            "_": "%d adet kaydı silmek istediğinize emin misiniz?",
                            "1": "Bu kaydı silmek istediğinizden emin misiniz?"
                        },
                        "submit": "Sil",
                        "title": "Kayıtları sil"
                    }
                }
            },
        } );
    </script>
    <title><?php echo $title."OSTP - Oyun Salonu Takip Programı";?></title>
</head>
<body>
    <div id="anaSayfa">
        <div id="solMenu">
            <img class="menuBtn" title="OSTP - Oyun Salonu Takip Programı" src="../images/logow.png" alt="logo" />
            <a href="index.php" class="menuBtn" title="Masalar"><i class="fa fa-gamepad fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="satislar.php" class="menuBtn" title="Kafeterya"><i class="fa fa-coffee fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="rokayitlar.php" class="menuBtn" title="Kayıtlar"><i class="fa fa-file-text-o fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="yonetici.php" class="menuBtn" title="Ayarlar"><i class="fa fa-cogs fa-2x fa-fw" aria-hidden="true"></i></a>
            <a href="../cikis.php" id="logoutBtn" class="menuBtn" title="Çıkış Yap"><i class="fa fa-power-off fa-2x fa-fw" aria-hidden="true"></i></a>
        </div>
        <div id="icerik">
            <div id="ustBar" class="ustBar">
                <?php echo '<div><i class="fa fa-calendar fa-fw" aria-hidden="true"></i>&nbsp;<span id="tarihim">' . date_tr('j F Y', strtotime('now')) . '</span></div>
                <div><i class="fa fa-clock-o fa-fw"></i>&nbsp;<span id="saatim">' . date('H:i') . '</span></div>'; ?>
            </div>