<?php
App::uses('AuthComponent', 'Controller/Component');
 
class role extends AppModel {
    
    public function add_role($data){
            if ($this->save($data))
               return $this->id;
           return FALSE;
       }
}