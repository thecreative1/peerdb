<?php

//receives the xml parse it and add it to database

session_start();

include 'dbcon.php';

$message = array(
    'message' => '',
    'fileContent' => ''
);
// PHP SCRIPT THAT COPIES THE UPLOADED FILE OVER. WE STILL NEED TO WRITE THE XML PARSER...
$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
//echo "lastID : $lastID";
$sql1 = "SELECT * FROM student WHERE studentID='$lastID'";
$result = mysqli_query($conn,$sql1);
$row = mysqli_fetch_array($result);
$groupID = $row['groupID'];

//echo "groupID: $groupID";

// PATH WHERE TO STORE UPLOADED FILES UNDER:
$target_dir = "../peerdb/uploads";
// FILE WHERE TO COPY UPLOADED FILE TO:
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Allow certain file formats
if($fileType != "xml" && $fileType != "XML" ) {
    $message['message'] .= "Sorry, only xml files are allowed.<br>";
    $uploadOk = 0;
}

// COPY UPLOADED FILE:
if ($uploadOk == 0) {
    $message['message'] .= "Sorry, your file was not uploaded.<br>";
} else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $message['message'] .= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
} else {
    $message['message'] .= "Sorry, there was an error uploading your file.<br>";
}

$fileContent = file_get_contents($target_file);

$xml=simplexml_load_string($fileContent) or die("Error: Cannot create object");

// Put report data into database:
$sql = "UPDATE `peerdb`.`groups` SET `reportData` = '" . $xml->asXML() . "' WHERE `groups`.`groupID` = " . $groupID .";";
if(mysqli_query($conn, $sql)){
    $message['message'] .= "Successfuly added report to DB!";
    $message['fileContent'] = $xml->asXML();
}

echo json_encode($message);


// Add all assigend to groups to DB:
/*$asigendGroups = explode(",", $xml->{'assigned-to'});
foreach ($asigendGroups as $ag) {
    $sql2="INSERT INTO `peerdb`.`groups_allocatedTo` (`groupID`, `allocatedGroupID`) VALUES ('" . $groupID  . "', ' " . $ag  . "');";
    if(mysqli_query($conn, $sql2)){
        echo "<br> assigend to: $ag";
    }
}*/
?>