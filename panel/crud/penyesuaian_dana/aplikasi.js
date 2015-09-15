(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var main = "crud/penyesuaian_dana/penyesuaian_dana.data.php";

		$("#data-penyesuaian_dana").load(main);
		
		$('.ubah-penyesuaian_dana, .tambah-penyesuaian_dana').live("click", function(){
            var url = "crud/penyesuaian_dana/penyesuaian_dana.form.php";
            id = this.id;
			
            if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data Penyesuaian Dana");
            } else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Penyesuaian Dana");
            }

            $.post(url, {id: id} ,function(data) {
				$(".isiForm").html(data).show();
            });
		});
		
		$('.import').live("click", function(){
            var url = "crud/penyesuaian_dana/import.form.php";
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data Penyesuaian Dana");
            $.post(url, "" ,function(data) {
				$(".isiForm").html(data).show();
            });
		});

		$('.hapus-penyesuaian_dana').live("click", function(){
            var url = "crud/penyesuaian_dana/penyesuaian_dana.input.php";
            id = this.id;

            var answer = confirm("Apakah anda ingin mengghapus data ini?");

            if (answer) {

                $.post(url, {hapus: id} ,function() {
                    $("#data-penyesuaian_dana").load(main);
                });
            }
		});
		
		$('#dialog-penyesuaian_dana').on('hidden.bs.modal', function () {
            $("#data-penyesuaian_dana").load(main);
            $("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data Penyesuaian Dana");
		});
    });	
}) (jQuery);
