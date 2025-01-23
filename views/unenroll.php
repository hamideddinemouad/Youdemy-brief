<?php
require '../models/Database.php';
require '../models/Session.php';
require '../models/Enrollment.php';
Session::start();

if (!Session::isLoggedIn() || Session::getUserRole() !== 'student') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['enrollment_id']) || !is_numeric($_GET['enrollment_id'])) {
    header("Location: student_dashboard.php");
    exit();
}

$enrollmentId = $_GET['enrollment_id']; 
$studentId = Session::getUserId();

try {
    $enrollment = new Enrollment();
    $enrollmentData = $enrollment->getByStudent($studentId);
    $isValidEnrollment = false;
    foreach ($enrollmentData as $enrollmentItem) { 
        if ($enrollmentItem['id'] == $enrollmentId) {
            $isValidEnrollment = true;
            break;
        }
    }

    if (!$isValidEnrollment) {
        throw new Exception("Vous n'êtes pas autorisé à vous désinscrire de ce cours.");
    }

    $enrollment->unenroll($enrollmentId);
    header("Location: bordStudent.php");
    exit();
} catch (Exception $e) {
    header("Location: bordStudent.php");
    exit();
}
?>