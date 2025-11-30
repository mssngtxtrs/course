<?php
namespace Server;

class Constructor {
    private string $templates_folder;
    private string $website_name;
    private string $media_folder;
    private string $page_name;
    private array $available_locales;
    private string $locale;
    private bool $debug;



    public function __construct(string $website_name, string $templates_folder = "templates", string $media_folder = "media", array $available_locales = [ "en" ], string $locale = "en", bool $debug = false) {
        $this->templates_folder = $templates_folder;
        $this->website_name = $website_name;
        $this->media_folder = $media_folder;
        $this->page_name = "";
        $this->available_locales = $available_locales;
        $this->locale = $locale;
        $this->debug = $debug;
    }



    public function __unset($name) {
        unset($this->templates_folder);
    }



    public function getTeplatesFolder(): string {
        return $this->templates_folder;
    }



    public function getWebsiteName(): string {
        return $this->website_name;
    }



    public function getLocale(): string {
        return $this->locale;
    }



    public function setSessionLocale(string $locale) {
        $found = false;

        foreach ($this->available_locales as $available_locale) {
            if ($locale == $available_locale) {
                $_SESSION['locale'] = $locale;
                $found = true;
                $_SESSION['msg']['std'][] = "language";
                break;
            }
        }

        if (!$found) {
            $_SESSION['locale'] = $this->locale;
            $_SESSION['msg']['error'][] = "language-failed";
        }
    }



    public function returnTemplate(string $template_name): string {
        global $hostings, $auth, $database, $dictionary;
        $path_to_template = $this->templates_folder . "/" . $template_name . ".php";
        ob_start();
        include $path_to_template;
        return ob_get_clean();
    }



    public function constructPage(array $elements, string $page_name, bool $show_messages = false): string {
        global $message_handler;
        $this->page_name = $page_name;
        $page = '';

        foreach ($elements as $element) {
            $page .= $this->returnTemplate($element);
        }

        if ($show_messages) {
            $page .= $message_handler->showMessages($this->debug);
        }

        return $page;
    }
}
?>
