<?php
	error_reporting(0);
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
                 <th>Tanggal</th>
                <th>Keterangan</th>
				<th>NIP Pegawai</th>
                <th>Nama Pegawai</th>
				<th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Jumlah Jam Kerja</th>
                <th>Jam Lembur</th>
                <th>Jam Keterlambatan</th>
		
            </tr>
		</thead>
		<tbody>
		<?php
            $queryabsensi_data=mysql_query("SELECT * FROM absensi") or die (mysql_error());
            $no = 1;
			
			while($objectdata=mysql_fetch_object($queryabsensi_data)){
				$querypegawai=mysql_query("SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$objectdata->NIP_PEGAWAI) or die (mysql_error());
				$tampilpegawai=mysql_fetch_object($querypegawai);
				$queryjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$objectdata->KODE_JAM_KERJA) or die (mysql_error());
				$tampiljam=mysql_fetch_object($queryjam);
		
				$start=new DateTime($tampiljam->JAM_PULANG);
				$end=new DateTime($objectdata->JAM_KELUAR);
				$lembur = $end->diff($start)->format('%h jam %i menit '); 
         
				$jammasukkantor=new DateTime($tampiljam->JAM_DATANG);
				$jammasukpegawai=new DateTime($objectdata->JAM_MASUK);
				$jamkeluarpegawai=new DateTime($objectdata->JAM_KELUAR);
				$terlambat=$jammasukpegawai->diff($jammasukkantor)->format('%h jam %i menit '); 
				$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h jam %i menit '); 
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->TANGGAL.'</td>
                <td>'.$tampiljam->KETERANGAN.'</td>
				<td>'.$tampilpegawai->NIP_PEGAWAI.'</td>
                <td>'.$tampilpegawai->NAMA_PEGAWAI.'</td>
                <td>'.$objectdata->JAM_MASUK.'</td>
                <td>'.$objectdata->JAM_KELUAR.'</td>
                <td>'.$jmlhjam.'</td>
                <td>'.$lembur.'</td>
                <td>'.$terlambat.'</td>
			</tr>';
                $no++;
            }
		?>
		</tbody>
	</table>
</div>