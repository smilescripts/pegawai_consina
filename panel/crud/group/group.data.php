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
				<th>Nama group</th>
				<th>Akses modul</th>
				<th>Aksi</th>
            </tr>
		</thead>
		<tbody>
		<?php
            $querygroup=mysql_query("SELECT * FROM rights_group group by GROUP_NAME") or die (mysql_error());
            $no = 1;
            
			while($objectdata=mysql_fetch_object($querygroup)){
				$menudata=$objectdata->AKSES;
				$tmpmenudata=array();
				$tmpmenudata=explode(",",$menudata);
				echo'
			<tr>
				<td>'.$no.'</td>
				<td>'.$objectdata->GROUP_NAME.'</td>
				<td><div style="overflow-y:scroll;height:100px">
				';
		
				foreach($tmpmenudata as $fixmenu){
					$menu=mysql_query("SELECT * FROM rights_menu where ID='$fixmenu'") or die (mysql_error());
					$objectmenu=mysql_fetch_object($menu);
					echo "&bull;$objectmenu->MENU_NAME<br/>";
		
				}
				echo'
				</div></td>
				<td>
                    <a href="#dialog-group" id="'.$objectdata->ID.'" alt="Ubah" title="Ubah" class="glyphicon ubah-group glyphicon-edit" data-toggle="modal"></a>&nbsp; 
				</td>
            </tr>';
				$no++;
            }
		?>
		</tbody>
    </table>
</div>

