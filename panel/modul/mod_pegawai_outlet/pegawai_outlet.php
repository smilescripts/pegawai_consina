<?php
    include_once "../../include/koneksi.php";
    session_start();
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman master pegawai outlet";
	catat($user,$aksi);
?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
	
	$.ajax({
		url:"crud/pegawai_outlet/pegawai_outlet.data.php",
		cache: false,
		beforeSend: function(){
			$('#loadingDiv').show();
		},
		complete: function(){
			$('#loadingDiv').hide(0);
		}
	
    });
</script>
<div id="loadingDiv" style="display:none" >
	<img src='img/loading.gif' style="position:absolute;margin-left:35%;margin-top:10%" width="300" />
</div> 
<ol class="breadcrumb">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user"> pegawai</li>
</ol>


<div class="panel panel-warning">
  <h1 class="headingtable" style="margin-top:0px" ><span>Data</span> Pegawai (Counter)</h1>
			<div class="btnbantuan" style="margin-top: -55px;">
							<a href="#dialog-pegawai_outlet" id="0" class="btn tambah-pegawai_outlet btn-danger" data-toggle="modal" ><i class="glyphicon glyphicon-plus-sign"></i>Tambah Data</a>
							</div>
    <div class="panel-body">
		
	
        <div class="well">
            <div id="data-pegawai_outlet"></div>
			
		</div>
    </div>
</div>

<div class="modal fade" id="dialog-pegawai_outlet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="myModalLabel">Tambah Data pegawai Bulanan</h3>
      </div>
      <div id="isiForm" class="isiForm"></div>
    </div>
  </div>
</div>
<script>var logo='<?php echo $profil->logo; ?>';</script>
<script src="crud/pegawai_outlet/aplikasi.js"></script>

           