<?php
session_start();

$website_name = "Название сайта";

require("basic/conn.php");
require("basic/auth.php");
require("basic/hostings.php");

$database = new Server\Database;
$hostings = new Server\Hostings;

require("basic/router.php");
?>
