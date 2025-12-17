<?php
namespace Server\Custom;

define("PERMISSIONS_QUERY", "select * from `permissionLevels`");

class Requests {
    static public function getPermissions() {
        global $database;
        $output = [];

        $raw = $database->returnQuery(
            PERMISSIONS_QUERY,
            "assoc"
        );

        foreach ($raw as $permission) {
            $output[] = [
                'permissionID' => $permission['permissionID'],
                'permission' => $permission['permission'],
            ];
        }

        return $output;
    }
}
