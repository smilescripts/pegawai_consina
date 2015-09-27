<?php
    include_once "../../include/koneksi.php";
    session_start();
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman laporan penggajian karyawan bulanan";
	catat($user,$aksi);
?>
<style type="text/css">
	@media print
    {
    	#non-printable { display: none;font-size:10pt }
    	#printable { display: block; }
    }
</style>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
</script>

<ol class="breadcrumb" id="non-printable">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user">Rekapitulasi karyawan bulanan</li>
</ol>




<div class="panel panel-warning" id="non-printable">
  <h1 class="headingtable" style="margin-top:0px" ><span>Rekapitulasi</span> gaji dan kehadiran karyawan bulanan (Buaran)</h1>
    <div class="panel-body" >
		<div class="well">
            <form class="form-horizontal rekapitulasi_bulananForm" id="rekapitulasi_bulananForm" action="modul/mod_rekapitulasi_bulanan/laporan_slip_bulanan.php" type="POST">
				<div class="form-group">
					<div class="col-sm-3">
					 <?php
                   
					$result=mysql_query("SELECT * FROM pegawai where (STATUS_PEGAWAI='Tetap' and STATUS_PEGAWAI!='Keluar') and OUTLET!='YA'") or die (mysql_error());
                    echo '<select id="NIP_PEGAWAIH" name="NIP_PEGAWAIH" style="width: 100%;" class="NIP_PEGAWAIH form-control">';  
                        echo '<option value="">Silahkan Pilih Pegawai</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['NIP_PEGAWAI'] .'">'.$row['NAMA_PEGAWAI']. '</option>';  
						}  
                    echo '</select>';
					?>
					</div>	
				
                    <div class="col-sm-5">
                       <div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" id="start" name="start" readonly />
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" id="end" name="end" readonly />
						</div>
                    </div>
					
					 <div class="col-sm-3">
             
					<?php
						$result = mysql_query("select * from departemen");  
						echo '<select id="DEPT" name="KODE_DEPARTEMEN" class="form-control">';  
                        echo'<option value="all">&bull;Semua Departemen</option>';
						
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_DEPARTEMEN'] . '">&bull;' . $row['NAMA_DEPARTEMEN']. '</option>';  
						}  
						echo '</select>';
				
					?>
				
                    </div>
                    <button type="submit"  class="btn btn-info">Tampil</button>
                </div>
            </form>
			
	
			<script type="text/javascript">
			$(document).ready(function() {
				$(document).ready(function() {
					$(".NIP_PEGAWAIH").select2();
					});
				$('.input-daterange').datepicker({
						format: "yyyy-mm-dd",
						orientation: "top right",
						autoclose: true,
						todayHighlight: true
					}).on('changeDate', function(e) {
						// Revalidate the date field
						$('#rekapitulasi_bulananForm').formValidation('revalidateField', 'end');
					});
					
					$('#rekapitulasi_bulananForm')
				
					.on('success.form.fv', function(e) {
						e.preventDefault();

						var $form = $(e.target),
							fv    = $form.data('formValidation');

						$.ajax({
							url: $form.attr('action'),
							type: 'POST',
							data: $form.serialize(),
							beforeSend: function(){
								$('#loadingDiv').show();
							},
							
							success: function(data) {
								var start = document.getElementById('start').value;
								var end = document.getElementById('end').value;
								var DEPT = document.getElementById('DEPT').value;
								var NIP_PEGAWAIH = document.getElementById('NIP_PEGAWAIH').value;
								$.get("modul/mod_rekapitulasi_bulanan/laporan.php?start="+start+"&end="+end+"&DEPT="+DEPT+"&NIP_PEGAWAIH="+NIP_PEGAWAIH, function(data){
								
									$('#laporan').html(data);
									$('#loadingDiv').hide(0);
								});
								
							}
						});
					})
					.on('init.field.fv', function(e, data) {

						var $icon      = data.element.data('fv.icon'),
							options    = data.fv.getOptions(), 
							validators = data.fv.getOptions(data.field).validators; 
						if (validators.notEmpty && options.icon && options.icon.required) {
							$icon.addClass(options.icon.required).show();
						}
					})
					.formValidation({
						message: 'This value is not valid',
						icon: {
							required: 'glyphicon glyphicon-asterisk',
							valid: 'glyphicon glyphicon-ok',
							invalid: 'glyphicon glyphicon-remove',
							validating: 'glyphicon glyphicon-refresh'
						},
						fields: {
							end: {
								validators: {
									notEmpty: {
										message: 'The is required'
									}
								}
							},
						}
					})
					.on('success.field.fv', function(e, data) {
						if (data.fv.getSubmitButton()) {
							data.fv.disableSubmitButtons(false);
						}
					});
				});
			</script>
  
		</div>
    </div>
</div>

<div class="panel panel-warning">
    <h1 class="headingtable" style="margin-top:0px" ><span>Data Rekapitulasi</span> gaji dan kehadiran karyawan bulanan (Buaran)</h1>
    <div class="panel-body">
	<center>
		<div id="loadingDiv" style="display:none" >
		<img src='img/gif-load.gif'/>
		</div> 
		</center>
		<div id="data-rekapitulasi_bulanan" id="non-printable">
			<span id="laporan"></span>
		</div>
	
    </div>
</div>

     