<?php
class FileUploadHelper
{
    const MAX_FILE_SIZE = 5000000; // 5MB limit
    const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png'];
    const ALLOWED_DOC_EXTENSIONS = ['pdf', 'doc'];

    public static function validateFile($file, $allowedExtensions)
    {
        $response = [
            'is_valid' => false,
            'error' => ''
        ];

        // Check if the file exists and has been uploaded
        if (empty($file) || !isset($file['name']) || $file['size'] == 0) {
            // No file was uploaded, so we can consider it valid or skip validation
            $response['is_valid'] = true;
            return $response;
        }

        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Check allowed file extension
        if (!in_array($file_ext, $allowedExtensions)) {
            $response['error'] = "Unsupported file type. Allowed types: " . implode(", ", $allowedExtensions);
            return $response;
        }

        // Check for file errors
        if ($file_error !== 0) {
            $response['error'] = "Error occurred during file upload.";
            return $response;
        }

        // Check for file size
        if ($file_size > self::MAX_FILE_SIZE) {
            $response['error'] = "File size exceeds the limit of " . (self::MAX_FILE_SIZE / 1000) . " KB.";
            return $response;
        }

        // If all checks pass
        $response['is_valid'] = true;
        return $response;
    }

    public static function uploadFile($file, $path)
    {
        $response = [
            'success' => false,
            'file_name' => null,
            'error' => ''
        ];

        // Check if the file exists and has been uploaded
        if (empty($file) || !isset($file['name']) || $file['size'] == 0) {
            // No file was uploaded, so we can consider it valid or skip validation
            $response['success'] = true;
            return $response;
        }

        // Ensure the directory exists
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $file_name_new = uniqid('', true) . "." . $file_ext;
        $file_destination = $path . DIRECTORY_SEPARATOR . $file_name_new;

        // Move the file and set response
        if (move_uploaded_file($file['tmp_name'], $file_destination)) {
            $response['success'] = true;
            $response['file_name'] = $file_name_new;
        } else {
            $response['error'] = "Failed to move uploaded file.";
        }

        return $response;
    }

    // Convenience methods for uploading images and documents
    // public static function uploadImage($file, $path)
    // {
    //     $validation = self::validateFile($file, self::ALLOWED_IMAGE_EXTENSIONS);
    //     if ($validation['is_valid']) {
    //         return self::uploadFile($file, $path);
    //     } else {
    //         return [
    //             'success' => false,
    //             'file_name' => '',
    //             'error' => $validation['error']
    //         ];
    //     }
    // }

    // public static function uploadDocument($file, $path)
    // {
    //     $validation = self::validateFile($file, self::ALLOWED_DOC_EXTENSIONS);
    //     if ($validation['is_valid']) {
    //         return self::uploadFile($file, $path);
    //     } else {
    //         return [
    //             'success' => false,
    //             'file_name' => '',
    //             'error' => $validation['error']
    //         ];
    //     }
    // }

    // vallidating array of files
    public static function validateFiles(array $files) {
        $response = [
            'is_valid' => true,
            'error' => []
        ];

        foreach ($files as $key => $fileInfo) {
            $validation = self::validateFile($fileInfo['file'], $fileInfo['allowedExtensions']);
            if (!$validation['is_valid']) {
                $response['is_valid'] = false;
                $response['error'][$key.'_err'] = $validation['error'];
            }
        }
        return $response;
    }

    //uploading array of files
    public static function uploadfiles(array $files) {
        $response = [
            'success' => true,
            'file_name' => [],
            'error' => []
        ];

        foreach ($files as $key => $fileInfo) {
            $upload = self::uploadFile($fileInfo['file'], $fileInfo['path']);
            if ($upload['success']) {
                $response['file_name'][$key.'Name'] = $upload['file_name'];
            } else {
                $response['success'] = false;
                $response['error'][$key.'_err'] = $upload['error'];
            }
        }

        return $response;
    }
}
?>
