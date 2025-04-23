<?php
class Pager {
    private static $instance = null;
    private $currentPage;
    private $totalItems;
    private $limit;
    private $totalPages;
    private $baseUrl;

    private function __construct($totalItems, $limit = 10) {
        $this->totalItems = $totalItems;
        $this->limit = $limit;
        $this->currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $this->totalPages = $totalItems ? ceil($totalItems / $limit) : 1;

        // Generate the base URL dynamically
        $this->baseUrl = $this->generateBaseUrl();
    }

    public static function getInstance($totalItems, $limit = 10) {
        if (self::$instance === null) {
            self::$instance = new self($totalItems, $limit);
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

        unset($queryParams['page']); // Remove 'page' param to add dynamically
        unset($queryParams['limit']); // Remove 'limit' param to add dynamically

        return $parsedUrl['path'] . '?' . http_build_query($queryParams);
    }

    public function render() {
        if ($this->totalPages <= 1) return ""; // No pagination needed

        $pagination = '<div class="pagination-buttons">';

        // Previous button (always displayed but disabled if on first page)
        $prevDisabled = ($this->currentPage <= 1) ? "disabled" : "";
        $pagination .= $this->pageButton($this->currentPage - 1, '&laquo;', 'prev ', $prevDisabled);

        // Page numbers
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $class = ($i == $this->currentPage) ? "active" : "";
            $pagination .= $this->pageButton($i, $i, $class);
        }

        // Next button (always displayed but disabled if on last page)
        $nextDisabled = ($this->currentPage >= $this->totalPages) ? "disabled" : "";
        $pagination .= $this->pageButton($this->currentPage + 1, '&raquo;', 'next ', $nextDisabled);

        $pagination .= '</div>';
        return $pagination;
    }

    private function pageButton($page, $label, $class = "", $disable = "") {
        $disabled = ($disable) ? "disabled" : "";
        $url = $this->baseUrl . "&page=$page&limit={$this->limit}";
        return "<button onclick=\"window.location.href='$url'\" class='page-btn $class' $disabled>$label</button>";
    }
}

?>
