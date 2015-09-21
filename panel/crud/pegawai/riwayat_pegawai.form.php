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
<div class="modal-body">	
<table class="tg" style="undefined;table-layout: fixed; width: 346px">
<colgroup>
<col style="width:113px">
<col style="width:109px">
<col style="width:124px">
</colgroup>
  <tr>
    <th class="tg-hy62" rowspan="4"><?php  echo '<img src="foto/pegawai/'.$FOTO_PEGAWAI.'" style="width:50px">'; ?></th>
    <th class="tg-031e">NIP</th>
    <th class="tg-031e"></th>
  </tr>
  <tr>
    <td class="tg-4eph">NAMA</td>
    <td class="tg-4eph"></td>
  </tr>
  <tr>
    <td class="tg-031e">JABATAN</td>
    <td class="tg-031e"></td>
  </tr>
  <tr>
    <td class="tg-4eph">DEPARTEMEN</td>
    <td class="tg-4eph"></td>
  </tr>
</table>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup Halaman</button>
     
    </div>

</div>
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
            $('#petugasForm').formValidation('revalidateField', 'TANGGAL_MASUK');
        });
        $('#datePicker2').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
		});
		
		$('#petugasForm')
		.find('[name="TUNJANGAN_LAIN[]"]')
            .select2({dropdownAutoWidth : true, width: "100%"})
            .change(function(e) {
                $('#jabatanForm').formValidation('revalidateField', 'TUNJANGAN_LAIN[]');
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
                    $('#dialog-pegawai').modal('hide');
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
                KODE_DEPARTEMEN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        }
                    }
				},    
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
