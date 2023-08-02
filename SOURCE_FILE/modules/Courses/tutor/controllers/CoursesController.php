<?php
class CoursesController extends Controller{

    function runBeforeAction(){
        $this->setaccesslevel('tutor');      
        return $this->checkPermission();
    }



    // session page
    function sessionAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;

        $tutorid = $_SESSION['user']['id'];
        $courseid = $pageObJ->yxz('Courses',["tutorid"=>$tutorid],'id');

        $tobj = new Topics($this->dbc);
        $variable['topics'] = $tobj->getTopics(['courseid'=>$courseid]);
        $sessionHadller = new Sessions($this->dbc);

        if($_POST['saveS'] ?? false){     $sessionHadller->saveSession($_POST);}
        if($_GET['act'] ?? '' =='del'){ $sessionHadller->findBy(['id'=>$_GET['id']]); $sessionHadller->delete(); }

        $variable['session'] = $sessionHadller->get_sessions(["tutorid"=>$tutorid]); 
        $this->template->view('courses/tutor/views/sessions',$variable);
    }

    // progress page handler
    function progressAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;
        
        $this->template->view('courses/tutor/views/progress',$variable);
    }
}


