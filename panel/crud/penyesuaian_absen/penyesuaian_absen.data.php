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
				<th>Nip - Nama</th>
				<th>Bulan - Tahun</th>
				<th style="width:50px">Jumlah </th>
				<th style="width:150px">Tanggal & Jam</th>
				<th>Tanggal akses</th>
				<th>Petugas</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
			if($_SESSION['AKSES']==43){
				$query=mysql_query("SELECT * FROM penyesuaian_absensi WHERE KODE_PEGAWAI IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak')") or die (mysql_error());
			}else if($_SESSION['AKSES']==44){
				$query=mysql_query("SELECT * FROM penyesuaian_absensi WHERE KODE_PEGAWAI IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATUS_PEGAWAI='Tetap')") or die (mysql_error());
			}else{
				$query=mysql_query("SELECT * FROM penyesuaian_absensi") or die (mysql_error());
			}
            $no = 1;
            
			while($objectdata=mysql_fetch_object($query)){
				echo'
            <tr>
				<td>'.$no.'</td>
				';
		 
				$query1=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->KODE_PEGAWAI'") or die (mysql_error());
				$objectdata1=mysql_fetch_object($query1);
				$count=mysql_query("SELECT count(TANGGAL) as jmlpey FROM detail_penyesuaian_absensi where HEAD_ID_PENYESUAIAN='$objectdata->ID' and TANGGAL!='0000-00-00' and JAM_MASUK!='' and JAM_KELUAR!=''") or die (mysql_error());
				$dpenyesuaian=mysql_fetch_object($count);
				echo'
				<td>'.$objectdata1->NIP_PEGAWAI.' - '.$objectdata1->NAMA_PEGAWAI.'</td>
				<td>'.$objectdata->BULAN.' - '.$objectdata->TAHUN.'</td>
				<td>'.$dpenyesuaian->jmlpey.' Hari</td>
				<td>	<div style="overflow-y:scroll;height:100px">
				';
		 
				$penyesuaian=mysql_query("SELECT * FROM detail_penyesuaian_absensi where HEAD_ID_PENYESUAIAN='$objectdata->ID' and TANGGAL!='0000-00-00' and JAM_MASUK!='' and JAM_KELUAR!=''") or die (mysql_error());
				
				while($objectdatapenyesuaian=mysql_fetch_object($penyesuaian)){
					echo '&bull;<b>'.$objectdatapenyesuaian->TANGGAL.'</b><br/>(<i>'.$objectdatapenyesuaian->JAM_MASUK.'-'.$objectdatapenyesuaian->JAM_KELUAR.'</i>)<br/>'; 
				}
				
				echo'
				</div></td>
				<td>'.$objectdata->TANGGAL_AKSES.'</td>
				';
		 
				$query12=mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$objectdata->KODE_PETUGAS'") or die (mysql_error());
				$objectdata12=mysql_fetch_object($query12);
				
				echo'
				<td>'.$objectdata12->NAMA_PETUGAS.'</td>
				<td>
				<a href="#" id="'.$objectdata->ID.'" class="view-penyesuaian_absen glyphicon glyphicon-eye-open" alt="Detail" title="Detail">
						<i class="icon-trash"></i>
					</a>&nbsp;';
				
				$pengaturan = mysql_fetch_array(mysql_query("SELECT VALUE FROM pengaturan_penggajian WHERE ID='9'"));
				$data = mysql_fetch_array(mysql_query("SELECT kode_penggajian,DATE_ADD(tanggal_gaji,INTERVAL ".$pengaturan['VALUE']." DAY) AS cktgl FROM head_penggajian WHERE bulan='$objectdata->BULAN' AND tahun='$objectdata->TAHUN'"));
                $datenow=date("Y-m-d");
				if($data["cktgl"]==""){
					 echo'<a href="#" id="'.$objectdata->ID.'" class="hapus-penyesuaian_absen glyphicon glyphicon-trash" alt="Hapus" title="Hapus">
						<i class="icon-trash"></i>
					</a>';
				}else{
					if($data["cktgl"]>=$datenow){
					  echo'<a href="#" id="'.$objectdata->ID.'" class="hapus-penyesuaian_absen glyphicon glyphicon-trash" alt="Hapus" title="Hapus">
							<i class="icon-trash"></i>
						</a>';
					}
				}
				
				echo'
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

