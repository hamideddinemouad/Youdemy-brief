<?php
require '../models/Session.php'; 
require '../models/User.php';   

Session::start();

if (Session::isLoggedIn()) {
    header("Location: home.php"); 
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    try {
        $user = new User();
        $user->register($username, $email, $password, $role);
        echo "<div class='alert alert-success text-center'>Inscription réussie!</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Erreur lors de l'inscription : " . $e->getMessage() . "</div>";
    }
}
?>


<?php include 'includes/header.php' ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3><i class="bi bi-person-plus"></i> Inscription</h3>
                </div>
                <div class="card-body">
                    <form id="registerForm" onsubmit="return validateForm()" method="POST">
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username">
                            <div id="usernameError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="bi bi-envelope"></i> Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div id="emailError" class="text-danger"></div>
                            <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre email avec quelqu'un d'autre.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="bi bi-lock"></i> Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div id="passwordError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label"><i class="bi bi-person-badge"></i> Choisissez votre rôle :</label>
                            <select class="form-select" id="role" name="role">
                                <option value="student">Étudiant</option>
                                <option value="teacher">Enseignant</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> S'inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const role = document.getElementById('role').value;

        let isValid = true;

        if (username.length < 3 || username.length > 20) {
            document.getElementById('usernameError').textContent = 'Le nom d\'utilisateur doit contenir entre 3 et 20 caractères.';
            isValid = false;
        } else {
            document.getElementById('usernameError').textContent = '';
        }

        // Validation de l'email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            document.getElementById('emailError').textContent = 'L\'email n\'est pas valide.';
            isValid = false;
        } else {
            document.getElementById('emailError').textContent = '';
        }

        // Validation du mot de passe
        const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!passwordPattern.test(password)) {
            document.getElementById('passwordError').textContent = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
            isValid = false;
        } else {
            document.getElementById('passwordError').textContent = '';
        }

        return isValid;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require 'includes/footer.php'; ?>