<?php require_once 'ust.php'; ?>
<?php
if (isset($_GET["sonuc"])) {$sonuc = $_GET["sonuc"];}else{$sonuc = 3;}
if (isset($_POST["firm"])) {
	$sifre = $_POST["pw"];
	$msifre = $_POST["mpw"];
	$pw = pass($_POST["pw"]);
	$mpw = pass($_POST["mpw"]);
	$durum = '1';
	$yuvhas = 2;
	$bas = date('Y-m-d 00:00:00', time());
	$bit = date('Y-m-d 00:00:00', strtotime('+1 week'));

	$isim = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	$firm = trim(filter_input(INPUT_POST, 'firm', FILTER_SANITIZE_STRING));
	$tel = trim(filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING));
	$mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_STRING));
	$ip = getIPNew();
	$yokla = $conn->query("SELECT id FROM uyeler WHERE tel='{$tel}' OR ip='{$ip}' OR mail='{$mail}'")->fetch(PDO::FETCH_COLUMN);
	if ($yokla) {
		$sonuc = 5;
	} else {
		try {
			$sorgu = $conn->prepare("INSERT INTO uyeler (tel, pw, mpw, atarih, dtarih, isim, firma, durum, yuvhas,ip, mail) VALUES (:tel,:pw,:mpw,:atarih,:dtarih,:isim,:firma,:durum,:yuvhas,:ip,:mail)");
			$sorgu->bindParam(':tel', $tel);
			$sorgu->bindParam(':pw', $pw);
			$sorgu->bindParam(':mpw', $mpw);
			$sorgu->bindParam(':atarih', $bas);
			$sorgu->bindParam(':dtarih', $bit);
			$sorgu->bindParam(':isim', $isim);
			$sorgu->bindParam(':firma', $firm);
			$sorgu->bindParam(':durum', $durum);
			$sorgu->bindParam(':yuvhas', $yuvhas);
			$sorgu->bindParam(':ip', $ip);
			$sorgu->bindParam(':mail', $mail);
			$sorgu->execute();
			$sonuc = 1;
		} catch (PDOException $e) {
			$sonuc = 0;
		}
	}
}
?>
<section id="login" style="min-height:100vh">
    <div class="overlay" style="min-height:100vh">
        <div class="container">
            <div class="row justify-content-center">
                <?php
					if (isset($sonuc)) {
						if ($sonuc == 1) {
							echo '<div class="alert alert-success"><strong>Üyelik oluşturuldu!</strong> <a href="/psct.php">Giriş yap</a>arak ücretsiz OSTP üyeliğinizi kullanmaya başlayabilirsiniz.</div>';
						} elseif ($sonuc == 0) {
							echo '<div class="alert alert-danger"><strong>Hata!</strong> Form gönderilirken bir hata oluştu. Lütfen iletişim bölümünden bu durumu bize bildirin.</div>';
						} elseif ($sonuc == 5) {
							echo '<div class="alert alert-danger"><strong>Dikkat!</strong> Zaten daha önce bir üyelik oluşturmuşsunuz. Lütfen <a href="/psct.php">giriş yap</a>ınız.</div>';
						}
					}
				?>
		        <div class="col-md-12 col-lg-6">
		            <h2 class="text-uppercase">ÜYELİK OLUŞTUR</h2>
		            <div class="contact-form justify-content-center">
		                <form id="registerForm" method="post">
		                    <div class="col">
		                        <input type="text" class="form-control" placeholder="Firma Adı" name="firm" autocomplete="on" required>
		                    </div>
		                    <div class="col">
		                        <input pattern="^[A-Za-z\ç\Ç\ö\Ö\ş\Ş\ı\İ\ğ\Ğ\ü\Ü]{3,}( [A-Za-z\ç\Ç\ö\Ö\ş\Ş\ı\İ\ğ\Ğ\ü\Ü]{3,})+$" type="text" class="form-control" placeholder="İsim Soyisim" name="name" autocomplete="on" required>
		                    </div>
		                    <div class="col">
		                        <input type="text" class="form-control" placeholder="Telefon" name="tel" autocomplete="on" required>
		                    </div>
		                    <div class="col">
		                        <input type="text" class="form-control" placeholder="E-Posta" name="mail" autocomplete="on" required>
		                    </div>
		                    <div class="col">
		                        <input pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" type="password" class="form-control" placeholder="Şifre" name="pw" size="10" title="En az; 8 karakter, 1 büyük harf, 1 küçük harf, 1 rakam" required>
		                    </div>
		                    <div class="col">
		                        <input pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" type="password" class="form-control" placeholder="Yönetici Şifresi" name="mpw" size="10" title="En az; 8 karakter, 1 büyük harf, 1 küçük harf, 1 rakam" required>
		                    </div>
		                    <div class="col">
		                        <input type="submit" id="submitRegister" class="form-control text-uppercase" value="OLUŞTUR">
		                    </div>
		                </form>
		            </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	$(document).ready(function () {
        $("#registerForm").submit(function (e) {
            //stop submitting the form to see the disabled button effect
            e.preventDefault();
            //disable the submit button
            $("#submitRegister").attr("disabled", true);
            return true;
        });
    });
</script>
<?php require_once 'alt.php'; ?>