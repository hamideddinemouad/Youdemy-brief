<?php
    require 'Database.php';
    require 'Validator.php';

    class User {
        private $id;
        private $username;
        private $email;
        private $password;
        private $role;
        private $status;
        private $createdAt;
        private $updatedAt;
        private $db;

        public function __construct() {
            $this->db = new Database('localhost', 'root', '123456', 'youdemy');
            $this->db->connect();
        }

        public function register($username, $email, $password, $role = 'student') {
            
            try {
                Validator::validateUsername($username);
                Validator::validateEmail($email);
                Validator::validatePassword($password);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
    
           
            $existingUser = $this->db->fetch("SELECT id FROM users WHERE email = ?", [$email]);
            if ($existingUser) {
                throw new Exception("Un utilisateur avec cet email existe déjà.");
            }
    
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
           
            $this->id = $this->db->insert(
                "INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)",
                [$username, $email, $hashedPassword, $role, 'pending']
            );
    
            
            $this->fetchUserData($this->id);
        }

        public function login($email, $password) {
            $user = $this->db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
            if (!$user) {
                throw new Exception("Email ou mot de passe incorrect.");
            }

            if (!password_verify($password, $user['password'])) {
                throw new Exception("Email ou mot de passe incorrect.");
            }
            $this->fetchUserData($user['id']);
            // session_start();
            $_SESSION['user_id'] = $this->id;
            $_SESSION['user_role'] = $this->role;
            // echo "Connexion réussie. Bienvenue, {$this->username}!\n";
            return [
                'id' => $this->id,
                'username' => $this->username,
                'role' => $this->role,
            ];
        }

        public function logout() {
            session_start();
            session_destroy();
            echo "Déconnexion réussie.\n";
        }

        public function updateProfile($data) {
            $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $this->db->query($sql, [$data['username'], $data['email'], $this->id]);
            $this->fetchUserData($this->id);
            echo "Profil mis à jour avec succès.\n";
        }

        public function changePassword($oldPassword, $newPassword) {
            if (!password_verify($oldPassword, $this->password)) {
                throw new Exception("Ancien mot de passe incorrect.");
            }
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->db->query("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $this->id]);
            echo "Mot de passe mis à jour avec succès.\n";
        }

        private function fetchUserData($userId) {
            $user = $this->db->fetch("SELECT * FROM users WHERE id = ?", [$userId]);
            if (!$user) {
                throw new Exception("Utilisateur non trouvé.");
            }

            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->role = $user['role'];
            $this->status = $user['status'];
            $this->createdAt = $user['created_at'];
            $this->updatedAt = $user['updated_at'];
        }

        public function getId() { return $this->id; }
        public function getUsername() { return $this->username; }
        public function getEmail() { return $this->email; }
        public function getRole() { return $this->role; }
        public function getStatus() { return $this->status; }
        public function getCreatedAt() { return $this->createdAt; }
        public function getUpdatedAt() { return $this->updatedAt; }
    }

?>
