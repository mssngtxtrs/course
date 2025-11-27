<?php
session_start();

require "basic/conn.php";
require "basic/auth.php";
require "basic/hostings.php";
require "basic/constructor.php";
require "basic/messages.php";
require "basic/dictionary.php";

$constructor = new Server\Constructor(
    website_name: "Название сайта",
    templates_folder: "templates",
    media_folder: "media",
    locale: "ru",
    debug: false,
);

$database = new Server\Database();
$hostings = new Server\Hostings();
$auth = new Server\Auth();
$message_handler = new Server\Messages();
$dictionary = new Server\Dictionary("dictionary");

require "basic/router.php";
?>
