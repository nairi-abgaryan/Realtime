<?php

class Service extends AppModel
{
    public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
        
    }
    public function search_station($data) {
       $res = $this->query("SELECT * FROM stations 
            left join technical_data as tech
            on tech.id=stations.station_user_id 
            left join villages as village
            on village.id=stations.station_village_id
            left join stations as s
            on s.id = stations.station_neighbour_id
            where stations.station_region='".$data."'");
          if ($res && !empty($res)){
                return $res;
            return FALSE;
          }
         
    }
    
}
?>