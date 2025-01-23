<?php
class Validator {
    
    public static function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'email n'est pas valide.");
        }
        return true;
    }

    
    public static function validatePassword($password) {
        if (strlen($password) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères.");
        }
        if (!preg_match("/[A-Z]/", $password)) {
            throw new Exception("Le mot de passe doit contenir au moins une majuscule.");
        }
        if (!preg_match("/[a-z]/", $password)) {
            throw new Exception("Le mot de passe doit contenir au moins une minuscule.");
        }
        if (!preg_match("/[0-9]/", $password)) {
            throw new Exception("Le mot de passe doit contenir au moins un chiffre.");
        }
        if (!preg_match("/[\W_]/", $password)) {
            throw new Exception("Le mot de passe doit contenir au moins un caractère spécial.");
        }
        return true;
    }

    
    public static function validateUsername($username) {
        if (strlen($username) < 3 || strlen($username) > 20) {
            throw new Exception("Le nom d'utilisateur doit contenir entre 3 et 20 caractères.");
        }
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            throw new Exception("Le nom d'utilisateur ne peut contenir que des lettres, des chiffres et des underscores.");
        }
        return true;
    }

    
    public static function validateText($text, $minLength = 10, $maxLength = 1000) {
        if (strlen($text) < $minLength || strlen($text) > $maxLength) {
            throw new Exception("Le texte doit contenir entre $minLength et $maxLength caractères.");
        }
        return true;
    }

   
    public static function validateNumber($number, $min = 1, $max = PHP_INT_MAX) {
        if (!is_numeric($number) || $number < $min || $number > $max) {
            throw new Exception("Le nombre doit être compris entre $min et $max.");
        }
        return true;
    }

    
    public static function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        if (!$d || $d->format($format) !== $date) {
            throw new Exception("La date n'est pas valide. Format attendu : $format.");
        }
        return true;
    }

    public static function validateUrl($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("L'URL n'est pas valide.");
        }
        return true;
    }

}
