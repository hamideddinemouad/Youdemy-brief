<?php
include 'includes/header.php';
require '../models/Database.php';
require '../models/Course.php';
require '../models/Pagination.php';
require '../models/Search.php';
require '../models/Enrollment.php'; 
// require '../models/Session.php';   


Session::start();

$isLoggedIn = Session::isLoggedIn();
$userRole = $isLoggedIn ? Session::getUserRole() : null;
$userId = $isLoggedIn ? Session::getUserId() : null;

$enrollment = new Enrollment();

$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 8; 
$searchKeyword = isset($_GET['search']) ? trim($_GET['search']) : ''; 

$course = new Course();
$search = new Search();

try {
    if (!empty($searchKeyword)) {
        $allCourses = $search->searchCourses($searchKeyword);
    } else {
        $allCourses = $categoryId ? $course->getByCategory($categoryId) : $course->getAll();
    }

    $totalItems = count($allCourses);
    $pagination = new Pagination($totalItems, $itemsPerPage, $page);
    $offset = $pagination->getOffset();
    $courses = array_slice($allCourses, $offset, $itemsPerPage);

    // Afficher la barre de recherche
    echo "<div class='container mt-4'>";
    echo "<h1 class='text-center mb-4'><i class='bi bi-book'></i> Cours</h1>";
    echo "<form method='GET' action='courses.php' class='mb-4'>";
    echo "<div class='input-group'>";
    echo "<input type='text' name='search' class='form-control' placeholder='Rechercher des cours...' value='{$searchKeyword}'>";
    if ($categoryId) {
        echo "<input type='hidden' name='category_id' value='{$categoryId}'>";
    }
    echo "<button type='submit' class='btn btn-primary'><i class='bi bi-search'></i> Rechercher</button>";
    echo "</div>";
    echo "</form>";

    // Afficher les cours
    echo "<div class='row'>";
    foreach ($courses as $course) {
        echo "<div class='col-md-6 col-lg-4 mb-4'>";
        echo "<div class='card h-100 shadow-sm'>";
        echo "<div class='card-body'>";
        echo "<h2 class='card-title text-primary'><i class='bi bi-file-earmark-text'></i> {$course['title']}</h2>";
        echo "<p class='card-text'>{$course['description']}</p>";

        if ($isLoggedIn) {
            if ($userRole === 'student') {
                $isEnrolled = false;
                try {
                    $enrollments = $enrollment->getByStudent($userId);
                    foreach ($enrollments as $enrollmentData) {
                        if ($enrollmentData['course_id'] == $course['id']) {
                            $isEnrolled = true;
                            break;
                        }
                    }
                } catch (Exception $e) {
                }

                if ($isEnrolled) {
                    echo "<a href='{$course['content']}' class='btn btn-primary' target='_blank'><i class='bi bi-eye'></i> Voir le cours</a>";
                }
                else {
                    echo "<a href='enroll.php?course_id={$course['id']}' class='btn btn-success'><i class='bi bi-plus-circle'></i> S'inscrire au cours</a>";
                }
            }
            elseif ($userRole === 'teacher' || $userRole === 'admin') {
                echo "<a href='{$course['content']}' class='btn btn-primary' target='_blank'><i class='bi bi-eye'></i> Voir le cours</a>";
            }
        }
        else {
            echo "<p class='text-muted'><i class='bi bi-info-circle'></i> Connectez-vous pour accéder à ce cours.</p>";
        }

        echo "</div>"; 
        echo "</div>"; 
        echo "</div>"; 
    }
    echo "</div>";

   
    $baseUrl = "courses.php?" . ($categoryId ? "category_id=$categoryId&" : "") . ($searchKeyword ? "search=$searchKeyword&" : "");
    $paginationLinks = $pagination->getPaginationLinks($baseUrl);

    echo "<nav aria-label='Page navigation' class='my-4'>";
    echo "<ul class='pagination justify-content-center'>";
    foreach ($paginationLinks as $link) {
        $class = $link['active'] ? 'page-item active' : 'page-item';
        echo "<li class='$class'>";
        echo "<a class='page-link' href='{$link['url']}'>{$link['label']}</a>";
        echo "</li>";
    }
    echo "</ul>";
    echo "</nav>";

} catch (Exception $e) {
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle'></i> Erreur : " . $e->getMessage() . "</div>";
    echo "</div>";
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<?php require 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>