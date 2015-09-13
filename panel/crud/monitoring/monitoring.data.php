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
				<th>Parameter</th>
				<th>Status</th>
			 </tr>
		</thead>
		<tbody>
			<tr>
				<td>Internet Connection</td>
				<td>
				<?php
					if(fsockopen("www.google.com", 80)){echo "<b style='color:green'>Connected</b>";}else{echo "<b style='color:red'>Disconnected</b>";}		
				?>
				</td>
			</tr>
			<tr>
				<td>Database Connection</td>
				<td><?php echo @mysql_ping() ? '<b style="color:green">Connected</b>' : '<b style="color:green">Disconnected</b>';?></td>
			</tr>
			<tr>
				<td>Fingerprint Machine Connection</td>
				<td><?php
					$getmachine=mysql_query("select * from mesin_absensi");
					$datamachine=mysql_fetch_object($getmachine);
					$ip=$datamachine->IP_ADDRESS;
					$port=$datamachine->PORT_COM;
					if(fsockopen($ip, $port)){echo "<b style='color:green'>Connected</b>";}else{echo "<b  style='color:red'>Disconnected</b>";}		
				?></td>
			</tr>
		</tbody>
    </table>
</div>

