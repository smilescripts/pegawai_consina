(function($) {
	$(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/absensi/absensi.data.php";

		$("#data-absensi").load(main);
		
		$('.ubah, .tambah').live("click", function(){
			var url = "crud/absensi/absensi.form.php";
			id = this.id;
			
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data absensi");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data absensi");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
		
		$('.import').live("click", function(){
			var url = "crud/absensi/import.form.php";
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data absensi");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus').live("click", function(){
			var url = "crud/absensi/absensi.input.php";

			id = this.id;

			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {

				$.post(url, {hapus: id} ,function() {
					$("#data-absensi").load(main);
				});
			}
		});
		
		$('#dialog-absensi').on('hidden.bs.modal', function () {
			//window.alert('hidden event fired!');
			$("#data-absensi").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data absensi");
		});
		
		
	});
	
	
}) (jQuery);
