<?php

class Product_name extends AppModel
{
    
       public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
        }
        
    
}
?>