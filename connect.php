<?php
function Connect()
{
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "root";
 $dbname = "montest";

 // Create connection
$bdd = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);

return $bdd;
}
