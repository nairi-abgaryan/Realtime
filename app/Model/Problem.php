<?php

class Problem extends AppModel
{
     public $validate = array(
       'adress' => array(
            'rule' => 'notEmpty',
            'message'=>'*գրեք ձեր անունը'
        ),
        'comment' => array(
            'rule' => 'notEmpty',
            'message'=>'*գրեք ձեր անունը'
        ),

    );
       public function addPost($data) {
        if ($this->save($data))
            return $this->id;
        return FALSE;
        }
        public function save_change($data){
            if($this->save(data))
                return $this->id;
             return FALSE;
        }
          public function profile_list($id,$sort="id",$direction="desc") {
            if($sort != "Adress.city"){
                $sort = "Person.$sort";
            }
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
                . "ORDER BY $sort $direction "
        );
        
        if ($res && !empty($res))
                return $res;
            return FALSE;
        }
         public function search_problem($id,$order,$sort) {
            if($sort != "Adress.city"){
                $sort = "problem.$sort";
            }
            
        $res = $this->query("SELECT * FROM problems AS problem
                            LEFT JOIN people as people 
                            ON  people.id = problem.problem_id
                            LEFT JOIN legal_people as legal 
                            ON legal.person_id = people.id 
                            LEFT JOIN technical_data as technical_data 
                            ON technical_data.data_id = people.id 
                            LEFT JOIN adresses as Adress 
                            ON Adress.adresses_id = people.id 
                            LEFT JOIN villages as Village 
                            ON Village.id = Adress.village_id 
                            LEFT JOIN streets as Street 
                            ON Street.id = Adress.street_id 
                            LEFT JOIN telefons as Telefon 
                            ON Telefon.tel_id = people.id 
                            WHERE problem.id IN $id
                            AND problem.enable=0
                            Group BY problem.created DESC 
                            Order by $sort $order "
                                 );
        
         if ($res && !empty($res)){
                return $res;
            return FALSE;
            }
      }
      
      public function search_data($c) {
        $res = $this->query("SELECT * "
                . "FROM people AS people "
                . "LEFT JOIN legal_people as legal "
                . "ON legal.person_id = people.id "
                . "LEFT JOIN technical_data as technical_data "
                . "ON technical_data.data_id = people.id "
                . "LEFT JOIN adresses as adress "
                . "ON adress.adresses_id = people.id "
                . "LEFT JOIN villages as village "
                . "ON village.id = adress.village_id "
                . "LEFT JOIN streets as street "
                . "ON street.id = adress.street_id "
                . "LEFT JOIN telefons as telefon "
                . "ON telefon.tel_id = people.id "
                . "LEFT JOIN problems as problem "
                . "ON problem.user_id = technical_data.id "
                . "where problem.problem_id IN ".$c." and enable=0 "
                . "Group BY problem.created DESC "
      );
     
           if ($res && !empty($res)){
                return $res;
            return FALSE;
            }
       
      }
      public function no_activeted($c=10){
           $ress = $this->query("SELECT  "
                . "pro_solution,technical_data.username,street_id,problem_id ,problem.id,problem.comment,problem.modified ,problem.created ,problem.pro_person,problem.reg_person,village_name,street_name,city,home,telefon,tel1,tel_name "
                . "FROM problems as problem "
                . "LEFT JOIN technical_data as technical_data "
                . "ON technical_data.id = problem.user_id "
                . "LEFT JOIN people as people "
                . "ON people.id = problem.problem_id "
                . "LEFT JOIN adresses as adress "
                . "ON adress.adresses_id = people.id "
                . "LEFT JOIN villages as village "
                . "ON village.id = adress.village_id "
                . "LEFT JOIN streets as street "
                . "ON street.id = adress.street_id "
                . "CROSS JOIN telefons as telefon "
                . "ON telefon.tel_id = people.id "
                . "where problem.enable = -1 group by problem.id");
         if ($ress && !empty($ress)){
                return $ress;
            return FALSE;
            }
      }
      
      public function data(){
           $ress = $this->query("SELECT technical_data.username,street_id,problem_id ,problem.id,problem.comment,problem.modified ,problem.created ,problem.pro_persontwo,problem.pro_persontree,problem.pro_person,problem.reg_person,village_name,street_name,city,home,telefon,tel1,tel_name "
                . "FROM problems as problem "
                . "LEFT JOIN technical_data as technical_data "
                . "ON technical_data.id = problem.user_id "
                . "LEFT JOIN people as people "
                . "ON people.id = problem.problem_id "
                . "LEFT JOIN adresses as Adress "
                . "ON Adress.adresses_id = people.id "
                . "LEFT JOIN villages as Village "
                . "ON Village.id = Adress.village_id "
                . "LEFT JOIN streets as Street "
                . "ON Street.id = Adress.street_id "
                . "LEFT JOIN telefons as Telefon "
                . "ON Telefon.tel_id = people.id "
                . "where problem.enable = 0 and problem.user_id != 'null' group by Telefon.telefon ");
        if ($ress && !empty($ress)){
                return $ress;
            return FALSE;
        }
      }
      public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {    
              
              
                if($order){
                    foreach ($order as $key => $value) {
                           $key = strtolower($key);
                    }   
                }else {
                  $key = "problem.id";
                  $value = "desc";
                }
                // Mandatory to have
            
                $sql = '';

                $sql .= "SELECT technical_data.username,"
                        . "street_id,problem_id ,problem.id,problem.adress,problem.telefons,"
                        . "problem.comment,problem.modified ,"
                        . "problem.created ,problem.pro_persontwo,"
                        . "problem.pro_persontree,problem.pro_person,"
                        . "problem.reg_person,problem.comment_team,village_name,street_name,"
                        . "city,home,telefon,tel1,tel_name "
                . "FROM problems as problem "
                . "LEFT JOIN technical_data as technical_data "
                . "ON technical_data.id = problem.user_id "
                . "LEFT JOIN people as people "
                . "ON people.id = problem.problem_id "
                . "LEFT JOIN adresses as adress "
                . "ON adress.adresses_id = people.id "
                . "LEFT JOIN villages as village "
                . "ON village.id = adress.village_id "
                . "LEFT JOIN streets as street "
                . "ON street.id = adress.street_id "
                . "INNER JOIN telefons as telefon "
                . "ON telefon.tel_id = people.id "
                . "where problem.enable = 0 and problem.user_id != 'null'"
                . "group by problem.id " 
                . "order by $key $value "
                . " LIMIT ";
               
                $sql .= (($page - 1) * $limit) . ', ' . $limit;
                   
                $results = $this->query($sql);
             
                   if(!empty($results)):
                        return $results;
                   else:
                        var_dump($sql); 
                   endif;
            }
       public function archive_problem($id) {
           $c = $id-10;
        $res = $this->query("SELECT * "
                . "FROM problems AS problem "
                . "LEFT JOIN legal_people as legal "
                . "ON legal.person_id = problem.problem_id "
                . "LEFT JOIN adresses as Adress "
                . "ON Adress.adresses_id = problem.problem_id "
                . "LEFT JOIN villages as Village "
                . "ON Village.id = Adress.village_id "
                . "LEFT JOIN streets as Street "
                . "ON Street.id = Adress.street_id "
                . "LEFT JOIN telefons as Telefon "
                . "ON Telefon.tel_id = problem.problem_id "
                . "LEFT JOIN people as people "
                . "ON people.id = problem.problem_id "
                . "WHERE problem.enable > 0 "
                . "Group by problem.id Order BY problem.created DESC "
                . "LIMIT " . $c . "," . 10 . ""
      );
         if ($res && !empty($res)){
                return $res;
            return FALSE;
            }
      }
      public function black_list($id) {
         
         $res = $this->query("SELECT * "
                . "FROM people AS people "
                . "WHERE people.id IN " . $id . ""
      );
         if ($res && !empty($res)){
                return $res;
            return FALSE;
            }
      }
}
?>