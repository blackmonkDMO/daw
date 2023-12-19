<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'bibliotecar';
$DATABASE_PASS = 'superbibliotecar';
$DATABASE_NAME = 'biblioteca';

$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ( mysqli_connect_errno() ) {
	exit('Nu m-am putut conecta la MySQL: ' . mysqli_connect_error());
}

?>