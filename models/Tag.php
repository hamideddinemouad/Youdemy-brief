<?php
require_once 'Database.php';
class Tag {
    private $id;
    private $name;
    private $db;

    public function __construct() {
         $this->db = new Database('localhost', 'root', '123456', 'youdemy');
         $this->db->connect();
    }

    public function create($name) {
        $this->name = $name;

        
        $existingTag = $this->db->fetch("SELECT id FROM tags WHERE name = ?", [$this->name]);
        if ($existingTag) {
            throw new Exception("Un tag avec ce nom existe déjà.");
        }

    
        $this->id = $this->db->insert("INSERT INTO tags (name) VALUES (?)", [$this->name]);
        echo "Tag créé avec succès. ID : {$this->id}\n";
    }

    public function getById($id) {
        $this->id = $id;

        $tag = $this->db->fetch("SELECT * FROM tags WHERE id = ?", [$this->id]);
        if (!$tag) {
            throw new Exception("Tag non trouvé.");
        }

        return $tag;
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM tags");
    }

    public function update($id, $name) {
        $this->id = $id;
        $this->name = $name;

        
        $existingTag = $this->db->fetch("SELECT id FROM tags WHERE id = ?", [$this->id]);
        if (!$existingTag) {
            throw new Exception("Tag non trouvé.");
        }

        
        $this->db->query("UPDATE tags SET name = ? WHERE id = ?", [$this->name, $this->id]);
        echo "Tag mis à jour avec succès.\n";
    }

    public function delete($id) {
        $this->id = $id;

        
        $existingTag = $this->db->fetch("SELECT id FROM tags WHERE id = ?", [$this->id]);
        if (!$existingTag) {
            throw new Exception("Tag non trouvé.");
        }

        
        $this->db->query("DELETE FROM tags WHERE id = ?", [$this->id]);
        echo "Tag supprimé avec succès.\n";
    }

    public function associateWithCourse($tagId, $courseId) {
        $this->id = $tagId;

        $existingTag = $this->db->fetch("SELECT id FROM tags WHERE id = ?", [$this->id]);
        if (!$existingTag) {
            throw new Exception("Tag non trouvé.");
        }

        $existingCourse = $this->db->fetch("SELECT id FROM courses WHERE id = ?", [$courseId]);
        if (!$existingCourse) {
            throw new Exception("Cours non trouvé.");
        }

        $existingAssociation = $this->db->fetch(
            "SELECT id FROM course_tag WHERE tag_id = ? AND course_id = ?",
            [$this->id, $courseId]
        );
        if ($existingAssociation) {
            throw new Exception("Ce tag est déjà associé à ce cours.");
        }

        $this->db->insert("INSERT INTO course_tag (tag_id, course_id) VALUES (?, ?)", [$this->id, $courseId]);
        
    }

    public function dissociateFromCourse($tagId, $courseId) {
        $this->id = $tagId;

        $existingAssociation = $this->db->fetch(
            "SELECT id FROM course_tag WHERE tag_id = ? AND course_id = ?",
            [$this->id, $courseId]
        );
        if (!$existingAssociation) {
            throw new Exception("Ce tag n'est pas associé à ce cours.");
        }

        $this->db->query("DELETE FROM course_tag WHERE tag_id = ? AND course_id = ?", [$this->id, $courseId]);
        echo "Tag dissocié du cours avec succès.\n";
    }

    public function getTagsByCourse($courseId) {
        return $this->db->fetchAll(
            "SELECT t.id, t.name 
             FROM tags t 
             JOIN course_tag ct ON t.id = ct.tag_id 
             WHERE ct.course_id = ?",
            [$courseId]
        );
    }

    public function getCoursesByTag($tagId) {
        $this->id = $tagId;

        return $this->db->fetchAll(
            "SELECT c.id, c.title 
             FROM courses c 
             JOIN course_tag ct ON c.id = ct.course_id 
             WHERE ct.tag_id = ?",
            [$this->id]
        );
    }
}

?>
