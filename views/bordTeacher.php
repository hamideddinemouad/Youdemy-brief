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

$courses = $course->getByTeacher($teacherId);

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
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="sub-navbar">
        <div class="container">
            <nav class="nav">
                <a class="nav-link active" href="bordTeacher.php">
                    <i class="bi bi-book"></i> Gestion des Cours
                </a>
                <a class="nav-link" href="bordTeacher1.php">
                    <i class="bi bi-person"></i> Étudiant
                </a>
                <a class="nav-link" href="bordTeacher2.php">
                    <i class="bi bi-bar-chart"></i> Statistiques
                </a>
            </nav>
        </div>
    </div>

    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $contentLink = $_POST['content_link'];
            $categoryId = $_POST['category_id'];
            $selectedTags = $_POST['tags'] ?? [];
        
            try {
                if (empty($title) || empty($description) || empty($contentLink) || empty($categoryId)) {
                    throw new Exception("Tous les champs obligatoires doivent être remplis.");
                }
        
                $courseId = $course->create($title, $description, $contentLink, $teacherId, $categoryId);
        
                foreach ($selectedTags as $tagId) {
                    $tag->associateWithCourse($tagId, $courseId);
                }
        
                echo "<div class='alert alert-success'>Cours créé avec succès.</div>";
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
            }
        }
    ?>

    <div class="container mt-4">
        <!-- Formulaire pour ajouter un cours -->
        <div class="form-container">
            <h2><i class="bi bi-plus-circle"></i> Ajouter un Nouveau Cours</h2>
            <form id="addCourseForm" method="POST" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du Cours</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                    <div id="titleError" class="text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    <div id="descriptionError" class="text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="content_link" class="form-label">Lien du Cours</label>
                    <input type="url" class="form-control" id="content_link" name="content_link" >
                    <div id="contentLinkError" class="text-danger"></div>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Choisir une catégorie</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="categoryError" class="text-danger"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags</label>
                    <div>
                        <?php foreach ($tags as $t): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $t['id'] ?>" id="tag<?= $t['id'] ?>">
                                <label class="form-check-label" for="tag<?= $t['id'] ?>"><?= $t['name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Ajouter le Cours</button>
            </form>
        </div>

        <!-- Tableau des cours existants -->
        <div class="table-container">
            <h2><i class="bi bi-list"></i> Mes Cours</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Étudiants Inscrits</th>
                        <th>Date de Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['title']) ?></td>
                            <td><?= $course->getEnrolledStudents($c['id']) ? count($course->getEnrolledStudents($c['id'])) : 0 ?></td>
                            <td><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                            <td>
                                <a href="edit_course.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Modifier</a>
                                <a href="courses/delete.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"><i class="bi bi-trash"></i> Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Validation Front-End en JavaScript -->
    <script>
        function validateForm() {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const categoryId = document.getElementById('category_id').value;

            let isValid = true;

        
            if (title.length < 5 || title.length > 100) {
                document.getElementById('titleError').textContent = 'Le titre doit contenir entre 5 et 100 caractères.';
                isValid = false;
            } else {
                document.getElementById('titleError').textContent = '';
            }

            // Validation de la description
            if (description.length < 10 || description.length > 500) {
                document.getElementById('descriptionError').textContent = 'La description doit contenir entre 10 et 500 caractères.';
                isValid = false;
            } else {
                document.getElementById('descriptionError').textContent = '';
            }

            // Validation de la catégorie
            if (!categoryId) {
                document.getElementById('categoryError').textContent = 'Veuillez sélectionner une catégorie.';
                isValid = false;
            } else {
                document.getElementById('categoryError').textContent = '';
            }

            return isValid;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>