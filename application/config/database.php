<?php

/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
|
| Dito kayo mag create ng connection.
| Pwede dito multiple connection.
| as is lang yung "$db[]", wag nyo babaguhen
| 
| Kung anong sinet nyong index yun ang gagamiten nyong connection name
| e.g.
| $db["connection_name"]
| $this->connection_name->prepare();
|
| Yung mga index name wag nyo din papalitan:
| hostname,database,username,password,charset,dbdriver
|
| Kaya kung mag aad kayo connection
| I copy paste nyo nalang.
|
| -nagmamahal
| -Developer
*/



$db['conn'] = array(
	'hostname' 		=> '10.164.30.166',
	'database' 		=> 'purchasing',
	'username'		=> 'postgres',
	'password'		=> '@ssy3#',
	'charset' 		=> 'utf8',
	'dbdriver'		=> 'pgsql'
);


