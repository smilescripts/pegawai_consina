<?php
    include_once "../../include/koneksi.php";
    session_start();
?>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": 'C<"top"flt>rt<"bottom"ip><"clear">',
        });
    });
</script>
<p>Versi saat ini: 1.00</p>

<center>
<a href="" class="btn btn-info">Cek Pembaruan Sistem</a>
</center>