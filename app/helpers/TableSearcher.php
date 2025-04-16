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
        $this->searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : "";
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
        unset($queryParams['searchBy']); // Remove 'searchBy' param to add dynamically

        return $parsedUrl['path'] . '?' . http_build_query($queryParams);
    }

    // Render search bar
    public function renderSearchBar($columns)
    {
        $baseUrlEscaped = htmlspecialchars($this->baseUrl, ENT_QUOTES, 'UTF-8');

        // Get current search values
        $searchTermEscaped = htmlspecialchars($this->searchTerm, ENT_QUOTES, 'UTF-8');
        $searchByEscaped = htmlspecialchars($this->searchBy, ENT_QUOTES, 'UTF-8');

        $searchBarHtml = "<form class='search-bar' method='GET' action='$baseUrlEscaped'>";
        $searchBarHtml .= "<span class='material-symbols-outlined icon'>search</span>";
        $searchBarHtml .= "<input type='text' class='search' name='search' placeholder='Search...' value='$searchTermEscaped'>";

        // Dropdown for selecting search fields
        $searchBarHtml .= "<select class='column-select' name='searchBy'>";
        // $searchBarHtml .= "<option value=''>All</option>";
        foreach ($columns as $key => $column) {
            $keyEscaped = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
            $columnEscaped = htmlspecialchars($column, ENT_QUOTES, 'UTF-8');
            $selected = ($searchByEscaped === $keyEscaped) ? "selected" : "";
            $searchBarHtml .= "<option value='$keyEscaped' $selected>$columnEscaped</option>";
        }
        $searchBarHtml .= "</select>";

        // Search Button
        $searchBarHtml .= "<button type='submit' class='search-button'>Search</button>";

        // Clear Button (resets form by linking to base URL)
        $searchBarHtml .= "<a href='$baseUrlEscaped' class='clear-button'>Clear</a>";

        $searchBarHtml .= "</form>";

        return $searchBarHtml;
    }
}
