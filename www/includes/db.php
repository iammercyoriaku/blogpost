<?php

define('DBNAME', 'blog');
define('DBUSER', 'root');
define('DBPASS', 'ilovecupcakes');

try{
	# prepare a pdp instance
	$conn = new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);

	#SET VERBOSE ERROR MODES
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

} catch(PDOExceptiom $e) {
	echo $e->getMessage();
}

?>
