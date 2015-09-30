<?php
	$BULAN=$_GET["BULAN"];
	$TAHUN=$_GET["TAHUN"];
?>

<table id="example" class="table table-bordered" border="1">
	<tr>
		<th width="10%" style="background-color:grey">No</th>
		<th style="background-color:grey"  width="45%">Jumlah Transfer</th>
		<th style="background-color:grey" width="45%">Pegawai</th>
	</tr>
	<?php
		$pdfcetak=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.format='Harian' and head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL) 
		and pegawai.STATE_ID='$_SESSION[STATE_ID]' AND pegawai.STATUS_PEGAWAI='Kontrak'") or die (mysql_error());
        $no = 0;
        
		while($objectdata=mysql_fetch_object($pdfcetak)){
			$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'"));
			
			$departemen=mysql_fetch_object(mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'"));
			$no++;
			echo'
				<tr>
				<td>'.$no.'</td>
				<td>'.number_format($objectdata->thp).'</td>
				<td>'.$pegawai->NAMA_PEGAWAI.'</td>
		
				</tr>
			';
$total = $objectdata->thp + $total;
        }
		
		echo '<tr>
				<td>Total</td>
				<td>'.number_format($total).'</td>
				<td></td>
			</tr>';
	?>
	
</table>

<p>
<br><br>
</p>


<table width="100%"> 
<tr> 
	<td colspan="3">Jakarta, <?php echo date('d'); echo" "; echo date('F'); echo" ";  echo date('Y'); ?><p></p></td>
</tr>
<tr>
	<td></td>
	<td><center>Mengetahui,</center></td>
	<td></td>
	
</tr>
<tr>
	<td colspan="3" height="90px"></td>
</tr>
<tr>
	<td><u><center>Doddy Purnomo</u></center></td>
	<td></td>
	<td><u><center>Heru Nopriyanto</u></center></td>
</tr>
<tr>
	<td><center><i>HRD</i></center></td>
	<td></td>
	<td><center><i>HR & GA Supervisor</i></center></td>
</tr>
<tr>
	<td></td>
	<td><center><p></p>Menyetujui,</center></td>
	<td></td>
</tr>
<tr>
	<td colspan="3" height="90px"></td>
</tr>
<tr>
	<td></td>
	<td><u><center>Disyon Toba,</center></u></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td><i><center>Director</center></i></td>
	<td></td>
</tr>

	
</table>