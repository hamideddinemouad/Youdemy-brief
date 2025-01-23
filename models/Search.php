<?php
// require 'Database.php';

class Search {
    private $db;

    public function __construct() {
        $this->db = new Database('localhost', 'root', '123456', 'youdemy');
        $this->db->connect();
    }

    public function searchCourses($keyword, $filters = []) {
        $sql = "SELECT c.id, c.title, c.description, c.teacher_id, c.category_id 
                FROM courses c 
                WHERE c.title LIKE :keyword OR c.description LIKE :keyword";
    
        $params = [':keyword' => '%' . $keyword . '%'];
    
        if (!empty($filters['category_id'])) {
            $sql .= " AND c.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        if (!empty($filters['teacher_id'])) {
            $sql .= " AND c.teacher_id = :teacher_id";
            $params[':teacher_id'] = $filters['teacher_id'];
        }
    
        $stmt = $this->db->query($sql, $params);
    
        return $stmt->fetchAll();
    }

    public function searchTeachers($keyword) {
        $sql = "SELECT u.id, u.username, u.email 
                FROM users u 
                WHERE u.role = 'teacher' AND (u.username LIKE :keyword OR u.email LIKE :keyword)";

        $stmt = $this->db->query($sql, [':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    public function searchCategories($keyword) {
        $sql = "SELECT id, name 
                FROM categories 
                WHERE name LIKE :keyword";

        $stmt = $this->db->query($sql, [':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    public function searchTags($keyword) {
        $sql = "SELECT id, name 
                FROM tags 
                WHERE name LIKE :keyword";

        $stmt = $this->db->query($sql, [':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    public function advancedSearch($keyword, $filters = []) {
        $results = [];

        $results['courses'] = $this->searchCourses($keyword, $filters);

        $results['teachers'] = $this->searchTeachers($keyword);

        $results['categories'] = $this->searchCategories($keyword);

        $results['tags'] = $this->searchTags($keyword);

        return $results;
    }
}
?>