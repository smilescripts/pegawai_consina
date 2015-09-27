(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/divisi/divisi.data.php";

		$("#data-divisi").load(main);
		
		$('.ubah-divisi, .tambah-divisi').live("click", function(){
			var url = "crud/divisi/divisi.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data divisi");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data divisi");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/divisi/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data divisi");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-divisi').live("click", function(){
			var url = "crud/divisi/divisi.input.php";
			id = this.id;
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-divisi").load(main);
				});
			}
		});
			
		$('#dialog-divisi').on('hidden.bs.modal', function () {
			$("#data-divisi").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data divisi");
		});
    });
}) (jQuery);
