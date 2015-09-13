(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/update/update.data.php";

		$("#data-update").load(main);
	
		$('.ubah-update, .tambah-update').live("click", function(){
            var url = "crud/update/update.form.php";
            id = this.id;
			
         

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/update/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data update");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-update').live("click", function(){
            var url = "crud/update/update.input.php";
            id = this.id;
            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-update").load(main);
				});
            }
		});
		
		$('#dialog-update').on('hidden.bs.modal', function () {
            $("#data-update").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data update");
		});
    });
}) (jQuery);
