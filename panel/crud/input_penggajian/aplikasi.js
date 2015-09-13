(function($) {
    $(document).ready(function(e) {
        var id = 0;
		var logo1 = logo;
		var main = "crud/input_penggajian/input_penggajian.data.php";

		$("#data-input_penggajian").load(main);
		
		$('.ubah-input_penggajian, .tambah-input_penggajian').live("click", function(){
            var url = "crud/input_penggajian/input_penggajian.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data input_penggajian");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data input_penggajian");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/input_penggajian/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data input_penggajian");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-input_penggajian').live("click", function(){
            var url = "crud/input_penggajian/input_penggajian.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-input_penggajian").load(main);
				});
            }
		});
		
		$('#dialog-input_penggajian').on('hidden.bs.modal', function () {
            $("#data-input_penggajian").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data input_penggajian");
		});
    });	
}) (jQuery);
