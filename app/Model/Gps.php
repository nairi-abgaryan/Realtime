<?php

class Gps extends AppModel {

    public $validate = array(
        'gps' => array(
            'rule' => 'notEmpty'
    ));

    public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
    }
    public function query_custom($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
    }
    public function gps_search($data_id) {
        $res = $this->query("SELECT gps_id,gps,username "
                . "FROM gps AS gps "
                . "LEFT JOIN technical_data AS tech "
                . "ON tech.data_id = gps.gps_id "
                . "WHERE gps.gps_id IN " . $data_id . ""
        );

        if ($res && !empty($res))
            return $res;
        return FALSE;
    }

}

?>