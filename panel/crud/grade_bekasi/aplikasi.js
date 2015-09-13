(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/grade_bekasi/grade_bekasi.data.php";

		$("#data-grade_bekasi").load(main);
		
		$('.ubah-grade_bekasi, .tambah-grade_bekasi').live("click", function(){
			var url = "crud/grade_bekasi/grade_bekasi.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data grade_bekasi");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data grade_bekasi");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/grade_bekasi/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data grade_bekasi");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-grade_bekasi').live("click", function(){
			var url = "crud/grade_bekasi/grade_bekasi.input.php";
			id = this.id;
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-grade_bekasi").load(main);
				});
			}
		});
			
		$('#dialog-grade_bekasi').on('hidden.bs.modal', function () {
			$("#data-grade_bekasi").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data grade_bekasi");
		});
    });
}) (jQuery);
