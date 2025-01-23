<?php require '../models/User.php'; ?>
<?php include 'includes/header.php' ?>
<style>
    body {
        background-color: #f8f9fa;
    }
    .jumbotron {
        background-image: url('https://image.slidesdocs.com/responsive-images/background/learning-tool-return-to-school-black-education-creative-school-powerpoint-background_6a3bb90141__960_540.jpg');
        background-size: cover; /* Pour couvrir toute la div */
        background-position: center; /* Pour centrer l'image */
        color: white; /* Couleur du texte */
        padding: 100px 0;
        margin-bottom: 50px;
        position: relative; /* Pour positionner le fond semi-transparent */
    }
    .jumbotron::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent noir */
        z-index: 1;
    }
    .jumbotron .container {
        position: relative;
        z-index: 2; /* Pour placer le texte au-dessus du fond semi-transparent */
    }
    .feature-icon {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 20px;
    }
    .feature-card {
        transition: transform 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-10px);
    }
    .testimonial-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .testimonial-card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 15px;
    }
    .footer {
        background-color: #007bff;
        color: white;
        padding: 40px 0;
        margin-top: 50px;
    }
</style>

<div class="jumbotron text-center">
    <div class="container">
        <h1 class="display-4">Apprenez en Ligne avec Youdemy</h1>
        <p class="lead">Découvrez des cours interactifs et personnalisés pour booster vos compétences.</p>
        <a href="register.php" class="btn btn-light btn-lg">Commencer Maintenant</a>
        <a href="login.php" class="btn btn-outline-light btn-lg">Se Connecter</a>
    </div>
</div>

<!-- Section Pourquoi Choisir Youdemy -->
<div class="container">
    <div class="text-center mb-5">
        <h2>Pourquoi Choisir Youdemy ?</h2>
        <p class="lead">Nous offrons une expérience d'apprentissage unique et adaptée à vos besoins.</p>
    </div>
    <div class="row">
        <div class="col-md-4 text-center feature-card">
            <i class="fas fa-chalkboard-teacher feature-icon"></i>
            <h3>Enseignants Experts</h3>
            <p>Apprenez auprès des meilleurs enseignants et professionnels du secteur.</p>
        </div>
        <div class="col-md-4 text-center feature-card">
            <i class="fas fa-laptop-code feature-icon"></i>
            <h3>Cours Pratiques</h3>
            <p>Des cours interactifs avec des exercices pratiques pour une meilleure assimilation.</p>
        </div>
        <div class="col-md-4 text-center feature-card">
            <i class="fas fa-certificate feature-icon"></i>
            <h3>Certificats Reconnus</h3>
            <p>Obtenez des certificats reconnus pour valoriser vos compétences.</p>
        </div>
    </div>
</div>

<!-- Section Témoignages -->
<div class="container mt-5">
    <div class="text-center mb-5">
        <h2>Ce Que Disent Nos Étudiants</h2>
        <p class="lead">Découvrez les témoignages de nos étudiants satisfaits.</p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="testimonial-card text-center">
                <img src="https://landen.imgix.net/blog_enKWriAikxIViACa/assets/LkUFRqBoIRmXcwBN.jpg?w=880" alt="Étudiant 1">
                <h4>Alice Dupont</h4>
                <p>"Les cours sont très bien structurés et les enseignants sont très compétents. Je recommande Youdemy !"</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card text-center">
                <img src="https://www.smeno.com/media/blog/vie-pratique-bon-plan-etudiants/etudiant-a-salarie.webp" alt="Étudiant 2">
                <h4>Jean Martin</h4>
                <p>"J'ai pu acquérir de nouvelles compétences rapidement grâce aux cours pratiques. Merci Youdemy !"</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card text-center">
                <img src="https://static.lematin.ma/files/lematin/images/articles/2020/10/74dda08b7cd2a6a35972f0ae5875ce0d.jpg" alt="Étudiant 3">
                <h4>Sophie Leroy</h4>
                <p>"La plateforme est intuitive et les cours sont de haute qualité. Je suis très satisfaite."</p>
            </div>
        </div>
    </div>
</div>

<!-- Section Call to Action -->
<div class="jumbotron text-center mt-5">
    <div class="container">
        <h2>Prêt à Commencer Votre Voyage d'Apprentissage ?</h2>
        <p class="lead">Rejoignez des milliers d'étudiants et commencez dès aujourd'hui.</p>
        <a href="register.php" class="btn btn-light btn-lg">S'Inscrire Maintenant</a>
    </div>
</div>

<?php require 'includes/footer.php'; ?>