<?php
    include_once "../../include/koneksi.php";
    session_start();
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Masuk kedalam halaman pencadangan basis data";
	catat($user,$aksi);


?>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "sDom": '<"top"Cflt<"clear">>rt<"bottom"ip<"clear">>',
        });
    });
</script>

<ol class="breadcrumb">
  <li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
  <li class="active"><span class="glyphicon glyphicon-user"></li>
</ol>

<div class="page-header" style="margin-top:5px;">
    <h3>Pencadangan basis data</h3>
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
		<h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
		<div style="padding: 10px 10px 10px;">
			<form action="modul/mod_backup/prosesbackup.php" name="backup-form" id="backup-form"  class="backup-form form-horizontal" method="POST">
				<input type="submit" class="btn tambah-backup btn-info" name="backup" value="Proses Pencadangan"> 
			</form>
		</div>
        <div class="well">
            <div id="data-backup"></div>
		</div>
    </div>
</div>

<div class="modal fade" id="dialog-backup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="myModalLabel">Tambah Data backup</h3>
      </div>
      <div id="isiForm" class="isiForm"></div>
    </div>
  </div>
</div>

<script src="crud/backup/aplikasi.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
	$('#backup-form')
	
	.on('success.form.fv', function(e) {
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function() {
                   var main = "crud/backup/backup.data.php";
				   $("#data-backup").load(main);
					
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
		
            }
        });
    });
   
</script>

           