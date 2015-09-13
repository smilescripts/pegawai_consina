<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
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
				<th>Nip</th>
				<th>Nama</th>
				<th>Tanggal</th>
				<th>Nominal</th>
				<th>Jumlah</th>
				<th>Cicilan/Bulan</th>
				<th>Sisa</th>
				<th>Keterangan</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
			if($_SESSION['AKSES']==43){
				$querykasbon=mysql_query("SELECT * FROM pinjaman WHERE KODE_PEGAWAI IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak') order by TANGGAL DESC") or die (mysql_error());
			}else if($_SESSION['AKSES']==44){
				$querykasbon=mysql_query("SELECT * FROM pinjaman WHERE KODE_PEGAWAI IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATUS_PEGAWAI='Tetap') order by TANGGAL DESC") or die (mysql_error());
			}else{
				$querykasbon=mysql_query("SELECT * FROM pinjaman order by TANGGAL DESC") or die (mysql_error());
			}
            $no = 1;
           
			while($objectdata=mysql_fetch_object($querykasbon)){
                $querypegawai=mysql_query("SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$objectdata->KODE_PEGAWAI) or die (mysql_error());
				$tampilpegawai=mysql_fetch_object($querypegawai);
                echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.$tampilpegawai->NIP_PEGAWAI.'</td>
                <td>'.$tampilpegawai->NAMA_PEGAWAI.'</td>
                <td>'.$objectdata->TANGGAL.'</td>
                <td>'.number_format($objectdata->NOMINAL).',-</td>
                <td>'.$objectdata->JUMLAH_BLN.' Bulan</td>
               
                <td>Rp.'.number_format($objectdata->CICILAN_PERBULAN).',-</td>
                <td>X '.$objectdata->SISA_CICILAN.'</td>
				 <td>'.$objectdata->KETERANGAN.'</td>
				 ';
				
				$validasiubah=mysql_query("SELECT * FROM pembayaran_angsuran WHERE ID_PINJAMAN=".$objectdata->KODE_PINJAMAN) or die (mysql_error());
				$execvalidasiubah=mysql_fetch_object($validasiubah);
				
				echo'
				<td style="width:10%">
				';
				
				if($execvalidasiubah->ID_PEMBAYARAN==""){
					if($objectdata->SISA_CICILAN!=0){
						echo'
                    <a href="#dialog-pinjaman2" id="'.$objectdata->KODE_PINJAMAN.'" alt="Ubah" title="Ubah" class="glyphicon ubah-pinjaman2 glyphicon-edit" data-toggle="modal"></a>
						';
					}
				}
				
				if($objectdata->SISA_CICILAN!=0){
					echo'
					<a href="#dialog-pinjaman2" id="'.$objectdata->KODE_PINJAMAN.'" alt="Bayar pinjaman" title="Bayar pinjaman" class="glyphicon bayar-pinjaman2 glyphicon-upload" data-toggle="modal"></a>
					';
				}
				
				echo '
					<a href="#dialog-pinjaman2" id="'.$objectdata->KODE_PINJAMAN.'" alt="Riwayat pinjaman" title="Riwayat pinjaman" class="glyphicon history-pinjaman2 glyphicon-zoom-in"  data-toggle="modal"></a>
				';
				
				if($objectdata->SISA_CICILAN!=0){
					echo'
					<a href="#dialog-pinjaman2" id="'.$objectdata->KODE_PINJAMAN.'" alt="Pelunasan pinjaman" title="Pelunasan pinjaman" class="glyphicon pelunasan-pinjaman2 glyphicon-ok"  data-toggle="modal"></a>
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