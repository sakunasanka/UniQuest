<?php
class ModelFactory
{
    public static function createModel($modelName)
    {
        $modelPath = '../app/models/' . $modelName . '.php';
        
        if (file_exists($modelPath)) {
            require_once $modelPath;
            if (class_exists($modelName)) {
                return new $modelName();
            } else {
                throw new Exception("Model class $modelName does not exist in file $modelPath.");
            }
        } else {
            throw new Exception("Model file $modelPath does not exist.");
        }
    }
}