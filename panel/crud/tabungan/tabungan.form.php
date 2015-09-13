<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
    $id = $_POST['id'];
	
	$data = mysql_fetch_array(mysql_query("
        SELECT * FROM tabungan WHERE NIP=".$id
    ));
		
    if($id> 0) { 
		$ID_PENGAMBILAN = $data['ID'];
		$NIP_PEGAWAI = $data['NIP'];
		$ID_PETUGAS = $data['KODE_PETUGAS'];
		$TANGGAL_PENGAMBILAN = $data['TANGGAL'];
		$NOMINAL_PENGAMBILAN = $data['NOMINAL'];
		$KETERANGAN = $data['KETERANGAN'];
	
    } else {
		$NIP_PEGAWAI = "";
		$ID_PETUGAS = "";
		$TANGGAL_PENGAMBILAN = "";
		$NOMINAL_PENGAMBILAN = "";
		$KETERANGAN = "";
	}
	$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$ID_PETUGAS'"));
	$tabungan=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL) as totaltabungan FROM tabungan where NIP='$NIP_PEGAWAI'"));
	$pengambilantab=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL_PENGAMBILAN) as totalpengambilanpeg FROM pengambilan_tabungan where NIP_PEGAWAI='$NIP_PEGAWAI'"));
	$totalsubnya=$tabungan->totaltabungan-$pengambilantab->totalpengambilanpeg;
	
?>
<style>
    .green{color: green;}
    .red{color: red;}
</style>

<script type="text/javascript">
	$(document).ready(function () {

		$("#NOMINAL_PENGAMBILAN").change(function () {
			var NOMINAL_PENGAMBILAN = $(this).val();
			var NOMINAL_TABUNGAN = $(this).val();
			if (NOMINAL_PENGAMBILAN == '') {
				$("#availability").html("");
			}
			else{
				$.ajax({
					url: "crud/tabungan/cek.php?NOMINAL_PENGAMBILAN="+NOMINAL_PENGAMBILAN+"&NOMINAL_TABUNGAN="+NOMINAL_TABUNGAN
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
<form class="form-horizontal petugasForm" id="petugasForm" action="crud/tabungan/tabungan.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
		
		
		<div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label">NIP Pegawai</label>
            <div class="col-sm-9">
				<input type="text" readonly class="form-control" value="<?php echo $pegawai->NIP_PEGAWAI; ?>" \>
			
            </div>
		</div>
		<div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label">Pegawai</label>
            <div class="col-sm-9">
				<input type="text" readonly class="form-control" value="<?php echo $pegawai->NAMA_PEGAWAI; ?>" \>
				<input type="hidden" readonly class="form-control" value="<?php echo $NIP_PEGAWAI; ?>" id="NIP_PEGAWAI" name="NIP_PEGAWAI"  \>
            </div>
		</div>
        <div class="form-group">
            <label for="TANGGAL_PENGAMBILAN" class="col-sm-3 control-label">Tanggal pengambilan</label>
            <div class="col-sm-9">
				<input type="text" readonly class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" id="TANGGAL_PENGAMBILAN" name="TANGGAL_PENGAMBILAN"  \>
			
            </div>
		</div> 
		<div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label">Total tabungan S/d saat ini</label>
            <div class="col-sm-9">
				<input type="text" readonly class="form-control" id="NOMINAL_TABUNGAN" name="NOMINAL_TABUNGAN" value="<?php echo $totalsubnya; ?>" \>
			
            </div>
		</div>
	
		<div class="form-group">
            <label for="NOMINAL_PENGAMBILAN" class="col-sm-3 control-label">Nominal pengambilan</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="" id="NOMINAL_PENGAMBILAN" placeholder="Rp." name="NOMINAL_PENGAMBILAN"  \>
				<div id="availability"></div>
            </div>
			 
		</div>
	
		
		<div class="form-group">
            <label for="KETERANGAN" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-9">
				<textarea  class="form-control"  id="KETERANGAN" name="KETERANGAN"  \></textarea>
			
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
                    $('#dialog-tabungan').modal('hide');
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
                        },
                        stringLength: {
                            max: 50,
                            message: 'The must be less than 50 characters'
                        }
                    }
                },
				NOMINAL_PENGAMBILAN: {
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
