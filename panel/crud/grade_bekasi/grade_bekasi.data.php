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
				<th>Nama Grade</th>
				<th>Nominal</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM grade_bekasi") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NAMA_GRADE.'</td>
				<td>Rp.'.number_format($objectdata->NOMINAL_GRADE).'</td>
				<td>
                    <a href="#dialog-grade_bekasi" id="'.$objectdata->KODE_GRADE.'" alt="Ubah" title="Ubah" class="glyphicon ubah-grade_bekasi glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                </td>
            </tr>';
				$no++;
            }
				/*  <a href="#" id="'.$objectdata->KODE_DEPARTEMEN.'" alt="Hapus" title="Hapus" class="glyphicon hapus-departemen glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>