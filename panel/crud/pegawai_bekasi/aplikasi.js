(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
	
		var main = "crud/pegawai_bekasi/pegawai_bekasi.data.php";
		$("#data-pegawai_bekasi").load(main);

		$('.ubah-pegawai_bekasi, .tambah-pegawai_bekasi').live("click", function(){
            var url = "crud/pegawai_bekasi/pegawai_bekasi.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data pegawai bekasi");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai bekasi");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
		
		$('.import').live("click", function(){
            var url = "crud/pegawai_bekasi/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data pegawai bekasi");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-pegawai_bekasi').live("click", function(){
            var url = "crud/pegawai_bekasi/pegawai_bekasi.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-pegawai_bekasi").load(main);
				});
            }
		});
		
		$('#dialog-pegawai_bekasi').on('hidden.bs.modal', function () {
            $("#data-pegawai_bekasi").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai bekasi");
		});
    });	
}) (jQuery);
