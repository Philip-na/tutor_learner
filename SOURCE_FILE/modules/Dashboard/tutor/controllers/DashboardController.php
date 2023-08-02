<?php
class DashboardController extends Controller{

    function runBeforeAction(){
        $this->setaccesslevel('tutor');      
        return $this->checkPermission();
     }

    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;

        if($_GET['act'] ?? '' == 'pass'){
          $eobj = new Enrollment($this->dbc);
          $eobj->findBy(['id'=>$_GET['id']], '');
          $value['status'] = 'complete';
          $eobj->setValues($value);
          $eobj->save();
       }
    
       $enrollData = new Enrollment($this->dbc);
       $variable['enrolls'] = $enrollData->get_Enrolled_Course(['status'=>'active']);

        
        $this->template->view('dashboard/tutor/views/dashboard',$variable);
    }
}


