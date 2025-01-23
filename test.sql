mysql> select * from course_tag;
+-----------+--------+
| course_id | tag_id |
+-----------+--------+
|         1 |      1 |
|         2 |      2 |
|         3 |      3 |
|         4 |      4 |
|         5 |      5 |
|         1 |      6 |
|         2 |      6 |
|         3 |      6 |
|         5 |      6 |
|         4 |      7 |
+-----------+--------+


mysql> describe statistics;
+----------------+----------+------+-----+-------------------+-----------------------------------------------+
| Field          | Type     | Null | Key | Default           | Extra                                         |
+----------------+----------+------+-----+-------------------+-----------------------------------------------+
| id             | int      | NO   | PRI | NULL              | auto_increment                                |
| course_id      | int      | YES  | MUL | NULL              |                                               |
| teacher_id     | int      | YES  | MUL | NULL              |                                               |
| students_count | int      | YES  |     | 0                 |                                               |
| created_at     | datetime | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED                             |
| updated_at     | datetime | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED on update CURRENT_TIMESTAMP |
+----------------+----------+------+-----+-------------------+-----------------------------------------------+
6 rows in set (0.00 sec)

mysql> select * from statistics;
+----+-----------+------------+----------------+---------------------+---------------------+
| id | course_id | teacher_id | students_count | created_at          | updated_at          |
+----+-----------+------------+----------------+---------------------+---------------------+
|  1 |         1 |          2 |             50 | 2025-01-22 21:17:28 | 2025-01-22 21:17:28 |
|  2 |         2 |          5 |             30 | 2025-01-22 21:17:28 | 2025-01-22 21:17:28 |
|  3 |         3 |          2 |             25 | 2025-01-22 21:17:28 | 2025-01-22 21:17:28 |
|  4 |         4 |          5 |             40 | 2025-01-22 21:17:28 | 2025-01-22 21:17:28 |
|  5 |         5 |          2 |             15 | 2025-01-22 21:17:28 | 2025-01-22 21:17:28 |
+----+-----------+------------+----------------+---------------------+---------------------+
5 rows in set (0.00 sec)

mysql> select * from courses;
+----+----------------------------+---------------------------------------------------------+---------------------------------+------------+-------------+---------------------+---------------------+
| id | title                      | description                                             | content                         | teacher_id | category_id | created_at          | updated_at          |
+----+----------------------------+---------------------------------------------------------+---------------------------------+------------+-------------+---------------------+---------------------+
|  1 | Apprendre Python           | Cours complet pour apprendre Python.                    | Contenu vidéo et documents.     |          2 |           1 | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  2 | Design Graphique           | Maîtrisez Adobe Photoshop et Illustrator.               | Contenu vidéo et exercices.     |          5 |           2 | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  3 | SEO pour Débutants         | Apprenez les bases du référencement naturel.            | Contenu vidéo et études de cas. |          2 |           3 | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  4 | Anglais Avancé             | Perfectionnez votre anglais avec des cours interactifs. | Contenu vidéo et quiz.          |          5 |           4 | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  5 | Introduction à la Biologie | Découvrez les bases de la biologie.                     | Contenu vidéo et documents.     |          2 |           5 | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
+----+----------------------------+---------------------------------------------------------+---------------------------------+------------+-------------+---------------------+---------------------+
5 rows in set (0.00 sec)

mysql> describe courses;
+-------------+--------------+------+-----+-------------------+-----------------------------------------------+
| Field       | Type         | Null | Key | Default           | Extra                                         |
+-------------+--------------+------+-----+-------------------+-----------------------------------------------+
| id          | int          | NO   | PRI | NULL              | auto_increment                                |
| title       | varchar(255) | NO   |     | NULL              |                                               |
| description | text         | YES  |     | NULL              |                                               |
| content     | text         | YES  |     | NULL              |                                               |
| teacher_id  | int          | YES  | MUL | NULL              |                                               |
| category_id | int          | YES  | MUL | NULL              |                                               |
| created_at  | datetime     | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED                             |
| updated_at  | datetime     | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED on update CURRENT_TIMESTAMP |
+-------------+--------------+------+-----+-------------------+-----------------------------------------------+
8 rows in set (0.00 sec)

mysql> select * from tags;
+----+----------+---------------------+---------------------+
| id | name     | created_at          | updated_at          |
+----+----------+---------------------+---------------------+
|  1 | Python   | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  2 | Design   | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  3 | SEO      | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  4 | Langues  | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  5 | Biologie | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  6 | Débutant | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
|  7 | Avancé   | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 |
+----+----------+---------------------+---------------------+
7 rows in set (0.00 sec)

mysql> describe tags;
+------------+--------------+------+-----+-------------------+-----------------------------------------------+
| Field      | Type         | Null | Key | Default           | Extra                                         |
+------------+--------------+------+-----+-------------------+-----------------------------------------------+
| id         | int          | NO   | PRI | NULL              | auto_increment                                |
| name       | varchar(255) | NO   |     | NULL              |                                               |
| created_at | datetime     | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED                             |
| updated_at | datetime     | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED on update CURRENT_TIMESTAMP |
+------------+--------------+------+-----+-------------------+-----------------------------------------------+
4 rows in set (0.00 sec)

mysql> select * from users;
+----+--------------+--------------------------+--------------------------------------------------------------+---------+---------------------+---------------------+---------+
| id | username     | email                    | password                                                     | role    | created_at          | updated_at          | status  |
+----+--------------+--------------------------+--------------------------------------------------------------+---------+---------------------+---------------------+---------+
|  1 | john_doe     | john.doe@example.com     | hashed_password_1                                            | student | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 | active  |
|  2 | jane_smith   | jane.smith@example.com   | hashed_password_2                                            | teacher | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 | active  |
|  3 | admin_user   | admin@youdemy.com        | hashed_password_3                                            | admin   | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 | active  |
|  4 | alice_wonder | alice.wonder@example.com | hashed_password_4                                            | student | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 | active  |
|  5 | bob_marley   | bob.marley@example.com   | hashed_password_5                                            | teacher | 2025-01-22 21:17:27 | 2025-01-22 21:17:27 | pending |
|  6 | mouad        | mouad@gmail.com          | $2y$12$ScGw7BBsukDyzRNFMnayQuQd0OM5.YKLfNHlHCVLh760zJeEUmXYK | admin   | 2025-01-22 21:29:06 | 2025-01-22 22:09:11 | active  |
|  7 | admin2       | admin2@gmail.com         | $2y$12$EQYk1ioGLhxm7p36bEAMNOMs1U.Qx5X/7CFedT0C5wo0DzxDlKXPK | student | 2025-01-22 21:42:48 | 2025-01-22 21:42:48 | pending |
+----+--------------+--------------------------+--------------------------------------------------------------+---------+---------------------+---------------------+---------+
7 rows in set (0.00 sec)

mysql> describe users;
+------------+--------------------------------------+------+-----+-------------------+-----------------------------------------------+
| Field      | Type                                 | Null | Key | Default           | Extra                                         |
+------------+--------------------------------------+------+-----+-------------------+-----------------------------------------------+
| id         | int                                  | NO   | PRI | NULL              | auto_increment                                |
| username   | varchar(255)                         | NO   | UNI | NULL              |                                               |
| email      | varchar(255)                         | NO   | UNI | NULL              |                                               |
| password   | varchar(255)                         | NO   |     | NULL              |                                               |
| role       | enum('student','teacher','admin')    | NO   |     | NULL              |                                               |
| created_at | datetime                             | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED                             |
| updated_at | datetime                             | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED on update CURRENT_TIMESTAMP |
| status     | enum('active','suspended','pending') | YES  |     | pending           |                                               |
+------------+--------------------------------------+------+-----+-------------------+-----------------------------------------------+
8 rows in set (0.00 sec)

add more courses link them to already existing teachers id update statistics table give the new course in the
column content youtube video links and update already existing courses content with youtube video links

