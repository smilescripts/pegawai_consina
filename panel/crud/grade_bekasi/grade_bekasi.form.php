<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];
	
    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM grade_bekasi WHERE KODE_GRADE=".$id
    ));
		
    if($id> 0) { 
		$KODE_GRADE = $data['KODE_GRADE'];
		$NAMA_GRADE = $data['NAMA_GRADE'];
		$NOMINAL_GRADE = $data['NOMINAL_GRADE'];
	
    } else {
		$KODE_GRADE = "";
		$NAMA_GRADE = "";
		$NOMINAL_GRADE = "";
    }
?>
	
<form class="form-horizontal petugasForm" id="petugasForm" action="crud/grade_bekasi/grade_bekasi.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA_GRADE" class="col-sm-3 control-label">Nama Grade</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_GRADE; ?>" id="NAMA_GRADE" name="NAMA_GRADE"  \>
				<input type="hidden" class="form-control" value="<?php echo $KODE_GRADE; ?>" id="KODE_GRADE" name="KODE_GRADE"  \>
            </div>
		</div> 
		<div class="form-group">
            <label for="NOMINAL_GRADE" class="col-sm-3 control-label">Nominal Grade</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NOMINAL_GRADE; ?>" id="NOMINAL_GRADE" name="NOMINAL_GRADE"  \>
				
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
		$('#petugasForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                    $('#dialog-grade_bekasi').modal('hide');
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
				NOMINAL_GRADE: {
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
				NAMA_GRADE: {
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
        });
    });
</script>
