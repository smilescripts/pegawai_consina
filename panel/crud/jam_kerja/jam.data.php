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
				<th>Kode Jam Kerja</th>
                <th>Keterangan</th>
				<th>Jam Datang</th>
                <th>Jam Pulang</th>
                <!--<th>Kode Status Masuk Mesin</th>
				<th>Kode Status Keluar Mesin</th>-->
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $queryjam=mysql_query("SELECT * FROM jam_kerja") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($queryjam)){
                echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->KODE_JAM_KERJA.'</td>
                <td>'.$objectdata->KETERANGAN.'</td>
				<td>'.$objectdata->JAM_DATANG.'</td>
                <td>'.$objectdata->JAM_PULANG.'</td>';
                /* <td>'.$objectdata->KODE_MASUK.'</td>
                <td>'.$objectdata->KODE_KELUAR.'</td> */
				echo '
				<td>
                    <a href="#dialog-jam" id="'.$objectdata->KODE_JAM_KERJA.'" alt="Ubah" title="Ubah" class="glyphicon ubah-jam glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                   
				</td>
            </tr>';
                $no++;
            }
			/*  <a href="#" id="'.$objectdata->KODE_JAM_KERJA.'" alt="Hapus" title="Hapus" class="glyphicon hapus-jam glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>