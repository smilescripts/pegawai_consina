<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM penghargaan WHERE KODE_PENGHARGAAN=".$id
    ));
		
    if($id > 0) { 
		$KODE_PENGHARGAAN = $data['KODE_PENGHARGAAN'];
		$NIP_PEGAWAI = $data['NIP_PEGAWAI'];
		$BULAN = $data['BULAN'];
		$TAHUN = $data['TAHUN'];
		$NOMINAL = $data['NOMINAL'];
		$TANGGAL = $data['TANGGAL'];
		$KETERANGAN = $data['KETERANGAN'];
		$state = "true";
    } 
	else {
		$KODE_PENGHARGAAN ="";
		$NIP_PEGAWAI ="";
		$BULAN = "";
		$TAHUN = "";
		$NOMINAL ="";
		$TANGGAL = "";
		$KETERANGAN ="";

    }
?>
	
<form class="form-horizontal penghargaanForm" id="penghargaanForm" action="crud/penghargaan/penghargaan.input.php" type="POST">
    <div class="modal-body">
        <div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label">Pegawai</label>
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
      
		
			</div>
		</div> 
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Tahun</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="tahun">
                    <input type="text" class="form-control" id="TAHUN" name="TAHUN" value="<?php echo $TAHUN; ?>" placeholder="Tahun" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    <input type="hidden" class="form-control" id="KODE_PENGHARGAAN" name="KODE_PENGHARGAAN" value="<?php echo $KODE_PENGHARGAAN; ?>" >
                    <input type="hidden" class="form-control" id="state" name="state" value="<?php echo $state; ?>" >
				</div>
      
		
			</div>
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Bulan</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="BULAN">
                    <input type="text" class="form-control" id="BULAN" name="BULAN" value="<?php echo $BULAN; ?>" placeholder="Bulan" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
      
		
			</div> 
			
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Tanggal</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="datePicker">
                    <input type="text" class="form-control" id="TANGGAL" name="TANGGAL" value="<?php echo $TANGGAL; ?>" placeholder="Tanggal " readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
      
		
			</div> 
			
		</div>
		<div class="form-group">
            <label for="NOMINAL" class="col-sm-3 control-label">Nominal</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="NOMINAL" name="NOMINAL" placeholder="Rp." value="<?php echo $NOMINAL; ?>">
            </div>
		</div> 
		<div class="form-group">
            <label for="KETERANGAN" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="KETERANGAN" name="KETERANGAN" placeholder=""><?php echo $KETERANGAN; ?></textarea>
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
	
	
		$('#datePicker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			multidate: true,
			todayHighlight: true
		}); 
		$('#tahun').datepicker({
			format: "yyyy",
			autoclose: true,
			multidate: true,
			startView: 2,
			minViewMode: 2,
			todayHighlight: true
		
		});
		$('#BULAN').datepicker({
			format: "mm",
			autoclose: true,
			multidate: true,
			startView: 1,
			minViewMode: 1,
			todayHighlight: true
		
		});
		$('#penghargaanForm')
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                    $('#dialog-penghargaan').modal('hide');
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
				NAMA_conf_penggajian: {
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
