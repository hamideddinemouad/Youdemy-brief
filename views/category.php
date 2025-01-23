<?php include 'includes/header.php' ?>
<?php
    require '../models/Database.php';
    require '../models/Category.php';
    require '../models/Pagination.php';
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $category = new Category();
    $allCategories = $category->getAll();
    $totalCategories = count($allCategories);
    $itemsPerPage = 8;
    $pagination = new Pagination($totalCategories, $itemsPerPage, $currentPage);
    $offset = $pagination->getOffset();
    $categories = array_slice($allCategories, $offset, $itemsPerPage);
?>
<style>
    .category-card {
        transition: transform 0.3s ease;
    }
    .category-card:hover {
        transform: translateY(-10px);
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
    .footer {
            background-color: #007bff;
            color: white;
            padding: 40px 0;
            margin-top: 50px;
        }
</style>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Catégories de Cours</h1>

        <!-- Liste des catégories -->
        <div class="row">
            <?php foreach ($categories as $cat) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card category-card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($cat['name']); ?></h5>
                            <a href="courses.php?category_id=<?php echo $cat['id']; ?>" class="btn btn-primary">Voir les Cours</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                $baseUrl = 'category.php'; 
                $paginationLinks = $pagination->getPaginationLinks($baseUrl);

                foreach ($paginationLinks as $link) :
                    $activeClass = $link['active'] ? 'active' : '';
                ?>
                    <li class="page-item <?php echo $activeClass; ?>">
                        <a class="page-link" href="<?php echo $link['url']; ?>"><?php echo $link['label']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
    <?php require 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>