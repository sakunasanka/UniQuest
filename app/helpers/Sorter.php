<?php
class Sorter {
    private static $instance = null;
    private $currentSort;
    private $currentOrder;
    private $baseUrl;
    private $columns;

    private function __construct($columns) {
        $this->columns = $columns;
        $this->currentSort = isset($_GET['sort']) ? $_GET['sort'] : "UserID"; // Default sort column
        $this->currentOrder = isset($_GET['order']) ? $_GET['order'] : "ASC"; // Default order
        $this->baseUrl = $this->generateBaseUrl();
    }

    public static function getInstance($columns) {
        if (self::$instance === null) {
            self::$instance = new self($columns);
        }
        return self::$instance;
    }

    private function generateBaseUrl() {
        $url = $_SERVER['REQUEST_URI']; // Get full current URL
        $parsedUrl = parse_url($url);
        $queryParams = [];
        
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams); // Convert query string to array
        }

        unset($queryParams['sort']); // Remove 'sort' param to add dynamically
        unset($queryParams['order']); // Remove 'order' param to add dynamically

        return $parsedUrl['path'] . '?' . http_build_query($queryParams);
    }

    public function renderHeaders() {
        $headerHtml = "<tr>";
        
        foreach ($this->columns as $key => $column) {
            if ($key === "Actions") {
                $headerHtml .= "<th class='no-sort'>$column</th>";
                continue;
            }

            $newOrder = ($this->currentSort === $key && $this->currentOrder === "ASC") ? "DESC" : "ASC";
            $sortUrl = $this->baseUrl . "&sort=$key&order=$newOrder";
            
            $headerHtml .= "<th onclick=\"window.location.href='$sortUrl'\">$column";
            
            if ($this->currentSort === $key) {
                $headerHtml .= $this->currentOrder === "ASC" ? " ▲" : " ▼";
            }
            
            $headerHtml .= "</th>";
        }

        $headerHtml .= "</tr>";
        return $headerHtml;
    }
}

