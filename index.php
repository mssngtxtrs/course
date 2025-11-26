<?php
session_start();

require("basic/conn.php");
require("basic/auth.php");
require("basic/hostings.php");
require("basic/constructor.php");

$database = new Server\Database;
$hostings = new Server\Hostings;
$auth = new Server\Auth;
$constructor = new Server\Constructor(
    website_name: "Название сайта",
    templates_folder: "templates",
    media_folder: "media"
);

require("basic/router.php");
?>
