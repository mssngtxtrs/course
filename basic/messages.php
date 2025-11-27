<?php
namespace Server;

class Messages {
    private array $error_messages;
    private array $messages;
    private array $debug_messages;



    public function __construct() {
        $this->messages = $_SESSION['msg']['std'] ?? [];
        $this->error_messages = $_SESSION['msg']['error'] ?? [];
        $this->debug_messages = $_SESSION['msg']['dbg'] ?? [];

    }



    public function __unset($name) {
        unset($this->error_messages);
        unset($this->messages);
        unset($this->debug_messages);
    }



    private function getMessages(bool $debug = false): array {
        $messages = [];

        foreach ($this->error_messages as $msg) {
            array_push($messages, [ 'message' => $msg, 'type' => "error" ]);
        }

        foreach ($this->messages as $msg) {
            array_push($messages, [ 'message' => $msg, 'type' => "std" ]);
        }

        if ($debug) {
            foreach ($this->debug_messages as $msg) {
                array_push($messages, [ 'message' => $msg, 'type' => "debug" ]);
            }
        }

        /* echo "<pre>"; */
        /* var_dump($_SESSION); */
        /* var_dump($messages); */
        /* echo "</pre>"; */

        unset($_SESSION['msg']);
        return $messages;
    }



    public function showMessages(bool $debug = false): string {
        global $dictionary;

        $messages = $this->getMessages($debug);

        $output = "<div class='messages'>";
        $i = 0;
        foreach ($messages as $message) {
            $output .= "<div class='" . $message['type'] . "' id='msg" . $i . "' onclick='this.remove()'>";
            $output .= $dictionary->getDictionaryString($message['message'], "messages");
            $output .= "</div>";
            $i += 1;
        }
        $output .= "</div>";

        return $output;
    }
}
?>
