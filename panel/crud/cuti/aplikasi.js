(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/cuti/cuti.data.php";

		$("#data-cuti").load(main);
			
		$('.ubah-cuti, .tambah-cuti').live("click", function(){
			var url = "crud/cuti/cuti.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Pengajuan Cuti");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pengajuan Cuti");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/cuti/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data cuti");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-cuti').live("click", function(){
			var url = "crud/cuti/cuti.input.php";
			id = this.id;

			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {

				$.post(url, {hapus: id} ,function() {
					$("#data-cuti").load(main);
				});
			}
		});
			
		$('#dialog-cuti').on('hidden.bs.modal', function () {
			$("#data-cuti").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pengajuan Cuti");
		});
    });	
}) (jQuery);
