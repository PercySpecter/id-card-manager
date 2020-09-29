 <?php

$servername = "localhost";
$username = "btech2017";
$password = "btech2017";
$dbname = "btech2017";

  // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}

$state = $_REQUEST["s"];

if($state === "")
{
	echo "Please enter state for suggestions";
	return;
}

$sql = "SELECT district FROM AKDistrict, AKState WHERE AKDistrict.StCode=AKState.StCode AND AKState.StateName='" . $state . "';";
$result = $conn->query($sql);

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    while($row = $result->fetch_assoc()) {
    	$name = $row['DistrictName'];
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?> 

