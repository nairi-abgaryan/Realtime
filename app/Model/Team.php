<?php
App::uses('AuthComponent', 'Controller/Component');
 
class Team extends AppModel {
     
    public $avatarUploadDir = 'img/avatars';
      
public $validate = array(
         'username' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required',
                'allowEmpty' => false
            ),
            'between' => array( 
                'rule' => array('between', 5, 15), 
                'required' => true, 
                'message' => 'Usernames must be between 5 to 15 characters'
            ),
             'unique' => array(
                'rule'    => array('isUniqueUsername'),
                'message' => 'This username is already in use'
            )
        ),
        'firstname' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A firstname is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '3'),  
                'message' => 'firstname must have a mimimum of 3 characters'
            )
        )
 
         
    );
    public function archive($user){
            $res=$this->query("Update realtimes.teams set archive='1' where id=".$user.""
                    );
            
    }
 function isUniqueUsername() {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'Team.username'
                ),
                'conditions' => array(
                    'Team.username' => $this->data["Team"]['username']
                )
            )
        );
        if($username){
            return false;
        }else{
            return true; 
        }
    }
    public function add_team($data){
            if ($this->save($data))
               return $this->id;
           return false;
       }
        public function search($conditions) {
        $res = $this->query("SELECT * "
                . "FROM written_items AS written_item "
                . "LEFT JOIN product_names as product_name "
              
                  . "AND product_name.id = written_item.product_id "
                . "WHERE written_item.id IN " . $conditions . ""
                . "Group BY written_item.id DESC "
        );
//       $ress = $this->query("SELECT *,GROUP_CONCAT(username,password) FROM technical_data WHERE data_id IN ".$conditions." GROUP BY data_id;");
//       var_dump($ress );
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
}