<?php


class user_role extends AppModel
{
   
    public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
    }
   
  
}
?>