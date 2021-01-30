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
		$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
		$allowedfileExtensions = array('pdf');
		if (in_array($fileExtension, $allowedfileExtensions)) {
			$uploadFileDir = './';
			$dest_path = $uploadFileDir . $newFileName;
			$message= 'hola';
			if(move_uploaded_file($fileTmpPath, $dest_path))
			{
			  	$message ='Archivo subido correctamente';
			  	$_SESSION['message'] = $message;

			  	$parseador = new \Smalot\PdfParser\Parser();
				$nombreDocumento = $dest_path;
				$documento = $parseador->parseFile($nombreDocumento);

				$paginas = $documento->getPages();
				foreach ($paginas as $indice => $pagina) {
				    $txt = "<h1>Página #%02d</h1>";
				    $texto = $pagina->getText();
				    $txt .= '<pre>';
				    $txt .= $texto;
 				    $txt .= '</pre>';
				}
				$_SESSION['txt'] = $txt;

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