<?php

if ( !empty( $_FILES ) ) {
    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $uploadPath = 'D:/wamp/www/'. $_FILES[ 'file' ][ 'name' ];

    move_uploaded_file( $tempPath, $uploadPath );

    $answer = array( 'answer' => 'File transfer completed' );
    $json = json_encode( $answer );

    echo $json;

} else {
    echo 'No files';
}
?>