<?php
    include_once "../../include/koneksi.php";
    session_start();
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM penyesuaian_dana WHERE ID_PENYESUAIAN=".$id
    ));

    if($id> 0) { 
		$ID_PENYESUAIAN = $data['ID_PENYESUAIAN'];
		$KODE_PEGAWAI = $data['KODE_PEGAWAI'];
		$STATUS = $data['STATUS'];
		$NOMINAL = $data['NOMINAL'];
		$BULAN = $data['BULAN'];
		$KETERANGAN = $data['KETERANGAN'];
       
    } else {
		$ID_PENYESUAIAN = "";
		$KODE_PEGAWAI = "";
		$STATUS = "";
        $TUNJANGAN_LAIN = "";
		$NOMINAL = "";
		$BULAN = "";
		$KETERANGAN = "";
    }
?>
	
 <form class="form-horizontal penyesuaian_danaForm" id="penyesuaian_danaForm" action="crud/penyesuaian_dana/penyesuaian_dana.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="KODE_PEGAWAI" class="col-sm-3 control-label">Pegawai</label>
            <div class="col-sm-9">
                 <?php
                  
					$result=mysql_query("SELECT * FROM pegawai") or die (mysql_error());
				
                    echo '<select id="KODE_PEGAWAI" name="KODE_PEGAWAI" style="width: 100%;" class="KODE_PEGAWAI form-control">';  
                        echo '<option value="">Silahkan Pilih Pegawai</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_PEGAWAI'] . '"';if($KODE_PEGAWAI==$row['KODE_PEGAWAI']){echo "selected='selected'";} echo'>'.$row['NIP_PEGAWAI'].' - '.$row['NAMA_PEGAWAI']. '</option>';  
						}  
                    echo '</select>';
				?>
				<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="KODE_KASBON" name="KODE_KASBON"  \>
                <input type="hidden" class="form-control" value="<?php echo $STATUS; ?>" id="STATUS" name="STATUS"  \>
            </div>
		</div>
		<div class="form-group">
            <label for="STATUS" class="col-sm-3 control-label">Status Dana</label>
            <div class="col-sm-9">
				<select id="STATUS" name="STATUS" style="width: 100%;" class="STATUS form-control" required>
				<option value="">--Silahkan Pilih Status--</option>
				<option value="Penambahan" <?php if($STATUS=="Penambahan"){echo "selected='selected'";} ?>>1.Penambahan Dana</option>
				<option value="Pemotongan"  <?php if($STATUS=="Pemotongan"){echo "selected='selected'";} ?>>2.Pemotongan Dana</option>
				</select>
            </div>
		</div>
		<div class="form-group">
            <label for="NOMINAL" class="col-sm-3 control-label">Nominal</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NOMINAL; ?>" id="NOMINAL" name="NOMINAL"  \>
				<input type="hidden" class="form-control" value="<?php echo $ID_PENYESUAIAN; ?>" id="ID_PENYESUAIAN" name="ID_PENYESUAIAN"  \>
            </div>
		</div>
		  <div class="form-group">
            <label for="BULAN" class="col-sm-3 control-label">Bulan</label>
            <div class="col-sm-9">
                <div class="input-group date" id="datePicker">
                    <input type="text" class="form-control" id="BULAN" name="BULAN" value="<?php echo $BULAN; ?>" placeholder="Bulan" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
		</div>
		<div class="form-group">
            <label for="KETERANGAN" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="KETERANGAN" name="KETERANGAN" placeholder="Keterangan"><?php echo $KETERANGAN; ?></textarea>
            </div>
		</div>
		
		<div class="form-group">
            <label for="KETERANGAN" class="col-sm-3 control-label">catatan</label>
            <div class="col-sm-9" style="color:green">
             <b>Pemilihan status penambahan atau pemotongan akan diproses pada saat penggajian pegawai bersangkutan.</b>
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
		$(document).ready(function() {
            $(".KODE_PEGAWAI").select2();
        });
        $('#datePicker').datepicker({
			format: "mm",
			minViewMode: 1,
            autoclose: true,
            todayHighlight: true
		});
		$('#penyesuaian_danaForm')
            .find('[name="TUNJANGAN_LAIN[]"]')
            .select2({dropdownAutoWidth : true, width: "100%"})
            .change(function(e) {
                $('#penyesuaian_danaForm').formValidation('revalidateField', 'TUNJANGAN_LAIN[]');
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
			$('#dialog-penyesuaian_dana').modal('hide');
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
                    STATUS: {
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
                    KODE_PEGAWAI: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            integer: {
                                message: 'The is numeric'
                            },
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
					BULAN: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
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
