<table id="example" class="table table-bordered" border="1">
	<tr>
		<th width="10%" style="background-color:grey">No</th>
		<th width="30%" style="background-color:grey">No Rekening</th>
		<th style="background-color:grey " width="30%">Nominal</th>
		<th style="background-color:grey" width="30%">Pemilik Rekening</th>
	</tr>
	<?php
		$BULAN=$_GET["BULAN"];
		$TAHUN=$_GET["TAHUN"];
		$pdfcetak=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.format='Outlet' and head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and pegawai.NO_REKENING!=''") or die (mysql_error());
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
$total = $objectdata->thp + $total;
        }
		
		echo '<tr>
				<td></td>
				<td>Total</td>
				<td>'.number_format($total).'</td>
				<td></td>
			</tr>';
	?>
	
</table>

<p>
<br><br>
</p>


<table>
<tr>
	<td colspan="3">Jakarta, <?php echo date('d'); echo" "; echo date('F'); echo" ";  echo date('Y'); ?></td>
</tr>
<tr>
	<td><center>Mengetahui,</center></td>
	<td></td>
	<td><center>Menyetujui,</center></td>
	
</tr>
<tr>
	<td colspan="3" height="90px"></td>
</tr>
<tr>
	<td><u><center>Doddy Purnomo</u></center></td>
	<td></td>
	<td><u><center>Disyon Toba</u></center></td>
</tr>
<tr>
	<td><center><i>HRD</i></center></td>
	<td></td>
	<td><center><i>Director</i></center></td>
</tr>
</table>