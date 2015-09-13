<?php
    include_once "../../include/koneksi.php";
    session_start();
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM cuti WHERE KODE_CUTI=".$id
    ));

    if($id> 0) { 
		$KODE_CUTI = $data['KODE_CUTI'];
		$NIP_PEGAWAI = $data['NIP_PEGAWAI'];
		$KETERANGAN = $data['KETERANGAN'];
        $TANGGAL_AWAL = $data['TANGGAL_AWAL'];
        $TANGGAL_AKHIR = $data['TANGGAL_AKHIR'];
        $STATUS = $data['STATUS'];
    } else {
		$KODE_CUTI = "";
		$NIP_PEGAWAI = "";
		$KETERANGAN = "";
        $TANGGAL_AWAL = date("Y-m-d");
        $TANGGAL_AKHIR = date("Y-m-d");
        $STATUS = "";
    }
?>
	
 <form class="form-horizontal cutiForm" id="cutiForm" action="crud/cuti/cuti.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label"> Nama Pegawai</label>
            <div class="col-sm-9">
            <?php
                if($_SESSION['AKSES']==43){
					$result=mysql_query("SELECT * FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak'") or die (mysql_error());
				}else if($_SESSION['AKSES']==44){
					$result=mysql_query("SELECT * FROM pegawai WHERE STATUS_PEGAWAI='Tetap'") or die (mysql_error());
				}else{
					$result=mysql_query("SELECT * FROM pegawai") or die (mysql_error());
				}
				
                echo '<select id="NIP_PEGAWAI" name="NIP_PEGAWAI" style="width: 100%;" class="NIP_PEGAWAI form-control ">';  
                echo '<option value="">Silahkan Pilih Pegawai</option>';  
			
				while ($row = mysql_fetch_array($result)) {  
                    echo '<option value="' . $row['KODE_PEGAWAI'] . '"';if($NIP_PEGAWAI==$row['KODE_PEGAWAI']){echo "selected='selected'";} echo'>'.$row['NIP_PEGAWAI'].' - '.$row['NAMA_PEGAWAI']. '</option>';  
				}  
                echo '</select>';
			?>
				<input type="hidden" class="form-control" value="<?php echo $id; ?>" id="KODE_CUTI" name="KODE_CUTI"  \>
				<input type="hidden" class="form-control" value="<?php echo $STATUS; ?>" id="STATUS" name="STATUS"  \>
            </div>
		</div>
        <div class="form-group">
            <label for="KETERANGAN" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="KETERANGAN" name="KETERANGAN" placeholder="Keterangan Cuti"><?php echo $KETERANGAN; ?></textarea>
            </div>
		</div>
        <div class="form-group">
            <label for="TANGGAL" class="col-sm-3 control-label">Tanggal</label>
            <div class="col-sm-9">
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control" value="<?php echo $TANGGAL_AWAL; ?>" name="TANGGAL_AWAL" id="TANGGAL_AWAL" />
                    <span class="input-group-addon">sampai</span>
                    <input type="text" class="input-sm form-control" value="<?php echo $TANGGAL_AKHIR; ?>" name="TANGGAL_AKHIR" id="TANGGAL_AKHIR" />
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
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
		});
		$('#cutiForm')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(result) {
						$('#dialog-izin_absen').modal('hide');
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
                    NIP_PEGAWAI: {
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
