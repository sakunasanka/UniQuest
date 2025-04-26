<?php
class TableSearcher
{
    private static $instance = null;
    private $searchTerm;
    private $searchBy;
    private $baseUrl;

    // Constructor
    private function __construct()
    {
        $this->searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
        $this->baseUrl = $this->generateBaseUrl();
    }

    // Singleton pattern
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Generate base URL
    private function generateBaseUrl()
    {
        $url = $_SERVER['REQUEST_URI']; // Get full current URL
        $parsedUrl = parse_url($url);
        $queryParams = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams); // Convert query string to array
        }

        unset($queryParams['search']); // Remove 'search' param to add dynamically
        unset($queryParams['page']); // Remove 'page' param to add dynamically
        unset($queryParams['sort']); // Remove 'sort' param to add dynamically
        unset($queryParams['order']); // Remove 'order' param to add dynamically
        unset($queryParams['limit']); // Remove 'limit' param to add dynamically
        unset($queryParams['offset']); // Remove 'offset' param to add dynamically

        return $parsedUrl['path'] . '?' . http_build_query($queryParams);
    }

    // Render search bar
    public function renderSearchBar()
    {
        $baseUrlEscaped = htmlspecialchars($this->baseUrl, ENT_QUOTES, 'UTF-8');

        // Get current search values
        $searchTermEscaped = htmlspecialchars($this->searchTerm, ENT_QUOTES, 'UTF-8');

        // Search Bar form
        $searchBarHtml = "<form class='search-bar' method='GET' action='$baseUrlEscaped'>";
        // $searchBarHtml .= "<span class='material-symbols-outlined icon'>search</span>";
        $searchBarHtml .= "<input type='text' class='search' name='search' placeholder='Search...' value='$searchTermEscaped'>";

        // Search Button
        $searchBarHtml .= "<button type='submit' class='search-button'>Search</button>";

        // Clear Button (resets form by linking to base URL)
        $searchBarHtml .= "<a href='$baseUrlEscaped' class='clear-button'>Clear</a>";

        $searchBarHtml .= "</form>";

        return $searchBarHtml;
    }
}
