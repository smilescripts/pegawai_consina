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
				<th>Petugas</th>
				<th>Akses terakhir</th>
				<th>Ip</th>
				<th>Hostname</th>
				<th>Rekaman Aktivitas</th>
				<th>Detail riwayat</th>
		
			</tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM user_log_activity group by kode_petugas order by DATE(waktu) DESC") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$objectdata->kode_petugas'"));
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>('.$objectdata->kode_petugas.')-'.$pegawai->NAMA_PETUGAS.'</td>
				
				<td>'.$objectdata->waktu.'</td>
				<td>'.$objectdata->ip_address.'</td>
				<td>'.$objectdata->hostname.'</td>
				';
				$count=mysql_fetch_object(mysql_query("SELECT count(id) as rekaman from  user_log_activity where KODE_PETUGAS='$objectdata->kode_petugas'"));
				echo'
				<td>'.$count->rekaman.' Aktivitas</td>
				<td>
                    <a href="#dialog-monitoring_user" id="'.$objectdata->kode_petugas.'" alt="riwayat" title="riwayat" class="glyphicon ubah-monitoring_user glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                   
				</td>
		
            </tr>';
				$no++;
            }
			
	?>
		</tbody>
    </table>
</div>

