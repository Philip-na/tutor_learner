<?php

class Sessionatedence extends Entity {
  

  public function __construct($dbc)
  {
     parent::__construct($dbc, 'sessionatedence');

      
  }
  protected function tableFields(){
      $this->fields = [
        'learnerid',
        'sessionid',
        'status'         
      ];
  }

 
}