<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM absensi WHERE KODE_ABSENSI=".$id
    ));

    if($id> 0) { 
		$KODE_ABSENSI = $data['KODE_ABSENSI'];
		$KODE_JAM_KERJA = $data['KODE_JAM_KERJA'];
		$NIP_PEGAWAI = $data['NIP_PEGAWAI'];
        $TANGGAL = $data['TANGGAL'];
        $JAM_MASUK = $data['JAM_MASUK'];
        $JAM_KELUAR = $data['JAM_KELUAR'];
    } else {
		$KODE_ABSENSI = "";
		$KODE_JAM_KERJA = "";
		$NIP_PEGAWAI = "";
        $TANGGAL = date("Y-m-d");
        $JAM_MASUK = "";
        $JAM_KELUAR = "";
    }
?>
	
 <form class="form-horizontal absensiForm" id="absensiForm" action="crud/absensi/absensi.input.php" type="POST">
    <div class="modal-body">
        <div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label"> Nama Pegawai</label>
            <div class="col-sm-9">
                <?php
                    $result = mysql_query("select * from pegawai");  
                    echo '<select id="NIP_PEGAWAI" name="NIP_PEGAWAI" style="width: 100%;" class="NIP_PEGAWAI form-control ">';  
                    echo '<option value="">Silahkan Pilih Pegawai</option>';  
			
					while ($row = mysql_fetch_array($result)) {  
                        echo '<option value="' . $row['NIP_PEGAWAI'] . '"';if($NIP_PEGAWAI==$row['NIP_PEGAWAI']){echo "selected='selected'";} echo'>'.$row['NIP_PEGAWAI'].' - '.$row['NAMA_PEGAWAI']. '</option>';  
					}  
                    echo '</select>';
				?>
				<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="KODE_ABSENSI" name="KODE_ABSENSI"  \>
            </div>
		</div>
        <div class="form-group">
            <label for="TANGGAL" class="col-sm-3 control-label">Tanggal</label>
			<div class="col-sm-9">
				<div class="input-group date" id="datePicker">
					<input type="text" class="form-control" id="TANGGAL" name="TANGGAL" value="<?php echo $TANGGAL; ?>" placeholder="Tanggal" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
				</div>
			</div>
		</div>
        <div class="form-group">
            <label for="JAM_MASUK" class="col-sm-3 control-label">Jam Masuk</label>
            <div class="col-sm-4">
                <div class="input-group bootstrap-timepicker">
                    <input type="text" class="form-control" value="<?php echo $JAM_MASUK; ?>" id="JAM_MASUK" name="JAM_MASUK" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-time"></i></span>
				</div>
            </div>
		</div>
        <div class="form-group">
            <label for="JAM_KELUAR" class="col-sm-3 control-label">Jam Keluar</label>
            <div class="col-sm-4">
                <div class="input-group bootstrap-timepicker">
                    <input type="text" class="form-control" value="<?php echo $JAM_KELUAR; ?>" id="JAM_KELUAR" name="JAM_KELUAR" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-time"></i></span>
				</div>
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
        $(document).ready(function() {
            $(".NIP_PEGAWAI").select2();
        });
        $('#datePicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
		});
        $('#JAM_MASUK').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            modalBackdrop: false,
            showSeconds: false,
            showMeridian: false
		});
        $('#JAM_KELUAR').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            modalBackdrop: false,
            showSeconds: false,
            showMeridian: false
		});
		$('#absensiForm')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(result) {
			$('#dialog-absensi').modal('hide');
                    }
                });
            })
            .formValidation({
                message: 'This value is not valid',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    NIP_PEGAWAI: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    TANGGAL: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    JAM_MASUK: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    JAM_KELUAR: {
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
