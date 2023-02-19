<?php include_once("ust.php");
if(isset($_SESSION['bigboss'])){echo "<script>window.location.href = 'ayar.php';</script>";}
echo "<div class=\"welcomeBox\"><b>Yönetici Girişi</b></div>";?>

<form name="ylogin" method="post">
    <div class="container">
        <input pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" type="password" placeholder="Yönetici Şifresi" name="mpw" size="10" title="En az; 8 karakter, 1 büyük harf, 1 küçük harf, 1 rakam" required>
        <button type="submit" formaction="ayar.php">GİRİŞ YAP</button>
    </div>
</form>
<?php include_once("alt.php");?>
