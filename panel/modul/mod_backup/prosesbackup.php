<?php 
	session_start();
	error_reporting(0);
	
	function backup_tables($host,$user,$pass,$name,$nama_file,$tables = '*')
	{
		//untuk koneksi database
		$link = mysql_connect($host,$user,$pass);
		mysql_select_db($name,$link);
		
		if($tables == '*')
		{
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}else{
			//jika hanya table-table tertentu
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//looping dulu ah
		foreach($tables as $table)
		{
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			//menyisipkan query drop table untuk nanti hapus table yang lama
			$return.= 'DROP TABLE '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) 
			{
				while($row = mysql_fetch_row($result))
				{
					//menyisipkan query Insert. untuk nanti memasukan data yang lama ketable yang baru dibuat. so toy mode : ON
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 
					{
						//akan menelusuri setiap baris query didalam
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		
		//simpan file di folder yang anda tentukan sendiri. kalo saya sech folder "DATA"
		$nama_file;
		
		$handle = fopen('./data_backup/'.$nama_file,'w+');
		fwrite($handle,$return);
		fclose($handle);
	}
	
	$file=date("DdMY").'lukstron'.time().'.sql';
	$tanggal=date('Y-m-d H:i:s');
	backup_tables("localhost","root","","e-pegawai",$file);
	mysql_query("insert into backup_data values(NULL,'$tanggal','$file')");
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Melakukan pencadangan basis data";
	catat($user,$aksi);

?>