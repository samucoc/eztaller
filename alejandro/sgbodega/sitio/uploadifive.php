<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/arcoiris/sgadministrativo/sitio/uploads/'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name']; 
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','pdf'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		if (move_uploaded_file($tempFile,$targetFile)){
			echo '1';
			}
		else{
			echo '0'; 
			}
	} else {
		echo 'Invalid file type.';
	}
}
?>