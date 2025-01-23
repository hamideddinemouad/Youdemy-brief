<?php
    session_start(); 
    require 'Database.php';
    require 'User.php';

    class Auth {
        private $db;

        public function __construct() {
            $this->db = new Database('localhost', 'root', '123456', 'youdemy');
            $this->db->connect();
        }

        public function login($email, $password) {
            $user = $this->db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
            if (!$user) {
                throw new Exception("Email ou mot de passe incorrect.");
            }

            if (!password_verify($password, $user['password'])) {
                throw new Exception("Email ou mot de passe incorrect.");
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];

            echo "Connexion réussie. Bienvenue, {$user['username']}!\n";
        }

        public function logout() {
            session_destroy();
            echo "Déconnexion réussie.\n";
        }

        public function isAuthenticated() {
            return isset($_SESSION['user_id']);
        }

        public function authorize($role) {
            if (!$this->isAuthenticated()) {
                throw new Exception("Accès non autorisé. Veuillez vous connecter.");
            }

            if ($_SESSION['user_role'] !== $role) {
                throw new Exception("Accès refusé. Vous n'avez pas les permissions nécessaires.");
            }

            return true;
        }

                public function getCurrentUser() {
            if (!$this->isAuthenticated()) {
                throw new Exception("Aucun utilisateur connecté.");
            }

            return $this->db->fetch("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']]);
        }
    }

?>
