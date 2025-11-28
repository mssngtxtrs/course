<?php
namespace Server;

class Dictionary {
    private string $dictionary_folder;
    private string $locale;



    public function __construct(string $dictionary_folder) {
        global $constructor;
        $this->dictionary_folder = $dictionary_folder;
        $this->locale = $constructor->getLocale();

    }



    private function getDictionary(string $dictionary_name): array {
        $output = [];

        try {
            if (file_exists($this->dictionary_folder . '/' . $this->locale . '/' . $dictionary_name . '.csv')) {
                $dictionary_stream = fopen($this->dictionary_folder . '/' . $this->locale . '/' . $dictionary_name . '.csv', "r");
                while ($line = fgetcsv(stream: $dictionary_stream, separator: ",", enclosure: "'")) {
                    $output[] = $line;
                }
                fclose($dictionary_stream);
            } else {
                throw new \Exception("Dictionary file \"" . $dictionary_name . "\" not found");
            }
        } catch (\Exception $e) {
            error_log("Error reading dictionary file: " . $e);
        }

        return $output;
    }



    public function getDictionaryString(string $line_name, string $dictionary): string {
        $output = "";
        $found = false;
        /* $cached = false; */

        /* if (isset($_COOKIE['dictionary'][$this->locale][$dictionary])) { */
        /*     $output = $_COOKIE['dictionary'][$this->locale][$dictionary][$line_name]; */
        /*     $found = true; */
        /*     $cached = true; */
        /* } */

        /* if (!$cached) { */
            $dictionary_content = $this->getDictionary($dictionary);

            foreach ($dictionary_content as $line) {
                if ($line[0] == $line_name) {
                    $output = $line[1];
                    /* if ($this->cacheDictionaryString($line[1], $line_name, $dictionary)) { */
                    /*     error_log("Failed caching dictionary string"); */
                    /* } */
                    $found = true;
                }
            }
        /* } */

        if (!$found) {
            $output = $line_name;
        }


        return $output;
    }



    private function cacheDictionaryString(string $line, string $line_name, string $dictionary): bool {
        $output = false;

        if (setcookie("dictionary[{$this->locale}][{$dictionary}][{$line_name}]", "{$line}")) {
            $output = true;
        }

        return $output;
    }
}
?>
