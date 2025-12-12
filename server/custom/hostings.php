<?php
namespace Server\Custom;

/* Стандартный запрос */
define("HOSTINGS_QUERY", "select * from `hostings`");
define("CPU_QUERY", "select * from `cpu`");

/* Класс "Хостинги" */
class Hostings {
    /* Функция получения данных о хостингах */
    static public function returnHostings($purpose): string|array {
        global $database;
        $output = "";

        $raw = $database->returnQuery(
            HOSTINGS_QUERY,
            "assoc"
        );

        switch ($purpose) {
        case "slider":
            $cpu_data_container = Hostings::returnCPU();
            if (empty($raw)) {
                $output = <<<HERE
                <div class="hosting-wrap">
                    <div class="hosting">
                        <h3>Пока тут нет хостингов</h3>
                        <p>Но мы скоро это исправим!</p>
                    </div>
                </div>
                HERE;
            } else {
                foreach ($raw as $hosting) {
                    $cpu = "";

                    foreach ($cpu_data_container as $cpu_info) {
                        if ($cpu_info['cpuID'] == $hosting['cpuID']) {
                            $cpu = $cpu_info['cpuName'];
                        }
                    }

                    $ram =  $hosting['ram'] < 1048576 ? $hosting['ram'] / 1024 : $hosting['ram'] / 1024 / 1024;
                    $ram_digit = $hosting['ram'] < 1048576 ? "ГБ" : "ТБ";

                    $ram_per_user = $hosting['ramUser'] < 1048576 ? $hosting['ramUser'] / 1024 : $hosting['ramUser'] / 1024 / 1024;
                    $ram_per_user_digit = $hosting['ramUser'] < 1048576 ? "ГБ" : "ТБ";

                    $disk = $hosting['diskSpace'] < 1048576 ? $hosting['diskSpace'] / 1024 : $hosting['diskSpace'] / 1024 / 1024;
                    $disk_digit = $hosting['diskSpace'] < 1048576 ? "ГБ" : "ТБ";

                    $disk_per_user = $hosting['diskSpaceUser'] < 1048576 ? $hosting['diskSpaceUser'] / 1024 : $hosting['diskSpaceUser'] / 1024 / 1024;
                    $disk_per_user_digit = $hosting['diskSpaceUser'] < 1048576 ? "ГБ" : "ТБ";

                    $output .= <<<HERE
                    <div class='hosting-wrap'>
                        <div class='hosting'>
                            <h2>{$hosting['hostingAlias']}</h2>
                            <p>Максимум пользователей: {$hosting['maxUsers']}</p>
                            <p>Процессор: {$cpu}</p>
                            <p>Оперативная память: {$ram} {$ram_digit}</p>
                            <p>Пользовательский объём: {$ram_per_user} {$ram_per_user_digit}</p>
                            <p>Объём диска: {$disk} {$disk_digit}</p>
                            <p>Пользовательский объём: {$disk_per_user} {$disk_per_user_digit}</p>
                        </div>
                    </div>
                    HERE;
                }
            }

            break;
        case "raw":
        default:
            $output = [];
            foreach ($raw as $hosting) {
                $output[] = [
                    'hostingID' => $hosting['hostingID'],
                    'hostingAlias' => $hosting['hostingAlias'],
                    'maxUsers' => $hosting['maxUsers'],
                    'cpuID' => $hosting['cpuID'],
                    'ram' => $hosting['ram'],
                    'ramUser' => $hosting['ramUser'],
                    'diskSpace' => $hosting['diskSpace'],
                    'diskSpaceUser' => $hosting['diskSpaceUser'],
                ];
            }
            break;
        }

        return $output;
    }

    /* Функция получения данных о процессоре */
    static public function returnCPU(): array {
        global $database;
        $output = false;

        $output = $database->returnQuery(
            CPU_QUERY,
            "assoc"
        );

        return $output;
    }
}
?>
