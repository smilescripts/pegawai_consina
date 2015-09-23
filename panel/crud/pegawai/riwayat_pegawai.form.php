<?php
	error_reporting(0);
    include_once "../../include/koneksi.php";
    session_start();
	$state_session=$_SESSION['STATE_ID'];
    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM pegawai WHERE KODE_PEGAWAI=".$id
    ));

		
		$KODE_PEGAWAI = $data['KODE_PEGAWAI'];
		$NIP_PEGAWAI = $data['NIP_PEGAWAI'];
		$NAMA_PEGAWAI = $data['NAMA_PEGAWAI'];
		$KODE_JABATAN=$data['KODE_JABATAN'];
		$KODE_DEPARTEMEN=$data['KODE_DEPARTEMEN'];
		$FOTO_PEGAWAI=$data['FOTO_PEGAWAI'];
		$queryjabatan=mysql_query("SELECT * FROM jabatan WHERE KODE_JABATAN=".$KODE_JABATAN) or die (mysql_error());
        $tampiljabatan=mysql_fetch_object($queryjabatan);
        $querydepartemen=mysql_query("SELECT * FROM departemen WHERE KODE_DEPARTEMEN=".$KODE_DEPARTEMEN) or die (mysql_error());
		$tampildepartemen=mysql_fetch_object($querydepartemen);
 ?>
<div class="modal-body">
<div class="row">
  <div class="col-md-6">
 <div style="height:200px;overflow-y:auto;overflow-x: hidden;">
<table class="tg" style="undefined;table-layout: fixed; width: 346px">
<colgroup>
<col style="width:113px">
<col style="width:209px">
<col style="width:250px">
</colgroup>
  <tr>
    <th class="tg-hy62" rowspan="4">
	<?php if($FOTO_PEGAWAI!=""){
          echo '<img src="foto/pegawai/'.$FOTO_PEGAWAI.'" style="width:50px">';
           }else{
          echo '<img src="user.png" style="width:100px">';
          }?></th>
    <th class="tg-031e">NIP</th>
    <th class="tg-031e"><?php echo $NIP_PEGAWAI;?></th>
  </tr>
  <tr>
    <td class="tg-4eph">NAMA</td>
    <td class="tg-4eph"><?php echo $NAMA_PEGAWAI;?></td>
  </tr>
  <tr>
    <td class="tg-031e">JABATAN</td>
    <td class="tg-031e"><?php echo $tampiljabatan->NAMA_JABATAN;?></td>
  </tr>
  <tr>
    <td class="tg-4eph">DEPARTEMEN</td>
    <td class="tg-4eph"><?php echo $tampildepartemen->NAMA_DEPARTEMEN;?></td>
  </tr>
</table>
</div>
<hr/>
<p><b>Data Cuti / Izin</b></p>
 <div style="height:200px;overflow-y:auto">

    <table id="example" class="table table-bordered">
		<thead>
            <tr>
				<th>No</th>
				
                <th>Keterangan</th>
				<th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
              
            </tr>
		</thead>
		
		<tbody>
	
		<?php
			
			$querycuti=mysql_query("SELECT * FROM cuti WHERE NIP_PEGAWAI=".$KODE_PEGAWAI) or die (mysql_error());
			
            $no = 1;
            
			while($objectdatacuti=mysql_fetch_object($querycuti)){
                echo'
				<tr>
				<td>'.$no.'</td>
				 <td>'.$objectdatacuti->KETERANGAN.'</td>
                <td>'.$objectdatacuti->TANGGAL_AWAL.'</td>
                <td>'.$objectdatacuti->TANGGAL_AKHIR.'</td>
				
            </tr>';
                $no++;
            }
		?>
		
		</tbody>
		
    </table>
	</div>
<hr/>
<p><b>Data Tabungan</b></p>
 <div style="height:200px;overflow-y:auto">

    <table id="example" class="table table-bordered">
		<thead>
            <tr>
				<th>No</th>
				<th>Nominal</th>
				<th>Tanggal Nabung</th>
               
              
            </tr>
		</thead>
		<tbody>
		<?php
			
			$querytabungan=mysql_query("SELECT sum(NOMINAL) as jmltabungan,TANGGAL FROM tabungan where NIP='$KODE_PEGAWAI' group by MONTH(TANGGAL) ") or die (mysql_error());
			
            $no = 1;
            
			while($objectdatatabungan=mysql_fetch_object($querytabungan)){
             
                echo'
				<tr>
				<td>'.$no.'</td>
				 <td>Rp.'.number_format($objectdatatabungan->jmltabungan).'</td>
                <td>'.$objectdatatabungan->TANGGAL.'</td>
               
            </tr>';
                $no++;
            }
		?>
		</tbody>
    </table>
</div>
</div>
 <div class="col-md-6">
  <p><b>Data Kasbon</b></p>
 <div style="height:170px;overflow-y:auto">

 <table id="example" class="table table-bordered">
		<thead>
            <tr>
                <th>No</th>
				<th>Tanggal</th>
				<th>Nominal</th>
                <th>Status</th>
               
				
            </tr>
		</thead>
		<tbody>
		<?php
			$querykasbon=mysql_query("SELECT * FROM kasbon_pegawai WHERE NIP_PEGAWAI='$KODE_PEGAWAI'  order by TANGGAL DESC") or die (mysql_error());
			
            $no = 1;
			while($objectdatakasbon=mysql_fetch_object($querykasbon)){
            echo'
            <tr>
				<td>'.$no.'</td>
				<td>'.$objectdatakasbon->TANGGAL.'</td>
                <td>Rp.'.number_format($objectdatakasbon->NOMINAL).',-</td>
                <td>'.$objectdatakasbon->STATUS.'</td>
            </tr>';
                $no++;
            }
			
		?>
		</tbody>
    </table>
	</div>
<hr/>
<p><b>Data Pinjaman</b></p>
 <div style="height:200px;overflow-y:auto">

   <table id="example" class="table table-bordered">
		<thead>
            <tr>
			
				<th>No</th>
				<th>Tanggal</th>
				<th>Nominal</th>
				<th>Jumlah</th>
				<th>Cicilan/Bulan</th>
				<th>Sisa</th>
				
            </tr>
		</thead>
		<tbody>
		<?php
			
			$querypinjaman=mysql_query("SELECT * FROM pinjaman  where KODE_PEGAWAI='$KODE_PEGAWAI' order by TANGGAL DESC") or die (mysql_error());
		
            $no = 1;
           
			while($objectdatapinjaman=mysql_fetch_object($querypinjaman)){
              
                echo'
				<tr>
				<td>'.$no.'</td>
				<td>'.$objectdatapinjaman->TANGGAL.'</td>
                <td>'.number_format($objectdatapinjaman->NOMINAL).',-</td>
                <td>'.$objectdatapinjaman->JUMLAH_BLN.' Bulan</td>
               
                 <td>Rp.'.number_format($objectdatapinjaman->CICILAN_PERBULAN).',-</td>
                 <td>X '.$objectdatapinjaman->SISA_CICILAN.'</td>
				
				
            </tr>';
                $no++;
            }
		?>
		</tbody>
    </table>
	</div>
	<hr/>
	<p><b>Data Penggajian</b></p>
	 <div style="height:200px;overflow-y:auto">
  
    <table id="example" class="table table-bordered">
		<thead>
            <tr>
				<th>No</th>
				
                <th>Bulan</th>
                <th>Total Pemotongan</th>
				<th>Total Penerimaan</th>
                <th>Take home pay</th>
              
            </tr>
		</thead>
		<tbody>
		<?php
			 $no = 1;
            
                $querypegawai11=mysql_query("SELECT * FROM head_penggajian WHERE kode_pegawai='$KODE_PEGAWAI' group by bulan ") or die (mysql_error());
				 while($objectdata=mysql_fetch_object($querypegawai11)){
                echo'
				<tr>
				<td>'.$no.'</td>
				 <td>'.$objectdata->bulan.'</td>
				 <td>Rp.'.$objectdata->total_potongan.'</td>
                <td>Rp.'.$objectdata->total_penerimaan.'</td>
                <td>Rp.'.number_format($objectdata->thp).'</td>
				
            </tr>';
                $no++;
            }
		?>
		</tbody>
    </table>
	</div>
	<hr/>
	  <p><b>Data Penyesuaian Dana</b></p>
	 <div style="height:200px;overflow-y:auto">

    <table id="example" class="table table-bordered">
		<thead>
            <tr>
				<th>No</th>
				<th>Nominal</th>
                <th>Bulan</th>
				<th>Status</th>
               
            </tr>
		</thead>
		<tbody>
		<?php
			 $no = 1;
            
                $querypenyesuaiandana=mysql_query("SELECT sum(NOMINAL) as totpen,BULAN,STATUS FROM penyesuaian_dana WHERE kode_pegawai='$KODE_PEGAWAI' group by bulan,STATUS") or die (mysql_error());
				 while($objectdatapenyesuaiandana=mysql_fetch_object($querypenyesuaiandana)){
                echo'
				<tr>
				<td>'.$no.'</td>
				<td>Rp.'.number_format($objectdatapenyesuaiandana->totpen).'</td>
				<td>'.$objectdatapenyesuaiandana->BULAN.'</td>
                <td>'.$objectdatapenyesuaiandana->STATUS.'</td>
              
				
            </tr>';
                $no++;
            }
		?>
		</tbody>
    </table>
  
 </div>
 </div>
</div>	
    <div class="modal-footer" style="margin-top:20px">
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
