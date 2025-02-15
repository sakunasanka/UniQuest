<?php
class URLMiddleware {
    public static function handle($url) {
        $customRoutes = [
            'login' => 'user/login',
            'profile' => 'user/profile',
            'recover' => 'user/forgot_password',
        ];
        
        // Join the URL parts for easier matching
        $parsedUrl = implode('/', $url);

        // Check if the parsed URL matches any custom route
        if (array_key_exists($parsedUrl, $customRoutes)) {
            return explode('/', $customRoutes[$parsedUrl]); // Return the transformed URL
        }

        // If no custom route is found, return the original URL
        return $url;
    }
}
?>