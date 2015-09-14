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
				<th style="width:10px">No</th>
				<th>Nama lokasi</th>
				<th style="width:10px">Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM state") or die (mysql_error());
            $no = 1;
            while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->STATE_NAME.'</td>
				<td>
                    <a href="#dialog-state" id="'.$objectdata->STATE_ID.'" alt="Ubah" title="Ubah" class="glyphicon ubah-state glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                   
				</td>
            </tr>';
            $no++;
            }
		?>
		</tbody>
    </table>
</div>

