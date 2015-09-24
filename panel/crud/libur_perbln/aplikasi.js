(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/libur_perbln/libur_perbln.data.php";

		$("#data-libur_perbln").load(main);
		
		$('.ubah-libur_perbln, .tambah-libur_perbln').live("click", function(){
			var url = "crud/libur_perbln/libur_perbln.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Konfigurasi Penggajian");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data libur_perbln");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/libur_perbln/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data libur_perbln");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-libur_perbln').live("click", function(){
			var url = "crud/libur_perbln/libur_perbln.input.php";
			id = this.id;
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-libur_perbln").load(main);
				});
			}
		});
			
		$('#dialog-libur_perbln').on('hidden.bs.modal', function () {
			$("#data-libur_perbln").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data libur_perbln");
		});
    });
}) (jQuery);
