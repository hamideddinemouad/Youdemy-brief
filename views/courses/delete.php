<?php
require '../../models/Database.php';
require '../../models/Course.php';
require '../../models/Session.php';

Session::start();

if (!Session::isLoggedIn() || (Session::getUserRole() !== 'teacher' && Session::getUserRole() !== 'admin')) {
    header("Location: ../login.php"); 
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../bordTeacher.php"); 
    exit();
}
$courseId = $_GET['id']; 

try {
    $course = new Course();
    $course->delete($courseId);
    header("Location: ../bordTeacher.php");
    exit();
} catch (Exception $e) {
    header("Location: ../bordTeacher.php");
    exit();
}