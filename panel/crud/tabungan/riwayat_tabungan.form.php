<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
    $id = $_POST['id'];
	
    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM tabungan WHERE NIP=".$id
    ));
		
    if($id> 0) { 
		$ID_PENGAMBILAN = $data['ID_PENGAMBILAN'];
		$NIP_PEGAWAI = $data['NIP'];
		$ID_PETUGAS = $data['KODE_PETUGAS'];
		$TANGGAL_PENGAMBILAN = $data['TANGGAL_PENGAMBILAN'];
		$NOMINAL_PENGAMBILAN = $data['NOMINAL_PENGAMBILAN'];
		$KETERANGAN = $data['KETERANGAN'];
	
    } else {
		$NIP_PEGAWAI = "";
		$ID_PETUGAS = "";
		$TANGGAL_PENGAMBILAN = "";
		$NOMINAL_PENGAMBILAN = "";
		$KETERANGAN = "";
	
	
    }
	$pegawai=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$NIP_PEGAWAI'"));
	$petugas=mysql_fetch_object(mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$ID_PETUGAS'"));
	$pengambilantab=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL_PENGAMBILAN) as totalpengambilanpeg FROM pengambilan_tabungan where NIP_PEGAWAI='$NIP_PEGAWAI'"));
	$tabungan=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL) as totaltabungan FROM tabungan where NIP='$NIP_PEGAWAI'"));
?>
<div class="col-md-12">
	<div class="panel panel-warning">
		<div class="panel-body">
	
			<div class="well">
				<table id="example" class="table table-bordered">
					<tr><td>NIP</td><td><?php echo $pegawai->NIP_PEGAWAI; ?></td></tr>
					<tr><td>Nama</td><td><?php echo $pegawai->NAMA_PEGAWAI; ?></td></tr>
					<tr><td>Total Pengambilan tabungan S/d Sekarang</td><td>Rp.<?php echo number_format($pengambilantab->totalpengambilanpeg); ?></td></tr>
					<tr><td>Total Tabungan S/d Sekarang</td><td>Rp.<?php echo number_format($tabungan->totaltabungan); ?></td></tr>
					<tr><td>Sub-Total Tabungan S/d Sekarang</td><td>Rp.<?php echo number_format($tabungan->totaltabungan-$pengambilantab->totalpengambilanpeg); ?></td></tr>
					
				</table>
				
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal  </th>
							<th>Nominal </th>
							<th>keterangan</th>
							<th>Petugas</th>
					
						</tr>
					</thead>
					<tbody>
					<?php
						$query=mysql_query("SELECT * FROM pengambilan_tabungan where NIP_PEGAWAI='$NIP_PEGAWAI'") or die (mysql_error());
						$no = 1;
					
						while($objectdata=mysql_fetch_object($query)){
					
							echo'
						<tr>
							<td>'.$no.'</td>
							<td>'.$objectdata->TANGGAL_PENGAMBILAN.'</td>
							<td>Rp.'.number_format($objectdata->NOMINAL_PENGAMBILAN).'</td>
							<td>'.$objectdata->KETERANGAN.'</td>
							<td>'.$petugas->NAMA_PETUGAS.'</td>
						</tr>';
							$no++;
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

 <form class="form-horizontal pinjaman2Form" id="pinjaman2Form" action="crud/pinjaman2/bayar_pinjaman.input.php" type="POST">
    <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" aria-hidden="true">Tutup Halaman </button>
      
       
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
		 $(document).ready(function() {
            $(".NIP_PEGAWAI").select2();
        });
		
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
