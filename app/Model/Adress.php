<?php

class Adress extends AppModel
{
     public $validate = array(
       'city' => array(
            'rule' => 'notEmpty'
        ),
        'village' => array(
            'rule' => 'notEmpty'
        ),
        'gps' => array(
            'rule' => 'notEmpty'
        ),
        'street' => array(
            'rule' => 'notEmpty'
        ));
    public function addPost($data) {
    if ($this->save($data))
        return $this->id;
    return FALSE;
    }
}
?>