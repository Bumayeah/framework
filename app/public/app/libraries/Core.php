<?php
/**
 * Core routing class.
 *
 * Parses the incoming URL and dispatches the request to the correct
 * controller and method. URL format: /controller/method/param1/param2
 *
 * Falls back to Pages::index() when no URL segments are present.
 */
class Core {
    protected string $currentController = 'Pages';
    protected string $currentMethod = 'index';
    protected array $params = [];
    protected object $controllerInstance;

    public function __construct() {
        $url = $this->getUrl();

        if (isset($url[0])) {
            if (!preg_match('/^[a-zA-Z]+$/', $url[0])) {
                throw new \Exception('404 - Invalid controller name');
            }
            $controllerName = ucwords($url[0]);
            if (!file_exists('../app/controllers/' . $controllerName . '.php')) {
                throw new \Exception('404 - Controller not found');
            }
            $this->currentController = $controllerName;
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->controllerInstance = new $this->currentController;

        if (isset($url[1])) {
            if (!method_exists($this->controllerInstance, $url[1])) {
                throw new \Exception('404 - Method not found');
            }
            $this->currentMethod = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        $this->controllerInstance->{$this->currentMethod}(...$this->params);
    }

    /**
     * Parses and sanitizes the URL query parameter into an array of segments.
     *
     * @return string[] URL segments, e.g. ['pages', 'index', '42']
     */
    public function getUrl(): array {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
