<?php
ini_set('session.gc_maxlifetime', 86400);

session_start();

$global_flags = [
    'debug' => false,
    'try-auto-login' => true,
    'show-messages' => true,
];

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
    locale: $_SESSION['locale'] ?? "ru",
    debug: $global_flags['debug'],
);

$database = new Server\Database();

$auth = new Server\Auth(
    try_auto_login: $global_flags['try-auto-login']
);

$hostings = new Server\Hostings();
$message_handler = new Server\Messages();

$dictionary = new Server\Dictionary(
    dictionary_folder: "dictionary"
);

require "basic/router.php";
?>
