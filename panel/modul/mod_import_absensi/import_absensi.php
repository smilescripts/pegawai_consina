<?php
    include_once "../../include/koneksi.php";
    session_start();
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman master pemulihan basis data";
	catat($user,$aksi);
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
  <li class="active"><span class="glyphicon glyphicon-user"></li>
</ol>



<div class="panel panel-warning">
  <h1 class="headingtable" style="margin-top:0px" ><span>Import</span> Data Absensi</h1>
    <div class="btnbantuan" style="margin-top:-55px;">
						
							</div>
    <div class="panel-body">
	
	
		<div class="well">
          <a href="#dialog-import_absensi" id="0" class="btn tambah-import_absensi btn-danger" data-toggle="modal">  <span class="glyphicon glyphicon-save" aria-hidden="true"></span>Import Data Absensi Pegawai</a> 
		  <hr/>
		<ul class="list-group" id="tutor">
  <li class="list-group-item"><b>TAHAPAN MELAKUKAN IMPORT ABSENSI</b></li>
  <li class="list-group-item">1.Silahkan klik tombol import data.</li>
  <li class="list-group-item">2.Pilih file absensi pegawai dalam format excell 2003.</li>
  <li class="list-group-item">3.Masukan periode tanggal awal - akhir absensi.</li>
  <li class="list-group-item">4.klik Simpan untuk melakukan import data absensi.</li>
 
</ul>
		</div>
    </div>
</div>

<div class="modal fade" id="dialog-import_absensi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="myModalLabel">Form Data import absensi</h3>
      </div>
      <div id="isiForm" class="isiForm"></div>
    </div>
  </div>
</div>
<script>var logo='<?php echo $profil->logo; ?>';</script>
<script src="crud/import_absensi/aplikasi.js"></script>

           