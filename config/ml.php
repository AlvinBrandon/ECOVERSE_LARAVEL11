<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Machine Learning Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the machine learning components
    | of the application, including paths to Python executable and scripts.
    |
    */

    // Path to Python executable
    'python_path' => env('ML_PYTHON_PATH', 'C:\\Python313\\python.exe'),

    // Path to Python scripts directory
    'scripts_path' => base_path('python_scripts'),

    // Model storage path
    'models_path' => storage_path('app/ml/models'),

    // Dataset path
    'dataset_path' => base_path('machinelearning/packaging_materials_dataset.csv'),
]; 