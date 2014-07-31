<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';

// Define a destination
$targetFolder = MIMGPATH; // Relative to the root
$verifyToken = md5('zhimeizimeizizhi9_wangqing' . $_POST['timestamp']);
if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $targetFolder;
    $newName = uniqid() . ".jpg";
    $targetFile = rtrim($targetPath) . $newName;
    // Validate the file type
//	$fileTypes = array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'); // File extensions
//	$fileParts = pathinfo($_FILES['Filedata']['name']);
    $response['status'] = 0;
    if (file_exists($targetFile)) {
        echo 0;
        return;
    }
    if (move_uploaded_file($tempFile, $targetFile)) {
        echo $newName;
    } else {
        echo 0;
    }
}