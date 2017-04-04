<?php
App::uses('AuthComponent', 'Controller/Component');
 
class written_log extends AppModel {
   
    public function add_logs($data){
            if ($this->save($data))
               return $this->id;
           return FALSE;
       }
}