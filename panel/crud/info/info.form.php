<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM profil_perusahaan WHERE id=".$id
    ));
		
    if($id> 0) { 
		$id = $data['id'];
		$NAMA_PERUSAHAAN = $data['NAMA_PERUSAHAAN'];
		$EMAIL = $data['EMAIL'];
		$PHONE_1 = $data['PHONE_1'];
		$PHONE_2 = $data['PHONE_2'];
		$KOTA = $data['KOTA'];
		$FAXIMILI = $data['FAXIMILI'];
		$ALAMAT = $data['ALAMAT'];
		$NEGARA = $data['NEGARA'];
		$logo = $data['logo'];
		$STATE_ID = $data['STATE_ID'];
		$COLOR = $data['COLOR'];
    } else {
		$NAMA_PERUSAHAAN ="";
		$EMAIL = "";
		$PHONE_1 = "";
		$PHONE_2 = "";
		$KOTA = "";
		$FAXIMILI = "";
		$ALAMAT ="";
		$NEGARA ="";
		$logo ="";
		$STATE_ID ="";
		$COLOR ="";
	
    }
?>
	
<form class="form-horizontal infoForm" id="infoForm" action="crud/info/info.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA_PERUSAHAAN" class="col-sm-3 control-label">  Perusahaan</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_PERUSAHAAN; ?>" id="NAMA_PERUSAHAAN" name="NAMA_PERUSAHAAN"  \>
				<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="id" name="id"  \>
			 </div>
		</div>
		<div class="form-group">
            <label for="EMAIL" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $EMAIL; ?>" id="EMAIL" name="EMAIL"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Phone 1</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $PHONE_1; ?>" id="PHONE_1" name="PHONE_1"  \>
            </div>
		</div>
	
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Phone 2</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $PHONE_2; ?>" id="PHONE_2" name="PHONE_2"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Kota</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $KOTA; ?>" id="KOTA" name="KOTA"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Faximili</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $FAXIMILI; ?>" id="FAXIMILI" name="FAXIMILI"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Negara</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NEGARA; ?>" id="NEGARA" name="NEGARA"  \>
            </div>
		</div>	
		<div class="form-group">
            <label for="PORT_COM" class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-9">
				<textarea class="form-control" id="ALAMAT" name="ALAMAT"  \><?php echo $ALAMAT; ?></textarea>
            </div>
		</div>
		<div class="form-group">
            <label for="STATE_ID" class="col-sm-3 control-label">STATE </label>
            <div class="col-sm-9">
                <?php
                    $result = mysql_query("select * from state");  
                    echo '<select id="STATE_ID" name="STATE_ID" style="width: 100%;" class="form-control">';  
                    echo '<option value="">Silahkan Pilih State</option>';  
					
					while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['STATE_ID'] . '"';if($STATE_ID==$row['STATE_ID']){echo "selected='selected'";} echo'>' . $row['STATE_NAME']. '</option>';  
					}  
                    echo '</select>';
				?>
            </div>
		</div>
		<div class="form-group">
            <label for="LOGO" class="col-sm-3 control-label">Warna</label>
            <div class="col-sm-9">
				<input type="text" class="demo1" value="<?php echo $COLOR; ?>" name="COLOR" />
				<script>
				$(function(){
					$('.demo1').colorpicker();
				});
				</script>
			</div>
		</div>
		<div class="form-group">
            <label for="LOGO" class="col-sm-3 control-label">Logo</label>
            <div class="col-sm-9">
				<input type="file" class="form-control" accept="image/jpeg, image/png" id="logo" name="logo" placeholder="File Import" \>
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
	$('#infoForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();
			
			var $form = $(e.target),
            formData = new FormData(),
            params   = $form.serializeArray(),
            files    = $form.find('[name="logo"]')[0].files;

            $.each(files, function(i, logo) {
                formData.append('logo[]', logo);
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
                success: function(data) {
                    $('#dialog-info').modal('hide');
					location.reload();
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
				NAMA_PERUSAHAAN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				EMAIL: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
						regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        }
                    }
                },
				PHONE_1: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				PHONE_2: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				KOTA: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				FAXIMILI: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				NEGARA: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				ALAMAT: {
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
