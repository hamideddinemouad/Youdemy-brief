<?php
require_once '../models/Session.php'; 
Session::start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-book"></i> Youdemy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="home.php">
                        <i class="bi bi-house"></i> Home
                    </a>
                    <a class="nav-link" href="category.php">
                        <i class="bi bi-list-task"></i> Category
                    </a>
                    <a class="nav-link" href="courses.php">
                        <i class="bi bi-book"></i> Course
                    </a>
                    <?php if (!Session::isLoggedIn()): ?>
                        <a class="nav-link" href="register.php">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                        <a class="nav-link" href="login.php">
                            <i class="bi bi-box-arrow-in-right"></i> Connexion
                        </a>
                    <?php endif; ?>
                    <?php if (Session::isLoggedIn()): ?>
                        <?php if (Session::getUserRole() === 'student'): ?>
                            <a class="nav-link" href="bordStudent.php">
                                <i class="bi bi-house-door"></i> Tableau de Bord
                            </a>
                        <?php elseif (Session::getUserRole() === 'teacher'): ?>
                            <a class="nav-link" href="bordTeacher.php">
                                <i class="bi bi-house-door"></i> Tableau de Bord
                            </a>
                        <?php elseif (Session::getUserRole() === 'admin'): ?>
                            <a class="nav-link" href="bordAdmin.php">
                                <i class="bi bi-house-door"></i> Tableau de Bord
                            </a>
                        <?php endif; ?>

                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
