<?php 

// forbindelse til mySQL serveren ved brug af mysqli metode

// 1. variabler (konstanter) til forbindelsen


const HOSTNAME = 'localhost'; // server
const MYSQLUSER = 'root'; // superbruger
const MYSQLPASS = 'root'; // password
const MYSQLDB = 'webshop1'; // database navn 

// 2. Forbindelsen via mysqli metoden

$con = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

// at sikre sig, at alle utf 8 tegn kan blive brugt i forbindelsen
$con->set_charset ('utf8');


// 3. Tjek om forbindelse

// hvis der er fejl i forbindelsen 
if($con->connect_error){
	die($con->connect_error);
//hvis der er hul i gennem
} else {
	
}
// php slut tag kan undlades, hvis filen indeholder rent php 
