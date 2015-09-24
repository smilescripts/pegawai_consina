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
				<th>Pegawai</th>
				<th>Status Dana</th>
				<th>Nominal</th>
				<th>Bulan - Tahun</th>
				<th>Keterangan</th>
				<th style="width:10px">Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM penyesuaian_dana order by MONTH(BULAN) desc") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
			$peg=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->KODE_PEGAWAI'"));
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$peg->NAMA_PEGAWAI.' ('.$peg->NIP_PEGAWAI.')</td>
				<td>'.$objectdata->STATUS.'</td>
				<td>Rp.'.number_format($objectdata->NOMINAL).',-</td>
				<td>'.$objectdata->BULAN.'-'.$objectdata->TAHUN.'</td>
				<td>'.$objectdata->KETERANGAN.'</td>
			
				<td>
                    <a href="#dialog-penyesuaian_dana" id="'.$objectdata->ID_PENYESUAIAN.'" alt="Ubah" title="Ubah" class="glyphicon ubah-penyesuaian_dana glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                   
				</td>
            </tr>';
                $no++;
            }
			/*  <a href="#" id="'.$objectdata->KODE_penyesuaian_dana.'" alt="Hapus" title="Hapus" class="glyphicon hapus-penyesuaian_dana glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>