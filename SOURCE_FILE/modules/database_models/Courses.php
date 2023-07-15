<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

class Courses extends Entity {
  

    public function __construct($dbc)
    {
       parent::__construct($dbc, 'course');

        
    }
    protected function tableFields(){
        $this->fields = [
            'name',
            'duration',
            'prerequisites',
            'evaluation',
            'learningOutcome',
            'about',
            'tutorid',
            'created',
            'category'
           
        ];
    }


    function getallCourses(){
        return $this->findAll();
    }
    function saveCourse($value){

        $this->setValues($this->setCourseValue($value));
        $this->save();
    }
    public function get_course_tutors($value = [],$oprt = 'AND'){
        $y = [];
        if(empty($value)){
            $x = $this->findAll();
        }else{
            $x = $this->findAll($value,$oprt);
        }
        foreach($x as $u){
            $obj = (object)[];
            $obj->id = $u->id ?? '';
            $obj->name = $u->name ?? '';
            $obj->duration = $u->duration ?? '';
            $obj->evaluation = $u->evaluation ?? '';
            $obj->prerequisites = $u->prerequisites ?? '';
            $obj->learningOutcome = $u->learningOutcome ?? '';
            $obj->about = $u->about ?? '';
            $obj->created = $u->created ?? '';
            $obj->tutorid = $u->tutorid ?? '';
            $obj->category = $u->category ?? '';
            $obj->tutor = $this->yxz("User",['id'=>$u->tutorid]);
            $obj->enrolls = $this->get_course_enrolls($u->id);
            $y[] = $obj;
        }
        return $y;
    }
    
    private function setCourseValue($value){
        $rest = [];
        foreach($this->fields as $field){
            if($field == 'created'){
                $rest[$field] = date("Y-m-d");
            }else{
                $rest[$field] = $value[$field];
            }
        }
        return $rest;
    }

    private function get_course_enrolls($value){
        $y = new Enrollment($this->dbc);
        return $y->findAll(['courseid'=>$value],'AND');
    }

    
   
}