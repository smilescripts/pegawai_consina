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
				<th>Nama Divisi</th>
				<th>Nama Departemen</th>
				<th style="width:10px">Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM divisi") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				$tdepartemen=mysql_fetch_object(mysql_query("select * from departemen where KODE_DEPARTEMEN='$objectdata->KODE_DEPARTEMEN'"));
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->NAMA.'</td>
				<td>'.$tdepartemen->NAMA_DEPARTEMEN.'</td>
				<td>
                    <a href="#dialog-divisi" id="'.$objectdata->ID.'" alt="Ubah" title="Ubah" class="glyphicon ubah-divisi glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                </td>
            </tr>';
				$no++;
            }
				/*  <a href="#" id="'.$objectdata->KODE_DEPARTEMEN.'" alt="Hapus" title="Hapus" class="glyphicon hapus-departemen glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>