(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/laporan_gaji/laporan_gaji.data.php";

		$("#data-laporan_gaji").load(main);
	
		$('.ubah-laporan_gaji, .tambah-laporan_gaji').live("click", function(){
            var url = "crud/laporan_gaji/laporan_gaji.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data laporan_gaji");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data laporan_gaji");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/laporan_gaji/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data laporan_gaji");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-laporan_gaji').live("click", function(){
            var url = "crud/laporan_gaji/laporan_gaji.input.php";
            id = this.id;
            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-laporan_gaji").load(main);
				});
            }
		});
		
		$('#dialog-laporan_gaji').on('hidden.bs.modal', function () {
            $("#data-laporan_gaji").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data laporan_gaji");
		});
    });
}) (jQuery);
