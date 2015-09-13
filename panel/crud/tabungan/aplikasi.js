(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/tabungan/tabungan.data.php";

		$("#data-tabungan").load(main);
	
		$('.ubah-tabungan, .tambah-tabungan').live("click", function(){
            var url = "crud/tabungan/tabungan.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data tabungan");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Pengambilan tabungan");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
	
		$('.riwayat-tabungan').live("click", function(){
            var url = "crud/tabungan/riwayat_tabungan.form.php";
            id = this.id;
			
        
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Riwayat pengambilan tabungan");
    

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});	
	
		$('.pengambilan-tabungan').live("click", function(){
            var url = "crud/tabungan/tabungan.form.php";
            id = this.id;
			
        
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Pengambilan tabungan");
    

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/tabungan/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data tabungan");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-tabungan').live("click", function(){
            var url = "crud/tabungan/tabungan.input.php";
            id = this.id;
            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
                    $("#data-tabungan").load(main);
				});
            }
		});
		
		$('#dialog-tabungan').on('hidden.bs.modal', function () {
            $("#data-tabungan").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data tabungan");
		});
    });
}) (jQuery);
