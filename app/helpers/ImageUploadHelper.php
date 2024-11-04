<?php
class ImageUploadHelper
{
    const MAX_FILE_SIZE = 5000000; // 1MB limit
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png'];

    public static function uploadImage($file, $path)
    {
        $response = [
            'success' => false,
            'file_name' => '',
            'error' => ''
        ];

        $file_name = basename($file['name']); // Prevent directory traversal
        $file_tmp_name = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        if (!is_dir($path)) {
            mkdir($path, 0755, true); // Creates the directory with permissions, including nested ones if needed
        }        
        
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check allowed file extension
        if (in_array($file_ext, self::ALLOWED_EXTENSIONS)) {
            // Check for file errors
            if ($file_error === 0) {
                // Check for file size
                if ($file_size <= self::MAX_FILE_SIZE) {
                    $file_name_new = uniqid('', true) . "." . $file_ext;
                    $file_destination = $path . DIRECTORY_SEPARATOR . $file_name_new;

                    // Move the file and set response
                    if (move_uploaded_file($file_tmp_name, $file_destination)) {
                        $response['success'] = true;
                        $response['file_name'] = $file_name_new;
                    } else {
                        $response['error'] = "Failed to move uploaded file.";
                    }
                } else {
                    $response['error'] = "File size exceeds the limit of " . (self::MAX_FILE_SIZE / 1000) . " KB.";
                }
            } else {
                $response['error'] = "Error occurred during file upload.";
            }
        } else {
            $response['error'] = "Unsupported file type. Allowed types: " . implode(", ", self::ALLOWED_EXTENSIONS);
        }

        return $response;
    }
}
?>
