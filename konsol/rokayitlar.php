<?php include_once("ust.php");
echo "<div class=\"welcomeBox\"><b>Kayıtlar</b></div>";
echo'<div style="width:100%;margin-top:20px;"><table id="records" class="veri display" width="100%">
<thead>
<tr>
<th>Masa</th>
<th>Açılış</th>
<th>Kapanış</th>
<th>Ücret</th>
</tr> 
</thead>  
<tbody>';
$rQuery=$conn->query("SELECT * FROM kayitlar WHERE uid='$userid' ORDER BY kzaman DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
foreach($rQuery as $row){
    echo'
    <tr><td>'. $row["masa"] .'</td><td>'. date_tr('d.m.Y H:i', strtotime($row["azaman"])) .'</td><td>'. date_tr('d.m.Y H:i', strtotime($row["kzaman"])) .'</td><td>₺'. $row["ucret"] .'</td></tr>';
    $toplam+=temizle($row["ucret"]);
}
echo'</tbody><tfoot><tr><th align="right" colspan="2"></th><th align="right" colspan="2"></th></tr></tfoot></table>';
echo'<script type="text/javascript">
$(document).ready( function () {
    $("#records").DataTable({
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 3 },
            { responsivePriority: 3, targets: 2 }
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            var floatVal = function ( i ) {
                return accounting.unformat(i, ",");
            };
 
            var toplamBedel = api.column( 3 ).data().reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                }, 0 );      

            var sayfaToplamBedel = api.column( 3, { page: \'current\'} ).data().reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                }, 0 );

            var toplam = accounting.formatMoney(toplamBedel, "₺", 2, ".", ",");
            var sayfaToplam = accounting.formatMoney(sayfaToplamBedel, "₺", 2, ".", ",");

            $( api.column( 0 ).footer() ).html(\'Genel Toplam: \'+toplam);
            $( api.column( 3 ).footer() ).html(\'Sayfa Toplam: \'+sayfaToplam);
        }
    });
} );
</script>
';
include_once("alt.php"); ?>
