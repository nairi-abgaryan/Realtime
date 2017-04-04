<?php

class Technical_data extends AppModel
{
    public function addPost($data) {
    if ($this->save($data))
        return $this->id;
    return FALSE;
    }
   
 function isUniqueUsername() {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'Technical_data.username'
                ),
                'conditions' => array(
                    'Technical_data.username' => $this->data["Technical_data"]['username']
                )
            )
        );
        if($username){
            return false;
        }else{
            return true; 
        }
    }
   public function a() {
        $res = $this->query("SELECT `realtimes`.`technical_data`.`ip_range`,`realtimes`.`technical_data`.`id`, COUNT(*)
FROM
     realtimes.technical_data
GROUP BY
   technical_data.ip_range
HAVING 
    COUNT(*) >= 2"
        );
        if ($res && !empty($res))
                return $res;
            return FALSE;
        
   }
   
}
?>