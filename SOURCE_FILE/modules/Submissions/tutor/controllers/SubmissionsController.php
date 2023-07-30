<?php
class SubmissionsController extends Controller{
    function runBeforeAction(){
        $this->setaccesslevel('tutor');      
        return $this->checkPermission();
    }
    function defaultAction(){
        $pageObJ = new Page($this->dbc);
        $pageObJ->findBy(['id'=>$this->entityId], '');
        $variable['pageObj'] = $pageObJ;
        $submissionHaddler = new Submissions($this->dbc);
        $tutorid = $_SESSION['user']['id'];
        $courseid = $submissionHaddler->yxz('Courses',["tutorid"=>$tutorid],'id');

        if(($_GET['act'] ?? '') == 'download'){ $this->getpdf(); }


        $variable['submissions'] = $submissionHaddler->get_submissions(['courseid'=>$courseid]);
        $this->template->view('submissions/tutor/views/submissions',$variable);
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
}


