<?php
class Filter
{
    private static $instance = null;
    private $industry;
    private $location;
    private $rating;
    private $minSalary;
    private $maxSalary;
    private $baseUrl;
    private $filtersApplied;

    private function __construct()
    {
        $this->initializeFilters();
        $this->baseUrl = $this->generateBaseUrl();
        $this->filtersApplied = $this->checkFiltersApplied();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function initializeFilters()
    {
        $this->industry = isset($_GET['industry']) ? htmlspecialchars($_GET['industry'], ENT_QUOTES, 'UTF-8') : "";
        $this->location = isset($_GET['location']) ? htmlspecialchars($_GET['location'], ENT_QUOTES, 'UTF-8') : "";
        $this->rating = isset($_GET['rating']) ? htmlspecialchars($_GET['rating'], ENT_QUOTES, 'UTF-8') : "";
        $this->minSalary = isset($_GET['minSalary']) ? htmlspecialchars($_GET['minSalary'], ENT_QUOTES, 'UTF-8') : "";
        $this->maxSalary = isset($_GET['maxSalary']) ? htmlspecialchars($_GET['maxSalary'], ENT_QUOTES, 'UTF-8') : "";
    }

    private function checkFiltersApplied()
    {
        return !empty($this->industry) || !empty($this->location) || !empty($this->rating) || !empty($this->minSalary) || !empty($this->maxSalary);
    }

    private function generateBaseUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($url);
        $queryParams = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        unset($queryParams['industry'], $queryParams['location'], $queryParams['rating'], $queryParams['minSalary'], $queryParams['maxSalary']);

        return $parsedUrl['path'];
    }

    public function renderFilters(array $categories, array $locations, array $ratings)
    {
        $filtersApplied = $this->filtersApplied ? 'true' : 'false';

        $filterHtml = "<div class='filter-container' data-filters-applied='$filtersApplied'>";
        $filterHtml .= "<form id='filterForm' class='filter-form' method='GET' action='#'>";

        $filterHtml .= $this->renderSelectFilter('industry', 'All Industries', $categories, $this->industry);
        $filterHtml .= $this->renderSelectFilter('location', 'All Locations', $locations, $this->location);
        $filterHtml .= $this->renderSelectFilter('rating', 'All Ratings', $ratings, $this->rating);
        $filterHtml .= $this->renderSalaryInputs();
        $filterHtml .= "<div>";
        $filterHtml .= "<button type='button' id='applyFilters' class='apply-filter-button'>Apply</button>";
        $filterHtml .= "<a href='" . htmlspecialchars($this->baseUrl, ENT_QUOTES, 'UTF-8') . "' class='clear-filter-button'>Clear</a>";
        $filterHtml .= "</div>";
        $filterHtml .= "</form>";
        $filterHtml .= "</div>";

        return $filterHtml;
    }

    private function renderSelectFilter($name, $defaultLabel, array $options, $selectedValue)
    {
        $html = "<select class='filter' name='$name'>";
        $html .= "<option value=''>$defaultLabel</option>";
        foreach ($options as $key => $label) {
            $selected = ($selectedValue == $key) ? "selected" : "";
            $html .= "<option value='$key' $selected>$label</option>";
        }
        $html .= "</select>";
        return $html;
    }

    private function renderSalaryInputs()
    {
        $minSalaryEscaped = $this->minSalary ?: 0;
        $maxSalaryEscaped = $this->maxSalary ?: 500000;
        $salaryFrequency = isset($_GET['salaryFrequency']) ? $_GET['salaryFrequency'] : 'monthly'; // Default to 'Per Month'

        $html = "<div class='salary-filter'>";
        $html .= "<label class='salary-label'>Salary Range:</label>";
        $html .= "<div class='salary-slider-container'>";

        // Display dynamic values
        $html .= "<div class='salary-values'>";
        $html .= "<span id='minSalaryValue'>$minSalaryEscaped</span> - ";
        $html .= "<span id='maxSalaryValue'>$maxSalaryEscaped</span>";
        $html .= "<select id='salaryFrequency' name='salaryFrequency' class='salary-frequency'>";
        $html .= "<option value='monthly' " . ($salaryFrequency == 'monthly' ? "selected" : "") . ">Per Month</option>";
        $html .= "<option value='weekly' " . ($salaryFrequency == 'weekly' ? "selected" : "") . ">Per Week</option>";
        $html .= "<option value='daily' " . ($salaryFrequency == 'daily' ? "selected" : "") . ">Per Day</option>";
        $html .= "</select>";
        $html .= "</div>";

        // Range slider with two handles
        $html .= "<div class='range-slider'>";
        $html .= "<input type='range' id='minSalaryRange' min='0' max='500000' step='2500' value='$minSalaryEscaped'>";
        $html .= "<input type='range' id='maxSalaryRange' min='0' max='500000' step='2500' value='$maxSalaryEscaped'>";
        $html .= "</div>";

        // Hidden inputs for form submission
        $html .= "<input type='hidden' name='minSalary' id='minSalary' value='$minSalaryEscaped'>";
        $html .= "<input type='hidden' name='maxSalary' id='maxSalary' value='$maxSalaryEscaped'>";
        // $html .= "<input type='hidden' name='salaryFrequencyHidden' id='salaryFrequencyHidden' value='$salaryFrequency'>";

        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }
}
