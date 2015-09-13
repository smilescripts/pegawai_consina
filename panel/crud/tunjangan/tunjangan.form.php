<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM master_tunjangan WHERE KODE_MASTER_TUNJANGAN=".$id
    ));

    if($id> 0) { 
		$KODE_MASTER_TUNJANGAN = $data['KODE_MASTER_TUNJANGAN'];
		$NAMA_TUNJANGAN = $data['NAMA_TUNJANGAN'];
		$NOMINAL = $data['NOMINAL'];
    } else {
		$KODE_MASTER_TUNJANGAN = "";
		$NAMA_TUNJANGAN = "";
		$NOMINAL = "";
        
    }
?>
	
 <form class="form-horizontal tunjanganForm" id="tunjanganForm" action="crud/tunjangan/tunjangan.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA_TUNJANGAN" class="col-sm-3 control-label"> Nama Tunjangan</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_TUNJANGAN; ?>" id="NAMA_TUNJANGAN" name="NAMA_TUNJANGAN" placeholder="Nama Tunjangan" \>
				<input type="hidden" class="form-control" value="<?php echo $KODE_MASTER_TUNJANGAN; ?>" id="KODE_MASTER_TUNJANGAN" name="KODE_MASTER_TUNJANGAN"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="NOMINAL" class="col-sm-3 control-label"> Nominal</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NOMINAL; ?>" id="NOMINAL" name="NOMINAL" placeholder="Nominal" \>
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
		$('#tunjanganForm')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(result) {
						$('#dialog-tunjangan').modal('hide');
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
                    NAMA_TUNJANGAN: {
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
                    NOMINAL: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            integer: {
                                message: 'The is numeric'
                            },
                        }
                    },
                }
            });
    });
</script>
