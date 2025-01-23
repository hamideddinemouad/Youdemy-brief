<?php
require '../models/Database.php';
require '../models/Session.php';
require '../models/Enrollment.php';
Session::start();
if (!Session::isLoggedIn() || Session::getUserRole() !== 'teacher') {
    header("Location: login.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];
    if (!is_numeric($studentId) || !is_numeric($courseId)) {
        header("Location: bordTeacher1.php?error=invalid_data"); 
        exit();
    }

    $enrollment = new Enrollment();

    try {
        $enrollment->unenrollByCourseAndStudent($courseId, $studentId);
        header("Location: bordTeacher1.php?success=1");
        exit();
    } catch (Exception $e) {
        header("Location: bordTeacher1.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: bordTeacher1.php");
    exit();
}