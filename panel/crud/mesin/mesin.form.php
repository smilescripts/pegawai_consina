<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM mesin_absensi WHERE KODE_MESIN=".$id
    ));
		
    if($id> 0) { 
		$KODE_MESIN = $data['KODE_MESIN'];
		$NAMA_MESIN = $data['NAMA_MESIN'];
		$IP_ADDRESS = $data['IP_ADDRESS'];
		$PORT_COM = $data['PORT_COM'];
		$MAC_ADDRESS = $data['MAC_ADDRESS'];
    } else {
		$KODE_MESIN = $id;
		$NAMA_MESIN = "";
		$IP_ADDRESS = "";
		$PORT_COM = "";
		$MAC_ADDRESS = "";
	
    }
?>
<style>
   
    .green{color: green;}
    .red{color: red;}
</style>
  

<script type="text/javascript">
	$(document).ready(function () {

		$("#NAMA_MESIN").change(function () {
			var NAMA_MESIN = $(this).val();
			if (NAMA_MESIN == '') {
				$("#availability").html("");
			}
			else{
				$.ajax({
				url: "crud/mesin/ceknamamesin.php?uname="+NAMA_MESIN
				}).done(function( data ) {
					$("#availability").html(data);
					var verifikasi=data["verifikasi"];
					if(verifikasi!="yes"){
					
						document.getElementById("simpan").disabled = true;		
						
					}
				});  
		
			} 
		});
	});
</script>
<form class="form-horizontal mesinForm" id="mesinForm" action="crud/mesin/mesin.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA_MESIN" class="col-sm-3 control-label"> Nama Mesin</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_MESIN; ?>" id="NAMA_MESIN" name="NAMA_MESIN"  \>
				<div id="availability"></div>
				<input type="hidden" class="form-control" value="<?php echo $KODE_MESIN; ?>" id="KODE_MESIN" name="KODE_MESIN"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="IP_ADDRESS" class="col-sm-3 control-label">IP Address</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $IP_ADDRESS; ?>" id="IP_ADDRESS" name="IP_ADDRESS"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Port Komunikasi</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $PORT_COM; ?>" id="PORT_COM" name="PORT_COM"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="MAC_ADDRESS" class="col-sm-3 control-label">MAC Adrress PC</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $MAC_ADDRESS; ?>" id="MAC_ADDRESS" name="MAC_ADDRESS"  \>
            </div>
		</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" id="simpan" class="btn btn-success">Simpan</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
		$('#mesinForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                    $('#dialog-mesin').modal('hide');
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
				NAMA_MESIN: {
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
				MAC_ADDRESS: {
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
