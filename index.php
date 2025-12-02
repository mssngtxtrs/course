<?php
ini_set('session.gc_maxlifetime', 86400);

session_start();

$global_flags = [
    'debug' => false,
    'try-auto-login' => true,
    'show-messages' => true,
];

require "server/basic/conn.php";
require "server/basic/auth.php";
require "server/basic/constructor.php";
require "server/basic/messages.php";
require "server/basic/dictionary.php";

require "server/custom/hostings.php";

$constructor = new Server\Constructor(
    website_name: "Курсач",
    templates_folder: "templates",
    media_folder: "media",
    available_locales: [ "en", "ru" ],
    locale: $_SESSION['locale'] ?? "ru",
    debug: $global_flags['debug'],
);

$database = new Server\Database();

$auth = new Server\Auth(
    try_auto_login: $global_flags['try-auto-login']
);

$hostings = new Server\Custom\Hostings();
$message_handler = new Server\Messages();

$dictionary = new Server\Dictionary(
    dictionary_folder: "dictionary"
);

require "server/router.php";
?>
