<?php
namespace Server;

class Constructor {
    private string $templates_folder;
    private string $website_name;
    private string $media_folder;
    private string $page_name;

    public function __construct(string $website_name, string $templates_folder = "templates", string $media_folder = "media") {
        $this->templates_folder = $templates_folder;
        $this->website_name = $website_name;
        $this->media_folder = $media_folder;
        $this->page_name = "";
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

    public function returnTemplate(string $template_name): string {
        global $hostings, $auth, $database;
        $path_to_template = $this->templates_folder . "/" . $template_name;
        ob_start();
        include $path_to_template;
        return ob_get_clean();
    }

    public function constructPage(array $elements, string $page_name): string {
        $this->page_name = $page_name;
        $page = '';

        foreach ($elements as $element) {
            $page .= $this->returnTemplate($element);
        }

        return $page;
    }
}
?>
