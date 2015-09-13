(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
	
		var main = "crud/pegawai_bulanan/pegawai_bulanan.data.php";
		$("#data-pegawai_bulanan").load(main);

		$('.ubah-pegawai_bulanan, .tambah-pegawai_bulanan').live("click", function(){
            var url = "crud/pegawai_bulanan/pegawai_bulanan.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data pegawai bulanan");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai bulanan");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
		
		$('.import').live("click", function(){
            var url = "crud/pegawai_bulanan/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data pegawai bulanan");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-pegawai_bulanan').live("click", function(){
            var url = "crud/pegawai_bulanan/pegawai_bulanan.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-pegawai_bulanan").load(main);
				});
            }
		});
		
		$('#dialog-pegawai_bulanan').on('hidden.bs.modal', function () {
            $("#data-pegawai_bulanan").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai bulanan");
		});
    });	
}) (jQuery);
