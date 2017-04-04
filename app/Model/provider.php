<?php

class provider extends AppModel
{
    
    public function group_prod($conditions) {
        $res = $this->query("SELECT * "
                . "FROM warehouses AS warehouses "
                . "LEFT JOIN providers as provider "
                . "ON provider.id = warehouses.provider_id "
                . "LEFT JOIN product_names as product "
                . "ON product.id = warehouses.product_id "
                . "WHERE warehouses.id IN " . $conditions . ""
                . "Order BY warehouses.id DESC "
        );
//       $ress = $this->query("SELECT *,GROUP_CONCAT(username,password) FROM technical_data WHERE data_id IN ".$conditions." GROUP BY data_id;");
//       var_dump($ress );
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
       public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
        }
    
}
?>