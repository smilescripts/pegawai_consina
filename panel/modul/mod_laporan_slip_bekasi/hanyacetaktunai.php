<?php
	$BULAN=$_GET["BULAN"];
	$TAHUN=$_GET["TAHUN"];
?>

<table id="example" class="table table-bordered" border="1">
	<tr>
		<th width="10%" style="background-color:grey">No</th>
		<th style="background-color:grey">Departemen</th>
		<th style="background-color:grey">Nama</th>
		<th style="background-color:grey">Jumlah Gaji</th>
	</tr>
	<?php
		$pdfcetak=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.format='Harian Bekasi' and head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL) 
		and pegawai.STATE_ID='$_SESSION[STATE_ID]' AND pegawai.STATUS_PEGAWAI='Kontrak'") or die (mysql_error());
        $no = 0;
        
		while($objectdata=mysql_fetch_object($pdfcetak)){
			$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'"));
			
			$departemen=mysql_fetch_object(mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'"));
			$no++;
			echo'
				<tr>
				<td>'.$no.'</td>
				<td>'.$departemen->NAMA_DEPARTEMEN.'</td>
				<td>'.$pegawai->NAMA_PEGAWAI.'</td>
				<td>'.number_format($objectdata->thp).'</td>
		
				</tr>
			';
        }
    ?>
</table>