(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/ambil_toko/ambil_toko.data.php";

		$("#data-ambil_toko").load(main);
		
		$('.ubah-ambil_toko, .tambah-ambil_toko').live("click", function(){
            var url = "crud/ambil_toko/ambil_toko.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data KasBon");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data KasBon");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/ambil_toko/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data KasBon");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-ambil_toko').live("click", function(){
            var url = "crud/ambil_toko/ambil_toko.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {

                $.post(url, {hapus: id} ,function() {
                    $("#data-ambil_toko").load(main);
                });
            }
		});
		
		$('#dialog-ambil_toko').on('hidden.bs.modal', function () {
            $("#data-ambil_toko").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data ambil_toko");
		});
    });	
}) (jQuery);
