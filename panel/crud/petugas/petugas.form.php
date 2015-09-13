<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM petugas WHERE KODE_PETUGAS=".$id
    ));
		
    if($id> 0) { 
		$KODE_PETUGAS = $data['KODE_PETUGAS'];
		$NAMA_PETUGAS = $data['NAMA_PETUGAS'];
		$EMAIL = $data['EMAIL'];
		$USERNAME_LOGIN = $data['USERNAME_LOGIN'];
		$PASSWORD_LOGIN = $data['PASSWORD_LOGIN'];
		$STATE_ID = $data['STATE_ID'];
		$AKSES = $data['AKSES'];
    } else {
		$KODE_PETUGAS = "";
		$NAMA_PETUGAS = "";
		$EMAIL = "";
		$USERNAME_LOGIN = "";
		$PASSWORD_LOGIN = "";
		$STATE_ID= "";
		$AKSES= "";
	
    }
?>
<style>
    .green{color: green;}
    .red{color: red;}
</style>
  

<script type="text/javascript">
	$(document).ready(function () {

		$("#USERNAME_LOGIN").change(function () {
			var USERNAME_LOGIN = $(this).val();
			if (USERNAME_LOGIN == '') {
				$("#availability").html("");
			}
			else{
				$.ajax({
					url: "crud/petugas/cekusername.php?uname="+USERNAME_LOGIN
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
<form class="form-horizontal petugasForm" id="petugasForm" action="crud/petugas/petugas.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA_PETUGAS" class="col-sm-3 control-label"> Nama Petugas</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_PETUGAS; ?>" id="NAMA_PETUGAS" name="NAMA_PETUGAS"  \>
				<input type="hidden" class="form-control" value="<?php echo $KODE_PETUGAS; ?>" id="KODE_PETUGAS" name="KODE_PETUGAS"  \>
            </div>
		</div> 
		<div class="form-group">
            <label for="EMAIL" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
				<input type="email" class="form-control" value="<?php echo $EMAIL; ?>" id="EMAIL" name="EMAIL"  \>
		
			</div>
		</div>
		<div class="form-group">
            <label for="USERNAME_LOGIN" class="col-sm-3 control-label">Username Login</label>
            <div class="col-sm-9">
				<input type="text" minlength="5" class="form-control" value="<?php echo $USERNAME_LOGIN; ?>" id="USERNAME_LOGIN" name="USERNAME_LOGIN"  \>
				<div id="availability"></div>
			</div>
		</div>
		<div class="form-group">
            <label for="PASSWORD_LOGIN" class="col-sm-3 control-label">Password Login</label>
            <div class="col-sm-9">
				<input type="password"  minlength="10" class="form-control" value="<?php echo $PASSWORD_LOGIN; ?>" id="PASSWORD_LOGIN" name="PASSWORD_LOGIN"  \>
		
			</div>
		</div>
		<div class="form-group">
            <label for="STATE_ID" class="col-sm-3 control-label">State</label>
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
            <label for="STATE_ID" class="col-sm-3 control-label">Group Akses</label>
             <div class="col-sm-9">
                <?php
                    $result = mysql_query("select * from rights_group");  
                    echo '<select id="AKSES" name="AKSES" style="width: 100%;" class="form-control">';  
                        echo '<option value="">Silahkan Pilih rights_group</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['ID'] . '"';if($AKSES==$row['ID']){echo "selected='selected'";} echo'>' . $row['GROUP_NAME']. '</option>';  
						}  
                    echo '</select>';
				?>
            </div>
		</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
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
                    $('#dialog-petugas').modal('hide');
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
		
				
				NAMA_PETUGAS: {
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
