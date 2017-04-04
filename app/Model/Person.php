<?php

class Person extends AppModel
{
   
        public function addPost($data) {
           
        if ($this->save($data))
            return $this->id;
        return FALSE;
        }
        public function add() {
           
        if ($this->save())
            return $this->id;
        return FALSE;
        }
        public function searchPost($value) {
            return $this->id;
        }
        
        public function getPostsFiles($conditions) {
        $res = $this->query("SELECT * "
                . "FROM people AS Person "
                . "LEFT JOIN adresses as Adress "
                . "ON Adress.adresses_id = Person.id "
                . "LEFT JOIN villages as Village "
                . "ON Village.id = Adress.village_id "
                . "LEFT JOIN streets as Street "
                . "ON Street.id = Adress.street_id "
                . "LEFT JOIN gps as Gps "
                . "ON Gps.gps_id = Person.id "
                . "LEFT JOIN estate_users as Estate "
                . "ON Estate.client_id = Person.id "
                . "LEFT JOIN telefons as Telefon "
                . "ON Telefon.tel_id = Person.id "
                . "LEFT JOIN technical_data as Technical "
                . "ON Technical.data_id = Person.id "
                . "LEFT JOIN payments as Payment "
                . "ON Payment.data_id = Technical.id "
                . "LEFT JOIN service_names as Services "
                . "ON Services.id = Technical.service_id "
                . "LEFT JOIN legal_data as legal_data "
                . "ON legal_data.data_id = Person.id "
                . "LEFT JOIN legal_people as legal "
                . "ON legal.person_id = Person.id "
                . "WHERE Person.id IN " . $conditions . ""
                . "Group BY Person.id DESC "
                . "LIMIT 10"
        );
//       $ress = $this->query("SELECT *,GROUP_CONCAT(username,password) FROM technical_data WHERE data_id IN ".$conditions." GROUP BY data_id;");
//       var_dump($ress );
   
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
         public function getPostsFilesActive($conditions) {
        $res = $this->query("SELECT *"
                . "FROM people AS Person "
                . "LEFT JOIN adresses as Adress "
                . "ON Adress.adresses_id = Person.id "
                . "LEFT JOIN villages as Village "
                . "ON Village.id = Adress.village_id "
                . "LEFT JOIN streets as Street "
                . "ON Street.id = Adress.street_id "
                . "LEFT JOIN telefons as Telefon "
                . "ON Telefon.tel_id = Person.id "
                . "LEFT JOIN gps as Gps "
                . "ON Gps.gps_id = Person.id "
                . "LEFT JOIN estate_users as Estate "
                . "ON Estate.client_id = Person.id "
                . "LEFT JOIN technical_data as Technical "
                . "ON Technical.data_id = Person.id "
                . "LEFT JOIN payments as Payment "
                . "ON Payment.data_id = Technical.id "
                . "LEFT JOIN service_names as Services "
                . "ON Services.id = Technical.service_id "
                . "LEFT JOIN legal_people as legal "
                . "ON legal.person_id = Person.id "
                . "LEFT JOIN legal_data as legal_data "
                . "ON legal_data.data_id = Person.id "
                . "WHERE Person.id IN " . $conditions . " "
                . "AND Person.active = 1 "
                . "Group BY Person.id DESC "
                . " LIMIT 10"
        );
//       $ress = $this->query("SELECT *,GROUP_CONCAT(username,password) FROM technical_data WHERE data_id IN ".$conditions." GROUP BY data_id;");
//       var_dump($ress );
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
          public function technical($conditions){
            $tech =  $this->query("SELECT * FROM technical_data as technical_data "
                    . "LEFT JOIN  stations as Station "
                    . "ON technical_data.station_id = Station.id "
                    . "LEFT JOIN  service_names as Service "
                    . "ON technical_data.service_id = Service.id "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = technical_data.id "
                    . "WHERE technical_data.data_id IN ".$conditions." Group BY technical_data.id ");
                if ($tech && !empty($tech))
                    return $tech;
                return FALSE;
            }
            
          public function days($conditions,$date1){
           
            $tech =  $this->query("SELECT username,"
                    . "payday,counter_credit,credit,category,"
                    . "service_name,price,firstname,lastname,"
                    . "city,village_name,home,street_name,telefon,tel1 FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "LEFT JOIN people as Person "
                    . "ON Person.id = tech.data_id "
                    . "LEFT JOIN telefons as Telefon "
                    . "ON Telefon.tel_id = tech.data_id "
                    . "LEFT JOIN  service_names as Service "
                    . "ON tech.service_id = Service.id "
                    . "LEFT JOIN adresses as Adress "
                    . "ON Adress.adresses_id = tech.data_id "
                    . "LEFT JOIN villages as Village "
                    . "ON Village.id = Adress.village_id "
                    . "LEFT JOIN streets as Street "
                    . "ON Street.id = Adress.street_id "
                    . "WHERE Payment.payday >='$conditions' "
                    . "and Payment.payday <'$date1' and"
                    . " Payment.credit>0 and Payment.no_credit=0 Group by username limit 300 ");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
             public function no_credit(){
           
            $tech =  $this->query("SELECT username,payday,counter_credit,credit,category,service_name,price,firstname,lastname,city,village_name,home,street_name,telefon,tel1 FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "LEFT JOIN people as Person "
                    . "ON Person.id = tech.data_id "
                    . "LEFT JOIN telefons as Telefon "
                    . "ON Telefon.tel_id = tech.data_id "
                    . "LEFT JOIN  service_names as Service "
                    . "ON tech.service_id = Service.id "
                    . "LEFT JOIN adresses as Adress "
                    . "ON Adress.adresses_id = tech.data_id "
                    . "LEFT JOIN villages as Village "
                    . "ON Village.id = Adress.village_id "
                    . "LEFT JOIN streets as Street "
                    . "ON Street.id = Adress.street_id "
                    . "WHERE Payment.no_credit=1 Group by username limit 300");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
            public function days_not_credit($conditions,$date1){
           
            $tech =  $this->query("SELECT username,payday,counter_credit,credit,category,service_name,price,firstname,lastname,city,village_name,home,street_name,telefon,tel1 FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "LEFT JOIN people as Person "
                    . "ON Person.id = tech.data_id "
                    . "LEFT JOIN telefons as Telefon "
                    . "ON Telefon.tel_id = tech.data_id "
                    . "LEFT JOIN  service_names as Service "
                    . "ON tech.service_id = Service.id "
                    . "LEFT JOIN adresses as Adress "
                    . "ON Adress.adresses_id = tech.data_id "
                    . "LEFT JOIN villages as Village "
                    . "ON Village.id = Adress.village_id "
                    . "LEFT JOIN streets as Street "
                    . "ON Street.id = Adress.street_id "
                    . "WHERE Payment.payday>='$conditions' and Payment.payday <'$date1' and Payment.credit=0 Group by username limit 300");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
             public function pay_debt($a,$b){
           
            $tech =  $this->query("SELECT username,payday,counter_credit,credit,category,service_name,price,firstname,lastname,city,village_name,home,street_name,telefon,tel1 FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "LEFT JOIN people as Person "
                    . "ON Person.id = tech.data_id "
                    . "LEFT JOIN telefons as Telefon "
                    . "ON Telefon.tel_id = tech.data_id "
                    . "LEFT JOIN  service_names as Service "
                    . "ON tech.service_id = Service.id "
                    . "LEFT JOIN adresses as Adress "
                    . "ON Adress.adresses_id = tech.data_id "
                    . "LEFT JOIN villages as Village "
                    . "ON Village.id = Adress.village_id "
                    . "LEFT JOIN streets as Street "
                    . "ON Street.id = Adress.street_id "
                    . "WHERE Payment.counter_credit>$a and Payment.counter_credit<$b;");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
          public function pay_credit($pay_start,$pay_end,$pay_category,$a,$b){
            
            if($pay_category == '2'){
                $query = "WHERE payday<='$pay_start' AND payday>='$pay_end' AND category='$pay_category' OR credit>0 group by username ORDER BY payday desc";
            }else if($pay_category == '0'){
                $query = "WHERE counter_credit>$a  AND counter_credit<$b AND category='$pay_category' group by username ORDER BY payday desc ";
            }else if($pay_category == '5') {
                $query =  "WHERE payday>='$pay_end' AND payday<='$pay_start' AND category='2' OR counter_credit>$a  AND counter_credit<$b  group by username ORDER BY payday desc ";
            }else{
                $query = "WHERE id = -1";
            }
        
            $tech =  $this->query("SELECT username,payday,counter_credit,credit,category,service_name,price,firstname,lastname,city,village_name,home,street_name,telefon,tel1 FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "LEFT JOIN people as Person "
                    . "ON Person.id = tech.data_id "
                    . "LEFT JOIN telefons as Telefon "
                    . "ON Telefon.tel_id = tech.data_id "
                    . "LEFT JOIN  service_names as Service "
                    . "ON tech.service_id = Service.id "
                    . "LEFT JOIN adresses as Adress "
                    . "ON Adress.adresses_id = tech.data_id "
                    . "LEFT JOIN villages as Village "
                    . "ON Village.id = Adress.village_id "
                    . "LEFT JOIN streets as Street "
                    . "ON Street.id = Adress.street_id "
                    . "$query ");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
            public function dis_view($client_category,$select_category,$d=0){
                    $thisdate = date("Y-m-d 00:00:00");
                    if($client_category ==2 && $select_category ==1):
                        $query="pers_pay is not null and category='2'";
                    elseif($client_category ==2 && $select_category ==3):
                         $query="payday<'$thisdate' and payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null 
                    or( credit>0 and payday>='$thisdate' and  payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null )
                    or( counter_credit>0 and payday>='$thisdate' and  payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null )";
                    elseif($client_category ==2 && $select_category ==2):
                        $query="payday>='$thisdate' and credit=0 and counter_credit=0 and payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null ";
                    elseif($client_category ==0 && $select_category ==4):
                        $query="counter_credit=0 and credit=0 and category='0' and pers_pay is null";
                     elseif($client_category ==0 && $select_category ==6):
                        $query="counter_credit>0 and category='0' and pers_pay is null or(credit>0 and category='0' and pers_pay)";
                     elseif($client_category ==0 && $select_category ==7):
                        $query="username like '%old%'";
                     elseif($client_category ==1 && $select_category ==8):
                        $query="category='1' ";
                    endif;
                    $d = (int)$d; 
                    $tech["all"] =  $this->query("SELECT username,"
                                . "payday,pers_pay,"
                                . "counter_credit,credit,"
                                . "Payment.category,service_name "
                                . "FROM technical_data as tech "
                                . "LEFT JOIN payments as Payment "
                                . "ON Payment.data_id = tech.id "
                                . "LEFT JOIN  service_names as Service "
                                . "ON tech.service_id = Service.id "
                                . "WHERE $query group by tech.id order by payday desc "
                                . "LIMIT ".$d. ",200 ");
                   $tech["count"] =  $this->query("SELECT count(*) FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id WHERE $query");
                    if ($tech && !empty($tech))
                            return $tech;
                        return FALSE;
            }
            public function client($c){
           if($c ==2){
            $thisdate = date("Y-m-d 00:00:00");
            $tech =  $this->query("SELECT count(*) as all_active,
                    (SELECT count(*) FROM realtimes.payments where pers_pay is not null and category='2') as pers_pay,
                    (SELECT count(*) FROM realtimes.payments where  payday<'$thisdate' and payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null 
                    or( credit>0 and payday>='$thisdate' and  payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null )
                    or( counter_credit>0 and payday>='$thisdate' and  payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null )) as client_credit,
                    (SELECT count(*) FROM realtimes.payments where payday>='$thisdate' and credit=0 and counter_credit=0 and payday!='0000-00-00 00:00:00' and category='2' and pers_pay is null) as client_not_credit
                     FROM payments as p where category='2'");
           }elseif($c==0){
                $tech = $this->query("SELECT count(*) as dis_client,
                    (SELECT count(*) FROM realtimes.payments where pers_pay is not null and category='0') as pers_pay,
                    (SELECT count(*) FROM realtimes.payments  as p inner join technical_data as t on p.data_id =t.id where username like '%old%') as old,
                    (SELECT count(*) FROM realtimes.payments where counter_credit>0 and category='0' and pers_pay is null or(credit>0 and category='0' and pers_pay)) as client_credit,
                    (SELECT count(*) FROM realtimes.payments where counter_credit=0 and credit=0 and category='0' and pers_pay is null) as client_not_credit
                     FROM payments as p where category='0' ;");
           }if($c==1){
               $tech = $this->query("SELECT count(*) as dis FROM payments as p where category='1'");
           }
            if ($tech && !empty($tech))
                    return $tech;
                return FALSE;
            }
             public function active_client(){
           
            $tech =  $this->query("SELECT count(*) FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "WHERE Payment.category=2");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
           public function stoped_client(){
           
            $tech =  $this->query("SELECT count(*) FROM technical_data as tech "
                    . "LEFT JOIN payments as Payment "
                    . "ON Payment.data_id = tech.id "
                    . "WHERE Payment.category=1");
            if ($tech && !empty($tech))
                
                    return $tech;
                return FALSE;
            }
        public function profile($id,$sort="id",$direction="desc") {
        $res = $this->query("SELECT * "
                . "FROM people AS Person "
                . "LEFT JOIN adresses as Adress "
                . "ON Adress.adresses_id = Person.id "
                . "LEFT JOIN villages as Village "
                . "ON Village.id = Adress.village_id "
                . "LEFT JOIN legal_people as legal "
                . "ON legal.person_id = Person.id "
                . "LEFT JOIN gps as Gps "
                . "ON Gps.gps_id = Person.id "
                . "LEFT JOIN streets as Street "
                . "ON Street.id = Adress.street_id "
                . "LEFT JOIN telefons as Telefon "
                . "ON Telefon.tel_id = Person.id "
                . "WHERE Person.id IN " . $id . ""
                . "AND Person.active=0 "
                . "Group by Telefon.tel_id Order BY `Person`.`$sort` $direction "
        );
        
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
    
}
?>