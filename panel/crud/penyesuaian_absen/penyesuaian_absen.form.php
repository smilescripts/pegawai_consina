<?php
	//error_reporting(0);
    include_once "../../include/koneksi.php";
    session_start();
 
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];
	
    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM penyesuaian_absensi WHERE ID=".$id
    ));
		
    if($id> 0) { 
		$ID = $data['ID'];
		$KODE_PEGAWAI = $data['KODE_PEGAWAI'];
		$BULAN = $data['BULAN'];
		$TAHUN = $data['TAHUN'];
		$KODE_PETUGAS = $data['KODE_PETUGAS'];

    } else {
		$ID = "";
		$KODE_PEGAWAI = "";
		$BULAN = "";
		$TAHUN = date("Y");
		$TANGGAL_AKSES = "";
		$KODE_PETUGAS = "";
	
	}
?>
<style>
   
    .green{color: green;}
    .red{color: red;}
</style>
<script>

	/* $(function(){ // sama dengan $(document).ready(function(){

		$('#JUMLAH_PENYESUAIAN_ABSEN').change(function(){

			$('#detail1').html("<img src='crud/penyesuaian_absen/ajax-loader.gif'>"); //Menampilkan loading selama proses pengambilan data kota

			var id = $(this).val();//Mengambil id provinsi

			$.get("crud/penyesuaian_absen/detail.php", {id1:id}, function(data){
				$('#detail1').html(data);
			});
		});
		
	});
 */
</script>
<script type="text/javascript">
	$(document).ready(function () {

		$("#BULAN").change(function () {
			var BULAN = $(this).val();
			var TAHUN = $("#TAHUN").val();
			//alert(TAHUN);
			if (BULAN == '') {
				$("#availability").html("");
			}
			else{
				$.ajax({
				url: "crud/penyesuaian_absen/cekhgaji.php?bulan="+BULAN+"&tahun="+TAHUN
				}).done(function( data ) {
					$("#availability").html(data["dtck"]);
					$("#availability1").html(data["dtck"]);
					var verifikasi=data["verifikasi"];
					if(verifikasi!="yes"){
					
						document.getElementById("simpan").disabled = true;		
						
					}
				});  
		
			} 
		});
		$("#TAHUN").change(function () {
			var TAHUN = $(this).val();
			var BULAN = $("#BULAN").val();
			if (TAHUN == '') {
				$("#availability").html("");
			}
			else{
				$.ajax({
				url: "crud/penyesuaian_absen/cekhgaji.php?bulan="+BULAN+"&tahun="+TAHUN
				}).done(function( data ) {
					$("#availability").html(data["dtck"]);
					$("#availability1").html(data["dtck"]);
					var verifikasi=data["verifikasi"];
					if(verifikasi!="yes"){
					
						document.getElementById("simpan").disabled = true;		
						
					}
				});  
		
			} 
		});
	});
</script>
<form class="form-horizontal penyesuaian_absenForm" id="penyesuaian_absenForm" action="crud/penyesuaian_absen/penyesuaian_absen.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
		<input type="hidden" class="form-control" value="<?php echo $ID; ?>" id="ID" name="ID"  \>
		<div class="form-group">
            <label for="KODE_PEGAWAI" class="col-sm-3 control-label">Pegawai</label>
            <div class="col-sm-9">
				<?php
                    if($_SESSION['AKSES']==43){
						$result=mysql_query("SELECT * FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak'") or die (mysql_error());
					}else if($_SESSION['AKSES']==44){
						$result=mysql_query("SELECT * FROM pegawai WHERE STATUS_PEGAWAI='Tetap'") or die (mysql_error());
					}else{
						$result=mysql_query("SELECT * FROM pegawai") or die (mysql_error());
					}
                    echo '<select id="KODE_PEGAWAI" name="KODE_PEGAWAI" style="width: 100%;" class="KODE_PEGAWAI form-control">';  
                        echo '<option value="">Silahkan Pilih Pegawai</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_PEGAWAI'] . '"';if($KODE_PEGAWAI==$row['KODE_PEGAWAI']){echo "selected='selected'";} echo'>'.$row['NIP_PEGAWAI'].' - '.$row['NAMA_PEGAWAI']. '</option>';  
						}  
                    echo '</select>';
				?>
            </div>
		</div>
		
		<div class="form-group">
			<label for="bulan" class="col-sm-3 control-label">Bulan</label>
			<div class="col-sm-9">
			  <div class="input-group date" id="datePicker1">
				<input type="text" class="form-control" id="BULAN" name="BULAN" value="<?php echo $BULAN;?>" placeholder="Bulan" readonly ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			  </div>
			  <div id="availability"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="tahun" class="col-sm-3 control-label">Tahun</label>
			<div class="col-sm-9">
			  <div class="input-group date" id="datePicker">
				<input type="text" class="form-control" id="TAHUN" name="TAHUN" value="<?php echo $TAHUN;?>" placeholder="Tahun" readonly ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			  </div>
			  <div id="availability1"></div>
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
		$('#datePicker').datepicker({
			format: "yyyy",
			startView: 2,
			minViewMode: 2,
			autoclose: true
		})
		.on('changeDate', function(e) {
            // Revalidate the date field
            $('#penyesuaian_absenForm').formValidation('revalidateField', 'TAHUN');
        });
		
		$('#datePicker1').datepicker({
			format: "mm",
			minViewMode: 1,
			autoclose: true
		})
		.on('changeDate', function(e) {
            // Revalidate the date field
            $('#penyesuaian_absenForm').formValidation('revalidateField', 'BULAN');
        });
		 $(document).ready(function() {
            $(".KODE_PEGAWAI").select2();
        }); 
		
		$('#penyesuaian_absenForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                    $('#dialog-penyesuaian_absen').modal('hide');
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
				KODE_PEGAWAI: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				BULAN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
                },
				TAHUN: {
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
