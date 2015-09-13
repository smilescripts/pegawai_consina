<?php
	error_reporting(0);
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
				<th>NIP</th>
				<th>TAHUN</th>
				<th>BULAN</th>
				<th>TANGGAL</th>
				<th>NOMINAL</th>
				<th>KETERANGAN</th>
				<th>Aksi</th>

            </tr>
		</thead>
		<tbody>
		<?php
            $query=mysql_query("SELECT * FROM penghargaan") or die (mysql_error());
            $no = 0;
            
			while($objectdata=mysql_fetch_object($query)){
				$no++;
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NIP_PEGAWAI.'</td>
				<td>'.$objectdata->TAHUN.'</td>
				<td>'.$objectdata->BULAN.'</td>
				<td>'.$objectdata->TANGGAL.'</td>
				<td>'.$objectdata->NOMINAL.'</td>
				<td>'.$objectdata->KETERANGAN.'</td>
				<td>
                    <a href="#dialog-penghargaan" id="'.$objectdata->KODE_PENGHARGAAN.'" alt="Ubah" title="Ubah" class="glyphicon ubah-penghargaan glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
		
				';
			}
		?>
		</tbody>
    </table>
</div>

