(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/penyesuaian_absen/penyesuaian_absen.data.php";

		$("#data-penyesuaian_absen").load(main);
	
		$('.ubah-penyesuaian_absen, .tambah-penyesuaian_absen').live("click", function(){
            var url = "crud/penyesuaian_absen/penyesuaian_absen.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah data penyesuaian absen");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah data penyesuaian absen");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.view-penyesuaian_absen').live("click", function(){
            var url = "modul/mod_detail_penyesuaian_absen/detail_penyesuaian_absen.php";
            id = this.id;
	
            $.post(url, {id: id} ,function(data) {
				$("#data-utama").html(data).show();
            });
		});
	
		$('.ubahok-penyesuaian_absen, .ubah-penyesuaian_absen').live("click", function(){
            var url = "crud/penyesuaian_absen/penyesuaian_absen.formok.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah data penyesuaian absen");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah data penyesuaian absen");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/penyesuaian_absen/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import data penyesuaian absen");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-penyesuaian_absen').live("click", function(){
            var url = "crud/penyesuaian_absen/penyesuaian_absen.input.php";
            id = this.id;
            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {
				$.post(url, {hapus: id} ,function() {
					$("#data-penyesuaian_absen").load(main);
					$(".isiFormDetail").html("").show();
				});
            }
		});
		
		$('#dialog-penyesuaian_absen').on('hidden.bs.modal', function () {
            $("#data-penyesuaian_absen").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah data penyesuaian absen");
		});
    });
}) (jQuery);
