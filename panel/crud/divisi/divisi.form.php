<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];
	
    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM divisi WHERE ID=".$id
    ));
		
    if($id> 0) { 
		$ID = $data['ID'];
		$KODE_DEPARTEMEN = $data['KODE_DEPARTEMEN'];
		$NAMA = $data['NAMA'];
	
    } else {
		$ID = $id;
		$KODE_DEPARTEMEN = "";
		$NAMA = "";
    }
?>
	
<form class="form-horizontal petugasForm" id="petugasForm" action="crud/divisi/divisi.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NAMA" class="col-sm-3 control-label"> Divisi</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA; ?>" id="NAMA" name="NAMA"  \>
				<input type="hidden" class="form-control" value="<?php echo $ID; ?>" id="ID" name="ID"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="DEPARTEMEN" class="col-sm-3 control-label"> Departemen</label>
            <div class="col-sm-9">
				<?php
                    $result = mysql_query("select * from departemen");  
                    echo '<select id="KODE_DEPARTEMEN" name="KODE_DEPARTEMEN" class="form-control">';  
                        echo '<option value="">Silahkan Pilih Departemen</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_DEPARTEMEN'] . '"';if($KODE_DEPARTEMEN==$row['KODE_DEPARTEMEN']){echo "selected='selected'";} echo'>' . $row['NAMA_DEPARTEMEN']. '</option>';  
						}  
                    echo '</select>';
				?>
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
                    $('#dialog-divisi').modal('hide');
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
				NAMA: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
                    }
                },
				KODE_DEPARTEMEN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
                    }
                },
            }
        });
    });
</script>
