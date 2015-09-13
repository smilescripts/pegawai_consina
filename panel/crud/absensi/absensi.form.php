<?php
// panggil file koneksi.php
	include_once "../../include/koneksi.php";
	session_start();

	// tangkap variabel kd_mhs
		$id = $_POST['id'];

	// query untuk menampilkan mahasiswa berdasarkan kd_mhs
	$data = mysql_fetch_array(mysql_query("
		SELECT * FROM departemen WHERE KODE_DEPARTEMEN=".$id
	));
		

// jika kd_mhs > 0 / form ubah data
	if($id> 0) { 
		$KODE_DEPARTEMEN = $data['KODE_DEPARTEMEN'];
		$NAMA_DEPARTEMEN = $data['NAMA_DEPARTEMEN'];
	

//form tambah data
	} else {
		$KODE_DEPARTEMEN = "";
		$NAMA_DEPARTEMEN = "";
	
	}

?>
	
 <form class="form-horizontal petugasForm" id="petugasForm" action="crud/departemen/departemen.input.php" type="POST">
	<div class="modal-body">
		<div class="form-group">
			<label for="NAMA_DEPARTEMEN" class="col-sm-3 control-label"> Departemen</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" value="<?php echo $NAMA_DEPARTEMEN; ?>" id="NAMA_DEPARTEMEN" name="NAMA_DEPARTEMEN"  \>
				<input type="hidden" class="form-control" value="<?php echo $KODE_DEPARTEMEN; ?>" id="KODE_DEPARTEMEN" name="KODE_DEPARTEMEN"  \>
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
	$('#petugasForm')
	
	.on('success.form.fv', function(e) {
             // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
					$('#dialog-departemen').modal('hide');
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
			NAMAPETUGAS: {
                validators: {
                    notEmpty: {
                        message: 'The is required'
                    }
                }
			},
			ALAMATPETUGAS: {
                validators: {
                    notEmpty: {
                        message: 'The is required'
                    }
                }
			},
			JKPETUGAS: {
                validators: {
                    notEmpty: {
                        message: 'The is required'
                    }
                }
			},
			PASSWORDPETUGAS: {
                validators: {
                    notEmpty: {
                        message: 'The is required'
                    }
                }
			},
			EMAILPETUGAS: {
                validators: {
                    notEmpty: {
                        message: 'The is required'
                    },
					regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    }
                }
			},
			TELPONPETUGAS: {
                validators: {
                    notEmpty: {
                        message: 'The is required'
                    },
					integer: {
                        message: 'The value is not an integer'
                    }
                }
			},
        }
    });
});
</script>
