<?php
    include_once "../../include/koneksi.php";
    session_start();
	error_reporting(0);
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM pinjaman WHERE KODE_PINJAMAN=".$id
    )); 
	
	$pegawai = mysql_fetch_array(mysql_query("
        SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$data['KODE_PEGAWAI']
    ));
	
	$history1 = mysql_fetch_array(mysql_query("SELECT * FROM pembayaran_angsuran WHERE ID_PINJAMAN=".$id ));
	
	if($history1["ID_PEMBAYARAN"]==""){
		$cicilanke=1;
		
	}
	
	if($history1["ID_PEMBAYARAN"]!=""){
		$history = mysql_fetch_array(mysql_query("SELECT count(ID_PEMBAYARAN) as cicilankeberapa FROM pembayaran_angsuran WHERE ID_PINJAMAN=".$id ));
		$totalbayarcicilan=$history["cicilankeberapa"];
		$cicilanke=$totalbayarcicilan+1;
  
		
	}
	
	$nominalpelunasan=$data['SISA_CICILAN'] * $data['CICILAN_PERBULAN'] ;
    
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
					<tr><td>Total pinjaman</td><td>Rp.<?php echo number_format($data["NOMINAL"]); ?></td></tr>
					<tr><td>Lama cicilan</td><td><?php echo $data["JUMLAH_BLN"]; ?> Bulan</td></tr>
					<tr><td>Cicilan per bulan</td><td>Rp.<?php echo number_format($data["CICILAN_PERBULAN"]); ?></td></tr>
					<tr><td>Sisa cicilan</td><td>X<?php echo $data["SISA_CICILAN"]; ?></td></tr>
				</table>
			</div>
		</div>
	</div>
</div>

 <form class="form-horizontal pinjaman2Form" id="pinjaman2Form" action="crud/pinjaman2/pelunasan_pinjaman.input.php" type="POST">
    <div class="modal-body">
	
        <div class="form-group">
            <label for="TANGGAL" class="col-sm-3 control-label">Tanggal</label>
            <div class="col-sm-9">
                <div class="input-group date">
					<input type="hidden" name="NIP_PEGAWAI" value="<?php echo $NIP_PEGAWAI;?>">
					<input type="hidden" name="ID_PINJAMAN" value="<?php echo $KODE_PINJAMAN;?>">
                    <input type="text" class="form-control" id="TANGGAL_PEMBAYARAN" name="TANGGAL_PEMBAYARAN" value="<?php echo date('Y-m-d'); ?>" placeholder="Tanggal" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
		</div>
        <div class="form-group">
            <label for="NOMINAL_PEMBAYARAN" class="col-sm-3 control-label">Nominal Pelunasan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="NOMINAL_PEMBAYARAN" name="NOMINAL_PEMBAYARAN" value="<?php echo $nominalpelunasan; ?>" placeholder="Nominal" readonly/>
            </div>
		</div>  
		<div class="form-group">
            <label for="KET" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="KET" name="KET" value="Pelunasan pembayaran pinjaman" placeholder="Nominal" readonly/>
            </div>
		</div>
	
		<div class="form-group">
            <label for="JML" class="col-sm-3 control-label">Cicilan Ke-</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ANGSURAN_KE" name="ANGSURAN_KE" value="<?php echo  $cicilanke; ?>" placeholder="Jumlah Bulan" readonly/>
            </div>
		</div>

		<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
				</div>
		</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal </button>
        <button type="submit" class="btn btn-success">Proses pembayaran</button>
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
