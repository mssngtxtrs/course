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
        $dictionary_locale = $_SESSION['locale'] ?? $this->locale;

        $dictionary_stream = fopen($this->dictionary_folder . '/' . $dictionary_locale . '/' . $dictionary_name . '.csv', "r");
        $output = [];

        while ($line = fgetcsv(stream: $dictionary_stream, separator: ",", enclosure: "'")) {
            $output[] = $line;
        }
        fclose($dictionary_stream);

        return $output;
    }



    public function getDictionaryString(string $lineName, string $dictionary): string {
        $output = "";

        foreach ($this->getDictionary($dictionary) as $line) {
            if ($line[0] == $lineName) {
                $output = $line[1];
            }
        }
            
        return $output;
    }
}
?>
