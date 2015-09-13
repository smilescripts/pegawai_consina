<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$id
    ));

    if($id> 0) { 
		$KODE_JAM_KERJA = $data['KODE_JAM_KERJA'];
        $KETERANGAN = $data['KETERANGAN'];
		$JAM_DATANG = $data['JAM_DATANG'];
		$JAM_PULANG = $data['JAM_PULANG'];
        $KODE_MASUK = $data['KODE_MASUK'];
        $KODE_KELUAR = $data['KODE_KELUAR'];
    } else {
		$KODE_JAM_KERJA = "";
        $KETERANGAN = "";
		$JAM_DATANG ="";
		$JAM_PULANG = "";
        $KODE_MASUK = "";
        $KODE_KELUAR = "";
    }
?>
	
 <form class="form-horizontal jamForm" id="jamForm" action="crud/jam_kerja/jam.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="KETERANGAN" class="col-sm-5 control-label">Keterangan</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" value="<?php echo $KETERANGAN; ?>" id="KETERANGAN" name="KETERANGAN" placeholder="Keterangan Jam Kerja" \>
            </div>
		</div>
        <div class="form-group">
            <label for="JAM_DATANG" class="col-sm-5 control-label">Jam Datang</label>
            <div class="col-sm-4">
                <div class="input-group bootstrap-timepicker">
                    <input type="text" class="form-control" value="<?php echo $JAM_DATANG; ?>" id="JAM_DATANG" name="JAM_DATANG" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-time"></i></span>
				</div>
				<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="KODE_JAM_KERJA" name="KODE_JAM_KERJA"  \>
            </div>
		</div>
        <div class="form-group">
            <label for="JAM_PULANG" class="col-sm-5 control-label">Jam Pulang</label>
            <div class="col-sm-4">
                <div class="input-group bootstrap-timepicker">
                    <input type="text" class="form-control" value="<?php echo $JAM_PULANG; ?>" id="JAM_PULANG" name="JAM_PULANG" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-time"></i></span>
				</div>
            </div>
		</div>
        <div class="form-group">
            <label for="KODE_MASUK" class="col-sm-5 control-label">Kode Status Masuk Mesin</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $KODE_MASUK; ?>" id="KODE_MASUK" name="KODE_MASUK" placeholder="Kode Status Masuk Mesin"\>
            </div>
		</div>
        <div class="form-group">
            <label for="KODE_KELUAR" class="col-sm-5 control-label">Kode Status Keluar Mesin</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $KODE_KELUAR; ?>" id="KODE_KELUAR" name="KODE_KELUAR" placeholder="Kode Status Keluar Mesin">
          
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
        $('#JAM_DATANG').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            modalBackdrop: false,
            showSeconds: false,
            showMeridian: false
		});
        $('#JAM_PULANG').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            modalBackdrop: false,
            showSeconds: false,
            showMeridian: false
		});
        $('#JAM_KELUAR_ISTIRAHAT').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            modalBackdrop: false,
            showSeconds: false,
            showMeridian: false
		});
         $('#JAM_MASUK_ISTIRAHAT').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            modalBackdrop: false,
            showSeconds: false,
            showMeridian: false
		});
		$('#jamForm')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(result) {
						$('#dialog-jam').modal('hide');
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
                    KETERANGAN: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    JAM_DATANG: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    JAM_PULANG: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    KODE_MASUK: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    KODE_KELUAR: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                }
            });
    });
</script>
