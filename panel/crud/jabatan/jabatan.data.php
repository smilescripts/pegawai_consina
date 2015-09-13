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
				<th>Nama Jabatan</th>
				<th>Tunjangan Jabatan</th>
				<!--<th>Nominal Tabungan</th>-->
				<!--<th>Nominal UMT</th>-->
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM jabatan") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NAMA_JABATAN.'</td>
				<td>Rp.'.number_format($objectdata->TUNJANGAN_JABATAN).',-</td>
			
				<td>
                    <a href="#dialog-jabatan" id="'.$objectdata->KODE_JABATAN.'" alt="Ubah" title="Ubah" class="glyphicon ubah-jabatan glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                   
				</td>
            </tr>';
                $no++;
            }
			/*  <a href="#" id="'.$objectdata->KODE_JABATAN.'" alt="Hapus" title="Hapus" class="glyphicon hapus-jabatan glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>