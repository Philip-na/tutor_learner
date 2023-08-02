<?php
class TutorsController extends Controller{
    function runBeforeAction(){
        $this->setaccesslevel('learner');      
        return $this->checkPermission();
    }
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;

        $userobj = new User($this->dbc);
        $t = $userobj->getTutors();
        $variable['tutors'] = $this->getUsertuter($t);
        
        $this->template->view('tutors/learner/views/tutors',$variable);
    }

    private function getUsertuter($value){
        $y = [];
        foreach($value as $s){
            $cid = $s->course->id ?? '';
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



