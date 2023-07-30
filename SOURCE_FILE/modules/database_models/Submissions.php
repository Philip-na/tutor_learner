<?php

class Submissions extends Entity {
  

    public function __construct($dbc)
    {
       parent::__construct($dbc, 'submissions');

        
    }
    protected function tableFields(){
        $this->fields = [
            'studentid',
            'courseid',
            'name',
            'slink',
            'filename'
           
        ];
    }

    public function getFilePath()
{
    $uploadDirectory = 'uploads/'; // Change this to your desired directory where the files are stored
    return $uploadDirectory . $this->filename;
}

    public function get_submissions($value = [],$oprt = 'AND'){
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
            $obj->course = $this->yxz("Courses",['id'=>$u->courseid]);
            $obj->learner = $this->yxz("User",['id'=>$u->studentid]);
               
            $y[] = $obj;
        }
        return $y;
    }

    public function saveSubmission($data){
        $studentId = $_SESSION['user']['id'] ?? '';
        $courseId = $data['courseid'] ?? '';
        $name = $data['name'] ?? '';
        $slink = $data['slink'] ?? '';
        $filename = $_FILES['myFile']['name'] ?? ''; 
        // File upload handling
        if (isset($_FILES['myFile'])) {
            $file = $_FILES['myFile'];
            $fileTempPath = $file['tmp_name'];
            $fileOriginalName = $file['name'];
            $uploadDirectory = 'uploads/';
            $fileExtension = pathinfo($fileOriginalName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $fileExtension;
            $fileDestination = $uploadDirectory . $newFileName;
            if (move_uploaded_file($fileTempPath, $fileDestination)) {
                // File upload success
                $filename = $newFileName;
            } else {
                echo "Error uploading the file.";
                return;
            }
        }
        $this->saveSubmissionToDatabase($studentId, $courseId, $name, $slink, $filename);
    }


    

    private function saveSubmissionToDatabase($studentId, $courseId, $name, $slink, $filename){  
        $submissionData = [
            'studentid' => $studentId,
            'courseid' => $courseId,
            'name' => $name,
            'slink' => $slink,
            'filename' => $filename
        ];
        $this->setValues($submissionData);
        $this->save();
    }

   
}