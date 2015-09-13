<?php
    include_once "../../include/koneksi.php";
    session_start();
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM jabatan WHERE KODE_JABATAN=".$id
    ));

    if($id> 0) { 
		$KODE_JABATAN = $data['KODE_JABATAN'];
		$NAMA_JABATAN = $data['NAMA_JABATAN'];
		$TUNJANGAN_JABATAN = $data['TUNJANGAN_JABATAN'];
		$TUNJANGAN_LAIN = $data['TUNJANGAN_LAIN'];
        $tmptunjanganlain=array();
        $tmptunjanganlain=explode(",",$TUNJANGAN_LAIN);
		$NOMINAL_TABUNGAN = $data['NOMINAL_TABUNGAN'];
		$NOMINAL_UMT = $data['NOMINAL_UMT'];
    } else {
		$KODE_JABATAN = "";
		$NAMA_JABATAN = "";
		$TUNJANGAN_JABATAN = "";
        $TUNJANGAN_LAIN = "";
        $tmptunjanganlain=array();
        $tmptunjanganlain=explode(",",$TUNJANGAN_LAIN);
		$NOMINAL_TABUNGAN = "";
		$NOMINAL_UMT = "";
    }
?>
	
 <form class="form-horizontal jabatanForm" id="jabatanForm" action="crud/jabatan/jabatan.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA_JABATAN" class="col-sm-3 control-label"> Jabatan</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_JABATAN; ?>" id="NAMA_JABATAN" name="NAMA_JABATAN"  \>
				<input type="hidden" class="form-control" value="<?php echo $KODE_JABATAN; ?>" id="KODE_JABATAN" name="KODE_JABATAN"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="TUNJANGAN_JABATAN" class="col-sm-3 control-label"> Tunjangan Jabatan</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $TUNJANGAN_JABATAN; ?>" id="TUNJANGAN_JABATAN" name="TUNJANGAN_JABATAN"  \>
            </div>
		</div>
	<!--<div class="form-group">
            <label for="NOMINAL_TABUNGAN" class="col-sm-3 control-label">Nominal Tabungan</label>
            <div class="col-sm-9">
		<input type="text" class="form-control" value="<?php /* echo $NOMINAL_TABUNGAN; */ ?>" id="NOMINAL_TABUNGAN" name="NOMINAL_TABUNGAN"  \>
            </div>
	</div>
	<div class="form-group">
            <label for="NOMINAL_UMT" class="col-sm-3 control-label">Nominal UMT</label>
            <div class="col-sm-9">
		<input type="text" class="form-control" value="<?php /* echo $NOMINAL_UMT; */ ?>" id="NOMINAL_UMT" name="NOMINAL_UMT"  \>
            </div>
	</div>-->
       
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
		$('#jabatanForm')
            .find('[name="TUNJANGAN_LAIN[]"]')
            .select2({dropdownAutoWidth : true, width: "100%"})
            .change(function(e) {
                $('#jabatanForm').formValidation('revalidateField', 'TUNJANGAN_LAIN[]');
            })
            .end()
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function() {
			$('#dialog-jabatan').modal('hide');
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
                    NAMA_JABATAN: {
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
                    TUNJANGAN_JABATAN: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            integer: {
                                message: 'The is numeric'
                            },
                        }
                    },
					NOMINAL_TABUNGAN: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            integer: {
                                message: 'The is numeric'
                            },
                        }
                    },
					NOMINAL_UMT: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            integer: {
                                message: 'The is numeric'
                            },
                        }
                    },
                    'TUNJANGAN_LAIN[]': {
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
