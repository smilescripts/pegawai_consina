<?php
    include_once "../../include/koneksi.php";
    session_start();
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman laporan penggajian karyawan harian";
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
  <li class="active"><span class="glyphicon glyphicon-user">Laporan gaji</li>
</ol>



<div class="panel panel-warning" id="non-printable">
   <h1 class="headingtable" style="margin-top:0px" ><span>Laporan</span> Gaji Karyawan Harian (Buaran)</h1>
	
    <div class="panel-body" >
		<div class="well">
            <form class="form-horizontal laporan_slipForm" id="laporan_slipForm" action="modul/mod_laporan_slip/laporan_slip.php" type="POST">
		
				<div class="form-group">
					<div class="col-sm-2">
						<input type="text" class="form-control" value="" id="NIP_PEGAWAIH" name="NIP_PEGAWAIH" placeholder="NIP Pegawai" \>
					</div>	
				
                    <div class="col-sm-2">
                        <div class="input-group date" id="datePicker1">
                            <input type="text" class="form-control" id="BULAN" name="BULAN" placeholder="Bulan" value=""  required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                     <div class="col-sm-2">
                        <div class="input-group date" id="datePicker">
                            <input type="text" class="form-control" id="TAHUN" name="TAHUN" placeholder="Tahun" value=""required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
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
					$('#datePicker').datepicker({
						format: "yyyy",
						startView: 2,
						minViewMode: 2,
						autoclose: true
					});
					$('#datePicker1').datepicker({
						format: "mm",
						minViewMode: 1,
						autoclose: true
					});
					$('#laporan_slipForm')
				
					.on('success.form.fv', function(e) {
						e.preventDefault();

						var $form = $(e.target),
							fv    = $form.data('formValidation');

						$.ajax({
							url: $form.attr('action'),
							type: 'POST',
							data: $form.serialize(),
							success: function(data) {
								var BULAN = document.getElementById('BULAN').value;
								var TAHUN = document.getElementById('TAHUN').value;
								var DEPT = document.getElementById('DEPT').value;
								var NIP_PEGAWAIH = document.getElementById('NIP_PEGAWAIH').value;
								$.get("modul/mod_laporan_slip/laporan.php?BULAN="+BULAN+"&TAHUN="+TAHUN+"&DEPT="+DEPT+"&NIP_PEGAWAIH="+NIP_PEGAWAIH, function(data){
									$('#laporan').html(data);
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
							BULAN: {
								validators: {
									notEmpty: {
										message: 'The is required'
									},
									stringLength: {
										max: 50,
										message: 'The must be less than 50 characters'
									}
								}
							},
							TAHUN: {
								validators: {
									notEmpty: {
										message: 'The is required'
									},
									stringLength: {
										max: 50,
										message: 'The must be less than 50 characters'
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
    <h1 class="headingtable" style="margin-top:0px" ><span>Data</span> Laporan Gaji Karyawan Harian (Buaran)</h1>
	
    <div class="panel-body">

        <div id="data-laporan_slip" id="non-printable">
			<span id="laporan"></span>
		</div>
	
    </div>
</div>

     