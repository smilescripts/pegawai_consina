<?php
    include_once "../../include/koneksi.php";
    session_start();
	
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM pinjaman WHERE KODE_PINJAMAN=".$id
    )); 
	
	$pegawai = mysql_fetch_array(mysql_query("
        SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$data['KODE_PEGAWAI']
    ));

    if($id> 0) { 
		$KODE_PINJAMAN = $data['KODE_PINJAMAN'];
		$NIP_PEGAWAI = $data['KODE_PEGAWAI'];
		$TANGGAL = $data['TANGGAL'];
		$NOMINAL = $data['NOMINAL'];
		$JUMLAH_BLN = $data['JUMLAH_BLN'];
		$KETERANGAN = $data['KETERANGAN'];
		$STATUS = $data['STATUS'];
		$CICILAN_PERBULAN = $data['CICILAN_PERBULAN'];
    } else {
		$KODE_PINJAMAN = "";
		$NIP_PEGAWAI = "";
		$TANGGAL = date("Y-m-d");
        $NOMINAL = "";
        $JUMLAH_BLN = "";
        $KETERANGAN = "";
        $STATUS = "";
    }
?>
<div class="col-md-12">
	<div class="panel panel-warning">
		<div class="panel-body">
			<div style="padding: 10px 10px 10px;">
				Keterangan Peminjaman
			</div>
			<div class="well">
				<table id="example" class="table table-bordered">
					<tr><td>NIP</td><td><?php echo $NIP_PEGAWAI; ?></td></tr>
					<tr><td>Nama</td><td><?php echo $pegawai["NAMA_PEGAWAI"]; ?></td></tr>
					<tr><td>Tanggal pinjaman</td><td><?php echo $data["TANGGAL"]; ?></td></tr>
					<tr><td>Total pinjaman</td><td>Rp.<?php echo number_format($data["NOMINAL"]); ?></td></tr>
					<tr><td>Lama cicilan</td><td><?php echo $data["JUMLAH_BLN"]; ?> Bulan</td></tr>
					<tr><td>Cicilan per bulan</td><td>Rp.<?php echo number_format($data["CICILAN_PERBULAN"]); ?></td></tr>
					<tr><td>Sisa cicilan</td><td>X<?php echo $data["SISA_CICILAN"]; ?></td></tr>
				</table>
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal </th>
							<th>Nominal </th>
							<th>Angsuran Ke-</th>
							<th>Petugas</th>
						
						</tr>
					</thead>
					<tbody>
					<?php
						$query=mysql_query("SELECT * FROM pembayaran_angsuran where ID_PINJAMAN='$id'") or die (mysql_error());
						$no = 1;
						
						while($objectdata=mysql_fetch_object($query)){
							$query1=mysql_query("SELECT * FROM petugas where KODE_PETUGAS='$objectdata->PETUGAS'") or die (mysql_error());
							$objectdata1=mysql_fetch_object($query1);
							echo'
						<tr>
							<td>'.$no.'</td>
							<td>'.$objectdata->TANGGAL_PEMBAYARAN.'</td>
							<td>'.number_format($objectdata->NOMINAL_PEMBAYARAN).'</td>
							<td>'.$objectdata->ANGSURAN_KE.'</td>
							<td>'.$objectdata1->NAMA_PETUGAS.'</td>
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
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup Halaman </button>
       
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
		$('#pinjaman2Form')
            .on('success.form.fv', function(e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv    = $form.data('formValidation');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function() {
						$('#dialog-pinjaman2').modal('hide');
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
                    TANGGAL: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            }
                        }
                    },
                    NOMINAL: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            numeric: {
                                message: 'The is numeric'
                            }
                        }
                    },
					JUMLAH_BLN: {
                        validators: {
                            notEmpty: {
                                message: 'The is required'
                            },
                            numeric: {
                                message: 'The is numeric'
                            }
                        }
                    },
                    KETERANGAN: {
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
