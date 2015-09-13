<form class="form-horizontal restoreForm" enctype="multipart/form-data" id="restoreForm" action="crud/restore/import.input.php" type="POST">
	<div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
		<div class="form-group">
			<label for="file" class="col-sm-3 control-label">File Import</label>
			<div class="col-sm-9">
				<input type="file" class="form-control" accept=".sql" id="file" name="file" placeholder="File Import" \>
			</div>
		</div>
		<div class="form-group">
			<label for="cek" class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				* file yang bisa di import adalah .sql 
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
					$('#dialog-restore').modal('hide');
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
							extension: 'sql',
							type: 'file/sql',   // 2048 * 1024
							message: 'The selected file is not valid'
						}
					}
				}
			}
		});
	});
</script>
