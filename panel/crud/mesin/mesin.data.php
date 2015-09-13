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
				<th>Kode Mesin</th>
				<th>Nama Mesin</th>
				<th>IP Address</th>
				<th>Port Komunikasi</th>
				<th>MAC adrress PC</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM mesin_absensi") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->KODE_MESIN.'</td>
				<td>'.$objectdata->NAMA_MESIN.'</td>
				<td>'.$objectdata->IP_ADDRESS.'</td>
				<td>'.$objectdata->PORT_COM.'</td>
				<td>'.$objectdata->MAC_ADDRESS.'</td>
				<td>
                    <a href="#dialog-mesin" id="'.$objectdata->KODE_MESIN.'" alt="Ubah" title="Ubah" class="glyphicon ubah-mesin glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

