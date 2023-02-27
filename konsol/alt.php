</div>
</div>
<script>
    var flex = document.getElementById('anaSayfa');
    const observer = new MutationObserver(function (mutations, observer) {
        flex.style.height = "";
    });
    observer.observe(flex, {
        attributes: true,
        attributeFilter: ['style']
    });
    /* TARİH VE SAAT GÖSTERME */
    var currenttime = '<? print date("F d, Y H:i:s", time())?>'
    var montharray = new Array("Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık")
    var serverdate = new Date(currenttime)
    function padlength(what) {
        var output = (what.toString().length == 1) ? "0" + what : what
        return output
    }
    function displaytime() {
        serverdate.setSeconds(serverdate.getSeconds() + 1)
        var datestring = serverdate.getDate() + " " + montharray[serverdate.getMonth()] + " " + serverdate.getFullYear()
        var timestring = padlength(serverdate.getHours()) + ":" + padlength(serverdate.getMinutes())
        document.getElementById("tarihim").innerHTML = datestring
        document.getElementById("saatim").innerHTML = timestring
    }
    /* TARİH VE SAAT GÖSTERME BİTİŞ*/
    $(document).ready(function() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $('select').select2({language: "tr"});
        setInterval("displaytime()", 1000);
        $("#bsaat").click(function() {
            $("#masaSaatD").toggle();
            $("#icerik").scrollTop(0);
        });
        $("#mSDKapat").click(function() {
            $("#masaSaatD").toggle();
        });
        $("#mAktar").click(function() {
            $("#masaAB").toggle();
            $("#icerik").scrollTop(0);
        });
        $("#mABKapat").click(function() {
            $("#masaAB").toggle();
        });
        $("#tarifeDB").click(function() {
            $("#tarifeD").toggle();
            $("#icerik").scrollTop(0);
        });
        $("#tDKapat").click(function() {
            $("#tarifeD").toggle();
        });
        const Toast = Swal.mixin({
          toast:true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          },
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        });
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js?v=<?php echo time(); ?>" integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>$('input[name*="mail"]').inputmask("email",{"clearIncomplete":true});</script>
<script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="ostp" data-description="OSTP'yi desteklemek için kahve ısmarlayın!" data-message="OSTP'ye Destek Olun!" data-color="#FF5F5F" data-position="Right" data-x_margin="18" data-y_margin="18"></script>
</body>
</html>