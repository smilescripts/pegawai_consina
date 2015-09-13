<?php
    include_once "../../include/koneksi.php";
    session_start();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
        SELECT * FROM rights_group WHERE ID=".$id
    ));
		
    if($id> 0) { 
		$ID = $data['ID'];
		$GROUP_NAME = $data['GROUP_NAME'];
		$AKSES = $data['AKSES'];

    } else {
		$ID = "";
		$GROUP_NAME = "";
		$AKSES = "";
	
	
    }
?>
	
<form class="form-horizontal groupForm" id="groupForm" action="crud/group/group.input.php" type="POST">
    <div class="modal-body">
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<span><i class="glyphicon glyphicon-asterisk"></i> <strong style="color:red;">Wajib Di Isi</strong></span>
			</div>
		</div>
        <div class="form-group">
            <label for="GROUP_NAME" class="col-sm-3 control-label">Group Name</label>
            <div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $GROUP_NAME; ?>" id="GROUP_NAME" name="GROUP_NAME"  \>
				<input type="hidden" class="form-control" value="<?php echo $ID; ?>" id="ID" name="ID"  \>
            </div>
		</div> 
		<script>
			$(document).ready(function(){
				$('.class1').on('change', function(){        
					if($('.class1:checked').length){
						$('.class3').prop('checked', true);
						$('.class1').prop('checked', false);
						<?php
								$mastermenu1=mysql_query("select * from rights_menu");
								while($datamastermenu1=mysql_fetch_object($mastermenu1)){
									echo "$('.ckontrol_'+".$datamastermenu1->ID.").prop('checked', true);";
									echo "$('#kontrol_'+".$datamastermenu1->ID.").show();";
								}
						?>
						return;
					}
					
					$('.class3').prop('disabled', false);
					 $('.class3').prop('checked', false);
				});
			})
		</script>
		<div class="form-group">
			<label for="AKSES" class="col-sm-3 control-label">Hak Akses</label>
			<div class="col-sm-9">
				<input type="checkbox"  value="" id="class1" class="class1" name="">Pilih Semua<br/>
				<?php
					$rights_group=mysql_query("select * from rights_group where ID='$ID'");
					$rights_groupdata=mysql_fetch_array($rights_group);
					$data12=$rights_groupdata["AKSES"];
					$tmptrights_group=array();
					$tmptrights_group=explode(",",$data12);
					$mastermenu=mysql_query("select * from rights_menu");
					
					while($datamastermenu=mysql_fetch_object($mastermenu)){
						$ok=0;	
						
						foreach($tmptrights_group as $datarights){
							if($datamastermenu->ID==$datarights){	
								$ok=1;
							}
						}	
				?>
						<input type="checkbox" <?php if($ok==1){echo 'checked';}?> value="<?php echo $datamastermenu->ID; ?>" id="AKSES_<?php echo $datamastermenu->ID; ?>"  class="class3" name="AKSES[]"><?php echo $datamastermenu->MENU_NAME;?><br/>
						<div class="kontrol_<?php echo $datamastermenu->ID; ?>" id="kontrol_<?php echo $datamastermenu->ID; ?>" style="<?php if($ok==0){ echo 'display:none;';} ?> border: 2px solid; padding: 5px 5px 5px 5px;">
					<?php
						$C=0;
						$U=0;
						$R=0;
						$D=0;
						$rights_kontrol=mysql_query("select * from rights_control where GROUP_ID='$ID' AND AKSES='$datamastermenu->ID'");
						$rights_kontroldata=mysql_fetch_array($rights_kontrol);
						$dkontrol=$rights_kontroldata["CONTROL"];
						$tmptrights_kontrol=array();
						$tmptrights_kontrol=explode(",",$dkontrol);
						
						foreach($tmptrights_kontrol as $datakontrol){
							if($datakontrol=="C"){	
								$C=1;
							}else if($datakontrol=="R"){	
								$R=1;
							}else if($datakontrol=="U"){	
								$U=1;
							}else if($datakontrol=="D"){	
								$D=1;
							}
						}
					?>
							<input type="checkbox" <?php if($C==1){echo 'checked';}?> value="C" class="ckontrol_<?php echo $datamastermenu->ID; ?>" id="ckontrol_<?php echo $datamastermenu->ID; ?>" name="<?php echo $datamastermenu->ID; ?>_kontrol[]"> Create 
							<input type="checkbox" <?php if($R==1){echo 'checked';}?> value="R" class="ckontrol_<?php echo $datamastermenu->ID; ?>" id="ckontrol_<?php echo $datamastermenu->ID; ?>" name="<?php echo $datamastermenu->ID; ?>_kontrol[]"> Read 
							<input type="checkbox" <?php if($U==1){echo 'checked';}?> value="U" class="ckontrol_<?php echo $datamastermenu->ID; ?>" id="ckontrol_<?php echo $datamastermenu->ID; ?>" name="<?php echo $datamastermenu->ID; ?>_kontrol[]"> Update 
							<input type="checkbox" <?php if($D==1){echo 'checked';}?> value="D" class="ckontrol_<?php echo $datamastermenu->ID; ?>" id="ckontrol_<?php echo $datamastermenu->ID; ?>" name="<?php echo $datamastermenu->ID; ?>_kontrol[]"> Delete 
						</div>
						<script>
							$(document).ready(function(){
								$('#AKSES_'+<?php echo $datamastermenu->ID; ?>).on('change', function(){
									
									if($('#AKSES_'+<?php echo $datamastermenu->ID; ?>+':checked').length){
										$('#kontrol_'+<?php echo $datamastermenu->ID; ?>).show();
										$('.ckontrol_'+<?php echo $datamastermenu->ID; ?>).prop('checked', true);
									}else{
										$('#kontrol_'+<?php echo $datamastermenu->ID; ?>).hide();
										$('.ckontrol_'+<?php echo $datamastermenu->ID; ?>).prop('checked', false);
									}
								});
								
							  
							})
						</script>
				<?php
					}
				?>
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
		$('#groupForm')
	
		.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                    $('#dialog-group').modal('hide');
					var menugroup = "crud/menu/menu.data.php";
					$("#data-menu").load(menugroup);
	
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
				USERNAME_LOGIN: {
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
				PASSWORD_LOGIN: {
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
				NAMA_group: {
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
