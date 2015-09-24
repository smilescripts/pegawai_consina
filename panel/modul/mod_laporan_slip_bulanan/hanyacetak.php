<table id="example" class="table table-bordered" border="1">
	<tr>
			<th width="10%" style="background-color:grey">No</th>
		<th width="30%" style="background-color:grey">No Rekening</th>
		<th style="background-color:grey"  width="30%">Nominal</th>
		<th style="background-color:grey" width="30%">Pemilik Rekening</th>
	</tr>
	<?php
		$BULAN=$_GET["BULAN"];
		$TAHUN=$_GET["TAHUN"];
		$pdfcetak=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.format='Bulanan' and head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and pegawai.NO_REKENING!='' ") or die (mysql_error());
        $no = 0;
        
		while($objectdata=mysql_fetch_object($pdfcetak)){
			$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'"));
			$departemen=mysql_fetch_object(mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'"));
			$no++;
			echo'
				<tr>
				<td>'.$no.'</td>
				<td>'.$pegawai->NO_REKENING.'</td>
				
				<td>'.number_format($objectdata->thp).'</td>
				<td>'.$pegawai->NAMA_PEGAWAI.'</td>
		
				</tr>';
        }
           
	?>
</table>