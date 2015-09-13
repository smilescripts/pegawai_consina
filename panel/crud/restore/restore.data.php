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
				<th>Tanggal</th>
				<th>Status</th>
		
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM restore_data") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->tanggal.'</td>
				<td>Pemulihan basis data berhasil</td>
		
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

