<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

/*$db['default']['hostname'] = '(DESCRIPTION=(ADDRESS_LIST=(FAILOVER=on)(LOAD_BALANCE=on)(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.106)(PORT=1521))
	(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.107)(PORT=1521)))
    (CONNECT_DATA=(SERVER=dedicated)(SERVICE_NAME=danecons.dane.gov.co)))';
	$db['default']['username'] = 'app_gestionh';
$db['default']['password'] = 'hum4ng3st10nis';*/

$db['default']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.122)(PORT=1521))(CONNECT_DATA=(SID=DESA122)))';
$db['default']['username'] = 'gestionh';
$db['default']['password'] = 'desahumano15';
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'oci8';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE; //OJO ... Se pudo el PConnect en False !!!
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['asis_desa']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP) (HOST=192.168.1.122) (PORT=1521))(CONNECT_DATA=(SID=DESA122)))';
$db['asis_desa']['username'] = 'CONTROL_ASISTENCIA';
$db['asis_desa']['password'] = 'control';
$db['asis_desa']['database'] = 'CONTROL_ASISTENCIA';
$db['asis_desa']['dbdriver'] = 'oci8';
$db['asis_desa']['dbprefix'] = '';
$db['asis_desa']['pconnect'] = FALSE;
$db['asis_desa']['db_debug'] = TRUE;
$db['asis_desa']['cache_on'] = FALSE;
$db['asis_desa']['cachedir'] = '';
$db['asis_desa']['char_set'] = 'utf8';
$db['asis_desa']['dbcollat'] = 'utf8_general_ci';
$db['asis_desa']['swap_pre'] = '';
$db['asis_desa']['autoinit'] = TRUE;
$db['asis_desa']['stricton'] = FALSE;

$db['asis']['hostname'] = '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP) (HOST=192.168.1.106) (PORT=1521))
							(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.107)(PORT=1521)))
							(CONNECT_DATA=(SERVICE_NAME = danecons.dane.gov.co)))';
$db['asis']['username'] = 'CONTROL_ASISTENCIA';
$db['asis']['password'] = 'soporte';
$db['asis']['database'] = 'CONTROL_ASISTENCIA';
$db['asis']['dbdriver'] = 'oci8';
$db['asis']['dbprefix'] = '';
$db['asis']['pconnect'] = FALSE;
$db['asis']['db_debug'] = TRUE;
$db['asis']['cache_on'] = FALSE;
$db['asis']['cachedir'] = '';
$db['asis']['char_set'] = 'utf8';
$db['asis']['dbcollat'] = 'utf8_general_ci';
$db['asis']['swap_pre'] = '';
$db['asis']['autoinit'] = TRUE;
$db['asis']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */
