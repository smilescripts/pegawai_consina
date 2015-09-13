<?php 
include_once "include/koneksi.php";
include_once "include/catat.php";

$username	= $_POST['username'];
$password	= $_POST['password'];

function anti_injection($data){
    $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
    return $filter;
}

if (!ctype_alnum($username) OR !ctype_alnum($password))
{
	header('Content-Type: application/json');
	echo json_encode(array('cek' => 'false'));
    //echo 'false';
	$user=$_POST['username'];
	$aksi="Melakukan percobaan tindakan sql injection";
	catat($user,$aksi);
}
else
{
    $username=anti_injection($username);
    $password=anti_injection($password);
    $login=mysql_query("SELECT * FROM  petugas WHERE USERNAME_LOGIN='$username' AND PASSWORD_LOGIN='$password' ");
    $ada=mysql_num_rows($login);
    $r=mysql_fetch_array($login);

    if ($ada > 0)
    {
        session_start();

  	$_SESSION['KODE_PETUGAS']     	= $r['KODE_PETUGAS'];
	$_SESSION['NAMA_PETUGAS']     	= $r['NAMA_PETUGAS'];
	$_SESSION['EMAIL']              = $r['EMAIL'];
    $_SESSION['USERNAME_LOGIN']     = $r['USERNAME_LOGIN'];
    $_SESSION['STATE_ID']     = $r['STATE_ID'];
    $_SESSION['AKSES']        = $r['AKSES'];
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Melakukan login sistem";
	catat($user,$aksi);
	header('Content-Type: application/json');
	echo json_encode(array('cek' => 'true'));
    }else{
       header('Content-Type: application/json');
		echo json_encode(array('cek' => 'false'));
		$user=$_POST['username'];
		$aksi="Gagal melakukan login";
		catat($user,$aksi);
    }	
}
?>