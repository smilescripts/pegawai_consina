<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
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
				<th>Senin</th>
				<th>Selasa</th>
				<th>Rabu</th>
				<th>Kamis</th>
				<th>Bulan - Tahun</th>
				<th>Aksi</th>

            </tr>
		</thead>
		<tbody>
		<?php
			$querypetugas=mysql_query("SELECT * FROM libur_outlet_perbln") or die (mysql_error());
			$no = 0;
        
			while($objectdata=mysql_fetch_object($querypetugas)){
				$no++;
				
				$qsenin=mysql_query("select NIP_PEGAWAI,NAMA_PEGAWAI from pegawai where KODE_PEGAWAI IN (".$objectdata->SENIN.")");
				$qselasa=mysql_query("select NIP_PEGAWAI,NAMA_PEGAWAI from pegawai where KODE_PEGAWAI IN (".$objectdata->SELASA.")");
				$qrabu=mysql_query("select NIP_PEGAWAI,NAMA_PEGAWAI from pegawai where KODE_PEGAWAI IN (".$objectdata->RABU.")");
				$qkamis=mysql_query("select NIP_PEGAWAI,NAMA_PEGAWAI from pegawai where KODE_PEGAWAI IN (".$objectdata->KAMIS.")");
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>';
				while($tsenin=mysql_fetch_object($qsenin)){
					echo '- '.$tsenin->NIP_PEGAWAI.' - '.$tsenin->NAMA_PEGAWAI.'</br>';
				}
				echo '</td>
				<td>';
				while($tselasa=mysql_fetch_object($qselasa)){
					echo '- '.$tselasa->NIP_PEGAWAI.' - '.$tselasa->NAMA_PEGAWAI.'</br>';
				}
				echo '</td>
				<td>';
				while($trabu=mysql_fetch_object($qrabu)){
					echo '- '.$trabu->NIP_PEGAWAI.' - '.$trabu->NAMA_PEGAWAI.'</br>';
				}
				echo '</td>
				<td>';
				while($tkamis=mysql_fetch_object($qkamis)){
					echo '- '.$tkamis->NIP_PEGAWAI.' - '.$tkamis->NAMA_PEGAWAI.'</br>';
				}
				echo '</td>
				<td>'.$objectdata->BULAN.'-'.$objectdata->TAHUN.'</td>
				<td>
                    <a href="#dialog-libur_perbln" id="'.$objectdata->ID.'" alt="Ubah" title="Ubah" class="glyphicon ubah-libur_perbln glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
				';
			}
		?>
		</tbody>
    </table>
</div>

