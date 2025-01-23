CREATE DATABASE IF NOT EXISTS youdemy;
USE youdemy;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher', 'admin') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'suspended', 'pending') DEFAULT 'pending'
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content TEXT,
    teacher_id INT,
    category_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE course_tag (
    course_id INT,
    tag_id INT,
    PRIMARY KEY (course_id, tag_id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    enrolled_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'completed') DEFAULT 'active',
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    teacher_id INT,
    students_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (teacher_id) REFERENCES users(id)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT NOT NULL,
    status ENUM('unread', 'read') DEFAULT 'unread',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    rating INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    issued_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

INSERT INTO users (username, email, password, role, status) VALUES
('john_doe', 'john.doe@example.com', 'hashed_password_1', 'student', 'active'),
('jane_smith', 'jane.smith@example.com', 'hashed_password_2', 'teacher', 'active'),
('admin_user', 'admin@youdemy.com', 'hashed_password_3', 'admin', 'active'),
('alice_wonder', 'alice.wonder@example.com', 'hashed_password_4', 'student', 'active'),
('bob_marley', 'bob.marley@example.com', 'hashed_password_5', 'teacher', 'pending');

INSERT INTO categories (name) VALUES
('Programmation'),
('Design'),
('Marketing Digital'),
('Langues'),
('Sciences');

INSERT INTO courses (title, description, content, teacher_id, category_id) VALUES
('Apprendre Python', 'Cours complet pour apprendre Python.', 'Contenu vidéo et documents.', 2, 1),
('Design Graphique', 'Maîtrisez Adobe Photoshop et Illustrator.', 'Contenu vidéo et exercices.', 5, 2),
('SEO pour Débutants', 'Apprenez les bases du référencement naturel.', 'Contenu vidéo et études de cas.', 2, 3),
('Anglais Avancé', 'Perfectionnez votre anglais avec des cours interactifs.', 'Contenu vidéo et quiz.', 5, 4),
('Introduction à la Biologie', 'Découvrez les bases de la biologie.', 'Contenu vidéo et documents.', 2, 5);

INSERT INTO tags (name) VALUES
('Python'),
('Design'),
('SEO'),
('Langues'),
('Biologie'),
('Débutant'),
('Avancé');

INSERT INTO course_tag (course_id, tag_id) VALUES
(1, 1), (1, 6),  -- Python, Débutant
(2, 2), (2, 6),  -- Design, Débutant
(3, 3), (3, 6),  -- SEO, Débutant
(4, 4), (4, 7),  -- Langues, Avancé
(5, 5), (5, 6);  -- Biologie, Débutant

INSERT INTO enrollments (student_id, course_id, status) VALUES
(1, 1, 'active'),  -- John Doe s'inscrit à Python
(1, 3, 'active'),  -- John Doe s'inscrit à SEO
(4, 2, 'active'),  -- Alice Wonder s'inscrit à Design
(4, 4, 'completed'); -- Alice Wonder a terminé Anglais Avancé

INSERT INTO statistics (course_id, teacher_id, students_count) VALUES
(1, 2, 50),  -- Python : 50 étudiants
(2, 5, 30),  -- Design : 30 étudiants
(3, 2, 25),  -- SEO : 25 étudiants
(4, 5, 40),  -- Anglais Avancé : 40 étudiants
(5, 2, 15);  -- Biologie : 15 étudiants


INSERT INTO notifications (user_id, message, status) VALUES
(1, 'Vous êtes inscrit au cours "Apprendre Python".', 'unread'),
(4, 'Vous avez terminé le cours "Anglais Avancé".', 'read'),
(2, 'Votre cours "SEO pour Débutants" a été approuvé.', 'unread');

INSERT INTO comments (course_id, user_id, comment, rating) VALUES
(1, 1, 'Très bon cours, bien expliqué !', 5),
(2, 4, 'Le cours est intéressant, mais un peu difficile.', 4),
(3, 1, 'Parfait pour comprendre les bases du SEO.', 5);

INSERT INTO certificates (student_id, course_id, file_path) VALUES
(4, 4, '/certificates/alice_wonder_anglais_avance.pdf');