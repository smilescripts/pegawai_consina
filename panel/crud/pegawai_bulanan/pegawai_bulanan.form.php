<?php
	error_reporting(0);
    include_once "../../include/koneksi.php";
    session_start();
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$id
    ));

    if($id> 0) { 
		$KODE_PEGAWAI = $data['KODE_PEGAWAI'];
		$NIP_PEGAWAI = $data['NIP_PEGAWAI'];
		$NAMA_PEGAWAI = $data['NAMA_PEGAWAI'];
		$TEMPAT_LAHIR = $data['TEMPAT_LAHIR'];
		$EMAIL = $data['EMAIL'];
		$TANGGAL_LAHIR = $data['TANGGAL_LAHIR'];
		$AGAMA = $data['AGAMA'];
		$STATUS_PERNIKAHAN = $data['STATUS_PERNIKAHAN'];
		$JUMLAH_ANAK=$data['JUMLAH_ANAK'];
		$ALAMAT=$data['ALAMAT'];
		$NOMOR_TELEPON=$data['NOMOR_TELEPON'];
		$KODE_JABATAN=$data['KODE_JABATAN'];
		$KODE_DEPARTEMEN=$data['KODE_DEPARTEMEN'];
		$GAJI_POKOK=$data['GAJI_POKOK'];
		$TANGGAL_MASUK=$data['TANGGAL_MASUK'];
		$TANGGAL_KELUAR=$data['TANGGAL_KELUAR'];
		$STATUS_PEGAWAI=$data['STATUS_PEGAWAI'];
		$JENIS_KELAMIN=$data['JENIS_KELAMIN'];
		$FOTO_PEGAWAI=$data['FOTO_PEGAWAI'];
		$NO_REKENING=$data['NO_REKENING'];
		$STATE_ID=$data['STATE_ID'];
		$NOMINAL_UMT=$data['NOMINAL_UMT'];
		$TABUNGAN=$data['TABUNGAN'];
		$PENGHARGAAN=$data['PENGHARGAAN'];
		$CATATAN=$data['CATATAN'];
		$TUNJANGAN_LAIN = $data['TUNJANGAN_LAIN'];
		$NOMINAL_LEMBUR = $data['NOMINAL_LEMBUR'];
		$OUTLET = $data['OUTLET'];
		$STATE_ID = $data['STATE_ID'];
        $tmptunjanganlain=array();
        $tmptunjanganlain=explode(",",$TUNJANGAN_LAIN);
    } else {
			
		$query = "SELECT max(NIP_PEGAWAI) as idMaks FROM pegawai";
		$hasil = mysql_query($query);
		$data  = mysql_fetch_array($hasil);
		$nim = $data['idMaks'];
		$noUrut = (int) substr($nim, 8, 5);
		$noUrut++;
		$char =  date('ym');
		$w = "PG".$state_session."-";
		$NIP_PEGAWAI = ""/* $w.$char . sprintf("%05s", $noUrut) */;

		$NAMA_PEGAWAI = "";
		$TEMPAT_LAHIR = "";
		$TANGGAL_LAHIR = "";
		$EMAIL = "";
		$AGAMA = "";
		$STATUS_PERNIKAHAN = "";
		$JUMLAH_ANAK="";
		$ALAMAT="";
		$NOMOR_TELEPON="";
		$KODE_JABATAN="";
		$KODE_DEPARTEMEN="";
		$GAJI_POKOK="";
		$TANGGAL_MASUK="";
		$TANGGAL_KELUAR="";
		$STATUS_PEGAWAI="";
		$JENIS_KELAMIN="";
		$FOTO_PEGAWAI="";
		$NO_REKENING="";
		$STATE_ID="";
		$NOMINAL_UMT="";
		$TABUNGAN="";
		$PENGHARGAAN="";
		$CATATAN="";
		$TUNJANGAN_LAIN = "";
		$NOMINAL_LEMBUR = "";
		$OUTLET = "";
		$STATE_ID = "";
		$tmptunjanganlain=array();
		$tmptunjanganlain=explode(",",$TUNJANGAN_LAIN);
    }
?>
<style>
    .green{color: green;}
    .red{color: red;}
</style>
  

<script type="text/javascript">
	$(document).ready(function () {

		$("#NIP_PEGAWAI").change(function () {
			var NIP_PEGAWAI = $(this).val();
			if (NIP_PEGAWAI == '') {
				$("#availability").html("");
			}
			else{
				$.ajax({
					url: "crud/pegawai_bulanan/ceknip.php?uname="+NIP_PEGAWAI
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
 <form class="form-horizontal pegawai_bulananForm" id="pegawai_bulananForm" action="crud/pegawai_bulanan/pegawai_bulanan.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
            </div>
		</div>
	
		<div class="form-group">
            <label for="NIP_PEGAWAI" class="col-sm-3 control-label">NIP</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NIP_PEGAWAI; ?>" id="NIP_PEGAWAI" name="NIP_PEGAWAI" required\>
				<div id="availability"></div>
				<input type="hidden" id="KODE_PEGAWAI" name="KODE_PEGAWAI" value="<?php echo $KODE_PEGAWAI; ?>" />
            </div>
		</div>
		<div class="form-group">
            <label for="NAMA_PEGAWAI" class="col-sm-3 control-label">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?php echo $NAMA_PEGAWAI; ?>" id="NAMA_PEGAWAI" name="NAMA_PEGAWAI" \>
            </div>
		</div>
		<div class="form-group">
            <label for="TEMPAT_LAHIR" class="col-sm-3 control-label">Tempat Lahir</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $TEMPAT_LAHIR; ?>" id="TEMPAT_LAHIR" name="TEMPAT_LAHIR" "\>
            </div>
		</div>
		<div class="form-group">
            <label for="TANGGAL_LAHIR" class="col-sm-3 control-label">Tanggal Lahir</label>
            <div class="col-sm-9">
                <div class="input-group date" id="datePicker">
                    <input type="text" class="form-control" id="TANGGAL_LAHIR" name="TANGGAL_LAHIR" value="<?php echo $TANGGAL_LAHIR; ?>" placeholder="Tanggal Lahir" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
		</div>
		<div class="form-group">
            <label for="jk" class="col-sm-3 control-label">Jenis Kelamin</label>
            <div class="col-sm-9">
            	<select name="JENIS_KELAMIN" class="form-control" id="JENIS_KELAMIN" style="width:100%">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="laki-laki" <?php if($JENIS_KELAMIN=="laki-laki"){echo "selected='selected'";}?>>laki-laki</option>
                    <option value="Perempuan" <?php if($JENIS_KELAMIN=="Perempuan"){echo "selected='selected'";}?>>Perempuan</option>
                </select>
            </div>
		</div>	
		<div class="form-group">
            <label for="AGAMA" class="col-sm-3 control-label">Agama</label>
            <div class="col-sm-9">
                <select name="AGAMA" class="form-control" id="AGAMA" style="width:100%">
                    <option value="">Pilih Jenis Agama</option>
                    <option value="Islam" <?php if($AGAMA=="Islam"){echo "selected='selected'";}?>>Islam</option>
                    <option value="Hindhu" <?php if($AGAMA=="Hindhu"){echo "selected='selected'";}?>>Hindhu</option>
                    <option value="Budha" <?php if($AGAMA=="Budha"){echo "selected='selected'";}?>>Budha</option>
                    <option value="Kristen" <?php if($AGAMA=="Kristen"){echo "selected='selected'";}?>>Kristen</option>
                </select>
            </div>
		</div>
		<div class="form-group">
            <label for="STATUS_PERNIKAHAN" class="col-sm-3 control-label">Status Pernikahan</label>
            <div class="col-sm-9">
				<select name="STATUS_PERNIKAHAN" class="form-control" id="STATUS_PERNIKAHAN" style="width:100%">
                    <option value="">Pilih Status Pernikahan</option>
                    <option value="Kawin" <?php if($STATUS_PERNIKAHAN=="Kawin"){echo "selected='selected'";}?>>Kawin</option>
                    <option value="Belum Kawin" <?php if($STATUS_PERNIKAHAN=="Belum Kawin"){echo "selected='selected'";}?>>Belum Kawin</option>
				</select>
			</div>
		</div>
		<div class="form-group">
            <label for="JUMLAH_ANAK" class="col-sm-3 control-label">Jumlah Anak</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $JUMLAH_ANAK; ?>" id="JUMLAH_ANAK" name="JUMLAH_ANAK" \>
            </div>
		</div>
		<div class="form-group">
            <label for="alamat" class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-9">
				<textarea class="form-control" id="ALAMAT" name="ALAMAT" ><?php echo $ALAMAT; ?></textarea>
            </div>
		</div>
		<div class="form-group">
            <label for="NOMOR_TELEPON" class="col-sm-3 control-label">No Telepon</label>
            <div class="col-sm-9">
            	<input type="text" class="form-control" value="<?php echo $NOMOR_TELEPON; ?>" id="NOMOR_TELEPON" name="NOMOR_TELEPON" \>
            </div>
		</div>
		<div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $EMAIL; ?>" id="EMAIL" name="EMAIL" \>
            </div>
		</div>
		<div class="form-group">
            <label for="KODE_JABATAN" class="col-sm-3 control-label">Jabatan</label>
            <div class="col-sm-9">
                <?php
                    $result = mysql_query("select * from jabatan");  
                    echo '<select id="KODE_JABATAN" name="KODE_JABATAN" style="width: 100%;" class="form-control">';  
                        echo '<option value="">Silahkan Pilih Jabatan</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_JABATAN'] . '"';if($KODE_JABATAN==$row['KODE_JABATAN']){echo "selected='selected'";} echo'>' . $row['NAMA_JABATAN']. '</option>';  
						}  
                    echo '</select>';
				?>
            </div>
		</div>
		<input type="hidden" name="KODE_DEPARTEMEN" value="">
		<!--<div class="form-group">
            <label for="KODE_DEPARTEMEN" class="col-sm-3 control-label">Departemen</label>
            <div class="col-sm-9">
                <?php
/*                     $result = mysql_query("select * from departemen");  
                    echo '<select id="KODE_DEPARTEMEN" name="KODE_DEPARTEMEN" style="width: 100%;" class="form-control">';  
                        echo '<option value="">Silahkan Pilih Departemen</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['KODE_DEPARTEMEN'] . '"';if($KODE_DEPARTEMEN==$row['KODE_DEPARTEMEN']){echo "selected='selected'";} echo'>' . $row['NAMA_DEPARTEMEN']. '</option>';  
						}  
                    echo '</select>'; */
				?>
            </div>
		</div>-->
	
				<input type="hidden" class="form-control" value="TIDAK" id="OUTLET" name="OUTLET" \>
			
		<div class="form-group">
            <label for="GAJI_POKOK" class="col-sm-3 control-label">Gaji Bulanan</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $GAJI_POKOK; ?>" id="GAJI_POKOK" name="GAJI_POKOK" \>
            </div>
		</div>
		<div class="form-group">
            <label for="NOMINAL_UMT" class="col-sm-3 control-label">Nominal UMT</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NOMINAL_UMT; ?>" id="NOMINAL_UMT" name="NOMINAL_UMT"\>
            </div>
		</div>	
		
				<input type="hidden" class="form-control" value="0" id="TABUNGAN" name="TABUNGAN" \>
          
		
				<input type="hidden" class="form-control" value="0" id="PENGHARGAAN" name="PENGHARGAAN" placeholder="Nominal PENGHARGAAN" \>
          	

	
				<input type="hidden" class="form-control" value="0" id="NOMINAL_LEMBUR" name="NOMINAL_LEMBUR" placeholder="Nominal lembur" \>
           
		
		<div class="form-group">
            <label for="TUNJANGAN_LAIN" class="col-sm-3 control-label">Tunjangan Lain</label>
            <div class="col-sm-9">
				<?php
					$result = mysql_query("select * from master_tunjangan");  
                    echo '<select multiple="multiple" style="width:100%" class="form-control select2" name="TUNJANGAN_LAIN[]" id="TUNJANGAN_LAIN" >';  
                    while ($row = mysql_fetch_array($result)) {  
						echo '<option value="' .$row['KODE_MASTER_TUNJANGAN'].'"';
						foreach($tmptunjanganlain as $tmptunjanganlains){
							if($tmptunjanganlains==$row['KODE_MASTER_TUNJANGAN']){
								echo "selected='selected'";
							}; 
						}
						echo'>' . $row['NAMA_TUNJANGAN']. '</option>';  
                    }  
                    echo '</select>';
				?>
            </div>
		</div>
		<div class="form-group">
            <label for="NO_REKENING" class="col-sm-3 control-label">No Rekening</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NO_REKENING; ?>" id="NO_REKENING" name="NO_REKENING"\>
            </div>
		</div>	
		<div class="form-group">
            <label for="TANGGAL_MASUK" class="col-sm-3 control-label">Tanggal Masuk</label>
            <div class="col-sm-9">
                <div class="input-group date" id="datePicker1">
                    <input type="text" class="form-control" id="TANGGAL_MASUK" name="TANGGAL_MASUK" value="<?php echo $TANGGAL_MASUK; ?>"  required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
		</div>
		<div class="form-group">
            <label for="TANGGAL_KELUAR" class="col-sm-3 control-label">Tanggal Keluar</label>
            <div class="col-sm-9">
                <div class="input-group date" id="datePicker2">
                    <input type="text" class="form-control" id="TANGGAL_KELUAR" name="TANGGAL_KELUAR" value="<?php echo $TANGGAL_KELUAR; ?>" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
		</div>
		<div class="form-group">
            <label for="STATUS_PEGAWAI" class="col-sm-3 control-label">Status Pegawai</label>
            <div class="col-sm-9">
				<select name="STATUS_PEGAWAI" class="form-control" id="STATUS_PEGAWAI" style="width:100%">
                 
					<option value="Tetap" <?php if($STATUS_PEGAWAI=="Tetap"){echo "selected='selected'";}?>>1.Bulanan (Office)</option>
                    <option value="Keluar" <?php if($STATUS_PEGAWAI=="Keluar"){echo "selected='selected'";}?>>2.Keluar (Non-Aktif)</option>
                </select>
			</div>
		</div>
		<div class="form-group">
            <label for="STATE_ID" class="col-sm-3 control-label">Lokasi</label>
            <div class="col-sm-9">
                <?php
                    $result = mysql_query("select * from state");  
                    echo '<select id="STATE_ID" name="STATE_ID" style="width: 100%;" class="form-control">';  
                        echo '<option value="">Silahkan Pilih Lokasi</option>';  
						while ($row = mysql_fetch_array($result)) {  
                            echo '<option value="' . $row['STATE_ID'] . '"';if($STATE_ID==$row['STATE_ID']){echo "selected='selected'";} echo'>' . $row['STATE_NAME']. '</option>';  
						}  
                    echo '</select>';
				?>
            </div>
		</div>
        <div class="form-group">
            <label for="foto" class="col-sm-3 control-label">Foto Pegawai</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" id="FOTO_PEGAWAI" name="FOTO_PEGAWAI" value="" multiple\>
            </div>
		</div> 
		<div class="form-group">
            <label for="foto" class="col-sm-3 control-label">Catatan</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="CATATAN" name="CATATAN" ><?php echo $CATATAN; ?></textarea>
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
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
		});
        $('#datePicker1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
		}).on('changeDate', function(e) {
            // Revalidate the date field
            $('#pegawai_bulananForm').formValidation('revalidateField', 'TANGGAL_MASUK');
        });
        $('#datePicker2').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
		});
		
		$('#pegawai_bulananForm')
		.find('[name="TUNJANGAN_LAIN[]"]')
            .select2({dropdownAutoWidth : true, width: "100%"})
            .change(function(e) {
                $('#pegawai_bulananForm').formValidation('revalidateField', 'TUNJANGAN_LAIN[]');
            })
            .end()
		.on('success.form.fv', function(e) {
            e.preventDefault();
            var $form = $(e.target),
            formData = new FormData(),
            params   = $form.serializeArray(),
            files    = $form.find('[name="FOTO_PEGAWAI"]')[0].files;

            $.each(files, function(i, file) {
                formData.append('FOTO_PEGAWAI[]', file);
            });

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });
            
            $.ajax({
                url: $form.attr('action'),
				data: formData,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data) {
                    $('#dialog-pegawai_bulanan').modal('hide');
					//alert(data);
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
		
                NAMA_PEGAWAI: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
                        stringLength: {
                            max: 100,
                            message: 'The must be less than 100 characters'
                        }
                    }
				},
                TEMPAT_LAHIR: {
                    validators: {
                        /* notEmpty: {
                            message: 'The is required'
                        }, */
                        stringLength: {
                            max: 50,
                            message: 'The must be less than 50 characters'
                        }
                    }
				},
		/* TANGGAL_LAHIR: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
		},
                AGAMA: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
		}, */
                STATUS_PERNIKAHAN: {
                    validators: {
                       /*  notEmpty: {
                            message: 'The is required'
                        }, */
                        stringLength: {
                            max: 50,
                            message: 'The must be less than 50 characters'
                        }
                    }
				},
                JUMLAH_ANAK: {
                    validators: {
                       /*  notEmpty: {
                            message: 'The is required'
                        }, */
                        numeric: {
                           message: 'The is numeric'
                        }
                    }
				},
                /* ALAMAT: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
		}, */
                NOMOR_TELEPON: {
                    validators: {
                       /*  notEmpty: {
                            message: 'The is required'
                        }, */
                        stringLength: {
                            max: 20,
                            message: 'The must be less than 20 characters'
                        },
                        numeric: {
                            message: 'The is numeric'
                        }
                    }
				},
                EMAIL: {
                    validators: {
                       /*  notEmpty: {
                            message: 'The is required'
                        }, */
						regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        }
                    }
				},
				KODE_JABATAN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				},
				NIP_PEGAWAI: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				},
				STATE_ID: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				},
               /*  KODE_DEPARTEMEN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				},     */
				/* NO_REKENING: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				}, */
                GAJI_POKOK: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
                        integer: {
                            message: 'The is numeric'
                        }
                    }
				},
               
                STATUS_PEGAWAI: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				},
                /* JENIS_KELAMIN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
		}, */
                FOTO_PEGAWAI: {
                    validators: {
						file: {
                            extension: 'jpeg,png,jpg',
                            type: 'image/jpeg,image/png,image/jpg',
                            maxSize: 2097152,   // 2048 * 1024
                            message: 'The selected file is not valid'
                        }
                    }
				},
            }
        });
    });
</script>
