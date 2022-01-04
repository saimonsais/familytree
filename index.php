<?php

unset($goto);
$url_rest = $_SERVER['REQUEST_URI'];    
$url_query = parse_url ($url_rest, PHP_URL_QUERY);
parse_str($url_query);

include 'config-db.php';
//  $dbserver
//  $dbname
//  $dbuser
//  $dbpass

echo '<html>';
echo '<head>';
include 'index-header.php';
echo '</head>';
echo '<body>';

session_start();
 if (isset($_SESSION['user'])) 
    {
    include 'index-loggedin.php';
    } 
else 
    {
    include 'index-login.php';
    }
echo '</body>';
echo '</html>';
?>
