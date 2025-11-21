<section id="hostings-slider">
    <div class="container">
        <h1>Наши хостинги</h1>
        <div class="hostings-slider">
<?php
    $query = "select * from `hostings`";

    $result = $conn->query($query);

    if (!$conn->affected_rows) {
        echo <<<HERE
<div class="hosting">
    <h3>На данный момент хостингов нет</h3>
    <p>Но мы скоро это исправим!</p>
</div>
HERE;
    } else {
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $hosting) {
            echo "<div class='hosting'>";
            echo "<h2>Хостинг " . $hosting['hostingID'] . "</h2>";
            echo "<p>Максимум пользователей: " . $hosting['maxUsers'] . "</p>";
            echo "<p>Процессор: " . $hosting['cpu'] . "</p>";
            echo "<p>Оперативная память: " . $hosting['ram'] / 1024 . " ГБ</p>";
            echo "<p>Пользовательский объём: " . $hosting['ramUser'] / 1024 . " ГБ</p>";
            echo "<p>Объём диска: " . $hosting['diskSpace'] / 1024 . " ГБ</p>";
            echo "<p>Пользовательский объём: " . $hosting['diskSpaceUser'] / 1024 . " ГБ</p>";
            echo "</div>";
        }
    }

    $result->free();
?>
        </div>
    </div>
</section>
