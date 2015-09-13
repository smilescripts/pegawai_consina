(function($) {
    $(document).ready(function(e) {
        var id = 0;
		var main = "crud/backup/backup.data.php";

		$("#data-backup").load(main);
			
		$('.ubah-backup, .tambah-backup').live("click", function(){
			var url = "crud/backup/backup.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='logo.png' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data backup");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='logo.png' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data backup");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/backup/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='logo.png' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data backup");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-backup').live("click", function(){
			var url = "crud/backup/backup.input.php";
			id = this.id;

			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-backup").load(main);
				});
			}
		});
			
		$('#dialog-backup').on('hidden.bs.modal', function () {
			$("#data-backup").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='logo.png' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data backup");
		});
    });	
}) (jQuery);
