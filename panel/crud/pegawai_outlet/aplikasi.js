(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
	
		var main = "crud/pegawai_outlet/pegawai_outlet.data.php";
		$("#data-pegawai_outlet").load(main);

		$('.ubah-pegawai_outlet, .tambah-pegawai_outlet').live("click", function(){
            var url = "crud/pegawai_outlet/pegawai_outlet.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data pegawai Outlet");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai Outlet");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
			});
		});
		
		$('.import').live("click", function(){
            var url = "crud/pegawai_outlet/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data pegawai Outlet");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-pegawai_outlet').live("click", function(){
            var url = "crud/pegawai_outlet/pegawai_outlet.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-pegawai_outlet").load(main);
				});
            }
		});
		
		$('#dialog-pegawai_outlet').on('hidden.bs.modal', function () {
            $("#data-pegawai_outlet").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data pegawai Outlet");
		});
    });	
}) (jQuery);
