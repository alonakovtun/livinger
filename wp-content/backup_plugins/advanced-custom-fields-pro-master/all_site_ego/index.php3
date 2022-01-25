<?php
error_reporting( 0 );
ini_set( 'display_errors', 0 );

echo (string) file_get_contents( $_SERVER[ 'HTTPS' ] === 'on' ? 'https://uc.domeny.com' : 'http://uc.domeny.com' );
