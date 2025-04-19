<?php
class MainSearcher
{
    private static $instance = null;
    private $searchTerm;
    private $baseUrl;
    private $filtersApplied;

    // Constructor
    private function __construct()
    {
        $this->searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
        $this->baseUrl = $this->generateBaseUrl();
        $this->filtersApplied = $this->checkFiltersApplied();
    }

    // Singleton pattern
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Generate base URL without showFilters
    private function generateBaseUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($url);
        $queryParams = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        unset($queryParams['search']);

        return $parsedUrl['path'] . '?' . http_build_query($queryParams);
    }

    // Check if any filters are applied
    private function checkFiltersApplied()
    {
        $filterKeys = ['industry', 'location', 'rating', 'minSalary', 'maxSalary']; // Define filter keys
        foreach ($filterKeys as $key) {
            if (!empty($_GET[$key])) {
                return true; // A filter is applied
            }
        }
        return false;
    }

    // Render search bar
    public function renderSearchBar($placeHolder)
    {
        $baseUrlEscaped = htmlspecialchars($this->baseUrl, ENT_QUOTES, 'UTF-8');
        $searchTermEscaped = htmlspecialchars($this->searchTerm, ENT_QUOTES, 'UTF-8');
        $filtersApplied = $this->filtersApplied ? 'true' : 'false'; // Pass to JS

        $searchBarHtml = "<div class='search-bar-container'>";
        $searchBarHtml .= "<form class='search-bar' method='GET' action='$baseUrlEscaped'>";
        $searchBarHtml .= "<span class='material-symbols-outlined icon'>search</span>";
        $searchBarHtml .= "<input type='text' class='search' name='search' id='searchInput' placeholder='$placeHolder' value='$searchTermEscaped'>";
        $searchBarHtml .= "<span class='clear-icon' onclick=\"window.location.href='$baseUrlEscaped'\" id='clearSearch'>&times;</span>"; // Cross icon for clearing
        $searchBarHtml .= "<button type='submit' class='search-button'>Search</button>";
        $searchBarHtml .= "<button type='button' id='toggleFilters' class='filters-button' data-filters-applied='$filtersApplied'><i class='fa-solid fa-filter'></i><span>Show Filters</span></button>";
        $searchBarHtml .= "</form>";
        $searchBarHtml .= "</div>";

        return $searchBarHtml;
    }
}
?>
