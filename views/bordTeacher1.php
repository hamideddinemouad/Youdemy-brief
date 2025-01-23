<?php
require '../models/Database.php';
require '../models/Session.php';
require '../models/Course.php';
require '../models/Category.php';
require '../models/Tag.php';
Session::start();

if (!Session::isLoggedIn() || Session::getUserRole() !== 'teacher') {
    header("Location: login.php");
    exit();
}

$teacherId = Session::getUserId();

$course = new Course();
$category = new Category();
$tag = new Tag();

$course = new Course();
$enrolledStudents = $course->getEnrolledStudentsByTeacher($teacherId); // Récupérer les étudiants inscrits// Récupérer les étudiants inscrits

$categories = $category->getAll();
$tags = $tag->getAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Enseignant - Youdemy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .sub-navbar {
            background-color: #f8f9fa; /* Couleur de fond */
            border-bottom: 1px solid #dee2e6; /* Bordure en bas */
            padding: 10px 0; /* Espacement interne */
        }
        .sub-navbar .nav-link {
            color: #007bff; /* Couleur des liens */
            font-weight: 500; /* Poids de la police */
            margin: 0 10px; /* Espacement entre les liens */
        }
        .sub-navbar .nav-link:hover {
            color: #0056b3; /* Couleur au survol */
        }
        .sub-navbar .nav-link.active {
            color: #0056b3; /* Couleur du lien actif */
            border-bottom: 2px solid #0056b3; /* Soulignement du lien actif */
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="sub-navbar">
        <div class="container">
            <nav class="nav">
                <a class="nav-link " href="bordTeacher.php">
                    <i class="bi bi-book"></i> Gestion des Cours
                </a>
                <a class="nav-link active" href="bordTeacher1.php">
                    <i class="bi bi-person"></i> Étudiant
                </a>
                <a class="nav-link " href="bordTeacher2.php">
                    <i class="bi bi-bar-chart"></i> Statistiques
                </a>
            </nav>
        </div>
    </div>

    <!-- Tableau des étudiants inscrits -->
    <div class="container mt-4">
        <h2>Étudiants inscrits à vos cours</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom de l'étudiant</th>
                    <th>Nom du cours</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolledStudents as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['course_name']); ?></td>
                        <td>
                            <form action="reject_student.php" method="POST" style="display:inline;">
                                <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                <input type="hidden" name="course_id" value="<?php echo $student['course_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>