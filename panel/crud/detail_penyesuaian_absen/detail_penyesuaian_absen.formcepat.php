<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];
    $headid = $_POST['headid'];
    $kpeg = $_POST['kpeg'];
	
    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM detail_penyesuaian_absensi WHERE ID_DETAIL_PENYESUAIAN=".$id
    ));
	
	$data2 = mysql_fetch_array(mysql_query("
        SELECT * FROM penyesuaian_absensi WHERE ID=".$headid
    ));
		
    if($id> 0) { 
		$ID_DETAIL_PENYESUAIAN = $data['ID_DETAIL_PENYESUAIAN'];
		$HEAD_ID_PENYESUAIAN = $data['HEAD_ID_PENYESUAIAN'];
		$KODE_PEGAWAI = $data['KODE_PEGAWAI'];
	
    } else {
		$ID_DETAIL_PENYESUAIAN = $id;
		$HEAD_ID_PENYESUAIAN = $headid;
		$JML = "";
		$KODE_PEGAWAI = $kpeg;
    }
?>

<style>
   
    .green{color: green;}
    .red{color: red;}
</style>
<script type="text/javascript">
	/* $(document).ready(function () {

		$("#TANGGAL").change(function () {
			var nip = <?php echo $data2['KODE_PEGAWAI']; ?>;
			var TANGGAL1 = $(this).val();
			var BULAN = <?php echo $data2['BULAN']; ?>;
			var TAHUN = <?php echo $data2['TAHUN']; ?>;
			//alert(nip);
			if (TANGGAL == '') {
				$("#availability6").html("");
			}
			else{
				$.ajax({
				url: "crud/detail_penyesuaian_absen/cktgl.php?tanggal="+TANGGAL1+"&nip="+nip+"&bulan="+BULAN+"&tahun="+TAHUN
				}).done(function( data ) {
					$("#availability6").html(data["dtck"]);
					var verifikasi=data["verifikasi"];
					if(verifikasi!="yes"){
					
						document.getElementById("simpan2").disabled = true;		
						
					}
				});  
		
			} 
		});
	}); */
</script>
	
<form class="form-horizontal petugasForm2" id="petugasForm2" action="crud/detail_penyesuaian_absen/detail_penyesuaian_absen.inputcepat.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
		<input type="hidden" class="form-control" value="<?php echo $ID_DETAIL_PENYESUAIAN; ?>" id="ID_DETAIL_PENYESUAIAN" name="ID_DETAIL_PENYESUAIAN"  \>
		<input type="hidden" class="form-control" value="<?php echo $HEAD_ID_PENYESUAIAN; ?>" id="HEAD_ID_PENYESUAIAN" name="HEAD_ID_PENYESUAIAN"  \>
		<input type="hidden" class="form-control" value="<?php echo $KODE_PEGAWAI; ?>" id="KODE_PEGAWAI" name="KODE_PEGAWAI"  \>
        <div class="form-group">
            <label for="tanggal" class="col-sm-3 control-label"> Periode</label>
            <div class="col-sm-9">
                <div class="input-daterange input-group" id="datepicker">
					<input type="text" class="input-sm form-control" id="start" name="start" readonly />
					<span class="input-group-addon">to</span>
					<input type="text" class="input-sm form-control" id="end" name="end" readonly />
				</div>
            </div>
		</div>
		<div class="form-group">
            <label for="KODE_JAM_KERJA" class="col-sm-3 control-label">Jam Kerja</label>
            <div class="col-sm-9">
                <?php
                    $result = mysql_query("select * from jam_kerja");  
                    echo '<select id="KODE_JAM_KERJA" name="KODE_JAM_KERJA" style="width: 100%;" class="form-control">';  
                        echo '<option value="">Silahkan Pilih Jam Kerja</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_JAM_KERJA'] . '">' . $row['KETERANGAN']. '</option>';  
						}  
                    echo '</select>';
				?>
            </div>
		</div>
		<div class="form-group">
            <label for="tanggal" class="col-sm-3 control-label"> Jumlah Hari</label>
            <div class="col-sm-4">
               <input type="text" class="form-control" value="<?php echo $JML; ?>" id="JML" name="JML" placeholder="Jumlah Hari" \>
            </div>
		</div>
		<div class="form-group">
            <label for="tanggal" class="col-sm-3 control-label"></label>
            <div class="col-sm-8">
               <div id="availability6" class="availability6" style="color:red;"></div>
            </div>
		</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" id="simpan2" class="btn btn-success">Simpan</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
		$('.input-daterange').datepicker({
						format: "yyyy-mm-dd",
						orientation: "top right",
						autoclose: true,
						todayHighlight: true
					}).on('changeDate', function(e) {
						
						$('#petugasForm2').formValidation('revalidateField', 'end');
					});
		$('#petugasForm2')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();
			//alert('tes');
            var $form = $(e.target),
                fv    = $form.data('formValidation');
			//alert("tes");
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
				dataType: "json",
                data: $form.serialize(),
                success: function(html) {
					//alert(html);
					if(html["ket"]=='nol'){
						$("#availability6").html("data absensi pegawai ini tidak perlu penyesuaian");
					}else if(html["ket"]=='lebih'){
						$("#availability6").html("jumlah hari penyesuaian max : "+html["hasil"]);
					}else if(html["ket"]=='ok'){
						$('#dialog-detail_penyesuaian_absen').modal('hide');
					}
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
				JML: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
						integer: {
							message: 'Harap isi dengan angka'
						},
						between: {
							min: 1,
							max: 999,
							message: 'Nilai dimasukkan minimal 1'
						}
                    }
                },
				end: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				KODE_JAM_KERJA: {
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
