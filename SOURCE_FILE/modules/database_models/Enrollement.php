 <?php

use PhpParser\Node\Expr\New_;

class Enrollment extends Entity {
  

    public function __construct($dbc)
    {
       parent::__construct($dbc, 'enrollment');

        
    }
    protected function tableFields(){
        $this->fields = [
            'learnerid',
            'courseid',
            'date',
            'status',
            'grade'
           
        ];
    }

    public function checkEnrollement($value = []){
        $this->findBy($value, 'AND');
        if(property_exists($this, 'id')){
            return true;
        }else{
            return false;
        }
    }

    public function enrollMe($lid,$cid){
        $value['learnerid'] = $lid;
        $value['courseid'] = $cid;
        $value['date'] = date('Y-m-d');
        $value['status'] = 'pending';
        $value['grade'] = ' ';
        $this->setValues($value);
        $this->save();
    }

    public function get_Enrolled_Course($value = [],$oprt = 'AND'){
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
            $obj->course = $this->yxz("Courses",['id'=>$u->courseid],'name');
            $obj->learner = $this->yxz("User",['id'=>$u->learnerid],'username');
            $obj->learnerData = $this->yxz("User",['id'=>$u->learnerid]);
            $obj->courseData = $this->yxz("Courses",['id'=>$u->courseid]);
            $obj->submission = $this->yxz("Submissions",['courseid'=>$u->courseid,'studentid'=>$u->learnerid]);
            $y[] = $obj;
        }
        return $y;
        

    }
   
}