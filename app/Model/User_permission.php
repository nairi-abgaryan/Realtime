<?php
App::uses('AuthComponent', 'Controller/Component');
class User_permission extends AppModel
{
     
     public function addPost($data) {
        if ($this->save($data))
            return $this->user_id;
        return FALSE;
    }
    
}
?>