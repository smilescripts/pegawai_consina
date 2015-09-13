(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/conf_penggajian/conf_penggajian.data.php";

		$("#data-conf_penggajian").load(main);
		
		$('.ubah-conf_penggajian, .tambah-conf_penggajian').live("click", function(){
			var url = "crud/conf_penggajian/conf_penggajian.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Konfigurasi Penggajian");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data conf_penggajian");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/conf_penggajian/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data conf_penggajian");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-conf_penggajian').live("click", function(){
			var url = "crud/conf_penggajian/conf_penggajian.input.php";
			id = this.id;
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-conf_penggajian").load(main);
				});
			}
		});
			
		$('#dialog-conf_penggajian').on('hidden.bs.modal', function () {
			$("#data-conf_penggajian").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data conf_penggajian");
		});
    });
}) (jQuery);
