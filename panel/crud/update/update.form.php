<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM update_absensi WHERE KODE_update=".$id
    ));
		
    if($id> 0) { 
		$KODE_update = $data['KODE_update'];
		$NAMA_update = $data['NAMA_update'];
		$IP_ADDRESS = $data['IP_ADDRESS'];
		$PORT_COM = $data['PORT_COM'];
    } else {
		$KODE_update = "";
		$NAMA_update = "";
		$IP_ADDRESS = "";
		$PORT_COM = "";
	
    }
?>
	
<form class="form-horizontal updateForm" id="updateForm" action="crud/update/update.input.php" type="POST">
    <div class="modal-body">
		
		<center>		
			<div class="loading" style="display:none" id="loading"><img style="width:100%" src="crud/update/loading.gif"/></div>     
		</center>  
    </div>
    <div class="modal-footer">
		<center>
			<button type="submit" class="btn btn-success">Perbarui sistem sekarang</button>
		</center>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
		$('#loading').show();
		
		$('#updateForm')
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
				
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
				
                success: function() {
					$('#dialog-update').modal('hide');  
					alert("Pembaruan sistem berhasil");	
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
				NAMA_update: {
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
				IP_ADDRESS: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				PORT_COM: {
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
