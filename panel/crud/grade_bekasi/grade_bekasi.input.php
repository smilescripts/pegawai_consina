<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM grade_bekasi WHERE KODE_GRADE=".$_POST['hapus']);
    } else {
		$KODE_GRADE = $_POST['KODE_GRADE'];
		$NAMA_GRADE = $_POST['NAMA_GRADE'];
		$NOMINAL_GRADE = $_POST['NOMINAL_GRADE'];
	
		$before=mysql_fetch_object(mysql_query("SELECT * FROM grade_bekasi where KODE_GRADE='$KODE_GRADE'"));
	
		if($KODE_GRADE == 0) {
            mysql_query("INSERT INTO grade_bekasi VALUES(NULL,'$NAMA_GRADE','$NOMINAL_GRADE')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data Grade :".$NAMA_GRADE."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE grade_bekasi SET NAMA_GRADE = '$NAMA_GRADE',NOMINAL_GRADE = '$NOMINAL_GRADE'  WHERE KODE_GRADE = '$KODE_GRADE' ");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data Grader ".$before->NAMA_GRADE." Menjadi ".$NAMA_GRADE."";
			catat($user,$aksi);
		}
    }
?>
