<?php

/**
 * Remove that file in production!
 *
 */

require 'vendor/autoload.php';
require 'app/config.php';

echo "connecting to database...<br>";
\RedBeanPHP\R::setup( 'mysql:host='.$config['db_host'].';dbname='.$config['db_name'].'',
    $config['db_user'], $config['db_pass'] );

require 'app/db/setup_tables.php';
echo "setup_tables.php executed...<br>";

require 'app/db/seed.php';
echo "seed.php executed...<br>";

echo "<br>";
echo "<div style='color:red;'>Remove that file in production!</div>";
