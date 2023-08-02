<?php
class CoursesController extends Controller{
    
    function runBeforeAction(){
        $this->setaccesslevel('learner');      
        return $this->checkPermission();
    }
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;

        $lid = $_SESSION['user']['id'] ?? '';
        $EnrolledCourseObj = new Enrollment($this->dbc);
       
        if(($_GET['act'] ?? '') == 'unenrol'){
            $id = $_GET['id'] ?? 0;
            $ctn = ['id'=> $id];
            if($EnrolledCourseObj->checkEnrollement($ctn)){
              $EnrolledCourseObj->findBy($ctn,'AND');
              $EnrolledCourseObj->delete();
            }
        }
        $v = $EnrolledCourseObj->get_Enrolled_Course(['learnerid'=>$lid]);
        $variable['courses'] = $v;

        $this->template->view('courses/learner/views/courses',$variable);
    }

    function enrollAction(){

        $id = $_GET['id'] ?? '';
        // var_dump($id);
        $userid = $_SESSION['user']['id'];
        $en = new Enrollment($this->dbc);
        $ctn = ['courseid'=>$id,'learnerid'=>$userid];

        if(($_GET['act'] ?? '') == 'enroll'){
            // var_dump($id);
            if(!$en->checkEnrollement($ctn)){
                $en->enrollMe($userid,$id);
            }
        }

        if(($_GET['act'] ?? '') == 'denroll'){
        
            if($en->checkEnrollement($ctn)){
              $en->findBy($ctn,'AND');
              $en->delete();
            }
        }

        $variable['state'] = false;
        if($en->checkEnrollement($ctn)){ $variable['state'] = true;}

        $cobj = new Courses($this->dbc);
        $cobj->findBy(['id'=>$id], '');
        $tutorid = $cobj->tutorid;
        $tobj = new User($this->dbc);
        $tobj->findBy(['id'=>$tutorid], '');
        $variable['course'] = $cobj;
        $variable['tutor'] = $tobj;


        $tobj = new Topics($this->dbc);
        $variable['topics'] = $tobj->findAll(['courseid'=>$id], 'AND');
        $this->template->view('courses/learner/views/enroll',$variable);
    }
    private function getUserCourses($value){
        $y = [];
        foreach($value as $s){
            $cid = $s->id ?? '';
            $lid = $_SESSION['user']['id'] ?? '';
            $ctn = ['learnerid'=>$lid, 'courseid'=>$cid];
            // var_dump($cid);
            $en = new Enrollment($this->dbc);
            if($en->checkEnrollement($ctn)){
                $y[] = $s;
            }
        }
        return $y;
    }
}


