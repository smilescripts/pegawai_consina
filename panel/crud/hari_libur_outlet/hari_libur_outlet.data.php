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
				<th>TAHUN</th>
				<th>BULAN</th>
				<th>TANGGAL</th>
				<th>Aksi</th>

            </tr>
		</thead>
		<tbody>
		<?php
			$querypetugas=mysql_query("SELECT * FROM hari_libur_outlet") or die (mysql_error());
			$no = 0;
        
			while($objectdata=mysql_fetch_object($querypetugas)){
				$no++;
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->TAHUN.'</td>
				<td>'.$objectdata->BULAN.'</td>
				<td>'.$objectdata->TANGGAL.'</td>
				<td>
                    <a href="#dialog-hari_libur_outlet" id="'.$objectdata->ID.'" alt="Ubah" title="Ubah" class="glyphicon ubah-hari_libur_outlet glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
				';
			}
		?>
		</tbody>
    </table>
</div>

