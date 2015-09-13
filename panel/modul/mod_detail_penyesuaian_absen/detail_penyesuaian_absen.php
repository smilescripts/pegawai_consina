<?php
    include_once "../../include/koneksi.php";
    session_start();
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman master Detail penyesuaian absensi";
	catat($user,$aksi);
	$HEAD_ID=$_POST["id"];
	//echo 'dsadsad';
	$query2=mysql_query("SELECT * FROM penyesuaian_absensi where ID='$HEAD_ID'") or die (mysql_error());
	$objectdata2=mysql_fetch_object($query2);
	$query3=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata2->KODE_PEGAWAI'") or die (mysql_error());
	$objectdata3=mysql_fetch_object($query3);
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
  <li class="active"><span class="glyphicon glyphicon-user"> penyesuaian absen</li>
</ol>

<div class="page-header" style="margin-top:5px;">
    <h3>Kelola data penyesuaian absen</h3>
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Data Detail penyesuaian absen (<?php echo $objectdata3->NIP_PEGAWAI.' - '.$objectdata3->NAMA_PEGAWAI.' Bulan : '.$objectdata2->BULAN.' Tahun : '.$objectdata2->TAHUN; ?>)</h3>
    </div>
    <div class="panel-body">
	<?php
		$pengaturan = mysql_fetch_array(mysql_query("SELECT VALUE FROM pengaturan_penggajian WHERE ID='9'"));
		$data = mysql_fetch_array(mysql_query("SELECT kode_penggajian,DATE_ADD(tanggal_gaji,INTERVAL ".$pengaturan['VALUE']." DAY) AS cktgl FROM head_penggajian WHERE bulan='$objectdata2->BULAN' AND tahun='$objectdata2->TAHUN'"));
		$datenow=date("Y-m-d");
		if($data["cktgl"]==""){
	?>
		<div style="padding: 10px 10px 10px;">
            <a href="#dialog-detail_penyesuaian_absen" id="0_<?php echo $HEAD_ID;?>_<?php echo $objectdata2->KODE_PEGAWAI;?>" class="btn tambah-detail_penyesuaian_absen btn-info" data-toggle="modal" >Tambah Data</a> 
            <a href="#dialog-detail_penyesuaian_absen" id="0_<?php echo $HEAD_ID;?>_<?php echo $objectdata2->KODE_PEGAWAI;?>" class="btn tambahcepat-detail_penyesuaian_absen btn-info" data-toggle="modal" >Tambah Data Cepat</a> 
		</div>
	<?php
	}else{
		if($data["cktgl"]>=$datenow){
	?>
		<div style="padding: 10px 10px 10px;">
            <a href="#dialog-detail_penyesuaian_absen" id="0_<?php echo $HEAD_ID;?>_<?php echo $objectdata2->KODE_PEGAWAI;?>" class="btn tambah-detail_penyesuaian_absen btn-info" data-toggle="modal" >Tambah Data</a> 
            <a href="#dialog-detail_penyesuaian_absen" id="0_<?php echo $HEAD_ID;?>_<?php echo $objectdata2->KODE_PEGAWAI;?>" class="btn tambahcepat-detail_penyesuaian_absen btn-info" data-toggle="modal" >Tambah Data Cepat</a> 
		</div>
	<?php
		}
	}
	?>
		<div class="well">
            <div id="data-detail_penyesuaian_absen"></div>
		</div>
    </div>
</div>

<div class="modal fade" id="dialog-detail_penyesuaian_absen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="myModalLabel">Tambah Data Detail penyesuaian absen</h3>
      </div>
      <div id="isiForm2" class="isiForm2"></div>
    </div>
  </div>
</div>

<script>
	var logo='<?php echo $profil->logo; ?>';
	var tamp2='<?php echo $HEAD_ID; ?>';
</script>
<script src="crud/detail_penyesuaian_absen/aplikasi.js"></script>

           