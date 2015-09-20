(function($) {
    $(document).ready(function(e) {
        var id = 0;
		var logo1 = logo;
		var main = "crud/input_penggajian_bulanan/input_penggajian_bulanan.data.php";

		$("#data-input_penggajian_bulanan").load(main);
		
		$('.ubah-input_penggajian_bulanan, .tambah-input_penggajian_bulanan').live("click", function(){
            var url = "crud/input_penggajian_bulanan/input_penggajian_bulanan.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data input_penggajian_bulanan");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data input_penggajian_bulanan");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/input_penggajian_bulanan/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data input_penggajian_bulanan");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-input_penggajian_bulanan').live("click", function(){
            var url = "crud/input_penggajian_bulanan/input_penggajian_bulanan.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-input_penggajian_bulanan").load(main);
				});
            }
		});
		
		$('#dialog-input_penggajian_bulanan').on('hidden.bs.modal', function () {
            $("#data-input_penggajian_bulanan").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data input_penggajian_bulanan");
		});
    });	
}) (jQuery);
