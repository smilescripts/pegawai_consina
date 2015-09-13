(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/absensi_data/absensi_data.data.php";

		$("#data-absensi_data").load(main);
			
		$('.ubah-absensi_data, .tambah-absensi_data').live("click", function(){
			var url = "crud/absensi_data/absensi_data.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Absensi");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Absensi");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/absensi_data/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data Absensi");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-absensi_data').live("click", function(){
			var url = "crud/absensi_data/absensi_data.input.php";
			id = this.id;

			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {

				$.post(url, {hapus: id} ,function() {
					$("#data-absensi_data").load(main);
				});
			}
		});
			
		$('#dialog-absensi_data').on('hidden.bs.modal', function () {
			$("#data-absensi_data").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Absensi");
		});
    });	
}) (jQuery);
