<?php
require_once '../app/models/modelFactory.php'; // Ensure ModelFactory is included

class Controller
{
    // Load model
    public function model($model)
    {
        try {
            // Use ModelFactory to create an instance of the model
            return ModelFactory::createModel($model);
        } catch (Exception $e) {
            // Handle exceptions (e.g., model file or class not found)
            throw new Exception("Error loading model: " . $e->getMessage());
        }
    }

    // Load view
    public function view($view, $data = [])
    {
        // Define view path
        $viewPath = '../app/views/' . $view . '.php';

        // Check for view file
        if (file_exists($viewPath)) {
            // Extract data array to variables
            extract($data);

            // Load view
            require_once $viewPath;
        } else {
            // View does not exist
            // throw new Exception("View file $viewPath does not exist.");

            // Alternatively, redirect to an error page
            require_once '../app/views/pages/404_not_found/page_not_found.php';
        }
    }
}
