<form class="form-horizontal restoreForm" enctype="multipart/form-data" id="restoreForm" action="crud/import_absensi/import_absensi.input.php" type="POST">
	<div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
		<div class="form-group">
			<label for="file" class="col-sm-3 control-label">Periode Tanggal</label>
		 <div class="col-sm-9">
						
                       <div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" id="start" name="start" readonly />
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" id="end" name="end" readonly />
						</div>
                    </div>
		</div>
		<div class="form-group">
			<label for="file" class="col-sm-3 control-label">File Import</label>
			<div class="col-sm-9">
				<input type="file" class="form-control" accept=".xls" id="file" name="file" placeholder="File Import" \>
			</div>
		</div>
		<div class="form-group">
			<label for="cek" class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				* file yang bisa di import excel (97/2003)adalah .xls 
			</div>
		</div>
	</div>
	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
</form>


<script type="text/javascript">
	$(document).ready(function() {
		$('.input-daterange').datepicker({
						format: "yyyy-mm-dd",
						orientation: "top right",
						autoclose: true,
						todayHighlight: true
					}).on('changeDate', function(e) {
						// Revalidate the date field
						$('#input_penggajianForm').formValidation('revalidateField', 'end');
					});
		$('#restoreForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();
			var $form = $(e.target),
                 formData = new FormData(),
                params   = $form.serializeArray(),
                files    = $form.find('[name="file"]')[0].files;

			 $.each(files, function(i, file) {
                formData.append('file[]', file);
            });

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });

            $.ajax({
                url: $form.attr('action'),
				data: formData,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(result) {
					//alert(result);
					$('#dialog-import_absensi').modal('hide');
					$('#import_berhasil').show();
					$('#jmldt').html('Jumlah Data Absensi : '+result['jmldt']).show();
					$('#dtggl').html('Jumlah Data Gagal : '+result['dtggl']).show();
					$('#dtmsk').html('Jumlah Data Absensi Masuk : '+result['dtmsk']).show();
					$('#dtklr').html('Jumlah Data Absensi Keluar : '+result['dtklr']).show();
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
				file: {
					validators: {
						notEmpty: {
							message: 'The is required'
						},
						file: {
							extension: 'xls',
							type: 'application/vnd.ms-excel',   // 2048 * 1024
							message: 'The selected file is not valid'
						}
					}
				},
				end: {
					validators: {
						notEmpty: {
							message: 'The is required'
						}
					}
				}
			}
		});
	});
</script>
