<?php
class TutorsController extends Controller{
    function runBeforeAction(){
        $this->setaccesslevel('admin');      
        return $this->checkPermission();
    }
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;
        
        if($_POST['savet'] ?? 0 === 1){
            $tutorobj = new Auth($this->dbc);
            $tutorobj->createUser($this->prepareUser($_POST));
        }
        $tutorobj = new User($this->dbc);
        if($_GET['act'] ?? '' == 'delete'){
            $tutorobj->findBy(['id'=>$_GET['id']]);
            if(property_exists($tutorobj,'id')){
                $tutorobj->delete();
            }
        }
        $variable['tutors'] = $tutorobj->getTutors();
        
        $this->template->view('tutors/admin/views/tutors',$variable);
    }
}


