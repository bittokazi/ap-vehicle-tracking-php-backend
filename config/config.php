<?php
define('HOME_URL', 'https://ap-vehicle-tracking.herokuapp.com');
define('HOME_URL_SSL', 'https://ap-vehicle-tracking.herokuapp.com');

define('ROOT_URL', dirname(__FILE__));
define('DEBUG', true);

define('DB_TYPE', 'mysqli');
define('CONNECT_DB', true);

define('AUTH_KEY', md5($_ENV['AUTH_KEY']));

define('MYSQLI_DB_HOST', $_ENV['DB_HOST']);
define('MYSQLI_DB_USER', $_ENV['DB_USERNAME']);
define('MYSQLI_DB_PASS', $_ENV['DB_PASSWORD']);
define('MYSQLI_DB_NAME', $_ENV['DB_NAME']);

?>
