(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/group/group.data.php";

		$("#data-group").load(main);
		
		$('.ubah-group, .tambah-group').live("click", function(){
			var url = "crud/group/group.form.php";
			id = this.id;
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data group");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data group");
			}

			$.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/group/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data group");
			$.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
			});
		});

		$('.hapus-group').live("click", function(){
			var url = "crud/group/group.input.php";
			id = this.id;
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-group").load(main);
				});
			}
		});
			
		$('#dialog-group').on('hidden.bs.modal', function () {
			$("#data-group").load(main);
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data group");
		});
    });
}) (jQuery);