<?php
    session_start();
    if(!isset($_GET)){
        if(isset($_SESSION['patron'])){
            echo "<script>window.location.href = 'konsol';</script>";
        } 
    }
?>
<?php require_once 'ust.php'; ?>
<section id="login" style="min-height:100vh">
    <div class="overlay" style="min-height:100vh">
        <div class="container">
            <?php if (!isset($_POST['skipdonate'])) { ?>
            <div class="card">
                <div class="card-header text-center text-muted">📢&emsp;OSTP Desteğini Bekliyor!</div>
                <div class="card-body text-muted">
                    <div class="row">
                        <div class="col-lg-6">
                            Oyun Salonu Takip Programı ücretsiz bir yazılım ve bu durumun her zaman böyle devam etmesini istiyoruz. Ancak her geçen gün artan maliyetler bunu imkansız hale getiriyor. <br> <br> Abone olarak veya sadece kahve ısmarlayarak maliyetlerin bir kısmını üstlenebilir, OSTP'nin ayakta kalmasına ve gelişmesine katkıda bulunabilirsiniz. <br> <br> Desteğiniz ve anlayışınız için teşekkürler.
                        </div>
                        <div class="col-lg-6 pt-4 text-center">
                            <br><br>
                            <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="ostp" data-color="#ffc107" data-emoji=""  data-font="Poppins" data-text="Destek Ol" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <form action="" method="POST" role="form">
                                <button type="submit" name="skipdonate" class="btn btn-sm btn-link">Destek olmadan devam et >></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="row justify-content-center">
                <?php
                    if(isset($_GET["giris"])){
                        if($_GET["giris"]=="basarisiz"){
                            echo'<div class="alert alert-danger"><strong>Hatalı Giriş!</strong> Girdiğiniz bilgiler yanlış veya böyle bir üyelik bulunmamaktadır.</div>';
                        }elseif($_GET["giris"]=="son"){
                            echo'<div class="alert alert-danger"><strong>Üyelik Süresi Bitmiş!</strong> Üyeliğinizi devam ettirmek için lütfen <a href="//shopier.com/987008" class="alert-link">tıklayın</a>.</div>';
                        }elseif($_GET["giris"]=="pasif"){
                            echo'<div class="alert alert-danger"><strong>Üyelik Pasif!</strong> Üyeliğiniz sistem tarafından pasifleştirilmiştir. Lütfen varsa gecikmiş ödemelerinizi yapınız, deneme üyeliği hakkınız dolduysa <a href="//shopier.com/987008" class="alert-link" target="_blank">üyelik satın alınız</a>. Bir yanlışlık olduğunu düşünüyorsanız lütfen bizimle iletişime geçiniz.</div>';
                        }
                    }
                ?>
                <div class="col-md-12 col-lg-6">
                    <h2 class="text-uppercase">GİRİŞ YAP</h2>
                    <div class="iletisim-form justify-content-center">
                        <form method="post" action="konsol/index.php">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Telefon" name="tel" autocomplete="on" required>
                            </div>
                            <div class="col">
                                <input pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$" type="password" class="form-control" placeholder="********" name="pw" size="10" title="En az; 8 karakter, 1 büyük harf, 1 küçük harf, 1 rakam" required>
                            </div>
                            <div class="col">
                                <input type="submit" class="form-control text-uppercase" value="GİRİŞ YAP">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php require_once 'alt.php'; ?>