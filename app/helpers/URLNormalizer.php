<?php
class URLNormalizer
{
    public static function normalizeUrl(string $url, string $type = 'website'): ?string
    {
        // Remove whitespace and check for empty value
        $url = trim($url);
        if (empty($url)) {
            return null;
        }

        // Remove any trailing slashes for consistency
        $url = rtrim($url, '/');

        switch (strtolower($type)) {
            case 'facebook':
                // Remove protocol and domain if included
                $url = preg_replace('~^(?:https?://)?(?:www\.)?facebook\.com/~i', '', $url);
                if (!preg_match('~^[a-z0-9\-\.\/]+$~i', $url)) {
                    throw new InvalidArgumentException("Invalid Facebook URL format");
                }
                return 'https://www.facebook.com/' . $url;

            case 'linkedin':
                // Remove protocol and domain if included
                $url = preg_replace('~^(?:https?://)?(?:[a-z]+\.)?linkedin\.com/~i', '', $url);
                if (!preg_match('~^[a-z0-9\-/]+$~i', $url)) {
                    throw new InvalidArgumentException("Invalid LinkedIn URL format");
                }
                return 'https://www.linkedin.com/' . $url;

            case 'website':
                // Remove any existing protocol and www
                $url = preg_replace('~^(?:https?://)?(?:www\.)?~i', '', $url);
                $url = ltrim($url, '/');

                if (!filter_var('https://' . $url, FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException("Invalid website URL format");
                }
                return 'https://' . $url;

            default:
                throw new InvalidArgumentException("Unknown URL type: " . $type);
        }
    }

    public static function validateAndNormalizeUrls(array $urls): array
    {
        $normalized = [
            'website' => '',
            'website_err' => '',
            'facebook' => '',
            'facebook_err' => '',
            'linkedin' => '',
            'linkedin_err' => '',
        ];

        foreach ($urls as $type => $value) {
            if (!empty($value)) {
                try {
                    $normalized[$type] = self::normalizeUrl($value, $type);
                } catch (InvalidArgumentException $e) {
                    $normalized[$type . '_err'] = "Invalid " . ucfirst($type) . " URL format";
                }
            }
        }

        return $normalized;
    }
}
