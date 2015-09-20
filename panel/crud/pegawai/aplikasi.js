(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		
		var main = "crud/pegawai/pegawai.data.php";
		
		$("#data-pegawai").load(main);
		
		$('.ubah-pegawai, .tambah-pegawai').live("click", function(){
            var url = "crud/pegawai/pegawai.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data pegawai");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
		
		$('.import').live("click", function(){
            var url = "crud/pegawai/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data pegawai");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-pegawai').live("click", function(){
            var url = "crud/pegawai/pegawai.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-pegawai").load(main);
				});
            }
		});
		
		$('#dialog-pegawai').on('hidden.bs.modal', function () {
            $("#data-pegawai").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai");
		});
    });	
}) (jQuery);
