<?php

/**
 * @author yuda KLN
 * @copyright 2017
 */

// set post fields
    $urlPost = 'http://localhost/yuda/api-upload/3rdparty/upload.php';
    
    $fileInfo = pathinfo($_REQUEST["name"]);
    $fileName = url_title($fileInfo['filename']).'.'.$fileInfo['extension'];
    
    $post = [
        'username' => 'user1',
        'password' => 'passuser1',
        'chunk' => isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0,
        'chunks' => isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0,
        'finish' => false,
        'file_name' => $fileName,
    ];
    
    //file
    $in = isset($_FILES["file"]["tmp_name"]) ? @fopen($_FILES["file"]["tmp_name"], "rb") : @fopen("php://input", "rb"); 
    while ($buff = fread($in, 1028)) 
    {
        $post['file'] = $buff;
        echo sendServer($urlPost, $post);	
    }
    if (!$post['chunks'] || $post['chunk'] == $post['chunks'] - 1) 
    {
        $post['file'] = null;
        $post['finish'] = true;
        echo sendServer($urlPost, $post);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    function sendServer($url, $params)
    {
        $ch = curl_init('http://localhost/yuda/api-upload/3rdparty/upload.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        
        // execute!
        $response = curl_exec($ch);
        
        // close the connection, release resources used
        curl_close($ch);
        
        return $response;            
    }
    function url_title ($str, $separator = 'dash', $lowercase = true) 
    {
    if ( $separator == 'dash' ) {
        $search = '_';
        $replace = '-';
    }
    else {
        $search = '-';
        $replace = '_';
    }

    $trans = array(
        '&\#\d+?;' => '',
        '&\S+?;' => '',
        '\s+' => $replace,
        '[^a-z0-9\-\._]' => '',
        $replace . '+' => $replace,
        $replace . '$' => $replace,
        '^' . $replace => $replace,
        '\.+$' => ''
    );

    $str = strip_tags($str);

    foreach ( $trans as $key => $val ) {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    if ( $lowercase === true ) {
        $str = strtolower($str);
    }

    return trim(stripslashes(str_replace(array( ',', '.' ), array( '', '' ), $str)));
}

?>