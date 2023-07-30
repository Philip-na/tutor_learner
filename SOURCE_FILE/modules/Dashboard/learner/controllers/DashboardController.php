<?php
class DashboardController extends Controller{
    
    function runBeforeAction(){
       $this->setaccesslevel('learner');      
       return $this->checkPermission();
    }
    
    
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;
        // mark attendence
        $sessionObj = new Sessions($this->dbc);
        $x = $_GET['act'] ?? ' ';
        if($x == 'missed'){ $this->attend('missed'); }
        if($x == 'attend'){ $this->attend('attended'); }
        if(($_POST['sub'] ?? '') == 1){ $this->makeSubmission();}

        // get user session
        $v = $sessionObj->get_sessions();
        $variable['session'] = $this->getUserSession($v); 
        // get courses
        $courseObj = new Courses($this->dbc);
        $v = $courseObj->get_course_tutors();
        $variable['courses'] = $this->getUserCourses($v);

        $this->template->view('dashboard/learner/views/dashboard',$variable);
    }

    private function makeSubmission(){
      $a = new Submissions($this->dbc);
      $a->saveSubmission($_POST);
    }

    private function getUserSession($value){
        $y = [];
        foreach($value as $s){
            $cid = $s->topic->course->id ?? '';
            $lid = $_SESSION['user']['id'] ?? '';
            $ctn = ['learnerid'=>$lid, 'courseid'=>$cid];
            $en = new Enrollment($this->dbc);
            if($en->checkEnrollement($ctn)){ $y[] = $s; }
        }
        return $y;
    }

    // user course filter
    private function getUserCourses($value){
        $y = [];
        foreach($value as $s){
            $cid = $s->id ?? '';
            $lid = $_SESSION['user']['id'] ?? '';
            $ctn = ['learnerid'=>$lid, 'courseid'=>$cid];
            $en = new Enrollment($this->dbc);
            if($en->checkEnrollement($ctn)){
                $y[] = $s;
            }
        }
        return $y;
    }

    private function attend($val){
        $value = [];
        $std = new Sessionatedence($this->dbc);
        $lid = $_SESSION['user']['id'] ?? " ";
        $sid =$_GET['id'] ?? ' ';
        $std->findBy(['learnerid'=>$lid, 'sessionid'=>$sid]);
        $value['learnerid'] = $lid;
        $value['sessionid'] = $sid;
        $value['status'] = $val; 

        $std->setValues($value);
        $std->save();
    }
}


