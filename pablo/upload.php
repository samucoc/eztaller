<?php 
session_start(); 
include "vendor/autoload.php";

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
	if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
		$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
		$fileName = $_FILES['uploadedFile']['name'];
		$fileSize = $_FILES['uploadedFile']['size'];
		$fileType = $_FILES['uploadedFile']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		$newFileName = $fileName;
		$allowedfileExtensions = array('xls');
		if (in_array($fileExtension, $allowedfileExtensions)) {
			$uploadFileDir = './';
			$dest_path = $uploadFileDir . $newFileName;
			$message= 'hola';
			if(move_uploaded_file($fileTmpPath, $dest_path))
			{
			  	$message ='Archivo subido correctamente';
			  	$_SESSION['message'] = $message;

				$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($newFileName);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
				$spreadsheet = $reader->load($newFileName);
				$schdeules = $spreadsheet->getActiveSheet()->toArray();
				
				$_SESSION['txt'] .= '<table>';
				foreach( $schdeules as $single_schedule )
				{               
				    $_SESSION['txt'] .= '<tr class="row">';
				    foreach( $single_schedule as $single_item )
				    {
				        $_SESSION['txt'] .=  '<td class="item">' . $single_item . '</td>';
				    }
				    $_SESSION['txt'] .=  '</tr>';
				}
				$_SESSION['txt'] .= '/<table>';
				header("Location: index.php");
			}
			else
			{
			  	$message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
				$_SESSION['message'] = $message;
				header("Location: index.php");
			}
		}
		else{
			$message = 'No corresponde tipo de archivo';
			$_SESSION['message'] = $message;
			header("Location: index.php");
		}
	}
	else{
		$message = 'Error al subir archivo';
		$_SESSION['message'] = $message;
		header("Location: index.php");
	}
}

?>