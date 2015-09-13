(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/izin_absen/izin_absen.data.php";

		$("#data-izin_absen").load(main);
			
		$('.ubah-izin_absen, .tambah-izin_absen').live("click", function(){
			var url = "crud/izin_absen/izin_absen.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Pengajuan izin_absen");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pengajuan izin_absen");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/izin_absen/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data izin_absen");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-izin_absen').live("click", function(){
			var url = "crud/izin_absen/izin_absen.input.php";
			id = this.id;

			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {

				$.post(url, {hapus: id} ,function() {
					$("#data-izin_absen").load(main);
				});
			}
		});
			
		$('#dialog-izin_absen').on('hidden.bs.modal', function () {
			$("#data-izin_absen").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pengajuan izin_absen");
		});
    });	
}) (jQuery);
