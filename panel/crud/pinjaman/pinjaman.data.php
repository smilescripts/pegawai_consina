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
				<th>Kode Pinjaman</th>
				<th>Nip Pegawai</th>
                <th>Nama Pegawai</th>
                <th>Tanggal</th>
				<th>Nominal</th>
                <th>Keterangan</th>
                <th>Status</th>
               
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
			if($_SESSION['AKSES']==43){
				$querykasbon=mysql_query("SELECT * FROM kasbon_pegawai WHERE NIP_PEGAWAI IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak') order by TANGGAL DESC") or die (mysql_error());
			}else if($_SESSION['AKSES']==44){
				$querykasbon=mysql_query("SELECT * FROM kasbon_pegawai WHERE NIP_PEGAWAI IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATUS_PEGAWAI='Tetap') order by TANGGAL DESC") or die (mysql_error());
			}else{
				$querykasbon=mysql_query("SELECT * FROM kasbon_pegawai order by TANGGAL DESC") or die (mysql_error());
			}
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querykasbon)){
                $querypegawai=mysql_query("SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$objectdata->NIP_PEGAWAI) or die (mysql_error());
				$tampilpegawai=mysql_fetch_object($querypegawai);
                echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->KODE_KASBON.'</td>
				<td>'.$tampilpegawai->NIP_PEGAWAI.'</td>
                <td>'.$tampilpegawai->NAMA_PEGAWAI.'</td>
                <td>'.$objectdata->TANGGAL.'</td>
                <td>Rp. '.number_format($objectdata->NOMINAL).',-</td>
                <td>'.$objectdata->KETERANGAN.'</td>
                <td>'.$objectdata->STATUS.'</td>
                
				<td>
				';
				$pengaturan = mysql_fetch_array(mysql_query("SELECT VALUE FROM pengaturan_penggajian WHERE ID='9'"));
				$data = mysql_fetch_array(mysql_query("SELECT kode_penggajian,start,end,DATE_ADD(tanggal_gaji,INTERVAL ".$pengaturan['VALUE']." DAY) AS cktgl FROM head_penggajian WHERE bulan=MONTH('$objectdata->TANGGAL') AND tahun=YEAR('$objectdata->TANGGAL')"));
                $datenow=date("Y-m-d");
				if($data["cktgl"]==""){
					 echo'
                    <a href="#dialog-pinjaman" id="'.$objectdata->KODE_KASBON.'" alt="Ubah" title="Ubah" class="glyphicon ubah-pinjaman glyphicon-edit" data-toggle="modal"></a>&nbsp; 
					';
				}else{
					if($objectdata->TANGGAL>=$data["start"] && $objectdata->TANGGAL<=$data["end"]){
						if($data["cktgl"]>=$datenow){
						  echo'
						<a href="#dialog-pinjaman" id="'.$objectdata->KODE_KASBON.'" alt="Ubah" title="Ubah" class="glyphicon ubah-pinjaman glyphicon-edit" data-toggle="modal"></a>&nbsp; 
						';
						}
					}else{
						 echo'
						<a href="#dialog-pinjaman" id="'.$objectdata->KODE_KASBON.'" alt="Ubah" title="Ubah" class="glyphicon ubah-pinjaman glyphicon-edit" data-toggle="modal"></a>&nbsp; 
						';
					} 
				}
		
				echo '			 
				</td>
            </tr>';
                $no++;
            }
			/* <a href="#" id="'.$objectdata->KODE_KASBON.'" alt="Hapus" title="Hapus" class="glyphicon hapus-pinjaman glyphicon-trash"></a> */
		?>
		</tbody>
    </table>
</div>