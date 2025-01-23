<?php
// require 'Database.php';

class Enrollment {
    private $id;
    private $studentId;
    private $courseId;
    private $enrolledAt;
    private $status;
    private $db;

    public function __construct() {
        $this->db = new Database('localhost', 'root', '123456', 'youdemy');
        $this->db->connect();
    }

    public function enroll($studentId, $courseId) {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
        $existingEnrollment = $this->db->fetch(
            "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?",
            [$this->studentId, $this->courseId]
        );
        if ($existingEnrollment) {
            throw new Exception("L'étudiant est déjà inscrit à ce cours.");
        }

        $course = $this->db->fetch("SELECT id FROM courses WHERE id = ?", [$this->courseId]);
        if (!$course) {
            throw new Exception("Cours non trouvé.");
        }

        $student = $this->db->fetch("SELECT id FROM users WHERE id = ? AND role = 'student'", [$this->studentId]);
        if (!$student) {
            throw new Exception("L'utilisateur n'est pas un étudiant.");
        }

        $this->id = $this->db->insert(
            "INSERT INTO enrollments (student_id, course_id, status) VALUES (?, ?, 'active')",
            [$this->studentId, $this->courseId]
        );

        echo "Inscription réussie. ID : {$this->id}\n";
    }

    public function unenroll($enrollmentId) {
        $this->id = $enrollmentId;

        $existingEnrollment = $this->db->fetch("SELECT id FROM enrollments WHERE id = ?", [$this->id]);
        if (!$existingEnrollment) {
            throw new Exception("Inscription non trouvée.");
        }

        $this->db->query("DELETE FROM enrollments WHERE id = ?", [$this->id]);
        echo "Désinscription réussie.\n";
    }

    public function getByStudent($studentId) {
        $this->studentId = $studentId;
    
        $enrollments = $this->db->fetchAll(
            "SELECT e.id, e.course_id, c.title, c.content, e.enrolled_at, e.status 
             FROM enrollments e 
             JOIN courses c ON e.course_id = c.id 
             WHERE e.student_id = ?",
            [$this->studentId]
        );
    
        return $enrollments;
    }

    public function getByCourse($courseId) {
        $this->courseId = $courseId;

        $students = $this->db->fetchAll(
            "SELECT u.id, u.username, u.email, e.enrolled_at, e.status 
             FROM enrollments e 
             JOIN users u ON e.student_id = u.id 
             WHERE e.course_id = ?",
            [$this->courseId]
        );

        return $students;
    }

    public function updateStatus($enrollmentId, $status) {
        $this->id = $enrollmentId;
        $this->status = $status;
        $existingEnrollment = $this->db->fetch("SELECT id FROM enrollments WHERE id = ?", [$this->id]);
        if (!$existingEnrollment) {
            throw new Exception("Inscription non trouvée.");
        }

        $this->db->query("UPDATE enrollments SET status = ? WHERE id = ?", [$this->status, $this->id]);
        echo "Statut de l'inscription mis à jour avec succès.\n";
    }

    public function unenrollByCourseAndStudent($courseId, $studentId) {
        $existingEnrollment = $this->db->fetch(
            "SELECT id FROM enrollments WHERE course_id = ? AND student_id = ?",
            [$courseId, $studentId]
        );
    
        if (!$existingEnrollment) {
            throw new Exception("L'inscription de l'étudiant au cours n'a pas été trouvée.");
        }
    
        $this->db->query(
            "DELETE FROM enrollments WHERE course_id = ? AND student_id = ?",
            [$courseId, $studentId]
        );
    }
}
