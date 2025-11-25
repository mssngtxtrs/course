<?php
echo <<<HERE
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница не найдена :: $website_name</title>
    <link rel="stylesheet" href="media/css/style.css">
</head>
<body>
HERE;

include("elements/header.php");
include("elements/rickroll.html");
include("elements/404.html");
include("templates/elements/footer.php");

echo <<<HERE
</body>
</html>
HERE;

unsetServer();
?>
