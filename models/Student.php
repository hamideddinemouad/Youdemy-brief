<?php
require 'User.php'; 
require 'Course.php';
require 'Enrollment.php';
require 'Certificate.php';

class Student extends User {
    public function __construct($userId) {
        parent::__construct(); 
        $this->loadUserData($userId); 
        if ($this->role !== 'student') {
            throw new Exception("L'utilisateur n'est pas un étudiant.");
        }
    }

    public function enrollInCourse($courseId) {
        $enrollment = new Enrollment();
        $enrollment->enroll($this->id, $courseId);
    }

    public function unenrollFromCourse($courseId) {
        $enrollment = new Enrollment();
        $enrollment->unenrollByCourseAndStudent($courseId, $this->id);
    }

    public function getEnrolledCourses() {
        $enrollment = new Enrollment();
        return $enrollment->getByStudent($this->id);
    }

    public function getCourseDetails($courseId) {
        $course = new Course();
        return $course->getById($courseId);
    }

    
}
