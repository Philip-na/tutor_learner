<?php

class Sessions extends Entity {
  

    public function __construct($dbc)
    {
       parent::__construct($dbc, 'sessions');

        
    }
    protected function tableFields(){
        $this->fields = [
           'topicid',
           'sessiondt',
           'tutorId',
           'created',
           'date'
           
        ];

        
    }

    public function get_session($value = [],$oprt = 'AND'){
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
            $obj->topic = $this->yxz("Topics",['id'=>$u->topicid]);
            $obj->tutor = $this->yxz("User",['id'=>$u->tutorId]);
               
            $y[] = $obj;
        }
        return $y;
    }

    public function saveSession($value){
        $this->setValues($this->setSession($value));
        $this->save();
    }

    private function setSession($value){
        $y = [];
        foreach($this->fields as $field){
            if(isset($value[$field])){
                $y[$field] = $value[$field];
            }
        }
        $y['created'] = date('Y-m-d');
        $y['tutorId'] = $_SESSION['user']['id'];

        return $y;
    }

   
}