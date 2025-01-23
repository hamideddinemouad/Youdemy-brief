<?php
    // require 'Database.php';

    class Category {
        private $id;
        private $name;
        private $db;

        public function __construct() {
            $this->db = new Database('localhost', 'root', '123456', 'youdemy');
            $this->db->connect();
        }

        public function create($name) {
            $this->name = $name;

            $existingCategory = $this->db->fetch("SELECT id FROM categories WHERE name = ?", [$this->name]);
            if ($existingCategory) {
                throw new Exception("Une catégorie avec ce nom existe déjà.");
            }

            $this->id = $this->db->insert("INSERT INTO categories (name) VALUES (?)", [$this->name]);
            echo "Catégorie créée avec succès. ID : {$this->id}\n";
        }

        public function update($id, $name) {
            $this->id = $id;
            $this->name = $name;

            $existingCategory = $this->db->fetch("SELECT id FROM categories WHERE id = ?", [$this->id]);
            if (!$existingCategory) {
                throw new Exception("Catégorie non trouvée.");
            }

            $this->db->query("UPDATE categories SET name = ? WHERE id = ?", [$this->name, $this->id]);
            echo "Catégorie mise à jour avec succès.\n";
        }

        public function delete($id) {
            $this->id = $id;

            $existingCategory = $this->db->fetch("SELECT id FROM categories WHERE id = ?", [$this->id]);
            if (!$existingCategory) {
                throw new Exception("Catégorie non trouvée.");
            }

            $this->db->query("DELETE FROM categories WHERE id = ?", [$this->id]);
            echo "Catégorie supprimée avec succès.\n";
        }

        public function getById($id) {
            $this->id = $id;

            $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$this->id]);
            if (!$category) {
                throw new Exception("Catégorie non trouvée.");
            }

            return $category;
        }

        public function getAll() {
            $categories = $this->db->fetchAll("SELECT * FROM categories");
            return $categories;
        }

        public function getCourses($categoryId) {
            $this->id = $categoryId;

            $existingCategory = $this->db->fetch("SELECT id FROM categories WHERE id = ?", [$this->id]);
            if (!$existingCategory) {
                throw new Exception("Catégorie non trouvée.");
            }

            $courses = $this->db->fetchAll("SELECT * FROM courses WHERE category_id = ?", [$this->id]);
            return $courses;
        }
    }
?>
