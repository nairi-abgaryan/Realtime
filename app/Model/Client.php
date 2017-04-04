<?php

class Client extends AppModel
{

     public $validate = array(
       'telefon' => array(
            'rule' => 'notEmpty',
            'message'=>'*գրեք ձեր անունը'
        ),
        'telefons' => array(
            'rule' => 'notEmpty',
            'message'=>'*գրեք ձեր անունը'
        ),
        'telefonss' => array(
            'rule' => 'notEmpty',
            'message'=>'*գրեք ձեր անունը'
        ),
        'adress' => array(
            'rule' => 'notEmpty',
            'message'=>'*նշեք ձեր հասցեն'
        ),
        'city' => array(
            'rule' => 'notEmpty',
            'message'=>'*նշեք քաղաքը որտեղ բնակվում էք'
        ),

    );
        
      public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
    }
    public function a(){
    }
    
}
?>