<?php

class User extends Entity{
    public function __construct($dbc)
    {
        parent::__construct($dbc, 'users');
    }
    protected function tableFields(){
        $this->fields = [
            'name',
            'username', 
            'password',
            'email',
            'role',
            'phone',
            'qualifications',
            's_question',
            'answer',
            'created'
        ];
    }
    public function saveUser($userdata) {
        $this->setValues($this->setUserValue($this->setPostData($userdata)));
        $this->save();
    }

    public function getTutors(){
        // return $this->findAll(['role'=>'tutor'], 'AND');
        $y = [];
        
        $x = $this->findAll(['role'=>'tutor'], 'AND');
        
        foreach($x as $u){
            $obj = (object)[];
            // set defalut fields
            foreach($this->fields as $field){
                $obj->$field = $u->$field ?? '';
            }

            // relelaship Dat
            $obj->id = $u->id;
            $obj->course = $this->yxz("Courses",['tutorid'=>$u->id]);
           
            $y[] = $obj;
        }
        return $y;
    }



    
    public function getLearners(){
        return $this->findAll(['role'=>'learner'], 'AND');
    }

    public function learnerTutorRatio() {
        return count($this->getLearners()) / count($this->getTutors());
    }

    private function setUserValue($value){
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

    public function getLearners_courseDetiles($value){
        $y = [];
        $x = $this->findAll($value, 'AND');
        foreach($x as $u){
            $obj = (object)[];
            $obj->id = $u->id ?? '';
            $obj->name = $u->name ?? '';
            $obj->username = $u->username ?? '';
            $obj->password = $u->password ?? '';
            $obj->email = $u->email ?? '';
            $obj->role = $u->role ?? '';
            $obj->phone = $u->phone ?? '';
            $obj->s_question = $u->s_question ?? '';
            $obj->answer = $u->answer ?? '';
            $obj->created = $u->created ?? '';

            $m = $this->learnEnrolls($u->id);
            $obj->active = $m['active'];
            $obj->pending = $m['pending'];
            $obj->completed = $m['completed'];
            $obj->ebrolled = [];
            $y[] = $obj;
        }

        return $y;

    }

    public function learnEnrolls($value){
        $enrollHandler = new Enrollment($this->dbc);
        $all = $enrollHandler->findAll(['learnerid'=>$value],'AND');
        $active  = $enrollHandler->findAll(['learnerid'=>$value,'status'=>'active'],'AND');
        $pending  = $enrollHandler->findAll(['learnerid'=>$value,'status'=>'pending'],'AND');
        $completed = $enrollHandler->findAll(['learnerid'=>$value,'status'=>'complete'],'AND');
        
        return ['completed'=>$completed,'active'=>$active,'pending'=>$pending,'all'=>$all];
    }
}