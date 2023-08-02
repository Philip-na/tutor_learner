<?php
class SubmissionsController extends Controller{
    function runBeforeAction(){
        $this->setaccesslevel('learner');      
        return $this->checkPermission();
    }
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;
        $lid = $_SESSION['user']['id'];
        $cdtn = ['studentid' => $lid];

        $submissionObj = new Submissions($this->dbc);

        if(($_GET['act'] ?? '') == 'remove'){ $this->revomeSubmission($_GET['id']); }

        if(($_GET['act'] ?? '') == 'download'){ $this->getpdf(); }

        $variable['submissions'] = $submissionObj->get_submissions($cdtn);   
        $this->template->view('submissions/learner/views/submissions',$variable);
    }

    private function getpdf(){
        $submissionId = $_GET['id'];
        $submission = new Submissions($this->dbc);
        $submission->findBy(['id' => $submissionId]);
        if (!empty($submission->filename)) {
            $filePath = $submission->getFilePath();
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    }
    private function revomeSubmission($id){
        $Obj = new Submissions($this->dbc);
        $Obj->findBy(['id'=>$id],"AND");
        if(property_exists($Obj,'id')){
            $filepath = $Obj->getFilePath();
            unlink($filepath);
            $Obj->delete();

        }

    }
}


