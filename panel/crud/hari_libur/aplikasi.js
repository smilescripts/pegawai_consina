(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/hari_libur/hari_libur.data.php";

		$("#data-hari_libur").load(main);
		
		$('.ubah-hari_libur, .tambah-hari_libur').live("click", function(){
			var url = "crud/hari_libur/hari_libur.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Konfigurasi Penggajian");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data hari_libur");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/hari_libur/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data hari_libur");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-hari_libur').live("click", function(){
			var url = "crud/hari_libur/hari_libur.input.php";
			id = this.id;
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-hari_libur").load(main);
				});
			}
		});
			
		$('#dialog-hari_libur').on('hidden.bs.modal', function () {
			$("#data-hari_libur").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data hari_libur");
		});
    });
}) (jQuery);
