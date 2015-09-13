(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/pinjaman/pinjaman.data.php";

		$("#data-pinjaman").load(main);
		
		$('.ubah-pinjaman, .tambah-pinjaman').live("click", function(){
            var url = "crud/pinjaman/pinjaman.form.php";
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
            var url = "crud/pinjaman/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data KasBon");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-pinjaman').live("click", function(){
            var url = "crud/pinjaman/pinjaman.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {

                $.post(url, {hapus: id} ,function() {
                    $("#data-pinjaman").load(main);
                });
            }
		});
		
		$('#dialog-pinjaman').on('hidden.bs.modal', function () {
            $("#data-pinjaman").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pinjaman");
		});
    });	
}) (jQuery);
