<?php

if( isset( $_POST[ 'Upload' ] ) ) {
	// Where are we going to be writing to?
	$target_path  = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
	// Validar extension, tipo real y tamano; guardar con nombre aleatorio
	$permitidos = array( 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png' );
	$tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ];
	$ext  = strtolower( pathinfo( $_FILES[ 'uploaded' ][ 'name' ], PATHINFO_EXTENSION ) );
	$mime = is_uploaded_file( $tmp ) ? ( new finfo( FILEINFO_MIME_TYPE ) )->file( $tmp ) : '';
	$valido = isset( $permitidos[ $ext ] ) && $permitidos[ $ext ] === $mime && $_FILES[ 'uploaded' ][ 'size' ] < 100000 && @getimagesize( $tmp ) !== false;
	$target_path .= bin2hex( random_bytes( 16 ) ) . '.' . $ext;

	// Can we move the file to the upload folder?
	if( !$valido || !move_uploaded_file( $_FILES[ 'uploaded' ][ 'tmp_name' ], $target_path ) ) {
		// No
		$html .= '<pre>Your image was not uploaded.</pre>';
	}
	else {
		// Yes!
		$html .= "<pre>{$target_path} succesfully uploaded!</pre>";
	}
}

?>
