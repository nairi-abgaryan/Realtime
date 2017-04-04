<?php
App::uses('AuthComponent', 'Controller/Component');
 
class calendar extends AppModel {
   
    public function add_cal($data){
            if ($this->save($data))
               return $this->id;
           return FALSE;
       }
}