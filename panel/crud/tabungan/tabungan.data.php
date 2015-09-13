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

<div class="table-responsive">
    <table id="example" class="table table-bordered">
		<thead>
            <tr>
				<th>No</th>
				<th>NIP pegawai</th>
				<th>Nama pegawai</th>
				<th>Petugas</th>
				<th>Total tabungan saat S/d ini</th>
				<th>Total pengambilan S/d saat ini</th>
				<th>Sub Total tabungan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($_SESSION['AKSES']==43){
				$querypetugas=mysql_query("SELECT * FROM tabungan WHERE NIP IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak') GROUP BY NIP order by TANGGAL desc") or die (mysql_error());
			}else if($_SESSION['AKSES']==44){
				$querypetugas=mysql_query("SELECT * FROM tabungan WHERE NIP IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATUS_PEGAWAI='Tetap') GROUP BY NIP order by TANGGAL desc") or die (mysql_error());
			}else{
				$querypetugas=mysql_query("SELECT * FROM tabungan") or die (mysql_error());
			}
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->NIP'"));
				$petugas=mysql_fetch_object(mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$objectdata->KODE_PETUGAS'"));
				$pengambilantab=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL_PENGAMBILAN) as totalpengambilanpeg FROM pengambilan_tabungan where NIP_PEGAWAI='$objectdata->NIP'"));
				$tottabungan=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL) as totaltabung FROM tabungan where NIP='$objectdata->NIP'"));
				$totalsub=$tottabungan->totaltabung-$pengambilantab->totalpengambilanpeg;
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$pegawai->NIP_PEGAWAI.'</td>
				<td>'.$pegawai->NAMA_PEGAWAI.'</td>
				<td>'.$petugas->NAMA_PETUGAS.'</td>
				<td>Rp.'.number_format($tottabungan->totaltabung).'</td>
				<td>Rp.'.number_format($pengambilantab->totalpengambilanpeg).'</td>
				<td>Rp.'.number_format($totalsub).'</td>
				<td>
                    <a href="#dialog-tabungan" id="'.$objectdata->NIP.'" alt="Riwayat Pengambilan" title="Riwayat Pengambilan" class="glyphicon riwayat-tabungan glyphicon-eye-open" data-toggle="modal"></a>&nbsp;  
					';
					if($totalsub!=0){
						echo'
						<a href="#dialog-tabungan" id="'.$objectdata->NIP.'" alt="Pengambilan tabungan" title="Pengambilan tabungan"  class="glyphicon pengambilan-tabungan glyphicon-share" data-toggle="modal"></a>&nbsp; 
						';
					}
					echo'
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

