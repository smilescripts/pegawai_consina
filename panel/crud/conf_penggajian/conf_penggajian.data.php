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
				<th>Parameter</th>
				<th>Value</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querypetugas=mysql_query("SELECT * FROM pengaturan_penggajian where ID!='1'") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querypetugas)){
				echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->PARAMETER.'</td>
				';
				
				if($objectdata->ID=="2"){
					$tmptunjanganlain=array();
					$tmptunjanganlain=explode(",",$objectdata->VALUE);
		
					echo'
				<td>'.$tmptunjanganlain[0].' | Rp. '.number_format($tmptunjanganlain[1]).',-</td>	
					';
				}		
				
				if($objectdata->ID!="2"){
		
					echo'
				<td>'.$objectdata->VALUE.'</td>
					';
				}
				echo'
				<td>
                    <a href="#dialog-conf_penggajian" id="'.$objectdata->ID.'" alt="Ubah" title="Ubah" class="glyphicon ubah-conf_penggajian glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

