<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM pengaturan_penggajian WHERE ID=".$id
    ));
		
    if($id > 0) { 
		$ID = $data['ID'];
		$PARAMETER = $data['PARAMETER'];
		$VALUE = $data['VALUE'];
    } else {
		$PARAMETER = "";
		$VALUE = "";
	
    }
?>
	
<form class="form-horizontal petugasForm" id="petugasForm" action="crud/conf_penggajian/conf_penggajian.input.php" type="POST">
    <div class="modal-body">
        <div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Parameter</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" readonly value="<?php echo $PARAMETER; ?>" id="PARAMETER" name="PARAMETER"  \>
				<input type="hidden" class="form-control" value="<?php echo $ID; ?>" id="ID" name="ID"  \>
			</div>
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Value</label>
            <div class="col-sm-9">
				<?php if($ID!="4" && $ID!="3" && $ID !="2" && $ID!="5" && $ID!="15" && $ID!="16" ){ ?>
				<input type="text" class="form-control"  value="<?php echo $VALUE; ?>" id="VALUE" name="VALUE"  \>
				<?php } ?>
				<?php if($ID=="2" || $ID=="15" || $ID=="16"){ ?>
				<div class="col-sm-3" style="margin-left:-15px">
					<input type="text" class="form-control" value="<?php echo $VALUE; ?>" id="VALUE" name="VALUE"  \>
				</div>
				<div class="col-sm-6" style="margin-left:-15px">
					<input type="text" class="form-control"  value="<?php echo $VALUE; ?>" id="VALUE1" name="VALUE1"  \>
				</div>
				<br/>
				<?php } ?>
				<?php if($ID=="4"){ ?>
		 
                <div class="input-group date" id="datePicker">
                    <input type="text" class="form-control" id="VALUE" name="VALUE" value="<?php echo $VALUE; ?>" placeholder="Tanggal Lahir" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
      
				<?php } ?>
				<?php if($ID=="3"){ ?>
				<select class="form-control" id="VALUE" name="VALUE"  \>
					<option value="THP">THP</option>
					<option value="GAJI POKOK">GAJI POKOK</option>
				</select>
				<?php } ?>
				<?php if($ID=="5"){ ?>
				<select class="form-control" id="VALUE" name="VALUE"  \>
					<option value="THP">THP</option>
					<option value="GAJI POKOK">GAJI POKOK</option>
				</select>
				<?php } ?>
				<br/><p><i>Catatan:
				<?php 
					if($ID=="1"){echo "Jumlah Hari kerja Masukan Jumlah Hari kerja Efektif Dalam Seminggu";}
					if($ID=="2" || $ID=="15" || $ID=="16" ){echo "Keterlambatan Masukan Dalam Satuan Menit";}
					if($ID=="3"){echo "Lembur Masukan Keterangan THP Atau Gaji Pokok";}
					if($ID=="6"){echo "Masukan Jumlah jam kerja pada hari sabtu";}
					if($ID=="5"){echo "Mangkir Masukan Keterangan THP Atau Gaji Pokok";}
					if($ID=="9"){echo "Masukan Lama jangka waktu perubahan penggajian setelah tanggal proses penggajian dilakukan";}
					if($ID=="4"){echo "Pilih Tanggal Penggajian";}
					if($ID=="17"){echo "Masukan nominal lemburan pegawai bekasi dengan jangka kerja 0-2 Tahun";}
					if($ID=="18"){echo "Masukan nominal lemburan pegawai bekasi dengan jangka kerja 2-3 Tahun";}
					if($ID=="19"){echo "Masukan nominal lemburan pegawai bekasi dengan jangka kerja 3 tahun-Dst";}
		
				?>
				</i></p>
			</div>
		</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
		$('#datePicker').datepicker({
			format: "dd",
			autoclose: true,

			todayHighlight: true
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
                    $('#dialog-conf_penggajian').modal('hide');
                }
            });
        })
		.formValidation({
            message: 'This value is not valid',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
				NAMA_conf_penggajian: {
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
			<?php if($ID == "2"){ ?>
			 fields: {
				VALUE: {
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
		<?php } ?>
			
			
        });
    });
</script>
