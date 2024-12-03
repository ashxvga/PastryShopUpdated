<?php

/*
 * Author: Louie Zhu
 * Date: 03/09/2024
 * File: config.php
 * Description: set application settings
 *
 */

//error reporting level: 0 to turn off all error reporting; E_ALL to report all
error_reporting(E_ALL);

//local time zone
date_default_timezone_set('America/New_York');

//base url of the application
const BASE_URL = "http://localhost/I211/PastryShopUpdated";

/*************************************************************************************
 *                       settings for movies                                         *
 ************************************************************************************/

//define default path for media im
define("PASTRY_IMG", "www/img/pastry/");