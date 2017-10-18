<?php

$targetDir = "plupload";
$filePath = $targetDir. DIRECTORY_SEPARATOR .$_POST['file_name'];

if ( !$_POST['finish'] )
{
    if (!file_exists($targetDir)) 
    {
    	@mkdir($targetDir);
    }
    
    $out = @fopen($filePath.".part", $_POST['chunks'] ? "ab" : "wb");
    fwrite($out, $_POST['file']);
    @fclose($out);
    @fclose($in);
}
else
{
    rename("{$filePath}.part", $filePath);
}
?>