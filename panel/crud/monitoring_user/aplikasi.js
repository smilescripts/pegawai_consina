(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/monitoring_user/monitoring_user.data.php";

		$("#data-monitoring_user").load(main);
	
		$('.ubah-monitoring_user, .tambah-monitoring_user').live("click", function(){
            var url = "crud/monitoring_user/monitoring_user.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Riwayat aktivitas pengguna");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data monitoring_user");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/monitoring_user/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data monitoring_user");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-monitoring_user').live("click", function(){
            var url = "crud/monitoring_user/monitoring_user.input.php";
            id = this.id;
            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-monitoring_user").load(main);
				});
            }
		});
		
		$('#dialog-monitoring_user').on('hidden.bs.modal', function () {
            $("#data-monitoring_user").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data monitoring_user");
		});
    });
}) (jQuery);
