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
				<th>Nama Tunjangan</th>
				<th>Nominal</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querytunjangan=mysql_query("SELECT * FROM master_tunjangan") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querytunjangan)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NAMA_TUNJANGAN.'</td>
				<td>Rp.'.number_format($objectdata->NOMINAL).',-</td>
				<td>
                    <a href="#dialog-tunjangan" id="'.$objectdata->KODE_MASTER_TUNJANGAN.'" alt="Ubah" title="Ubah" class="glyphicon ubah-tunjangan glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                  
				</td>
            </tr>';
                $no++;
            }
		?>
		</tbody>
    </table>
</div>