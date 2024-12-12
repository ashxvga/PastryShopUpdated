<?php
/**
 * Author: Kierra White
 * Date: 11/21/2024
 * File: index.php
 * Description: The homepage
 */

//load application settings

require_once ("application/config/config.php");
//load autoloader
require_once ("vendor/autoload.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
var_dump($_SESSION);
//load the dispatcher that dissects a request URL
new Dispatcher();
