<?php

    class Database {
        private $host;
        private $username;
        private $password;
        private $dbname;
        private $connection;

        public function __construct($host, $username, $password, $dbname) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
        }

        public function connect() {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
                $this->connection = new PDO($dsn, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                // echo "Connexion à la base de données réussie.\n";
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        public function query($sql, $params = []) {
            try {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute($params);
                return $stmt;
            } catch (PDOException $e) {
                die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
            }
        }

        public function fetch($sql, $params = []) {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch();
        }

        public function fetchAll($sql, $params = []) {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll();
        }

        public function fetchColumn($sql, $params = []) {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchColumn();
        }

        public function insert($sql, $params = []) {
            $this->query($sql, $params);
            return $this->connection->lastInsertId();
        }

        public function close() {
            $this->connection = null;
            echo "Connexion à la base de données fermée.\n";
        }
    }

?>
