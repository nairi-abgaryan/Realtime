<?php
App::uses('AuthComponent', 'Controller/Component');
 
class warehouse extends AppModel {
     
    public $avatarUploadDir = 'img/avatars';
      
public $validate = array(
        'species' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A species is required',
                'allowEmpty' => false
            ),
        ),
        'quantity' => array(
            'required' => array(
                'rule' => array('numeric'),
                'message' => 'A quantity is numeric'
            ),
        ),
        'email' => array(
            'required' => array(
                'rule' => array('email', true),    
                'message' => 'Please provide a valid email address.'   
            ),
        ),
 
         
    );
    public function add_tool($data){
            if ($this->save($data))
               return $this->id;
           return FALSE;
       }
       public function create_prod(){
            $res = $this->query("SELECT * "
                . "FROM product_counts AS prod_count "
                . "group by product_name"
            );
             if ($res && !empty($res)){
                return $res;
            return FALSE;
            }
       }
         
       
}