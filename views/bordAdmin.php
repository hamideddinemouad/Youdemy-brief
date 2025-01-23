<?php include 'includes/header.php'; 
require 'includes/footer.php'; ?>
<?php include 'includes/header.php'; 
require '../models/Database.php';
require '../models/Statistics.php';


Session::start();


if (!Session::isLoggedIn() || Session::getUserRole() !== 'admin') {
    header('Location: login.php');
    exit();
}


$statistics = new Statistics();
$globalStats = $statistics->getGlobalStatistics();
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Tableau de Bord Administrateur</h1>

   
    <div class="row">
  
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-book"></i> Total des Cours</h5>
                    <p class="card-text"><?php echo $globalStats['total_courses']; ?> cours</p>
                </div>
            </div>
        </div>

       
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total des Utilisateurs</h5>
                    <p class="card-text"><?php echo $globalStats['total_users']; ?> utilisateurs</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Total des Enseignants</h5>
                    <p class="card-text"><?php echo $globalStats['total_teachers']; ?> enseignants</p>
                </div>
            </div>
        </div>

       
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-graduate"></i> Total des Étudiants</h5>
                    <p class="card-text"><?php echo $globalStats['total_students']; ?> étudiants</p>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title"><i class="fas fa-star"></i> Cours les plus populaires</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($globalStats['most_popular_courses'] as $course): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($course['title']); ?> - <?php echo $course['enrollments']; ?> inscriptions
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Enseignants -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title"><i class="fas fa-trophy"></i> Top Enseignants</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($globalStats['top_teachers'] as $teacher): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($teacher['username']); ?> - <?php echo $teacher['courses']; ?> cours
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Catégories les plus populaires -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title"><i class="fas fa-tags"></i> Catégories les plus populaires</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($globalStats['most_popular_categories'] as $category): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($category['name']); ?> - <?php echo $category['courses']; ?> cours
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>