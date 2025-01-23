<?php
require '../models/Session.php';

Session::start(); 

if (Session::has('user_id')) {
    header("Location: home.php"); 
    exit();
}

require '../models/User.php';
include 'includes/header.php' ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $user = new User();
        $userData = $user->login($email, $password); 

        if ($userData) {
            Session::set('user_id', $userData['id']);
            Session::set('username', $userData['username']);
            Session::set('role', $userData['role']);

            if ($userData['role'] === 'teacher') {
                header("Location: home.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Email ou mot de passe incorrect.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Erreur lors de la connexion : " . $e->getMessage() . "</div>";
    }
}
?>


<!-- Ajouter Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3><i class="bi bi-box-arrow-in-right"></i> Connexion</h3>
                </div>
                <div class="card-body">
                    <form id="loginForm" method="POST" onsubmit="return validateForm()">
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="bi bi-envelope"></i> Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div id="emailError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="bi bi-lock"></i> Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div id="passwordError" class="text-danger"></div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validation Front-End -->
<script>
    function validateForm() {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        let isValid = true;

        // Validation de l'email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            document.getElementById('emailError').textContent = 'L\'email n\'est pas valide.';
            isValid = false;
        } else {
            document.getElementById('emailError').textContent = '';
        }

        // Validation du mot de passe
        if (password.length < 8) {
            document.getElementById('passwordError').textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
            isValid = false;
        } else {
            document.getElementById('passwordError').textContent = '';
        }

        return isValid;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php require 'includes/footer.php'; ?>