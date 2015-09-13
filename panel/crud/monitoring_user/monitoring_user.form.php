<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
    $id = $_POST['id'];
	
    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM user_log_activity WHERE kode_petugas=".$id
    ));
		
    if($id> 0) { 
		$kode_petugas = $data['kode_petugas'];
		$petugas=mysql_fetch_object(mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$kode_petugas'"));
	
    } else {
		$kode_petugas = "";
	
	
    }
?>
<script>
    $(document).ready(function() {
        $('#example1').DataTable( {
            "sDom": 'C<"top"flt>rt<"bottom"ip><"clear">',
        });
    });
</script>

<h4 style="padding:10px">pengguna:(<?php echo $petugas->KODE_PETUGAS;?>) - <?php echo $petugas->NAMA_PETUGAS;?></h4>
<hr/>
<div class="table-responsive" style="padding:10px">
    <table id="example1" class="table table-bordered">
		<thead>
            <tr>
				<th>No</th>
				<th>Aktivitas</th>
				<th>Waktu</th>
				<th>Ip</th>
				<th>Hostname</th>
	
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM user_log_activity where kode_petugas='$kode_petugas' order by DATE(waktu) DESC")or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$objectdata->kode_petugas'"));
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->aktivitas.'</td>
				<td>'.$objectdata->waktu.'</td>
				<td>'.$objectdata->ip_address.'</td>
				<td>'.$objectdata->hostname.'</td>
		
		
            </tr>';
				$no++;
            }
			
		?>
		</tbody>
    </table>
</div>

