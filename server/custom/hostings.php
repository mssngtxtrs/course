<?php
namespace Server\Custom;

class Hostings {
    private array $data_container;



    public function __construct() {
        global $database;
        $this->data_container = $database->returnQuery(
            "select * from `hostings`",
            "assoc"
        );
    }



    public function returnData($purpose): string {
        global $dictionary;

        $output = "";

        switch ($purpose) {
        case "slider":
            if (empty($this->data_container)) {
                $output = <<<HERE
                <div class="hosting-wrap">
                    <div class="hosting">
                        <h3>{$dictionary->getDictionaryString("empty", "hostings")}</h3>
                        <p>{$dictionary->getDictionaryString("empty-text", "hostings")}</p>
                    </div>
                </div>
                HERE;
            } else {
                foreach ($this->data_container as $hosting) {
                    $ram = $hosting['ram'] / 1024;
                    $ram_per_user = $hosting['ramUser'] / 1024;
                    $disk = $hosting['diskSpace'] / 1024;
                    $disk_per_user = $hosting['diskSpaceUser'] / 1024;

                    $output .= <<<HERE
                    <div class='hosting-wrap'>
                        <div class='hosting'>
                            <h2>{$dictionary->getDictionaryString("name", "hostings")} {$hosting['hostingID']}</h2>
                            <p>{$dictionary->getDictionaryString("stat-max-users", "hostings")}: {$hosting['maxUsers']}</p>
                            <p>{$dictionary->getDictionaryString("stat-cpu", "hostings")}: {$hosting['cpu']}</p>
                            <p>{$dictionary->getDictionaryString("stat-ram", "hostings")}: {$ram} {$dictionary->getDictionaryString("stat-ram-measurement", "hostings")}</p>
                            <p>{$dictionary->getDictionaryString("stat-ram-user", "hostings")}: {$ram_per_user} {$dictionary->getDictionaryString("stat-ram-measurement", "hostings")}</p>
                            <p>{$dictionary->getDictionaryString("stat-disk", "hostings")}: {$disk} {$dictionary->getDictionaryString("stat-disk-measurement", "hostings")}</p>
                            <p>{$dictionary->getDictionaryString("stat-disk-user", "hostings")}: {$disk_per_user} {$dictionary->getDictionaryString("stat-disk-measurement", "hostings")}</p>
                        </div>
                    </div>
                    HERE;
                }
            }

            break;
        case "raw":
            $output = $this->data_container;
            break;
        case "serialized":
            $output = serialize($this->data_container);
            break;
        case "json":
        default:
            $output = json_encode($this->data_container);
            break;
        }

        return $output;
    }
}
?>
