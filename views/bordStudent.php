<?php
include 'includes/header.php';
require '../models/Database.php';
require '../models/Course.php';
require '../models/Enrollment.php';
// require '../models/Session.php';

Session::start();

if (!Session::isLoggedIn() || Session::getUserRole() !== 'student') {
    header("Location: login.php"); // Rediriger vers la page de connexion
    exit();
}

$studentId = Session::getUserId();
$enrollment = new Enrollment();

try {
    $enrollments = $enrollment->getByStudent($studentId);
} catch (Exception $e) {
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle'></i> Erreur : " . $e->getMessage() . "</div>";
    echo "</div>";
    exit();
}

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-person'></i> Tableau de Bord Étudiant</h1>";
if (count($enrollments) > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Titre du Cours</th>";
    echo "<th>Date d'Inscription</th>";
    echo "<th>Statut</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($enrollments as $enrollment) {
        echo "<tr>";
        echo "<td>{$enrollment['title']}</td>";
        echo "<td>" . date('d/m/Y', strtotime($enrollment['enrolled_at'])) . "</td>";
        echo "<td>{$enrollment['status']}</td>";
        echo "<td>";
        echo "<a href='{$enrollment['content']}' class='btn btn-primary btn-sm' target='_blank'><i class='bi bi-eye'></i> Voir le cours</a>";
        echo "&nbsp;"; 
        echo "<a href='unenroll.php?enrollment_id={$enrollment['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir vous désinscrire de ce cours ?\")'><i class='bi bi-trash'></i> Se désinscrire</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='alert alert-info'><i class='bi bi-info-circle'></i> Vous n'êtes inscrit à aucun cours pour le moment.</div>";
}

echo "</div>"; 

require 'includes/footer.php';
?>