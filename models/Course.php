<?php
// require 'Database.php';

class Course {
    private $id;
    private $title;
    private $description;
    private $content;
    private $teacherId;
    private $categoryId;
    private $createdAt;
    private $updatedAt;
    private $db;

    public function __construct() {
        $this->db = new Database('localhost', 'root', '123456', 'youdemy');
        $this->db->connect();
    }

    public function create($title, $description, $content, $teacherId, $categoryId) {
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->teacherId = $teacherId;
        $this->categoryId = $categoryId;

        $teacher = $this->db->fetch("SELECT id FROM users WHERE id = ? AND role = 'teacher'", [$this->teacherId]);
        if (!$teacher) {
            throw new Exception("Enseignant non trouvé.");
        }

        $category = $this->db->fetch("SELECT id FROM categories WHERE id = ?", [$this->categoryId]);
        if (!$category) {
            throw new Exception("Catégorie non trouvée.");
        }

        $this->id = $this->db->insert(
            "INSERT INTO courses (title, description, content, teacher_id, category_id) VALUES (?, ?, ?, ?, ?)",
            [$this->title, $this->description, $this->content, $this->teacherId, $this->categoryId]
        );

        // echo "Cours créé avec succès. ID : {$this->id}\n";
        return $this->id;
    }

    public function update($id, $title, $description, $content, $teacherId, $categoryId) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->teacherId = $teacherId;
        $this->categoryId = $categoryId;

        $existingCourse = $this->db->fetch("SELECT id FROM courses WHERE id = ?", [$this->id]);
        if (!$existingCourse) {
            throw new Exception("Cours non trouvé.");
        }

        $teacher = $this->db->fetch("SELECT id FROM users WHERE id = ? AND role = 'teacher'", [$this->teacherId]);
        if (!$teacher) {
            throw new Exception("Enseignant non trouvé.");
        }

        $category = $this->db->fetch("SELECT id FROM categories WHERE id = ?", [$this->categoryId]);
        if (!$category) {
            throw new Exception("Catégorie non trouvée.");
        }

        $this->db->query(
            "UPDATE courses SET title = ?, description = ?, content = ?, teacher_id = ?, category_id = ? WHERE id = ?",
            [$this->title, $this->description, $this->content, $this->teacherId, $this->categoryId, $this->id]
        );

        echo "Cours mis à jour avec succès.\n";
    }

    public function delete($id) {
        $this->id = $id;

        $existingCourse = $this->db->fetch("SELECT id FROM courses WHERE id = ?", [$this->id]);
        if (!$existingCourse) {
            throw new Exception("Cours non trouvé.");
        }

        $this->db->query("DELETE FROM courses WHERE id = ?", [$this->id]);
        echo "Cours supprimé avec succès.\n";
    }

    public function getById($id) {
        $this->id = $id;
        $course = $this->db->fetch("SELECT * FROM courses WHERE id = ?", [$this->id]);
        if (!$course) {
            throw new Exception("Cours non trouvé.");
        }

        return $course;
    }

    public function getAll() {
        $courses = $this->db->fetchAll("SELECT * FROM courses");
        return $courses;
    }

    public function getByTeacher($teacherId) {
        $this->teacherId = $teacherId;
        $courses = $this->db->fetchAll("SELECT * FROM courses WHERE teacher_id = ?", [$this->teacherId]);
        return $courses;
    }

    public function getByCategory($categoryId) {
        $this->categoryId = $categoryId;
        $courses = $this->db->fetchAll("SELECT * FROM courses WHERE category_id = ?", [$this->categoryId]);
        return $courses;
    }

    public function getEnrolledStudents($courseId) {
        $this->id = $courseId;

        $students = $this->db->fetchAll(
            "SELECT u.id, u.username, u.email FROM users u 
             JOIN enrollments e ON u.id = e.student_id 
             WHERE e.course_id = ?",
            [$this->id]
        );

        return $students;
    }

    public function getEnrolledStudentsByTeacher($teacherId) {
        $this->teacherId = $teacherId;
    
        $query = "
            SELECT u.id AS student_id, u.username AS student_name, c.id AS course_id, c.title AS course_name
            FROM enrollments e
            JOIN users u ON e.student_id = u.id
            JOIN courses c ON e.course_id = c.id
            WHERE c.teacher_id = ?
        ";
    
        return $this->db->fetchAll($query, [$this->teacherId]);
    }
}
