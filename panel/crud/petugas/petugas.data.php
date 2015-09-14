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
				<th>Nama petugas</th>
				<th>Username Login</th>
				
				<th style="width:10px">Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM petugas") or die (mysql_error());
            $no = 1;
            while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NAMA_PETUGAS.'</td>
				<td>'.$objectdata->USERNAME_LOGIN.'</td>
				
				<td>
                    <a href="#dialog-petugas" id="'.$objectdata->KODE_PETUGAS.'" alt="Ubah" title="Ubah" class="glyphicon ubah-petugas glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                    
				</td>
            </tr>';
				$no++;
            }
			/* <a href="#" id="'.$objectdata->KODE_PETUGAS.'" alt="Hapus" title="Hapus" class="glyphicon hapus-petugas glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>

