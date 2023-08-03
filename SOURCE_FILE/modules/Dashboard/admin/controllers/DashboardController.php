<?php
class DashboardController extends Controller{

  function runBeforeAction(){
    $this->setaccesslevel('admin');      
    return $this->checkPermission();
  }


  function defaultAction(){
    $pageObJ = new Page($this->dbc);
    $pageObJ->findBy(['id'=>$this->entityId], '');
    $variable['pageObj'] = $pageObJ;


    $csobj = new Courses($this->dbc);
    if($_GET['act'] ?? '' == 'delete'){
      $uobj = new User($this->dbc);
      $uobj->findBy(['id'=>$_GET['id']], '');
      $uobj->delete();
   }
    // geting learners
    $lobj = new User($this->dbc);
    $variable['learners'] = $lobj->getLearners_courseDetiles(['role'=>'learner']);
    $variable['tutors'] = $lobj->getTutors();
    $variable['ratio'] = $lobj->learnerTutorRatio();
    $this->template->view('dashboard/admin/views/dashboard',$variable);
  }

  function enrollAction(){
    $pageObJ = new Page($this->dbc);
    $pageObJ->findBy(['id'=>$this->entityId], '');
    $variable['pageObj'] = $pageObJ;

   
  
    $csobj = new Courses($this->dbc);
    if($_GET['act'] ?? '' == 'pay'){
      $eobj = new Enrollment($this->dbc);
      $eobj->findBy(['id'=>$_GET['id']], '');
      $value['status'] = 'active';
      $eobj->setValues($value);
      $eobj->save();
   }

   $enrollData = new Enrollment($this->dbc);
   $variable['enrolls'] = $enrollData->get_Enrolled_Course();
    // geting learners
    $lobj = new User($this->dbc);
    $variable['learners'] = $lobj->getLearners_courseDetiles(['role'=>'learner']);
    $variable['tutors'] = $lobj->getTutors();
    $variable['ratio'] = $lobj->learnerTutorRatio();

    $this->template->view('dashboard/admin/views/enroll',$variable);
  }

}



