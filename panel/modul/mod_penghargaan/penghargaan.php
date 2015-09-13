<?php
    include_once "../../include/koneksi.php";
    session_start();
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
</script>

<ol class="breadcrumb">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user">Hari penghargaan</li>
</ol>

<div class="page-header" style="margin-top:5px;">
    <h3>Kelola Data Penghargaan Pegawai</h3>
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Data hari penghargaan</h3>
    </div>
    <div class="panel-body">
		<div style="padding: 10px 10px 10px;">
            <a href="#dialog-penghargaan" id="0" class="btn tambah-penghargaan btn-info" data-toggle="modal" >Tambah Data</a> 
		</div>
		<div class="well">
            <div id="data-penghargaan"></div>
		</div>
    </div>
</div>

<div class="modal fade" id="dialog-penghargaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="myModalLabel">Tambah Data penghargaan</h3>
      </div>
      <div id="isiForm" class="isiForm"></div>
    </div>
  </div>
</div>
<script>var logo='<?php echo $profil->logo; ?>';</script>
<script src="crud/penghargaan/aplikasi.js"></script>

           