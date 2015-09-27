<?php
	error_reporting(0);
	session_start();
    include_once "../../include/koneksi.php";
    $state_session=$_SESSION['STATE_ID'];	
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
				<th>Foto</th>
				<th>NIP</th>
				<th>Nama</th>
				<th>Departemen</th>
				<th>Divisi</th>
				<th>Jabatan</th>
				<!--<th>Line</th>
				<th>Pengawas</th>-->
				<th>Status</th>
				<th>Site</th>
				<th>Gaji Pokok</th>
				<th>No Rekening</th>
				<th>Email</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
			
				$querypetugas=mysql_query("SELECT * FROM pegawai WHERE STATUS_PEGAWAI='Tetap' and OUTLET='YA'") or die (mysql_error());
			
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
                $queryjabatan=mysql_query("SELECT * FROM jabatan WHERE KODE_JABATAN=".$objectdata->KODE_JABATAN) or die (mysql_error());
                $tampiljabatan=mysql_fetch_object($queryjabatan);
                $querydepartemen=mysql_query("SELECT * FROM departemen WHERE KODE_DEPARTEMEN=".$objectdata->KODE_DEPARTEMEN) or die (mysql_error());
                $tampildepartemen=mysql_fetch_object($querydepartemen);
				$querystate=mysql_query("SELECT * FROM state WHERE STATE_ID=".$objectdata->STATE_ID) or die (mysql_error());
                $tampilstate=mysql_fetch_object($querystate);
				$tdivisi=mysql_fetch_object(mysql_query("select * from divisi where ID='$objectdata->KODE_DIVISI'"));
                echo'
            <tr>
				<td>'.$no.'</td>
				<td>';
                
				if($objectdata->FOTO_PEGAWAI!=""){
                    echo '<img src="foto/pegawai/'.$objectdata->FOTO_PEGAWAI.'" style="width:50px">';
                }else{
                    echo '<img src="user.png" style="width:50px">';
                }
                echo '
                </td>
				<td>'.$objectdata->NIP_PEGAWAI.'</td>
				<td>'.$objectdata->NAMA_PEGAWAI.'</td>
				<td>'.$tampildepartemen->NAMA_DEPARTEMEN.'</td>
				<td>'.$tdivisi->NAMA.'</td>
				<td>'.$tampiljabatan->NAMA_JABATAN.'</td>';
				/* <td>'.$objectdata->LINE.'</td>
				<td>'.$objectdata->PENGAWAS.'</td> */
				echo '<td>';
		
				if($objectdata->STATUS_PEGAWAI=="Kontrak bulanan"){echo "Harian bulanan";}else if($objectdata->STATUS_PEGAWAI=="Tetap"){echo "Bulanan";}else{echo "Keluar";}
		
				echo'
				</td>
				<td>'.$tampilstate->STATE_NAME.'</td>
				<td>'.$objectdata->GAJI_POKOK.'</td>
				<td>'.$objectdata->NO_REKENING.'</td>
				<td>'.$objectdata->EMAIL.'</td>
				<td>
                    <a href="#dialog-pegawai_outlet" id="'.$objectdata->KODE_PEGAWAI.'" alt="Ubah" title="Ubah" class="glyphicon ubah-pegawai_outlet glyphicon-edit" data-toggle="modal"></a>&nbsp; 
                   
				</td>
            </tr>';
				$no++;
            }
			/*  <a href="#" id="'.$objectdata->KODE_PEGAWAI.'" alt="Hapus" title="Hapus" class="glyphicon hapus-pegawai glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>

