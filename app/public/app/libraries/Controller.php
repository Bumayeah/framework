<?php
/**
 * Base controller class.
 *
 * All application controllers extend this class. Provides helper methods
 * for loading models and rendering views.
 */
class Controller {
    /**
     * Loads a model by name and returns an instance of it.
     *
     * @param  string $modelName The class name of the model (e.g. 'Post')
     * @return object            An instance of the requested model
     */
    public function model(string $modelName): object {
        require_once '../app/models/' . $modelName . '.php';
        return new $modelName();
    }

    /**
     * Renders a view file, making the $data array available to the template.
     *
     * @param  string  $view  Path to the view relative to /app/views/ (e.g. 'pages/index')
     * @param  array   $data  Data to pass to the view
     * @throws \Exception     When the view file does not exist
     */
    public function view(string $view, array $data = []): void {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            throw new \Exception('404 - View not found: ' . $view);
        }
    }
}
