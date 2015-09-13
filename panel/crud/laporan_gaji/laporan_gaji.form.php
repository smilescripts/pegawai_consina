<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM departemen WHERE KODE_DEPARTEMEN=".$id
    ));
		
    if($id> 0) { 
        $KODE_DEPARTEMEN = $data['KODE_DEPARTEMEN'];
	$NAMA_DEPARTEMEN = $data['NAMA_DEPARTEMEN'];
    } else {
	$KODE_DEPARTEMEN = "";
	$NAMA_DEPARTEMEN = "";
	
    }
?>
	
<form class="form-horizontal petugasForm" id="petugasForm" action="crud/departemen/departemen.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
				</div>
		</div>
        <div class="form-group">
            <label for="NAMA_DEPARTEMEN" class="col-sm-3 control-label"> Departemen</label>
            <div class="col-sm-9">
		<input type="text" class="form-control" value="<?php echo $NAMA_DEPARTEMEN; ?>" id="NAMA_DEPARTEMEN" name="NAMA_DEPARTEMEN"  \>
		<input type="hidden" class="form-control" value="<?php echo $KODE_DEPARTEMEN; ?>" id="KODE_DEPARTEMEN" name="KODE_DEPARTEMEN"  \>
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
                    $('#dialog-departemen').modal('hide');
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
		NAMA_DEPARTEMEN: {
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
