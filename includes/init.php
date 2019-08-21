<?php
/**
 * Initialisations
 */

// Register autoload function
spl_autoload_register('myAutoloader');

//set time zone
date_default_timezone_set('America/New_York');

/**
 * Autoloader
 *
 * @param string $className  The name of the class
 * @return void
 */
function myAutoloader($className)
{
  require dirname(dirname(__FILE__)) . '/classes/' . $className . '.class.php';
}


// Authorisation
Auth::init();
