<?php

namespace Server;

class Hostings {
    private $hostings;

    public function __construct()
    {
        global $database;
        $query = "select * from `hostings`";
        $this->hostings = $database->returnQuery($query);
    }

    public function __unset($name) {
        unset($this->hostings);
    }

    public function returnHostings($purpose) {
        $output = "";
        switch ($purpose) {
        case "slider":
            if (!isset($this->hostings)) {
                $output = <<<HERE
                <div class="hosting-wrap">
                    <div class="hosting">
                        <h3>На данный момент хостингов нет</h3>
                        <p>Но мы скоро это исправим!</p>
                    </div>
                </div>
                HERE;
            } else {
                foreach ($this->hostings as $hosting) {
                    $output .= "<div class='hosting-wrap'>";
                    $output .= "<div class='hosting'>";
                    $output .= "<h2>Хостинг " . $hosting['hostingID'] . "</h2>";
                    $output .= "<p>Максимум пользователей: " . $hosting['maxUsers'] . "</p>";
                    $output .= "<p>Процессор: " . $hosting['cpu'] . "</p>";
                    $output .= "<p>Оперативная память: " . $hosting['ram'] / 1024 . " ГБ</p>";
                    $output .= "<p>Пользовательский объём: " . $hosting['ramUser'] / 1024 . " ГБ</p>";
                    $output .= "<p>Объём диска: " . $hosting['diskSpace'] / 1024 . " ГБ</p>";
                    $output .= "<p>Пользовательский объём: " . $hosting['diskSpaceUser'] / 1024 . " ГБ</p>";
                    $output .= "</div></div>";
                }
            }
            return $output;
            break;
        case "list":

            break;
        case "raw":

            break;
        }
    }
}
?>
