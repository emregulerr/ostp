<?php include_once("ust.php");
if(!isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'yonetici.php';</script>";}
if (!empty($_GET['sil'])) {
    $query = $conn->prepare("DELETE FROM kayitlar WHERE id = :id");
    $delete = $query->execute(array(
       'id' => $_GET['sil']
    ));
}
$yarin = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
$mesaj="";
echo "<div class=\"welcomeBox\"><b>Kayıtlar</b></div>";
$query=$conn->query("SELECT * FROM kayitlar WHERE uid='$userid' ORDER BY kzaman DESC")->fetchAll(PDO::FETCH_ASSOC);
echo'<div style="width:100%;"><table id="records" class="veri" width="100%">
<thead>
<tr>
<th>Masa</th>
<th>Açılış</th>
<th>Kapanış</th>
<th>Ücret</th>
<th>İşlemler</th>
</tr> 
</thead> 
<tbody>';
foreach($query as $row){
    echo'
    <tr><td>'. $row["masa"] .'</td><td>'. date_tr('d.m.Y H:i', strtotime($row["azaman"])) .'</td><td>'. date_tr('d.m.Y H:i', strtotime($row["kzaman"])) .'</td><td>₺'. $row["ucret"] .'</td><td><a href="kayitlar.php?sil='. $row["id"] .'"><i style="color:red;" class="fa fa-trash-o fa-lg"></i></a></td></tr>';
   $toplam+=temizle($row["ucret"]);
}
echo'</tbody><tfoot><tr><th align="right" colspan="2"></th><th align="right" colspan="3"></th></tr></tfoot></table></div>';
echo'
<script type="text/javascript">
$(document).ready( function () {
    $("#records").DataTable({
        pageLength:5,
	    columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 3 },
            { responsivePriority: 3, targets: 4 },
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            var floatVal = function ( i ) {
                return accounting.unformat(i, ",");
            };
 
            var toplamBedel = api.column( 3 ).data().reduce( function (a, b) {
                return floatVal(a) + floatVal(b);
            }, 0 );      

            var sayfaToplamBedel = api.column( 3,{page: \'current\'}).data().reduce( function (a, b) {
                return floatVal(a) + floatVal(b);
            }, 0 );

            var toplam = accounting.formatMoney(toplamBedel, "₺", 2, ".", ",");
            var sayfaToplam = accounting.formatMoney(sayfaToplamBedel, "₺", 2, ".", ",");

            $(api.column(0).footer()).html(\'Genel Toplam: \'+toplam);
            $(api.column(2).footer()).html(\'Sayfa Toplam: \'+sayfaToplam);
        }
    });
} );
</script>
';
include_once("alt.php"); ?>
