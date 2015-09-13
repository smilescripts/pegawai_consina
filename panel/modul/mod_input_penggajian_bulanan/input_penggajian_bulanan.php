<?php
    include_once "../../include/koneksi.php";
    session_start();
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));

	if(date('m')=="01"){$namabulan="Januari";}
	if(date('m')=="02"){$namabulan="Februari";}
	if(date('m')=="03"){$namabulan="Maret";}
	if(date('m')=="04"){$namabulan="April";}
	if(date('m')=="05"){$namabulan="Mei";}
	if(date('m')=="06"){$namabulan="Juni";}
	if(date('m')=="07"){$namabulan="Juli";}
	if(date('m')=="08"){$namabulan="Agustus";}
	if(date('m')=="09"){$namabulan="September";}
	if(date('m')=="10"){$namabulan="Oktober";}
	if(date('m')=="11"){$namabulan="November";}
	if(date('m')=="12"){$namabulan="Desember";}
	
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman master penggajian karyawan bulanan";
	catat($user,$aksi);
?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
</script>

<ol class="breadcrumb">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user"> input_penggajian_bulanan</li>
</ol>



<div class="panel panel-warning">
    <div class="panel-heading">
		<h3 class="panel-title">Input penggajian bulanan</h3>
    </div>
    <div class="panel-body">

        <div class="well">
			<form class="form-inline" id="input_penggajian_bulananForm" action="crud/input_penggajian_bulanan/input_penggajian_bulanan.input.php" type="POST">
				<div class="col-sm-6">
                       <div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" id="start" name="start" readonly />
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" id="end" name="end" readonly />
						</div>
                    </div>

				<button type="submit" class="btn btn-info">Proses penggajian</button>

			</form>
		</div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
		$('.input-daterange').datepicker({
						format: "yyyy-mm-dd",
						orientation: "top right",
						autoclose: true,
						todayHighlight: true
					}).on('changeDate', function(e) {
						// Revalidate the date field
						$('#input_penggajian_bulananForm').formValidation('revalidateField', 'end');
					});
		
		$('#input_penggajian_bulananForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(data) {
					var tipe=data["tipe"];
					var departemen=data["departemen"];
					if(tipe=="SIMPAN"){
					
						alert("Input Data Penggajian berhasil");
					
					}
					if(tipe=="false"){
					
						alert("Maaf Penggajian sudah dilakukan bulan ini");
					
					}
					/* if(tipe!="false" && tipe!="SIMPAN" ){
					
						alert("Maaf data karyawan tidak ditemukan");
					
					} */
					if(tipe=="CETAK"){
						//alert("Hanya Cetak");
						window.open('modul/mod_input_penggajian_bulanan/cetakpdf.php?dept='+departemen);
					
					}
					if(tipe=="CETAKSIMPAN"){
						//alert("Hanya Cetak");
						window.open('modul/mod_input_penggajian_bulanan/cetaksimpanpdf.php?dept='+departemen);
					
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
				end: {
								validators: {
									notEmpty: {
										message: 'The is required'
									}
								}
							},
            }
        })
		.on('success.field.fv', function(e, data) {
			if (data.fv.getSubmitButton()) {
				data.fv.disableSubmitButtons(false);
			}
		});
    });
</script>
<div class="modal fade" id="dialog-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 id="myModalLabel"><img alt='Brand' src='../panel/<?php echo $profil->logo; ?>' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Cetak PDF</h3>
			</div>

			<div id="isi-info" name="isi-info" class="isi-info"></div>
		</div>
	</div>
</div>
           