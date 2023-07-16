<?php
class HomeController extends Controller{
    
      function runBeforeAction(){
        $act = $_GET['action'] ?? $_POST['action'] ?? 'default';
           
       if($_SESSION["is_admin"] ?? 0 == 1){

          if($act === "logout"){
            unset($_SESSION["is_admin"]);
            unset($_SESSION["user"]);   
          }

          return true;
       }
        
        if($act == 'login'){

            $this->loginAction();
        }elseif ($act == 'signup') {
            $this->signupAction();
        }else {
            return true;
        }
    }
    
       function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;

        $courseObj = new Courses($this->dbc);
        $variable['courses'] = $courseObj->getallCourses();
             
        $this->template->view('',$variable);
    }
}
