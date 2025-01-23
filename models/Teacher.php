<?php
require 'User.php'; 
require 'Course.php';
require 'Enrollment.php';
require 'Statistics.php';

class Teacher extends User {
   
    public function __construct($userId) {
        parent::__construct(); 
        $this->loadUserData($userId); 

        if ($this->role !== 'teacher') {
            throw new Exception("L'utilisateur n'est pas un enseignant.");
        }
    }

    public function createCourse($title, $description, $content, $categoryId, $tags = []) {
        $course = new Course();
        $courseId = $course->create($title, $description, $content, $this->id, $categoryId);

        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $course->associateTag($courseId, $tagId);
            }
        }

        echo "Cours créé avec succès. ID : $courseId\n";
    }

    public function updateCourse($courseId, $title, $description, $content, $categoryId, $tags = []) {
        $course = new Course();
        $course->update($courseId, $title, $description, $content, $this->id, $categoryId);

        if (!empty($tags)) {
            $course->dissociateAllTags($courseId); 
            foreach ($tags as $tagId) {
                $course->associateTag($courseId, $tagId);
            }
        }

        echo "Cours mis à jour avec succès.\n";
    }

    public function deleteCourse($courseId) {
        $course = new Course();
        $course->delete($courseId);
        echo "Cours supprimé avec succès.\n";
    }

    public function getMyCourses() {
        $course = new Course();
        return $course->getByTeacher($this->id);
    }

    public function getCourseEnrollments($courseId) {
        $enrollment = new Enrollment();
        return $enrollment->getByCourse($courseId);
    }

    public function getCourseStatistics($courseId) {
        $statistics = new Statistics();
        return $statistics->getCourseStatistics($courseId);
    }

    public function getMyStatistics() {
        $statistics = new Statistics();
        return $statistics->getTeacherStatistics($this->id);
    }
}
