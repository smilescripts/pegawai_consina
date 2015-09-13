(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/pinjaman2/pinjaman.data.php";

		$("#data-pinjaman2").load(main);
		
		$('.ubah-pinjaman2, .tambah-pinjaman2').live("click", function(){
            var url = "crud/pinjaman2/pinjaman.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Pinjaman");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pinjaman");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
	
		$('.bayar-pinjaman2, .bayar-pinjaman2').live("click", function(){
            var url = "crud/pinjaman2/pembayaran_pinjaman.form.php";
            id = this.id;
			
           
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Pembayaran pinjaman Karyawan");
           
		

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.history-pinjaman2, .history-pinjaman2').live("click", function(){
            var url = "crud/pinjaman2/history_pinjaman.form.php";
            id = this.id;
			
          
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Riwayat pembayaran pinjaman Karyawan");
         

            $.post(url, {id: id} ,function(data){
				$(".isiForm").html(data).show();
            });
		});
	
		$('.pelunasan-pinjaman2, .pelunasan-pinjaman2').live("click", function(){
            var url = "crud/pinjaman2/pelunasan_pinjaman.form.php";
            id = this.id;
			
          
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Pelunasan pembayaran pinjaman Karyawan");
         

            $.post(url, {id: id} ,function(data){
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/pinjaman2/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data Pinjaman");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-pinjaman2').live("click", function(){
            var url = "crud/pinjaman2/pinjaman.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {

                $.post(url, {hapus: id} ,function() {
                    $("#data-pinjaman2").load(main);
                });
            }
		});
	
	
		
		$('#dialog-pinjaman2').on('hidden.bs.modal', function () {
            $("#data-pinjaman2").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Pinjaman");
		});
    });	
}) (jQuery);
