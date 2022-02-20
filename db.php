<?php 
require 'libs/rb.php';
// R::setup( 'mysql:host=localhost;dbname=id18160861_users','id18160861_kurscalendar2', ']h2np\T9F~MRXyI1' );
R::setup( 'mysql:host=127.0.0.1;dbname=users','root', '' );

if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}

session_start();