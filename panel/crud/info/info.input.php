<?php
    include_once "../../include/koneksi.php";

    $id = $_POST['id'];
    $NAMA_PERUSAHAAN = $_POST['NAMA_PERUSAHAAN'];
	$EMAIL = $_POST['EMAIL'];
	$PHONE_1 = $_POST['PHONE_1'];
	$PHONE_2 = $_POST['PHONE_2'];
	$KOTA = $_POST['KOTA'];
	$FAXIMILI = $_POST['FAXIMILI'];
	$ALAMAT = $_POST['ALAMAT'];
	$NEGARA = $_POST['NEGARA'];
	$STATE_ID = $_POST['STATE_ID'];
	$COLOR = $_POST['COLOR'];
	
	if($_FILES['logo']['name'][0]!=""){
		foreach($_FILES['logo']['name'] as $key => $value){
            $name = $_FILES['logo']['name'][$key];
            $tmp  = $_FILES['logo']['tmp_name'][$key];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $type=$_FILES['logo']['type'][$key];
            $ukuran=$_FILES['logo']['size'][$key];
                      
            $new_name = "consinalogo.".$ext;
            mysql_query("UPDATE profil_perusahaan SET NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN',EMAIL = '$EMAIL',PHONE_1 = '$PHONE_1' 
						,PHONE_2 = '$PHONE_2',KOTA = '$KOTA',PHONE_2 = '$PHONE_2'
						,FAXIMILI = '$FAXIMILI',ALAMAT = '$ALAMAT',NEGARA = '$NEGARA',logo = '$new_name' ,STATE_ID = '$STATE_ID',COLOR = '$COLOR' 

						WHERE id = '$id' ");
				   
            if(move_uploaded_file($tmp,'../../'.$new_name)){
					   
            }
							
		}
    }else{
		mysql_query("UPDATE profil_perusahaan SET NAMA_PERUSAHAAN = '$NAMA_PERUSAHAAN',EMAIL = '$EMAIL',PHONE_1 = '$PHONE_1' 
					,PHONE_2 = '$PHONE_2',KOTA = '$KOTA',PHONE_2 = '$PHONE_2',FAXIMILI = '$FAXIMILI',ALAMAT = '$ALAMAT',NEGARA = '$NEGARA',STATE_ID = '$STATE_ID',COLOR = '$COLOR' 

					WHERE id = '$id' ");	   
    }
?>
