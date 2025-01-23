<?php
require 'Database.php';
require 'User.php';

class Admin extends User {
    public function __construct() {
        parent::__construct(); 
    }

    public function validateTeacherAccount($teacherId) {
        $this->db->query("UPDATE users SET status = 'active' WHERE id = ? AND role = 'teacher'", [$teacherId]);
        echo "Compte enseignant validé avec succès.\n";
    }

    public function manageUser($userId, $action) {
        switch ($action) {
            case 'activate':
                $this->db->query("UPDATE users SET status = 'active' WHERE id = ?", [$userId]);
                echo "Utilisateur activé avec succès.\n";
                break;
            case 'suspend':
                $this->db->query("UPDATE users SET status = 'suspended' WHERE id = ?", [$userId]);
                echo "Utilisateur suspendu avec succès.\n";
                break;
            case 'delete':
                $this->db->query("DELETE FROM users WHERE id = ?", [$userId]);
                echo "Utilisateur supprimé avec succès.\n";
                break;
            default:
                throw new Exception("Action non reconnue.");
        }
    }

    public function manageContent($contentType, $action, $data) {
        switch ($contentType) {
            case 'course':
                $this->manageCourse($action, $data);
                break;
            case 'category':
                $this->manageCategory($action, $data);
                break;
            case 'tag':
                $this->manageTag($action, $data);
                break;
            default:
                throw new Exception("Type de contenu non reconnu.");
        }
    }

    private function manageCourse($action, $data) {
        switch ($action) {
            case 'add':
                $this->db->insert(
                    "INSERT INTO courses (title, description, content, teacher_id, category_id) VALUES (?, ?, ?, ?, ?)",
                    [$data['title'], $data['description'], $data['content'], $data['teacher_id'], $data['category_id']]
                );
                echo "Cours ajouté avec succès.\n";
                break;
            case 'update':
                $this->db->query(
                    "UPDATE courses SET title = ?, description = ?, content = ?, teacher_id = ?, category_id = ? WHERE id = ?",
                    [$data['title'], $data['description'], $data['content'], $data['teacher_id'], $data['category_id'], $data['id']]
                );
                echo "Cours mis à jour avec succès.\n";
                break;
            case 'delete':
                $this->db->query("DELETE FROM courses WHERE id = ?", [$data['id']]);
                echo "Cours supprimé avec succès.\n";
                break;
            default:
                throw new Exception("Action non reconnue pour les cours.");
        }
    }

    private function manageCategory($action, $data) {
        switch ($action) {
            case 'add':
                $this->db->insert("INSERT INTO categories (name) VALUES (?)", [$data['name']]);
                echo "Catégorie ajoutée avec succès.\n";
                break;
            case 'update':
                $this->db->query("UPDATE categories SET name = ? WHERE id = ?", [$data['name'], $data['id']]);
                echo "Catégorie mise à jour avec succès.\n";
                break;
            case 'delete':
                $this->db->query("DELETE FROM categories WHERE id = ?", [$data['id']]);
                echo "Catégorie supprimée avec succès.\n";
                break;
            default:
                throw new Exception("Action non reconnue pour les catégories.");
        }
    }

    private function manageTag($action, $data) {
        switch ($action) {
            case 'add':
                $this->db->insert("INSERT INTO tags (name) VALUES (?)", [$data['name']]);
                echo "Tag ajouté avec succès.\n";
                break;
            case 'update':
                $this->db->query("UPDATE tags SET name = ? WHERE id = ?", [$data['name'], $data['id']]);
                echo "Tag mis à jour avec succès.\n";
                break;
            case 'delete':
                $this->db->query("DELETE FROM tags WHERE id = ?", [$data['id']]);
                echo "Tag supprimé avec succès.\n";
                break;
            default:
                throw new Exception("Action non reconnue pour les tags.");
        }
    }

    public function viewGlobalStatistics() {
        $totalCourses = $this->db->fetchColumn("SELECT COUNT(*) FROM courses");
        $totalUsers = $this->db->fetchColumn("SELECT COUNT(*) FROM users");
        $totalTeachers = $this->db->fetchColumn("SELECT COUNT(*) FROM users WHERE role = 'teacher'");
        $totalStudents = $this->db->fetchColumn("SELECT COUNT(*) FROM users WHERE role = 'student'");

        echo "Statistiques globales :\n";
        echo "- Nombre total de cours : $totalCourses\n";
        echo "- Nombre total d'utilisateurs : $totalUsers\n";
        echo "- Nombre total d'enseignants : $totalTeachers\n";
        echo "- Nombre total d'étudiants : $totalStudents\n";
    }
}

?>
