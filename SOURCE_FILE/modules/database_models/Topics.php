<?php

class Topics extends Entity {
  

    public function __construct($dbc)
    {
       parent::__construct($dbc, 'topics');

        
    }
    protected function tableFields(){
        $this->fields = [
           'name',
           'topicdetiles',
           'courseId',
           'createdAt'          
        ];
    }

    public function addTopic($value){
        $v = $this->setPostData($this->setTopicValue($value));
        $this->setValues($v);
        $this->save();
    }

    public function getTopics($value = [],$oprt = 'AND'){
        $y = [];
        if(empty($value)){
            $x = $this->findAll();
        }else{
            $x = $this->findAll($value,$oprt);
        }
        foreach($x as $u){
            $obj = (object)[];
            // set defalut fields
            foreach($this->fields as $field){
                $obj->$field = $u->$field ?? '';
            }

            // relelaship Dat
            $obj->id = $u->id;
            $cid = $u->courseId ?? 0;
            $obj->course = $this->yxz("Courses",['id'=>$cid]);
            // $obj->learner = $this->yxz("User",['id'=>$u->learnerid],'username');
            // $obj->learnerData = $this->yxz("User",['id'=>$u->learnerid]);
            // $obj->courseData = $this->yxz("Courses",['id'=>3]);
            $y[] = $obj;
        }
        return $y;
    }

    private function setTopicValue($value){
        $rest = [];
        foreach($this->fields as $field){
            if($field == 'createdAt'){
                $rest[$field] = date("Y-m-d");
            }else{
                $rest[$field] = $value[$field];
            }
        }
        return $rest;
    }

   
}