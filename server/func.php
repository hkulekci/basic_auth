<?php


define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');

mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
mysql_select_db(DB_NAME);


function sqlcleaner($id){
	$id = get_magic_quotes_gpc() ? stripslashes($id) : $id;
	$id= function_exists("mysql_real_escape_string") ? mysql_real_escape_string($id) : mysql_escape_string($id);
	return $id;
}

function crypt_string($string){
	$ra = rand()%strlen($string);
	$r = "";
	for ($i = 0; $i<strlen($string); $i++){
		$r .= ( ($ra == $i)?($string[$i]):('*') );	
	}
	return $r."*";
}


?>