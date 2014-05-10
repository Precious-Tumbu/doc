<?php
/**	This is the settings file
*	It contains all System settings in constant variables
*	Must be called before any other script is included within the main script
*/


//	The name of the website
define("SITE_NAME","fresh one");

//	The MySQL database host, Leave empty to use default testing host
define("MYSQL_HOST", "");

//	The MySQL username, Leave empty to use default username
define("MYSQL_USER", "");

//	The MySQL password for username stated above, Leave empty to use default password
define("MYSQL_PASS", "");

//	The MySQL database name, Leave empty to use default database name "smg_db"
define("MYSQL_DATABASE", "");

//	Default system E-mail address
define("EMAIL_SYSTEM", "admin@freshone.com");

//	Nofification email address
define("EMAIL_NOTIFY", "info@freshone.com");

?>