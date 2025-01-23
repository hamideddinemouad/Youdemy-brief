<?php
require 'Database.php';

class Statistics {
    private $db;

    public function __construct() {
        $this->db = new Database('localhost', 'root', 'password', 'youdemy');
        $this->db->connect();
    }

    public function getTotalCourses() {
        return $this->db->fetchColumn("SELECT COUNT(*) FROM courses");
    }

    public function getTotalUsers() {
        return $this->db->fetchColumn("SELECT COUNT(*) FROM users");
    }

    public function getTotalTeachers() {
        return $this->db->fetchColumn("SELECT COUNT(*) FROM users WHERE role = 'teacher'");
    }

    public function getTotalStudents() {
        return $this->db->fetchColumn("SELECT COUNT(*) FROM users WHERE role = 'student'");
    }

    public function getMostPopularCourses($limit = 5) {
        return $this->db->fetchAll(
            "SELECT c.id, c.title, COUNT(e.id) AS enrollments 
             FROM courses c 
             LEFT JOIN enrollments e ON c.id = e.course_id 
             GROUP BY c.id 
             ORDER BY enrollments DESC 
             LIMIT ?",
            [$limit]
        );
    }

    public function getTopTeachers($limit = 5) {
        return $this->db->fetchAll(
            "SELECT u.id, u.username, COUNT(c.id) AS courses 
             FROM users u 
             LEFT JOIN courses c ON u.id = c.teacher_id 
             WHERE u.role = 'teacher' 
             GROUP BY u.id 
             ORDER BY courses DESC 
             LIMIT ?",
            [$limit]
        );
    }

    public function getMostPopularCategories($limit = 5) {
        return $this->db->fetchAll(
            "SELECT cat.id, cat.name, COUNT(c.id) AS courses 
             FROM categories cat 
             LEFT JOIN courses c ON cat.id = c.category_id 
             GROUP BY cat.id 
             ORDER BY courses DESC 
             LIMIT ?",
            [$limit]
        );
    }

    public function getGlobalStatistics() {
        return [
            'total_courses' => $this->getTotalCourses(),
            'total_users' => $this->getTotalUsers(),
            'total_teachers' => $this->getTotalTeachers(),
            'total_students' => $this->getTotalStudents(),
            'most_popular_courses' => $this->getMostPopularCourses(),
            'top_teachers' => $this->getTopTeachers(),
            'most_popular_categories' => $this->getMostPopularCategories()
        ];
    }

    public function getTeacherStatistics($teacherId) {
        $totalCourses = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM courses WHERE teacher_id = ?",
            [$teacherId]
        );

        $totalEnrollments = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM enrollments e 
             JOIN courses c ON e.course_id = c.id 
             WHERE c.teacher_id = ?",
            [$teacherId]
        );

        return [
            'total_courses' => $totalCourses,
            'total_enrollments' => $totalEnrollments
        ];
    }

    public function getCourseStatistics($courseId) {
        $totalEnrollments = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM enrollments WHERE course_id = ?",
            [$courseId]
        );

        $averageRating = $this->db->fetchColumn(
            "SELECT AVG(rating) FROM comments WHERE course_id = ?",
            [$courseId]
        );

        return [
            'total_enrollments' => $totalEnrollments,
            'average_rating' => $averageRating ? round($averageRating, 2) : null
        ];
    }
}
