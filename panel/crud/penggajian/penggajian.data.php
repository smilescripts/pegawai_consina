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
				<th>Bulan</th>
				<th>Tahun</th>
				<th>Departemen</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$query=mysql_query("SELECT * FROM head_penggajian  group by departemen ") or die (mysql_error());
			$no = 1;
			
			while($objectdata=mysql_fetch_object($query)){
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.substr($objectdata->tanggal_gaji,8,2).'</td>
				<td>'.substr($objectdata->tanggal_gaji,5,2).'</td>
				<td>'.substr($objectdata->tanggal_gaji,0,4).'</td>
				';
				
				$penggajiannama=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'") or die (mysql_error());
				$getnamapenggajian=mysql_fetch_object($penggajiannama);
		
				echo'
				<td>'.$getnamapenggajian->NAMA_DEPARTEMEN.'</td>
				<td>
                    <a href="#dialog-penggajian" id="'.$objectdata->departemen.'" alt="Ubah" title="Detail" class="glyphicon ubah-penggajian glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

