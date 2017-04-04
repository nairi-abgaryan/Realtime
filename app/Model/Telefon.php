<?php

class Telefon extends AppModel
{
     public $validate = array(
       'telefon' => array(
            'rule' => 'notEmpty'
        ));
    public function addPost($data) {
    if ($this->save($data))
        return $this->id;
    return FALSE;
    }
}
?>