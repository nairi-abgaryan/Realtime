<?php

class Estate_user extends AppModel
{
    public function addPost($data) {
    if ($this->save($data))
        return $this->id;
    return FALSE;
    }
}
?>