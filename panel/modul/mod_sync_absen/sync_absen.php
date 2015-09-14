<?php
    include_once "../../include/koneksi.php";
    session_start();
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman Sinkronisasi Absen Mesin";
	catat($user,$aksi);
?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
</script>

<ol class="breadcrumb">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user"> Sinkronisasi</li>
</ol>

<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Sinkronisasi Absen Mesin</h3>
    </div>
    <div class="panel-body">
		<form class="form-inline syncForm" id="syncForm" action="modul/mod_sync_absen/sync.php" type="POST">
				 
				 <div class="col-sm-6">
                       <div class="input-daterange input-group" id="datepicker1">
							<input type="text" class="input-sm form-control" id="start" name="start" readonly />
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" id="end" name="end" readonly />
						</div>
                    </div>
				<div class="form-group">
						<?php
							$result = mysql_query("select * from mesin_absensi");  
							echo '<select id="KODE_MESIN" name="KODE_MESIN" class="form-control">';  
								echo '<option value="">Silahkan Pilih Nama Mesin</option>';  
								while ($row = mysql_fetch_array($result)) {  
									echo '<option value="' . $row['KODE_MESIN'] . '">' . $row['NAMA_MESIN']. '</option>';  
								}  
							echo '</select>';
						?>
				</div>
				<button type="submit" class="btn btn-success">Proses</button>
		</form>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#datepicker1').datepicker({
						format: "yyyy-mm-dd",
						orientation: "top right",
						autoclose: true,
						todayHighlight: true
					}).on('changeDate', function(e) {
						// Revalidate the date field
						$('#syncForm').formValidation('revalidateField', 'end');
					});
				$('#syncForm')
			
				.on('success.form.fv', function(e) {
					e.preventDefault();
					var $form = $(e.target),
						fv    = $form.data('formValidation');

					$.ajax({
						url: $form.attr('action'),
						type: 'POST',
						data: $form.serialize(),
						success: function(html) {
							$(".data-sync").html(html).show();
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
						KODE_MESIN: {
							validators: {
								notEmpty: {
									message: 'The is required'
								}
							}
						},
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
		
		<form style="margin-top:20px;" class="form-inline syncAllForm" id="syncAllForm" action="modul/mod_sync_absen/syncAll.php" type="POST">
				 <div class="col-sm-6">
                       <div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" id="startall" name="startall" readonly />
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" id="endall" name="endall" readonly />
						</div>
                    </div>
				<button type="submit" class="btn btn-success">Proses Semua Mesin</button>
		</form>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#datepicker').datepicker({
						format: "yyyy-mm-dd",
						orientation: "top right",
						autoclose: true,
						todayHighlight: true
					}).on('changeDate', function(e) {
						// Revalidate the date field
						$('#syncAllForm').formValidation('revalidateField', 'endall');
					});
				$('#syncAllForm')
			
				.on('success.form.fv', function(e) {
					e.preventDefault();
					var $form = $(e.target),
						fv    = $form.data('formValidation');

					$.ajax({
						url: $form.attr('action'),
						type: 'POST',
						data: $form.serialize(),
						success: function(html) {
							$(".data-sync").html(html).show();
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
						endall: {
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

<div id="data-sync" class="data-sync"></div>