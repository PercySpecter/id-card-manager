 <?php
 $servername = "localhost";
 $username = "btech2017";
 $password = "btech2017";
 $dbname = "btech2017";
 $file = "backup.zip";

 // Create connection
 if (!move_uploaded_file($_FILES['backup']['tmp_name'], $file))
	{
		echo "File Upload Failed!!\n";
	}
	shell_exec('unzip '.$file);
 $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      }
 
	//shell_exec('mysqldump -u btech2017 -pbtech2017 btech2017 AnindyaKinjal AKState AKDistrict > db_back.sql'); 
	
	
	$sql = "source db_back.sql";
	$conn->query($sql);
	
	
	
?>
