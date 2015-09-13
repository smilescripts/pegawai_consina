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
				<th>Nama Perusahaan</th>
				<th>Email</th>
				<th>Phone 1</th>
				<th>Phone 2</th>
				<th>Kota</th>
				<th>Negara</th>
				<th>Faximili</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM profil_perusahaan") or die (mysql_error());
            $no = 1;
            while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NAMA_PERUSAHAAN.'</td>
				<td>'.$objectdata->EMAIL.'</td>
				<td>'.$objectdata->PHONE_1.'</td>
				<td>'.$objectdata->PHONE_2.'</td>
				<td>'.$objectdata->KOTA.'</td>
				<td>'.$objectdata->NEGARA.'</td>
				<td>'.$objectdata->FAXIMILI.'</td>
				<td>
					<a href="#dialog-info" id="'.$objectdata->id.'" alt="Ubah" title="Ubah" class="glyphicon ubah-info glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

