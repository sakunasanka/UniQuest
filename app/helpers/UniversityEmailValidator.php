<?php
class UniversityEmailValidator {
    private $domainToUniversityMap;

    public function __construct() {
        // Initialize the hash map
        $this->domainToUniversityMap = [];

        // Fetch data from the API and populate the hash map
        $this->loadUniversityData();
    }

    /**
     * Fetch university data from the API and populate the hash map.
     */
    private function loadUniversityData() {
        $cacheFile = 'university_cache.json';
        $cacheDuration = 24 * 60 * 60; // 24 hours in seconds
    
        // Check if the cache file exists and is not expired
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
            // Load data from the cache
            $cachedData = file_get_contents($cacheFile);
            if ($cachedData === false) {
                throw new Exception("Failed to read the cache file.");
            }
    
            $this->domainToUniversityMap = json_decode($cachedData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON in the cache file.");
            }
    
            return; // Use cached data
        }
    
        // Fetch fresh data from the API
        $url = "http://universities.hipolabs.com/search?country=sri%20lanka";
        $json = @file_get_contents($url);
        if ($json === false) {
            throw new Exception("Failed to fetch data from the API. Please check your network connection or the API URL.");
        }
    
        $universities = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON response from the API.");
        }
    
        if (empty($universities)) {
            throw new Exception("No data returned from the API.");
        }
    
        // Clear the existing map
        $this->domainToUniversityMap = [];
    
        // Populate the map with fresh data
        foreach ($universities as $university) {
            if (!isset($university['name']) || !isset($university['domains'])) {
                throw new Exception("Invalid university data format returned from the API.");
            }
    
            $universityName = $university['name'];
            $domains = $university['domains'];
    
            foreach ($domains as $domain) {
                $this->domainToUniversityMap[$domain] = $universityName;
            }
        }
    
        // Save the fresh data to the cache file
        $result = file_put_contents($cacheFile, json_encode($this->domainToUniversityMap));
        if ($result === false) {
            throw new Exception("Failed to write to the cache file. Please check file permissions.");
        }
    }

    /**
     * Add a university and its domains to the validator.
     *
     * @param string $universityName
     * @param array $domains
     */
    public function addUniversity($universityName, $domains) {
        foreach ($domains as $domain) {
            $this->domainToUniversityMap[$domain] = $universityName;
        }
    }

    /**
     * Check if an email belongs to a university.
     *
     * @param string $email
     * @return bool
     */
    public function isUniversityEmail($email) {
        $domain = $this->extractDomain($email);
        $baseDomain = $this->getBaseDomain($domain);
        return isset($this->domainToUniversityMap[$baseDomain]);
    }

    /**
     * Get the university name for a valid university email.
     *
     * @param string $email
     * @return string|null
     */
    public function getUniversityForEmail($email) {
        $domain = $this->extractDomain($email);
        $baseDomain = $this->getBaseDomain($domain);
        return $this->domainToUniversityMap[$baseDomain] ?? null;
    }

    /**
     * Extract the domain from an email address.
     *
     * @param string $email
     * @return string
     */
    private function extractDomain($email) {
        $parts = explode('@', $email);
        if (count($parts) === 2) {
            return $parts[1];
        }
        return '';
    }

    private function getBaseDomain($domain) {
        $parts = explode('.', $domain);
        $numParts = count($parts);
    
        // Handle two-part domains (e.g., "nsbm.lk")
        if ($numParts === 2) {
            return $domain; // Return the domain as-is
        }
    
        // Handle three-part domains (e.g., "cmb.ac.lk")
        if ($numParts === 3) {
            return implode('.', array_slice($parts, -2)); // Return the last 2 parts
        }
    
        // Handle domains with more than 3 parts (e.g., "stu.ucsc.cmb.ac.lk")
        if ($numParts > 3) {
            return implode('.', array_slice($parts, -3)); // Return the last 3 parts
        }
    
        return $domain; // Fallback for invalid domains
    }
}
?>