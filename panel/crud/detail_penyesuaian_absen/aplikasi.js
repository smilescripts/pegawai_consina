(function($) {
    $(document).ready(function(e) {
		var id = 0;
		var logo1 = logo;
		var tamp = tamp2;
		//alert(tamp);
		var url = "crud/detail_penyesuaian_absen/detail_penyesuaian_absen.data.php";
	
        $.post(url, {id: tamp} ,function(data) {
			$("#data-detail_penyesuaian_absen").html(data).show();
        });
		
		$('.ubah-detail_penyesuaian_absen, .tambah-detail_penyesuaian_absen').live("click", function(){
			var url = "crud/detail_penyesuaian_absen/detail_penyesuaian_absen.form.php";
			var IDValSplitter 	= (this.id).split("_");
			id = IDValSplitter[0];
			headid = IDValSplitter[1];
			tamp = IDValSplitter[1];
			kpeg = IDValSplitter[2];
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data detail penyesuaian absen");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data detail penyesuaian absen");
			}

			$.post(url, {id: id, headid: headid, kpeg: kpeg} ,function(data) {
				$(".isiForm2").html(data).show();
			});
		});
		
		$('.tambahcepat-detail_penyesuaian_absen').live("click", function(){
			var url = "crud/detail_penyesuaian_absen/detail_penyesuaian_absen.formcepat.php";
			var IDValSplitter 	= (this.id).split("_");
			id = IDValSplitter[0];
			headid = IDValSplitter[1];
			tamp = IDValSplitter[1];
			kpeg = IDValSplitter[2];
				
			if(id != 0) {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Ubah Data detail penyesuaian absen");
			} else {
				$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data detail penyesuaian absen");
			}

			$.post(url, {id: id, headid: headid, kpeg: kpeg} ,function(data) {
				$(".isiForm2").html(data).show();
			});
		});
			
		$('.import').live("click", function(){
			var url = "crud/detail_penyesuaian_absen/import.form.php";
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Import Data detail penyesuaian absen");
			$.post(url, "" ,function(data) {
				$(".isiForm2").html(data).show();
			});
		});

		$('.hapus-detail_penyesuaian_absen').live("click", function(){
			var url = "crud/detail_penyesuaian_absen/detail_penyesuaian_absen.input.php";
			var IDValSplitter 	= (this.id).split("_");
			id = IDValSplitter[0];
			tamp = IDValSplitter[1];
			var answer = confirm("Apakah anda ingin mengghapus data ini?");

			if (answer) {
				$.post(url, {hapus: id} ,function() {
					var url = "crud/detail_penyesuaian_absen/detail_penyesuaian_absen.data.php";
					//alert(tamp);
					$.post(url, {id: tamp} ,function(data) {
						$("#data-detail_penyesuaian_absen").html(data).show();
					});
				});
			}
		});
			
		$('#dialog-detail_penyesuaian_absen').on('hidden.bs.modal', function () {
			//alert(tamp);
			var url = "crud/detail_penyesuaian_absen/detail_penyesuaian_absen.data.php";
			//alert(tamp);
            $.post(url, {id: tamp} ,function(data) {
				$("#data-detail_penyesuaian_absen").html(data).show();
            });
			$("#myModalLabel").html("<img alt='Brand' src='"+logo1+"' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Tambah Data detail penyesuaian absen");
		});
    });
}) (jQuery);
