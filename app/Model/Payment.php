<?php

class Payment extends AppModel
{
    public function addPost($data) {
    if ($this->save($data))
        return $this->id;
    return FALSE;
    }      
    public function convert(){
        $res = $this->query("SELECT `realtimes`.`technical_data`.`ip_range`,`realtimes`.`technical_data`.`id`, COUNT(*)
FROM
     realtimes.technical_data
GROUP BY
   technical_data.ip_range
HAVING 
    COUNT(*) > 1");
   
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
    
}
?>