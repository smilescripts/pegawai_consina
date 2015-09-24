<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM libur_outlet_perbln WHERE ID=".$id
    ));
		
    if($id> 0) { 
		$ID = $data['ID'];
		$SENIN = $data['SENIN'];
		$SELASA = $data['SELASA'];
		$RABU = $data['RABU'];
		$KAMIS = $data['KAMIS'];
		$BULAN = $data['BULAN'];
		$TAHUN = $data['TAHUN'];
    } else {
		$ID = 0;
		$SENIN = "";
		$SELASA = "";
		$RABU = "";
		$KAMIS = "";
		$BULAN = "";
		$TAHUN = "";
    }
	
		$SENIN1 = array();
		$SELASA1 = array();
		$RABU1 = array();
		$KAMIS1 = array();
		
		$SENIN1 = explode(",",$SENIN);
		$SELASA1 = explode(",",$SELASA);
		$RABU1 = explode(",",$RABU);
		$KAMIS1 = explode(",",$KAMIS);
		
?>
	
<form class="form-horizontal libur_perblnForm" id="libur_perblnForm" action="crud/libur_perbln/libur_perbln.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
            </div>
		</div>
		<input type="hidden" class="form-control" id="ID" name="ID" value="<?php echo $ID; ?>" >
        <div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Tahun</label>
            <div class="col-sm-9">
	
                <div class="input-group date" id="tahun">
                    <input type="text" class="form-control" id="TAHUN" name="TAHUN" value="<?php echo $TAHUN; ?>" placeholder="Tahun" readonly required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                 
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
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Senin</label>
            <div class="col-sm-9">
	
                 <?php
						$result = mysql_query("select * from pegawai WHERE OUTLET='YA'");  
						echo '<select multiple="multiple" style="width:100%" class="form-control senin" name="SENIN[]" placeholder="Pilih Pegawai">';  
						 
						while ($row = mysql_fetch_array($result)) {  
							echo '<option value="' . $row['KODE_PEGAWAI'] . '"';
							foreach($SENIN1 as $SENIN2){
								if($SENIN2==$row['KODE_PEGAWAI']){
									echo "selected='selected'";
								}; 
							}
							echo'>' . $row['NIP_PEGAWAI']. ' - '.$row['NAMA_PEGAWAI'].'</option>';  
						$i=$i+1;
						}  
						echo '</select>';
			?>
      
		
			</div> 
			
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Selasa</label>
            <div class="col-sm-9">
	
                 <?php
						$result = mysql_query("select * from pegawai WHERE OUTLET='YA'");  
						echo '<select multiple="multiple" style="width:100%" class="form-control selasa" name="SELASA[]" placeholder="Pilih Pegawai">';  
						 
						while ($row = mysql_fetch_array($result)) {  
							echo '<option value="' . $row['KODE_PEGAWAI'] . '"';
							foreach($SELASA1 as $SELASA2){
								if($SELASA2==$row['KODE_PEGAWAI']){
									echo "selected='selected'";
								}; 
							}
							echo'>' . $row['NIP_PEGAWAI']. ' - '.$row['NAMA_PEGAWAI'].'</option>';  
						$i=$i+1;
						}  
						echo '</select>';
						
			?>
      
		
			</div> 
			
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Rabu</label>
            <div class="col-sm-9">
	
                 <?php
						$result = mysql_query("select * from pegawai WHERE OUTLET='YA'");  
						echo '<select multiple="multiple" style="width:100%" class="form-control rabu" name="RABU[]" placeholder="Pilih Pegawai">';  
						 
						while ($row = mysql_fetch_array($result)) {  
							echo '<option value="' . $row['KODE_PEGAWAI'] . '"';
							foreach($RABU1 as $RABU2){
								if($RABU2==$row['KODE_PEGAWAI']){
									echo "selected='selected'";
								}; 
							}
							echo'>' . $row['NIP_PEGAWAI']. ' - '.$row['NAMA_PEGAWAI'].'</option>';  
						$i=$i+1;
						}  
						echo '</select>';
						
			?>
      
		
			</div> 
			
		</div>
		<div class="form-group">
            <label for="NAMA_conf_penggajian" class="col-sm-3 control-label"> Kamis</label>
            <div class="col-sm-9">
	
                 <?php
						$result = mysql_query("select * from pegawai WHERE OUTLET='YA'");  
						echo '<select multiple="multiple" style="width:100%" class="form-control kamis" name="KAMIS[]" placeholder="Pilih Pegawai">';  
						 
						while ($row = mysql_fetch_array($result)) {  
							echo '<option value="' . $row['KODE_PEGAWAI'] . '"';
							foreach($KAMIS1 as $KAMIS2){
								if($KAMIS2==$row['KODE_PEGAWAI']){
									echo "selected='selected'";
								}; 
							}
							echo'>' . $row['NIP_PEGAWAI']. ' - '.$row['NAMA_PEGAWAI'].'</option>';  
						$i=$i+1;
						}  
						echo '</select>';
						
			?>
      
		
			</div> 
			
		</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal Simpan</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
 <script>
    $("select.senin").select2({dropdownAutoWidth : true, width: "100%"});
    $("select.selasa").select2({dropdownAutoWidth : true, width: "100%"});
    $("select.rabu").select2({dropdownAutoWidth : true, width: "100%"});
    $("select.kamis").select2({dropdownAutoWidth : true, width: "100%"});
    </script>
<script type="text/javascript">
    $(document).ready(function() {
		$('#tahun').datepicker({
			format: "yyyy",
			autoclose: true,
			
			startView: 2,
			minViewMode: 2,
			todayHighlight: true
	
		})
		.on('changeDate', function(e) {
            // Revalidate the date field
            $('#libur_perblnForm').formValidation('revalidateField', 'TAHUN');
        });
		$('#BULAN').datepicker({
			format: "mm",
			autoclose: true,
			
			startView: 1,
			minViewMode: 1,
			todayHighlight: true
	
		}).on('changeDate', function(e) {
            // Revalidate the date field
            $('#libur_perblnForm').formValidation('revalidateField', 'BULAN');
        });
		$('#libur_perblnForm')
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(data) {
					//alert(data);
                    $('#dialog-libur_perbln').modal('hide');
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
				BULAN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
                    }
                },
				TAHUN: {
                    validators: {
                        notEmpty: {
                            message: 'The is required'
                        },
                    }
                },
            }
        });
    });
</script>
