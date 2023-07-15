<?php
class CoursesController extends Controller{

    function runBeforeAction(){
        $this->setaccesslevel('admin');      
        return $this->checkPermission();
     }

     
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;
        // get tutors
        $tobj = new User($this->dbc);
        $variable['tutor'] = $tobj->getTutors();

        $topicobj = new Topics($this->dbc);
        $variable['topics'] = $topicobj->getTopics();
        
        if($_GET['act'] ?? '' == 'delete'){
            $Obj = new Courses($this->dbc);
            $Obj->findBy(['id'=>$_GET['id']]);
            if(property_exists($Obj, 'id')){
                $Obj->delete();
            }
        }

        $courseObj = new Courses($this->dbc);
        
        if($_POST['savec'] ?? false){
            $courseObj->saveCourse($_POST);
        }
        $variable['courses'] = $courseObj->get_course_tutors();
        $this->template->view('courses/admin/views/courses',$variable);
    }

        // handle topics page
        function topicAction(){
            $pageObJ = new Page($this->dbc);
            $pageObJ->findBy(['id'=>$this->entityId], '');
            $variable['pageObj'] = $pageObJ;
            $courses = new Courses($this->dbc);
            $variable['tutorCourses'] = $courses->getallCourses();
            $tobj = new Topics($this->dbc);
    
            if($_POST['saveTopic'] ?? false){  
                $tobj->addTopic($_POST);
            }
            if($_GET['act'] ?? '' == 'del'){
                $tobj->findBy(['id'=>$_GET['id']]);
                $tobj->delete();
            }
            $variable['topics'] = $tobj->getTopics();
    
            $this->template->view('courses/admin/views/topics',$variable);
        }
}


