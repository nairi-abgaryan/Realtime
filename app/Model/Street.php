<?php

class Street extends AppModel
{
     public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
    }
    
}
?>