<table id="example" class="table table-bordered" border="1">
	<tr>
		<th width="10%" style="background-color:grey">No</th>
		<th style="background-color:grey">Departemen</th>
		<th width="30%" style="background-color:grey">No Rekening</th>
		<th style="background-color:grey">Nama</th>
		<th style="background-color:grey">Jumlah Transfer</th>
	</tr>
	<?php
		$BULAN=$_GET["BULAN"];
		$TAHUN=$_GET["TAHUN"];
		$pdfcetak=mysql_query("SELECT * FROM head_penggajian where format='Bulanan' and MONTH(tanggal_gaji)='$BULAN' and YEAR(tanggal_gaji)='$TAHUN'") or die (mysql_error());
        $no = 0;
        
		while($objectdata=mysql_fetch_object($pdfcetak)){
			$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'"));
			$departemen=mysql_fetch_object(mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'"));
			$no++;
			echo'
				<tr>
				<td>'.$no.'</td>
				<td>'.$departemen->NAMA_DEPARTEMEN.'</td>
				<td>'.$pegawai->NO_REKENING.'</td>
				<td>'.$pegawai->NAMA_PEGAWAI.'</td>
				<td>'.number_format($objectdata->thp).'</td>
		
				</tr>';
        }
           
	?>
</table>