<?php
class Core
{
    //URL format UniQuest/controller/method/params
    protected $currentController = 'Home';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        // Get URL
        $url = $this->getURL();

        //Apply custom URL middleware to handle routing or transformations
        $url = URLMiddleware::handle($url);

        // Look in controllers for first value
        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                // If exists, set as controller
                $this->currentController = ucwords($url[0]);
                // Unset 0 Index
                unset($url[0]);
            } else {
                // Controller does not exist
                // Redirect to error page
                require_once '../app/views/pages/404_not_found/page_not_found.php';
                exit;
            }
        }
        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                // Unset 1 index
                unset($url[1]);
            } else {
                // Method does not exist
                // Redirect to error page
                require_once '../app/views/pages/404_not_found/page_not_found.php';
                exit;
            }
        } else {
            // Default method
            $this->currentMethod = 'index';
        }
        //get params
        $this->params = $url ? array_values($url) : [];

        // Apply middleware
        $this->applyMiddleware($this->currentController, $this->currentMethod);

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }

        return [];
    }

    private function applyMiddleware($Controller, $method)
    {
        // Check if the controller has an auth method
        if (method_exists($Controller, 'auth')) {
            // Call the auth method
            $Controller->auth($method);
        }
    }
}
