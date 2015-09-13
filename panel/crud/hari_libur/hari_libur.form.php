<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM hari_libur WHERE ID=".$id
    ));
		
    if($id> 0) { 
		$ID = $data['ID'];
		$TAHUN = $data['TAHUN'];
		$BULAN = $data['BULAN'];
		$TANGGAL = $data['TANGGAL'];
		$state = "true";
    } else {
		$TAHUN = "";
		$BULAN = "";
		$TANGGAL = "";
		$state = "";
    }
?>
	
<form class="form-horizontal hari_liburForm" id="hari_liburForm" action="crud/hari_libur/hari_libur.input.php" type="POST">
    <div class="modal-body">
        <div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Tahun</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="tahun">
                    <input type="text" class="form-control" id="TAHUN" name="TAHUN" value="<?php echo $TAHUN; ?>" placeholder="Tahun" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    <input type="hidden" class="form-control" id="ID" name="ID" value="<?php echo $ID; ?>" >
                    <input type="hidden" class="form-control" id="state" name="state" value="<?php echo $state; ?>" >
				</div>
      
		
			</div>
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Bulan</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="BULAN">
                    <input type="text" class="form-control" id="BULAN" name="BULAN" value="<?php echo $BULAN; ?>" placeholder="Bulan" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
      
		
			</div> 
			
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Tanggal</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="datePicker">
                    <input type="text" class="form-control" id="TANGGAL" name="TANGGAL" value="<?php echo $TANGGAL; ?>" placeholder="Tanggal " readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
      
		
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
			format: "yyyy-mm-dd",
			autoclose: true,
			multidate: true,
			todayHighlight: true
		}); 
		$('#tahun').datepicker({
			format: "yyyy",
			autoclose: true,
			
			startView: 2,
			minViewMode: 2,
			todayHighlight: true
	
		});
		$('#BULAN').datepicker({
			format: "mm",
			autoclose: true,
			
			startView: 1,
			minViewMode: 1,
			todayHighlight: true
	
		});
		$('#hari_liburForm')
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                    $('#dialog-hari_libur').modal('hide');
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
        });
    });
</script>
