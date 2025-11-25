<?php
function unsetServer() {
    global $database, $hostings;
    unset($database);
    unset($hostings);
}

session_start();

$website_name = "Название сайта";

require("basic/login.php");
require("basic/hostings.php");

$database = new Server\Database;
$hostings = new Server\Hostings;

require("basic/router.php");
?>
