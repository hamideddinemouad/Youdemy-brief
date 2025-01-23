<?php
class Pagination {
    private $totalItems;   
    private $itemsPerPage; 
    private $currentPage;  
    private $totalPages;   

    public function __construct($totalItems, $itemsPerPage, $currentPage = 1) {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPages = $this->calculateTotalPages();
    }

    private function calculateTotalPages() {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getOffset() {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getTotalPages() {
        return $this->totalPages;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function getPaginationLinks($baseUrl, $queryParam = 'page') {
        $links = [];
    
        $separator = (strpos($baseUrl, '?') === false) ? '?' : '&';
    
        if ($this->currentPage > 1) {
            $links[] = [
                'url' => $baseUrl . $separator . $queryParam . '=' . ($this->currentPage - 1), 
                'label' => 'Précédent',
                'active' => false
            ];
        }
    
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $links[] = [
                'url' => $baseUrl . $separator . $queryParam . '=' . $i, // Utilisation de '?' ou '&' selon le cas
                'label' => $i,
                'active' => ($i == $this->currentPage)
            ];
        }

        if ($this->currentPage < $this->totalPages) {
            $links[] = [
                'url' => $baseUrl . $separator . $queryParam . '=' . ($this->currentPage + 1), // Utilisation de '?' ou '&' selon le cas
                'label' => 'Suivant',
                'active' => false
            ];
        }
    
        return $links;
    }
}