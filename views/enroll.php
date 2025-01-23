<?php
require '../models/Database.php';
require '../models/Session.php';
require '../models/Enrollment.php';

Session::start();

if (!Session::isLoggedIn() || Session::getUserRole() !== 'student') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    header("Location: courses.php");
    exit();
}

$courseId = $_GET['course_id'];
$studentId = Session::getUserId(); 

try {
    $enrollment = new Enrollment();
    $enrollment->enroll($studentId, $courseId);
    header("Location: courses.php");
    exit();
} catch (Exception $e) {
    header("Location: courses.php");
    exit();
}
?>