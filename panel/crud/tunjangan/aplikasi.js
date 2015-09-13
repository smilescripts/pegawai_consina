(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/tunjangan/tunjangan.data.php";

		$("#data-tunjangan").load(main);
		
		$('.ubah-tunjangan, .tambah-tunjangan').live("click", function(){
            var url = "crud/tunjangan/tunjangan.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Tunjangan");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Tunjangan");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/tunjangan/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data Tunjangan");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-tunjangan').live("click", function(){
            var url = "crud/tunjangan/tunjangan.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {

                $.post(url, {hapus: id} ,function() {
                    $("#data-tunjangan").load(main);
                });
            }
		});
		
		$('#dialog-tunjangan').on('hidden.bs.modal', function () {
            $("#data-tunjangan").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Tunjangan");
		});
    });	
}) (jQuery);
