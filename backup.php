 <?php
 $servername = "localhost";
 $username = "btech2017";
 $password = "btech2017";
 $dbname = "btech2017";
 $file = "backup.zip";

 // Create connection
 /* $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      } */
 
	shell_exec('mysqldump -u btech2017 -pbtech2017 btech2017 AnindyaKinjal > db_back.sql'); 
	shell_exec('zip -r backup.zip uploads db_back.sql');
	
	
	if(!file_exists($file)){ // file does not exist
	    die('file not found');
	} else {
	    header("Cache-Control: public");
	    header("Content-Description: File Transfer");
	    header("Content-Disposition: attachment; filename=$file");
	    header("Content-Type: application/zip");
	    //header("Content-Transfer-Encoding: binary");

	    // read the file from disk
	    readfile($file);
	}
?>
