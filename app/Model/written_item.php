<?php

App::uses('AuthComponent', 'Controller/Component');

class written_item extends AppModel {

    public function add_logs($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
    }

    public function search_product($conditions) {
        $res = $this->query("SELECT * "
                . "FROM written_items AS written_item "
                . "LEFT JOIN product_names AS product_name "
                . "ON written_item.product_id = product_name.id "
                . "WHERE written_item.username = '". $conditions ."' "
        );
        if ($res && !empty($res))
                return $res;
            return FALSE;
        
    }

}
