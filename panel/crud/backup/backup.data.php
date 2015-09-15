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
				<th>Download</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querybackup=mysql_query("SELECT * FROM `backup_data` order by date(`tanggal`) desc") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querybackup)){
                echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->tanggal.'</td>
				<td>Pencadangan basis data Berhasil</td>
				<td>
                    <a href="modul/mod_backup/data_backup/'.$objectdata->file.'" id="'.$objectdata->file.'" alt="Download" title="Download" class="glyphicon ubah-pegawai glyphicon-download" data-toggle="modal">Download</a>&nbsp; 
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>