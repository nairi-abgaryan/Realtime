<?php

App::uses('AppController', 'Controller');
 
class RealtimesController extends AppController {
     
    public $helpers = array('Html', 'Form', 'Session');
    public $uses = array( 
        "warehouse", "warehofuse", "written_item", "Comment", "Station", "Server","Cron",
        "User", "Realtime", "Team", "Client", "Person", "Transaction_log","new_sms",
        "Estate_user", "Estate_user", "Gps", "Adress", "Service", "Payment","url",
        "Technical_data", "Telefon", "Legal_person", "online", "histori", "role","credit",
        "Problem", "Permission", "Service_name", 'Problem', 'Product_name', 'legal_data',
        "User_permission", "Village", "Street", "Transaction", "sxal_username", 
        "black_list", "sms", "new_messages","call_history","problem_log","page","permission","pay_center"
    );
  
    public $paginate = array(
        'fields' => array('Problem.id', 'Problem.created'),
        'limit' => 50,
        'order' => array(
            'Problem.id' => 'asc'
        )
    );
    public $components = array(
    
        'Cookie',
        'Paginator',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'realtimes', 'action' => 'search'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authError' => 'You must be logged in to view this page.',
            'loginError' => 'Invalid Username or Password entered, please try again.'
    ));
    public function call_history(){
        if(isset($_POST["values"])){
            $values = $_POST["values"];
            $thisdate = date("Y-m-d");
            //$last_date = date(strtotime(date("Y-m-d H:i:s") . '-20 second'));
            if($values["0"]=='' && $values["2"]=='' && $values["1"]==''){
                echo 0; die();
            }
            if($values["0"]==''):
                $date1  = date(strtotime(date("Y-m-d") . '-1 month'));
            else:
                $date1 = $values["0"];
            endif;
            if($values["1"] ==''):
                    $date2 = $thisdate;
                else:
                    $date2=$values["1"];
            endif;
           
            if(strlen($values["2"]) == 0):
                $query = "call_history.created BETWEEN '$date1' AND '$date2 23:59:59.999' and call_history.user_id is null and f_name !='.mp3' and f_name !=''";
                else:
                $number = $values["2"];
                $query = "(call_history.src = '$number'"
                        . " or call_history.dst = '$number' "
                        . "or call_history.userfield = '$number') and "
                        . "call_history.created BETWEEN '$date1' AND '$date2 23:59:59.999' and call_history.user_id is null and f_name !='.mp3' and f_name !=''";
            endif;
           
            $a = $this->call_history->find("all",array(
                        "joins"=>array(
                                        array(
                                            "table" => "tel_users",
                                            "alias"=>"tech",
                                            "type" => "Left",
                                            "conditions" => array("call_history.src = tech.tel or call_history.dst = tech.tel "
                                                . "or call_history.userfield = tech.tel"),
                                        ) 
                                    ),
                        "conditions"=> array($query),
                        "fields"=>array("tech.tel_user,call_history.src,"
                            . "call_history.dst,call_history.created,call_history.comment,call_history.id,"
                            . "call_history.billsec,call_history.f_name,call_history.href,src,dst,disposition"),
                        "order"=>"call_history.created desc",
                        "limit"=>"300",

                        ));
            echo json_encode($a);
            die();
        }
        $this->page->find("all");
        if(isset($_POST["call_id"]) && isset($_POST["comment"])){
            $comment = $_POST["comment"];
            $call_id = $_POST["call_id"];
            $a = $this->call_history->updateAll(array("call_history.comment"=>"'$comment'"),array("call_history.id"=>$call_id));
            if($a):
               echo 1;
            else:
               echo 0;
            endif;
        }
        if(isset($_POST["tel_id"]) ){
           $tel_id = $_POST["tel_id"];

            if($tel_id ){
//                    $history = $this->call_history->find("all", array(
//                        "conditions"=> array("call_history.user_id" => $tel_id),
//                        'limit' => '100',
//                    ));
                    $a = $this->call_history->find("all",array(
                        "joins"=>array(
                                        array(
                                            "table" => "tel_users",
                                            "alias"=>"tech",
                                            "type" => "Left",
                                            "conditions" => array("call_history.src = tech.tel or call_history.dst = tech.tel "
                                                . "or call_history.userfield = tech.tel"),
                                        ) 
                                    ),
                        "conditions"=> array("call_history.user_id" => $tel_id),
                        "fields"=>array("tech.tel_user,call_history.src,"
                            . "call_history.dst,call_history.created,call_history.comment,call_history.id,"
                            . "call_history.billsec,call_history.f_name,call_history.href"),
                        "order"=>"call_history.created desc",
						));

                    echo json_encode($a);
             die();
            }

         die();
        }
       die();
    }
    
      public function perm($controller,$action,$role){
        $page = $this->perm = $this->page->query("SELECT perm FROM realtimes.pages as page "
                . "left join permissions as perm "
                . "on perm.page=page.id "
                . "where page.page_controller='$controller' and page_name='$action' and role='$role'");
        if(count($page)!=0 ){
        
            if(!$page["0"]["perm"]["perm"]){ 
                $page = $this->perm = $this->page->query("SELECT * FROM realtimes.pages as page "
                . "left join permissions as perm "
                . "on perm.page=page.id "
                . "where page.page_controller='$controller' and perm='1' and role='$role' limit 1");
                if(count($page)!=0 && $page["0"]["perm"]["perm"]){
                   return $this->redirect(array('action'=>$page["0"]["page"]["page_name"],'controller'=>$page["0"]["page"]["page_controller"]));
                 }else{   
                     $page = $this->perm = $this->page->query("SELECT * FROM realtimes.pages as page "
                    . "left join permissions as perm "
                    . "on perm.page=page.id "
                    . "where perm='1' and role='$role' limit 1");
            
                      if(count($page)!=0 && $page["0"]["perm"]["perm"]){
                          return $this->redirect(array('action'=>$page["0"]["page"]["page_name"],'controller'=>$page["0"]["page"]["page_controller"]));
                      }else{
                          return $this->redirect(array('action'=>'logout','controller'=>'users'));
                      }
                 }
            }else{
                
            }
        }else if(count($page)==0){
            
        }
   }
    // only allow the login controllers only
  //    public  $variable = array("a"=>array($this->page->query("SELECT * FROM realtimes.pages as page left join permissions as perm on perm.page=page.id")));
    public function beforeFilter() {

          
        $this->Auth->allow('login');
        $this->set('logged_in', $this->Auth->loggedIn());
        $this->set('current_user', $this->Auth->user());
        $user = $this->Auth->user();
        //var_dump($user);
        $role = $this->Auth->user()["role"];
         
        $controller = $this->request->params['controller'];
        $action = $this->request->params['action'];
        $this->perm($controller, $action,$role);
    }
  
    public function new_message(){
        if(isset($_POST["new_message"])){
       
        $user = $this->Auth->user()["username"];
     
        $filename = 'message/'.$user.'.json';
          
              if (file_exists($filename)) {
                   $curent = file_get_contents($filename);
                   echo "<span style='z-index:9999;text-align:center;width:16px;height:16px;position:fixed;border-radius:100%;background:red;color:#fff;top:20px;left:47px;'>1</span>";

              } else {
                  echo 0;
               }
        }
        die();
    }
    public function auth() {
        
        if (isset($_POST["CAKEPHP"])) {
            $a = setcookie("CAKEPHP", '', time() + (10 * 365 * 24 * 60 * 60), "");
            die();
        }
    }
    
    public function problem_list(){
        $a = $this->Session->read();
        $this->set("auth_user",$this->Auth->user());
        $direction = "desc";
        $this->set("direction",$direction);
        if($_SERVER['REQUEST_URI'] === "/realtimes/problem_list"):
                $person = $this->Person->find('all', array(
                                           "conditions" => array("Person.active = 0 order by id desc Limit 0,20")));
                    $sort = "id";
                    $direction = "desc";
                    $this->set("direction","none");
                elseif(strpos($_SERVER['REQUEST_URI'],"sort")):
                    $sort = strpos($_SERVER['REQUEST_URI'],"sort:");
                    $direction = strpos($_SERVER['REQUEST_URI'],"/direction:");
                    $sort = substr($_SERVER['REQUEST_URI'], $sort+5,-(strlen($_SERVER['REQUEST_URI'])-$direction));
                    $direction = substr($_SERVER['REQUEST_URI'], $direction + 11);
                    if($direction == 'asc'):
                        $this->set("direction","desc");
                        else:
                        $this->set("direction","asc");
                    endif;
       endif; 
      
        $a = $this->Problem->find("first");
        $user = $this->Auth->user()["username"];
        
        $this->set("username",$user);
                $id = "";

                $problem = $this->Problem->query("SELECT Problem.id,Problem.pro_person,Problem.problem_id FROM 
                                    `realtimes`.`problems` AS `Problem` 
                                    WHERE `Problem`.`enable` = 0 
                                    AND (`Problem`.`pro_person`='$user'
                                    OR `Problem`.`pro_persontwo`='$user'
                                    OR `Problem`.`pro_persontree`='$user')");
              
                if($problem){
                 foreach ($problem as $value) {
                         if (!is_null($value["Problem"]["id"]))
                             $id .= "'" . $value["Problem"]["id"] . "',";
                     }
                     $id = trim($id, ",");
                     $id = "(" . $id . ")";
                      
                    $data = $this->Problem->search_problem($id,$direction,$sort);
                    
                    $this->set("data",$data);
                }

                $person = $this->Person->query("
                    SELECT `Person`.`id`, `Person`.`group_id`, `Person`.`desc`, `Person`.`change_legal`, `Person`.`firstname`, `Person`.`lastname`, `Person`.`pasport_seria`, `Person`.`add_pasport_time`, `Person`.`email`, `Person`.`auth_user`, `Person`.`by_whom`, `Person`.`comment`, `Person`.`comment_team`, `Person`.`active`, `Person`.`con_person`, `Person`.`conperson_two`, `Person`.`conperson_tree`, `Person`.`modified`, `Person`.`created` 
                        FROM `realtimes`.`people` AS `Person` WHERE `Person`.`active` = 0 
                        AND (`Person`.`con_person` = '$user' or `Person`.`conperson_two` = '$user' or `Person`.`conperson_tree` = '$user')");
                 $id = "";
                if ($person) {
                        foreach ($person as $value) {
                            $id .= "'" . $value["Person"]["id"] . "',";
                        }
                        $id = trim($id, ",");
                        $id = "(" . $id . ")";
                        $people = $this->Problem->profile_list($id,$sort,$direction);

                        $mexanik = $this->Team->find("all", array("fields" => "username", "conditions" => array("Team.role" => "աշխ. ղեկավար")));

                        $this->set("people", $people);
                        $this->set("mexanik", $mexanik);
                 }
                 if(isset($_POST["exel"])){
                     $datas = array();
                     $datas["people"] = $people;
                     $datas["data"] = $data;
                    echo json_encode($datas);
                    die();
                }

    }
    public function modem_search() {
        if (isset($_POST["modem_ip"])) {
            $modem_ip = $_POST["modem_ip"];
            $id = "";
            $data_id = $this->Technical_data->find("all", array(
                "conditions" => array("Technical_data.modem" => $modem_ip),
                "fields" => array("Technical_data.data_id")));
            foreach ($data_id as $value) {
                if (!is_null($value["Technical_data"]["data_id"]))
                    $id .= "'" . $value["Technical_data"]["data_id"] . "',";
            }
            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $modem_gps = $this->Gps->gps_search($id);
            echo json_encode($modem_gps);
            die();
        }
        die();
    }

    public function maps() {

    }

    public function maps_2() {

    }

    public function show_message() {

    }

    public function message() {
        $thisdate = date("m-d H:i");
        $username_now = $this->Auth->user()["username"];
      
        if(isset($_POST["load"])){
           
            $this->new_sms->updateAll(array('new_sms.active' => null), array('new_sms.username_rec'=>$username_now));
        }
        if (isset($_POST["response"])) {

          $username_read = $_POST["response"];
          $filename = 'message/'.$username_read.'.json';
        
            if (file_exists($filename)) {
                 $curent = file_get_contents($filename);
                 
                 echo $curent;
                  unlink($filename);
            } else {
                echo 0;

            }
            die();
           //  $messages = $this->new_sms->find("all", array("conditions"
           //      => array(
           //          "new_sms.username_rec" => $username_read,
           //          "new_sms.active is null"
           //      ),
           //     'order' => array('new_sms.id DESC', 'new_sms.created DESC')
           //  ));
            
           //  foreach ($messages as $value) {
           //      $id = $value["new_sms"]["id"];
           //      $this->new_sms->updateAll(array('new_sms.active' => "1"), array('new_sms.id' => $id));
           //  }
           //  echo json_encode(array_reverse($messages));
           
        }

        if (isset($_POST["show_message"])) {

            $username_read = $_POST["show_message"];
            $messages = $this->sms->find("all", array("conditions"
                => array(
                    "sms.username_send='$username_read' AND sms.username_rec = '$username_now' OR "
                    . "sms.username_rec='$username_read' AND sms.username_send = '$username_now'"
                ),
                "order" => array("sms.id DESC,sms.created DESC"),
                'limit' => '30',
            ));
           echo json_encode(array_reverse($messages));
            $file = 'message/'.$username_now.'.json';
            $dir = 'message/'.$username_now.'.json';
            if(file_exists('message/'.$username_now.'.json')):
            $file = trim(file_get_contents($file));
            
            if($file != "null"):
                $file = json_decode($file,true);
                foreach ($file as $key => $value) {
                    unset($file[$key][$username_read]);
                }
                $curent = json_encode($file);
                if(strlen($curent)<20){
                     unlink($dir);die();
                }
                $curent = str_replace("[],","",$curent);
                $curent = str_replace("[]","",$curent);
                if($curent){
                $fp = fopen('message/'.$username_now.'.json', 'w');
                 fwrite($fp, $curent."\n");
                 fclose($fp);
                }else{

                }
              endif;
             endif;
            die();
          
        }
        $role = $this->role->find("all");
        $this->set("role", $role);
        if (isset($_POST["team"])) {

            $team = $this->Team->find("all", 
                    array("fields" => array("Team.firstname,Team.lastname,Team.username,Team.role,Team.image_name")));
            echo json_encode($team); 
            die();
        }
        $team = $this->Team->find("all", array(
            "conditions" => array("Team.chat=1"), 
            "fields" => array("Team.firstname,Team.lastname,Team.username,Team.role,Team.image_name")));
        $this->set("team", $team);

        if (isset($_POST["username"]) && isset($_POST["message"])) {
            $insert["username_rec"] = $_POST["username"];  
            $insert["username_send"] = $username_now;
            $insert["message"] = $_POST["message"];
        
            $this->new_sms->save($insert);
             $insert["created"] = $thisdate;
            $username_read = $_POST["username"];
            $nickname = htmlentities(strip_tags($_POST['username']));
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
            $message = htmlentities(strip_tags($_POST['message']));
           if(($message) != "\n"){
                 if(file_exists('message/'.$nickname.'.json')):
                        $file = 'message/'.$nickname.'.json';
                        $curent = file_get_contents($file);
                        $curent = str_replace("[","",$curent);
                        $curent = str_replace("]","",$curent);
                          $a[$username_now]= $insert;
                          $curent .=  ",".json_encode($a);
                          file_put_contents($file,"[".$curent."]\n");
                         else:
                            $a[$username_now] = $insert;
                            $fp = fopen('message/'.$nickname.'.json', 'w');
                            fwrite($fp, "[".json_encode($a)."]\n");
                            fclose($fp);
                    endif;
            }
           echo json_encode($a[$username_now]);
           die();
//            $messages = $this->new_sms->find("all", array("conditions"
//                => array(
//                    "new_sms.username_send" => (array($username_read, $username_now)),
//                    "new_sms.username_rec" => (array($username_read, $username_now)),
//                ),
//               'order' => array('new_sms.id DESC', 'new_sms.created DESC'), //string or array defining order
//                'limit' => '10'
//            ));
//     
//            
//            echo json_encode(array_reverse($messages));
            
            die();
        }
    }

    public function save_message() {

    }

    private function team() {

        $team = $this->Team->find("all");
        return $team;
        die();
    }

    public function softphone() {
        die();
    }

    public function menu() {
        $a = $this->Estate_user->find("all", array("fields" => array("Estate_user.client_id,Estate_user.id")));

        foreach ($a as $value) {
            $data_id = $value["Estate_user"]["client_id"];
            $ids = $value["Estate_user"]["id"];

            if ($data_id) {
                $id = $this->Technical_data->find("first", array("conditions" => array("Technical_data.data_id" => $data_id),
                    "fields" => array("Technical_data.id")));
            }
            $id = $id["Technical_data"]["id"];
            if ($id) {
                $this->Estate_user->updateAll(array('Estate_user.user_id' => "'$id'"), array('Estate_user.id' => $ids));
            }
        }
    }

    public function isAuthorized($user) {
        // Here is where we should verify the role and give access based on role

        return true;
    }

    public function adress_1() {
        if (isset($_POST["array"])) {
            $data = $_POST["array"];
            $name = array();

            foreach ($data as $key => $value) {
                array_push($name, $key);
            }

            $count = count($data) / 2;

            $username = $this->Technical_data->find("all", array("conditions" => array("Technical_data.username" => $name),
                "fields" => array("Technical_data.data_id,Technical_data.username"),
            ));

            $gps = array();
            $id = 52;
            // var_dump($username);
            var_dump($data);
            die();
            foreach ($username as $value) {
                $user = $value["Technical_data"]["username"];


//                if($id){
//                    $gps["id"] =  $id;
//
//                }
//                $gps["gps_id"] =  $value["Technical_data"]["data_id"];
//                $gps["gps"] =  $data["".$user.""][0]  . "," . $data["".$user.""][1];
//
                //$id = $this->Gps->addPost($gps);
                $id++;
            }

            // $this->Technical_data->find("all",array("conditions"=>array("Technical_data"=>$data[""])));
            die();
        }
    }

    //registration form and upload the database
    public function registration() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'search'));
            }
            $this->Session->setFlash(
                    __('The user could not be saved. Please, try again.')
            );
        }
    }

    public function add() {

    }

    public function sessia() {
        if (isset($_POST["start"])) {

            $time = date("Y-m-d H:i:s");
            if ($this->Auth->user()) {
                $online = $this->Online->find("first", array("conditions" => array("Online.username" => $this->Auth->user("username"))));

                if ($online) {
                    $user = array();
                    $user["id"] = $online["Online"]["id"];
                    $user["username"] = $this->Auth->user("username");
                    $user["time"] = strtotime($time);
                    $this->Online->save($user);
                    die();
                } else {
                    $user = array();
                    $user["username"] = $this->Auth->user("username");
                    $user["time"] = strtotime($time);
                    $user["online"] = 1;
                    $this->Online->save($user);
                    die();
                }
                //date
            }
            die();
        }
        if (isset($_POST["modified"])) {
            $last_date = date(strtotime(date("Y-m-d H:i:s") . '-20 second'));
            $online = $this->Online->find("first", array("conditions" => array('Online.time < ' => $last_date)));

            if ($online) {
                $this->Online->Delete($online["Online"]["id"]);
                die();
            } else {
                die();
            }
        }
    }

    public function change_house() {
        if (isset($_POST["username"]) && isset($_POST["change_user"]) && isset($_POST["product_name"]) && isset($_POST["spacies"]) && isset($_POST["quantity"])) {
            $username = $_POST["username"];
            $change_user = $_POST["change_user"];
            $id = trim($_POST["product_name"]);

            $spacies = trim($_POST["spacies"]);
            $user_id = trim($_POST["user_id"]);

            $quantity = $_POST["quantity"];

            if ($username && $change_user && $id && $spacies && $user_id && $quantity) {


                $query2 = $this->Estate_user->find("first", array("conditions" =>
                    array(
                        "Estate_user.user_id" => $user_id,
                        "Estate_user.species" => $spacies,
                        "Estate_user.id" => $id)));

                if ($query2 && $quantity <= $query2["Estate_user"]["quantity"]) {
                    $product_id = $query2["Estate_user"]['product_id'];
                    $count = $query2["Estate_user"]["quantity"] - $quantity;
                    $query1 = $this->written_item->find("first", array("conditions" =>
                        array("written_item.username" => $change_user,
                            "written_item.species" => $spacies,
                            "written_item.product_id" => $product_id)));

                    $id_estate = $query2["Estate_user"]["id"];
                    if ($query1) {
                        $count1 = $query1["written_item"]["quantity"] + $quantity;
                        $id_update = $query1["written_item"]["id"];
                        $a = $this->written_item->updateAll(array('written_item.quantity' => "'$count1'"), array('written_item.id' => $id_update));
                    } else {
                        $count1 = $quantity;
                        $insert = array();
                        $data = array();
                        $data["data"] = "pahestic trvel e $quantity hat  $spacies  $change_user in";
                        $data["username"] = $change_user;
                        $data["count"] = $quantity;
                        $data["species"] = $spacies;
                        $data["product_name"] = $product_id;

                        $logs_id = $this->written_log->add_logs($data);

                        $insert["written_item"]["username"] = $change_user;
                        $insert["written_item"]["quantity"] = $quantity;
                        $insert["written_item"]["product_id"] = $product_id;
                        $insert["written_item"]["species"] = $spacies;
                        $insert["written_item"]["logs_id"] = $logs_id;
                        $a = $this->written_item->add_logs($insert);
                        echo "1";
                    }
                    $a = $this->Estate_user->updateAll(array('Estate_user.quantity' => "'$count'"), array('Estate_user.id' => $id_estate));
                    echo 1;
                    die();
                } else {
                    die();
                }
            } else {
                die();
            }


            $count1 = $query1["written_item"]["quantity"] - $quantity;
            $id1 = $query1["written_item"]["id"];
            $product = $this->Product_name->find("first", array("conditions" => array("Product_name.id" => $product_id)));
        };
    }

    public function archive_problems() {
//            $problem =  $this->Problem->find("all",array("conditions"=>array("Problem.enable >" => 0 )));
//            $id = "";
//
//            foreach ($problem as $value) {
//                if($value["Problem"]["problem_id"]){
//                    $id .= "'" . $value["Problem"]["problem_id"] . "',";
//                   }
//            }
//            if($id){
//                $id = trim($id, ",");
//                $id = "(" . $id . ")";
//                var_dump($id);
//                $data = $this->Problem->archive_problem($id);
//                $this->set("problem", $data );
//             // var_dump($data);
//
//            }

        if (isset($_POST["page_count"])) {
            $count = $_POST["page_count"];
            $problem = $this->Problem->archive_problem($count);

            $json = json_encode($problem);
            echo $json;
            die();
        }
        $problem = $this->Problem->find("all", array("conditions" => array("Problem.enable > " => 0)));
        $i = 0;
        foreach ($problem as $value) {
            $i++;
        }
        $count = (int) ($i / 10);
        if ($count == 0) {
            $count = 0;
        }
        $count+=1;
        $this->set("page", $count);
    }

    public function userRoles() {
        if ($this->Authentication->isAdmin($this->Session->read("User.id"))) {
            //var_dump($this->Authentication->isSuperAdmin($this->Session->read("User.id"));
        } else {
            $this->redirect(array("Controller" => "realtimes", "action" => "search"));
        }
    }

    //xndirneri avelacnel@ databaza kapelov ogtatiroj bolor tvyalneri het
    public function problems() {
//        var_dump($_POST);
        if($this->Auth->user()["role"] == "1" && $_SERVER["REQUEST_URI"] == "/realtimes/problems" && !isset($_POST["search_con"])){
            $problem = $this->Problem->find("all", array("conditions" => array("Problem.enable" => -1)));

              $i = 0;
                foreach ($problem as $value) {
                    $i++;
                }
                $count = (int) ($i / 10);
                if ($count == 0) {
                    $count = 0;
                }
                $count+=1;
                $this->set("page", $count);
               
                $people = $this->Problem->no_activeted();
                $this->set("no_activeted", $people);
        }   
        $pos = strpos($_SERVER['REQUEST_URI'],'page:');
        if($pos):
            $i = substr($_SERVER['REQUEST_URI'], $pos+5);
        
            $this->set("j",(int)$i);
            else:
                $this->set("j",1); 
        endif;
        $a = $this->Auth->user()["role"];
        if($_SERVER['REQUEST_URI'] === "/realtimes/problems?active=1"){
            $this->set("url","1");
        }
        if($a == "1" || $a="Meneger"){
            $this->set("actived",1);
        }else{
            $this->set("actived",false);
        }
        
        $mexanik = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար")));
        $this->set("mexanik", $mexanik);
        if (isset($_POST["pro_person"]) && isset($_POST["id"])) {

            $data = array();
            $data["id"] = $_POST["id"];
            $problem = $this->Problem->find("first",array("conditions"=>array("Problem.id"=>$data["id"])));

            if(is_null($problem["Problem"]["pro_person"]) || $problem["Problem"]["pro_person"] == ""){
                $data["pro_person"] = $this->request->data["pro_person"];
                  $a = $this->Problem->save($data);
                  echo 1;
            }elseif(is_null($problem["Problem"]["pro_persontwo"]) || $problem["Problem"]["pro_persontwo"] == ""){
                $data["pro_persontwo"] = $this->request->data["pro_person"];
                  $a = $this->Problem->save($data);echo 1;
            }elseif(is_null($problem["Problem"]["pro_persontree"]) || $problem["Problem"]["pro_persontree"] == ""){
                $data["pro_persontree"] = $this->request->data["pro_person"];
                  $a = $this->Problem->save($data);echo 1;
            }else{
                    echo 0;
             }
            die();
        }
         if (isset($_POST["pro_person1"]) && isset($_POST["id1"])) {

            $data = array();
            $data["id"] = $_POST["id1"];
            $problem = $this->Problem->find("first",array("conditions"=>array("Problem.id"=>$data["id"])));

            if(is_null($problem["Problem"]["pro_person"]) || $problem["Problem"]["pro_person"] == ""){
                $data["pro_person"] = $this->request->data["pro_person1"];
                  $a = $this->Problem->save($data);
                 
            }elseif(is_null($problem["Problem"]["pro_persontwo"]) || $problem["Problem"]["pro_persontwo"] == ""){
                $data["pro_persontwo"] = $this->request->data["pro_person1"];
                  $a = $this->Problem->save($data);
            }elseif(is_null($problem["Problem"]["pro_persontree"]) || $problem["Problem"]["pro_persontree"] == ""){
                $data["pro_persontree"] = $this->request->data["pro_person11"];
                  $a = $this->Problem->save($data);
            }else{
                  
             }
           header('Location: http://newop.realtime.am/realtimes/problems ');
             
                exit;
        }
        $this->Problem->recursive = 0;

        $problem = $this->paginate('Problem',array("Problem.enable=0 and Problem.user_id != 'null'"));
        $this->set(compact('problem'));

        if (isset($this->request->data["Problem"])) {

            $user = $this->request->data["Problem"];
            $post["adress"] = $user["adress"];
            $post["telefons"] = $user["telefon"] . " " . $user["name"];
            $post["comment"] = $user["comment"];
            $post["user_id"] = '36912';
            $post["problem_id"] = '30904';
            $post["enable"] = 0;
            $post["reg_person"] = $this->Session->read("Auth.User.username");
            $a = $this->Problem->save($post);
            $this->redirect("problems");
            if (!$a) {
                $this->Session->setFlash('Ստուգեք Ճշտությունը');
            }
        }
        if(isset($_GET["limit"])){
            $limit = $_GET["limit"];
            $a= $this->Problem->data($limit);
            $this->set("problem",$a);

        }
        if (isset($_POST["search_con"])) {

            $result = $_POST["search_con"];
            $result = trim($result);
            if (strlen($result) < 3) {
                return $this->redirect(array(
                            'controller' => 'realtimes', 'action' => 'problems'));
                die();
            } elseif (preg_match("/^[a-zA-Z0-9-_]+$/", $result) == 1 && !is_numeric($result)) {
                $id = $this->login_search($result);
                if ($id) {
                    $people = $this->Problem->search_data($id);
                    
                  $this->set("problem", $people);
                   
                }

                
            } elseif (is_numeric($result)) {
                $id = $this->telephone($result);
                if ($id) {
                    $people = $this->Problem->search_data($id);
                }

                $this->set("problem", $people);
            } elseif (strlen($result) > 5) {
                $ids = "";
                $prob = $this->Problem->find('all', array(
                    'fields' => array('Problem.comment,Problem.problem_id'),
                    'conditions' => array(
                        'Problem.comment LIKE' => "%" . $result . "%"),));

                if ($prob) {
                    foreach ($prob as $value) {
                        if (!is_null($value["Problem"]["problem_id"]))
                            $ids .= "'" . $value["Problem"]["problem_id"] . "',";
                    }
                    $ids = trim($ids, ",");
                    $ids = "(" . $ids . ")";

                    $people = $this->Problem->search_data($ids);

                    $this->set("problem", $people);
                }
            }
        }
        
    }

    //if admin in logaut
    // in villages results on keyup the connectores page
    public function village() {
          
        if (isset($_POST['q']) && isset($_POST['city_val'])) {
        
            $t = $_POST['q'];
            $c = $_POST['city_val'];
            
            $values = array();
            $values["Village"] = $this->Village->find('all', array(
                'conditions' => array(
                    'Village.village_name LIKE' => '' . $t . '%',
                    'Village.region_name LIKE' => '' . $c . '%',
                ))
            );
            $json = json_encode($values["Village"]);
            echo $json;
            die();
        }
        die();
    }

    // in street results on keyup the connectores page
    public function street() {
        if (isset($_POST['q'])) {
            $t = $_POST['q'];
            $values = array();
            $values["Street"] = $this->Street->find('all', array(
                'conditions' => array(
                    'Street.street_name LIKE' => '%' . $t . '%',),
            ));
            $json = json_encode($values["Street"]);
            echo $json;
            die();
        }
    }

    //in adresses json fail
    public function adress() {
        if (isset($_POST['q'])) {
            $t = $_POST['q'];
            $values = array();
            $values["City"] = $this->Legal_person->find('all', array(
                'conditions' => array('OR' => array(
                        'Legal_person.company_name LIKE' => '%' . $t . '%',
                        'Legal_person.lastname LIKE' => '%' . $t . '%')),
            ));
            $json = json_encode($values["Legal_person"]);
            echo $json;
            die();
        }
    }

    //in users json fail
    public function user() {
        if (isset($_POST["q"])) {
            $t = $_POST["q"];
            $values = array();
            $values["Technical_data"] = $this->Technical_data->find('all', array(
                'fields' => array('Technical_data.username'),
                'conditions' => array(
                    'Technical_data.username' => $t),
            ));
            $json = json_encode($values["Technical_data"]);
            echo $json;
            die();
        } else {

        }
    }

    //telefon in json fail database
//    public function telefon() {
//        if (isset($_POST["q"])) {
//            $t = $_POST["q"];
//            $values = array();
//
//            $values["Telefon"] = $this->Telefon->find('all', array(
//                'conditions' => array(
//                    'Telefon.telefon LIKE' => '%' . $t . '%'),
//            ));
//            $json = json_encode($values["Telefon"]);
//            echo $json;
//            die();
//        } else {
//
//        }
//    }
    public function add_product() {

    }

    public function technical_results() {
        $values = array();
        $values["technical"] = $this->Technical_data->find('all');
        $values = $values["technical"];
        $this->set('values', $values);
    }

    public function ip_adress() {
        if (isset($_POST['q'])) {
            $t = $_POST['q'];
            $values = array();
            $values["Technical_data"] = $this->Technical_data->find('all', array(
                'conditions' => array('OR' => array(
                        'Technical_data.modem LIKE' => '%' . $t . '%',
                        'Technical_data.ip_range LIKE' => '%' . $t . '%')), "limit" => 10
            ));
            if ($values["Technical_data"]) {
                $json = json_encode($values["Technical_data"]);
                echo $json;
                die();
            } else {
                die();
            }
        }
    }

    // in people json fail databse
    public function searchresult() {
        if (isset($_POST['q'])) {
            $t = $_POST['q'];
            $values = array();
            $values["Person"] = $this->Person->find('all', array(
                'conditions' => array('Or' => array(
                        'Person.firstname LIKE' => '%' . $t . '%',
                        'Person.lastname LIKE' => '%' . $t . '%',
                    ), 'Person.active ' => 1), "limit" => 10,
            ));
            $json = json_encode($values["Person"]);
            echo $json;

            die();
        } else {

        }
        if (isset($_POST["login"])) {
            $login = $_POST["login"];

            $login = $this->Technical_data->find("all", array(
                "fields" => array("Technical_data.username,Technical_data.data_id"),
                'conditions' => array("Technical_data.username LIKE" => "%" . $login . "%",
                ),
                'limit' => 10,));
            echo json_encode($login);
            die();
        }
        if (isset($_POST["log_search"])) {
            $t = $_POST['log_search'];
            if (strpos($t, " ")) {



                $pos_pr = strpos($t, " ");
                $t = trim($t);
                $values = array();
                $search = array();
                $search["0"] = substr($t, 0, $pos_pr);
                $search["1"] = substr($t, $pos_pr + 1);

                $values["Person"] = $this->Person->find("all", array("conditions" =>
                    array("Person.lastname LIKE" => '%' . $search["1"] . '%', "Person.firstname LIKE" => '%' . $search["0"] . '%', 'Person.active ' => 1), 'limit' => 10,));
                $values["Person_r"] = $this->Person->find("all", array("conditions" =>
                    array("Person.lastname LIKE" => '%' . $search["0"] . '%', "Person.firstname LIKE" => '%' . $search["1"] . '%', 'Person.active ' => 1), 'limit' => 10,));

                if ($values["Person"]) {
                    $json = json_encode($values["Person"]);
                    echo $json;
                    die();
                } elseif ($values["Person_r"]) {

                    $json = json_encode($values["Person_r"]);
                    echo $json;
                    die();
                } else {
                    die();
                }

                die();
            } else {
                die();
            }
        }
        if (isset($_POST["lastname"])) {
            $t = $_POST["lastname"];
            $log = $this->Person->find('all', array(
                'conditions' => array('Person.lastname LIKE' => '%' . $t . '%'), 'limit' => 10,));
        }
    }
    
    public function clientpage() {
       
        
        if(isset($_POST["comment_team"]) && isset($_POST["person_id_team"])){
            $person_id = (int)$_POST["person_id_team"]; 
            $comment= $_POST["comment_team"];
            
            $a= $this->Person->updateAll(array("Person.comment_team"=>"'$comment'"),array("Person.id"=>$person_id));
            die();
        }
        if (isset($_POST["id"]) && isset($_POST["update_con"])) {
            $con = array();
            $data["con_person"] = $_POST["update_con"];
            $data["id"] = (int)$_POST["id"];
            $con = $this->Person->find("first",array("conditions"=>array("Person.id"=>$data["id"])));

            if(is_null($con["Person"]["con_person"]) || $con["Person"]["con_person"] === ""){

                $team = $_POST["update_con"];
                 $a= $this->Person->updateAll(array("Person.con_person"=>"'$team'"),array("Person.id"=>$data["id"] ));
                    if($a):echo "con_person"; endif; die();

            }elseif(is_null($con["Person"]["conperson_two"]) || $con["Person"]["conperson_two"] == ""){

                $team= $_POST["update_con"];
                 $a= $this->Person->updateAll(array("Person.conperson_two"=>"'$team'"),array("Person.id"=>$data["id"] ));
                    if($a):echo "conperson_two"; endif; die();

            }elseif(is_null($con["Person"]["conperson_tree"]) || $con["Person"]["conperson_tree"] == ""){

                    $team = $_POST["update_con"];

                    $a= $this->Person->updateAll(array("Person.conperson_tree"=>"'$team'"),array("Person.id"=>$data["id"] ));
                    if($a):echo "conperson_tree"; endif; die();
            }else{
                    echo 0;
            }
           die();
        }
        if (isset($_POST["edit_problem"])) {

            $id = $_POST["edit_problem"];

            $problem = $this->Problem->find("all", array("conditions" => array("Problem.id" => $id)));
            $json = json_encode($problem);
             echo $json;


            die();
        }
        if (isset($_POST["edit_problem_add"])  && isset($_POST["username"])) {
           $username = $_POST["username"];
          
            if($username == "1"):
                $id = $_POST["edit_problem_add"];
                $problem = array();
                $problem["comment"] = $id["0"];
                $problem["id"] = $id["1"];
                $this->Problem->save($problem);
            else:

                $id = $_POST["edit_problem_add"];
                $problem = array();
                $problem["comment_team"] = $id["0"];
                $problem["id"] = $id["1"];

                $this->Problem->save($problem);
            endif;
            die();
        }
        if (isset($_POST["technical"])) {
            $tech = $_POST["technical"];
            if ($tech["0"] && $tech["1"]) {
                $a = $this->Technical_data->find("all", array("conditions" => array("AND" => array("Technical_data.data_id" => $tech["0"], "Technical_data.id NOT" => $tech["1"]))));
                $json = json_encode($a);
                echo $json;
                die();
            }die();
        }
        if (isset($_POST["add_p"]) && isset($_POST["user"])) {
            $data = $_POST['add_p'];
            $user = (int)$_POST["user"];
          
            $insertproblem["problem_id"] = $data['1'];
            $insertproblem["comment"] = $data['0'];
            $insertproblem["user_id"] = (int)$user;
            $desc = $this->Problem->query("SELECT `desc` FROM villages where id=(SELECT village_id FROM adresses where adresses_id = (SELECT data_id FROM technical_data where id='$user' ))");
            $insertproblem["reg_person"] = $this->Session->read("Auth.User.username");
            $insertproblem["desc"] = $desc["0"]["villages"]["desc"];
            $insertproblem["enable"] = 0;
           
            $this->Problem->save($insertproblem);
            $values = $this->Problem->find("all", array(
                'conditions' => array("Problem_id" => $data['1']),
                'limit' => '5',
                'order' => array('Problem.created' => 'desc')
            ));
            echo json_encode($values);
        }
        if (isset($_POST["comment"])) {
            $data = $_POST['comment'];
            $comment["client_id"] = $data['1'];
            $comment["comment"] = $data['0'];
            $a = $this->Comment->save($comment);
            $values = $this->Comment->find("all", array(
                'conditions' => array("client_id" => $data['1']),
                'limit' => 5,
                'order' => array('Comment.created' => 'desc'),
            ));
            echo json_encode($values);
        }
        if (isset($_POST["comment_id"])) {
            $id = $_POST["comment_id"];
            $values = $this->Comment->find("all", array(
                'conditions' => array("client_id" => $id),
                'limit' => '5',
                'order' => array('Comment.created' => 'desc')
            ));
            echo json_encode($values);
        }
        if (isset($_POST["problem_id"])) {
            $id = $_POST['problem_id'];
            $values = $this->Problem->find("all", array(
                'conditions' => array("Problem.problem_id" => $id),
                'order' => array('Problem.created' => 'desc')
            ));
            echo json_encode($values);
        }
        if (isset($_POST["deletes"]) && isset($_POST["person"])) {
            $con = "";
            $id = (int) $_POST["deletes"];
            $person = $_POST["person"];

            $a = $this->Person->updateAll(array("Person.".$person."" => "null"), array('Person.id' => $id));
           var_dump($person,$id,$a);die();
            die();
        }
        if(isset($_POST["ok_problem"])){
            $id = $_POST["ok_problem"];
            $pro["id"] = $_POST["ok_problem"];
            $pro["enable"] = $_POST["ok_problem"];

            $a = $this->Problem->save($pro);
            echo $a;
            die();
        }
        if (isset($_POST["end_problem"]) && isset($_POST["data"])) {
            $pro = array();
            $data = $_POST["data"];
            $data = (int)$data;
            if ($data !== 0) {
                $pro["id"] = $_POST["end_problem"]["1"];
                $pro["pro_solution"] = $_POST["end_problem"]["0"];
                $pro["enable"] = $pro["id"];
                $a = $this->Problem->save($pro);
                echo $a;
            } else {
                $pro["id"] = $_POST["end_problem"]["1"];
                $pro["pro_solution"] = $_POST["end_problem"]["0"];
                $pro["pro_person"] = $_POST["end_problem"]["3"];
                $pro["enable"] = -1;
                $a = $this->Problem->save($pro);
                echo $a;
            }
        }
        if(isset($_POST["no_active"])){
            $id = $_POST["no_active"]["1"];
            $comment= $_POST["no_active"]["0"];
            $problem_logs = array();
            $problem = $this->Problem->find("first",
                                    array("conditions"=>array("Problem.id"=>$id)));
            $problem_logs["problem_id"] = $problem["Problem"]["id"];
            $problem_logs["comment"] = $problem["Problem"]["comment"];
            $problem_logs["pro_solution"] = $problem["Problem"]["pro_solution"];
            $problem_logs["pro_person"] = $problem["Problem"]["pro_person"];
            $problem_logs["reg_person"] = $problem["Problem"]["reg_person"];
            $a = $this->problem_log->save($problem_logs);
            $comment = $problem_logs["pro_solution"]. "//".$comment." //" .$this->Auth->user("username");
            if($a){
                 $b = $this->Problem->updateAll(array('Problem.comment_team' =>  "'$comment'",'Problem.enable' => 0,
                    'Problem.pro_person' => null), array('Problem.id' => $id));
                 echo 1;
            }else{
                echo 0;
            }
        }
        if (isset($_POST["delete_pro"]) && isset($_POST["data"])) {
            $team = $_POST["data"];
            $pros = array();
            $pros["id"] = $_POST["delete_pro"];
             
            $problem = $this->Problem->find("first",array("conditions"=>array("Problem.id"=>$pros["id"]),"fields"=>array("Problem.pro_person,Problem.pro_persontwo,Problem.pro_persontree")));
            
            if($team == $problem["Problem"]["pro_person"]){
                 $pros["pro_person"] = null;
            }elseif ($team == $problem["Problem"]["pro_persontwo"]) {
                  $pros["pro_persontwo"] = null;
            }elseif($team == $problem["Problem"]["pro_persontree"]){
                    $pros["pro_persontree"] = null;
            }

            $a = $this->Problem->save($pros);
           
        }
        die();
    }

    public function edit_profile() {
        if (isset($_POST["profile"])) {
            $id = $_POST["profile"];
            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $a = $this->Person->getPostsFilesActive($id);
            $json = json_encode($a);
            echo $json;
            die();
        }
        if (isset($_POST["edit_tech"])) {
            $id = $_POST["edit_tech"];

            $json["tech"] = $this->Technical_data->find("first", array("conditions" => array("Technical_data.id" => $id)));
            $json["service_name"] = $this->Service_name->find("all");

            $json = json_encode($json);
            echo $json;
            die();
        }
        if (isset($_POST["update_tech"])) {
            $update = $_POST["update_tech"];
            //0- user 1- pass 2-con_type 3-ap 4-vlan 5-modem 6-station 7-id
            $username = $update["0"];
            $password = $update["1"];
            $con_type = $update["2"];
            $ap = $update["3"];
            $modem = $update["5"];
            $station = $update["6"];
            $vlan = $update["4"];
            $service_id = (int) $update["8"];

            $stat = $this->Station->find("first", array("conditions" => array("Station.station_name" => $station), "fields" => array("Station.id")));
            if ($stat) {
                $station_id = $stat["Station"]["id"];
                $a = $this->Technical_data->updateAll(array('Technical_data.station' => "'$station'",
                    'Technical_data.username' => "'$username'",
                    'Technical_data.station_id' => "'$station_id'",
                    'Technical_data.password' => "'$password'",
                    'Technical_data.con_type' => "'$con_type'",
                    'Technical_data.modem' => "'$modem'",
                    'Technical_data.service_id' => "'$service_id'",
                    'Technical_data.vlan' => "'$vlan'",
                    'Technical_data.station' => "'$station'",), array('Technical_data.id' => $update["7"]));
            } else {
                $a = $this->Technical_data->updateAll(array('Technical_data.station' => "'$station'",
                    'Technical_data.username' => "'$username'",
                    'Technical_data.password' => "'$password'",
                    'Technical_data.con_type' => "'$con_type'",
                    'Technical_data.modem' => "'$modem'",
                    'Technical_data.service_id' => "'$service_id'",
                    'Technical_data.vlan' => "'$vlan'",
                    'Technical_data.station' => "'$station'",), array('Technical_data.id' => $update["7"]));
            }
            die();
        }
    }

    public function add_sess() {
        if (isset($_POST["end"])) {
            $a["id"] = $_POST["end"];
            $this->Session->write($a);
            if ($true) {
                echo 1;
            } else {
                echo 0;
            }
            //$c = $this->Session->delete("id");
            die();
        }
        if (isset($_POST["edit"])) {
            $a["id_e"] = $_POST["edit"];
            $this->Session->write($a);
            if ($true) {
                echo 1;
            } else {
                echo 0;
            }
            //$c = $this->Session->delete("id");
            die();
        }
        if (isset($_POST["new_user"])) {
            $a["new_user"] = $_POST["new_user"];
            $true = $this->Session->write($a);
            if ($true) {
                echo 1;
            } else {
                echo 0;
            }
            //$c = $this->Session->delete("id");
            die();
        }

        die();
    }

    public function estate() {
        if (isset($_POST["username_id"])) {
            $estate = $_POST["username_id"];

            $a["estate"] = $this->Estate_user->find("all", array("conditions" => array("Estate_user.user_id" => $estate)));
            $a["team"] = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար"), "fields" => array("Team.username", "Team.firstname", "Team.lastname")));

            if ($a) {
                $json = json_encode($a);
                echo $json;
                die();
            }die();
        }
        if (isset($_POST["team"])) {

            $team = $_POST["team"];
            $a = $this->written_item->search_product($team);

            if ($a) {
                $json = json_encode($a);
                echo $json;
                die();
            }die();
        }
        if (isset($_POST["prod_all"]) && isset($_POST["add_id"]) && isset($_POST["team_user"])) {

            $user_id = $_POST["add_id"];
            $username = $_POST["team_user"];
            $array = array();
            $array = $_POST["prod_all"];
            $estate_save = array();
            $team_save = array();

            foreach ($array as $value) {
                if ($value) {

                    $pos_name = strpos($value, "/");
                    $pos_space = strpos($value, ":");
                    $pos_count = strpos($value, ";");
                    $teamprod_id = strpos($value, "|");
                    $length = strlen($value);
                    $name_id = substr($value, 0, $pos_name);
                    $product_str = substr($value, 0, $pos_count);


                    $name2_str = substr($value, $pos_name + 1, -($length - $pos_space));
                    $count_str = substr($value, $pos_space + 1, -($length - $pos_count));
                    $count_now = (int) substr($value, $pos_count + 1, -($length - $teamprod_id));
                    $team_id = substr($value, $teamprod_id + 1);

                    $team_save["id"] = (int) $team_id;
                    $team_save["quantity"] = $count_now;

                    $this->written_item->save($team_save);

                    $estate_save['product_id'] = (int) $name_id;
                    $estate_save['user_id'] = (int) $user_id;
                    $estate_save['team_user'] = trim($username);
                    $estate_save['species'] = trim($name2_str);
                    $estate_save['quantity'] = (double) $count_str;
                    $estate_save['auth_user'] = $this->Session->read("Auth.User.username");
                    ;
                    $f = $this->Estate_user->addPost($estate_save);
                    var_dump($f);
                    $f++;
                    var_dump($f++);
                    $estate_save['id'] = $f++;
                    var_dump($estate_save['id']);
                }
            }
            die();
        } else {
            die();
        }
    }

    public function warehouse() {
        if (isset($_POST["con_p"])) {
            $con_p = $_POST["con_p"];
            var_dump($con_p);
            die();
            $username_con = $id;
        }
    }

    public function bookkeeper() {
        if (isset($_POST["value"]) && isset($_POST["pay_id"])){
            $value = $_POST["value"];
            $pay_id = $_POST["pay_id"];

            $a = $this->Payment->updateAll(array("Payment.pers_pay" => $value), array('Payment.id' => $pay_id));
              $payment["payment"]= $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$pay_id)));
               $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
             echo json_encode($payment);
            die();
        }
        if (isset($_POST["disable"]) && isset($_POST["pay_id"])){
            $value = null;
            $pay_id = $_POST["pay_id"];
            $this->Payment->updateAll(array("Payment.pers_pay" => $value), array('Payment.id' => $pay_id));
            $payment= $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$pay_id)));
            $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
             echo json_encode($payment);
        }
        if(isset($_POST["no_credit"]) && isset($_POST["nocredit_id"])){
            $no_credit = $_POST["no_credit"];
            $nocredit_id = $_POST["nocredit_id"];
            $a = $this->Payment->updateAll(array("Payment.no_credit" => $no_credit), array('Payment.id' => $nocredit_id));
            $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$nocredit_id)));
            $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
            die();
        }
        if (isset($_POST["day_count"]) && isset($_POST["id_payment"]) && isset($_POST["date"])) {
            $day = (int)$_POST["day_count"];
            $id = $_POST["id_payment"];
            $payday = $_POST["date"];
            if($day >= 0):
                $payday = date("Y-m-d H:i:s", strtotime($payday . "+ $day day"));
            else:
                $payday = date("Y-m-d H:i:s", strtotime($payday . " $day day"));
            endif;
            $pay = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
            $data["data"] = "Ավելացվեց $day օր";
                    $log_id = $this->Transaction_log->addPost($data);
                    $tran = array();

                    $tran["paying_user"] = $this->Auth->user()["username"];
                    $tran["logs_id"] = $log_id;
                    $tran["client_id"] = $pay["Payment"]["data_id"];
                    $this->Transaction->addPost($tran);

            $this->Payment->updateAll(array("Payment.payday" => "'$payday'","Payment.credit_date" => "'$payday'"), array('Payment.id' => $id));
              $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
                  $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
                  echo json_encode($payment);
            die();
        }
        if (isset($_POST["day_count_credit"]) && isset($_POST["id"]) && isset($_POST["date"])) {

            $day = (int)$_POST["day_count_credit"];
            date_default_timezone_set('Etc/GMT-4');
            $id = (int)$_POST["id"];
            $payday =  date("Y-m-d H:i:s", strtotime($_POST["date"]));

            $thisdate = date("Y-m-d H:i:s");
            $payday = date("Y-m-d H:i:s", strtotime($payday . "+ $day day"));

            $payday_dis = date("Y-m-d H:i:s", strtotime($thisdate . "+ $day day"));

            $person_payment = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));

            $datetime2 = new DateTime($person_payment["Payment"]["credit_date"]);
            $datetime1 = new DateTime();

            $interval = $datetime2->diff($datetime1);
            $interval = (int)$interval->format('%R%a');

            if($person_payment["Payment"]["category"] == 2){


                $data["data"] = "Կրեդիտ $day օր Ակտիվ էր ";
                $log_id = $this->Transaction_log->addPost($data);
                $tran = array();

                $tran["paying_user"] = $this->Auth->user()["username"];
                $tran["logs_id"] = $log_id;
                $tran["client_id"] = $person_payment["Payment"]["data_id"];

                $this->Transaction->addPost($tran);
                //vrdit date tal himikva date,heto angateluc hashvi qani ora ancel ogtagorceluc u partqi vra qci heto ete ches
                $a=$this->Payment->updateAll(
                        array(
                                "Payment.credit_date" => "'$thisdate'",
                                "Payment.counter_credit" =>"Payment.counter_credit+'$interval'",
                                "Payment.payday" => "'$payday_dis'",
                                "Payment.credit" => "Payment.credit+'$day'"),
                        array('Payment.id' => $id));


            }elseif($person_payment["Payment"]["category"] == 0){

                $data["data"] = "Կրեդիտ $day օր Անջատվածից էր";
                $log_id = $this->Transaction_log->addPost($data);
                $tran = array();

                $tran["paying_user"] = $this->Auth->user()["username"];
                $tran["logs_id"] = $log_id;
                $tran["client_id"] = $person_payment["Payment"]["data_id"];

                $a =  $this->Transaction->addPost($tran);

                $a=$this->Payment->updateAll(array("Payment.category" => 2,
                    "Payment.payday" => "'$payday_dis'","Payment.credit" => "'$day'","Payment.credit_date" => "'$thisdate'"),
                        array('Payment.id' => $id));

            }
            $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
                  $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
                  echo json_encode($payment);
            die();
        }
        if(isset($_POST["continue"])){
            $id = $_POST["continue"];

           $this->Payment->updateAll(array('Payment.category' => 2), array('Payment.data_id' => $id));
           $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.data_id"=>$id)));
                  $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
                    $datetime2 = new DateTime($payment["payment"]["Payment"]["payday_now"]);
                    $datetime1 = new DateTime();

                    $interval = $datetime2->diff($datetime1);
                    $interval = $interval->format('%R%a');
                    $interval = (int)$interval;
                    $data["data"] = "Կարգավիճակը փոխվեց Ակտիվ,$interval օր կասեցվածից հետո";
                    $log_id = $this->Transaction_log->addPost($data);
                    $tran = array();

                    $tran["paying_user"] = $this->Auth->user()["username"];
                    $tran["logs_id"] = $log_id;
                    $tran["client_id"] = $id;
                    $this->Transaction->addPost($tran);
                    echo json_encode($payment);
                 die();
              die();
        }
        if (isset($_POST["category"]) && isset($_POST["id_payment"]) && isset($_POST["price"])) {

            $thisdate = date("Y-m-d H:i:s");
            $category = (int)$_POST["category"];
            $id = (int)$_POST["id_payment"];
            $price = (int)$_POST["price"];
            if ($category == 1) {
                $category = 1;
                $this->Payment->updateAll(array('Payment.category' => $category,"Payment.payday_now"=>"'$thisdate'"), array('Payment.id' => $id));
               $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
                  $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
                  echo json_encode($payment);

                 die();
            } elseif($category == 0) {

                $person_data = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
                $credit_date = $person_data["Payment"]["credit_date"];
                $category = 0;
                $datetime2 = new DateTime($credit_date);
                $datetime1 = new DateTime();

                $interval = $datetime2->diff($datetime1);
                $interval = $interval->format('%R%a');

                  if($interval >= 0 && $person_data["Payment"]["category"] != 0){

                    $data["data"] = "Կարգավիճակը փոխվեց Անջատված";
                    $log_id = $this->Transaction_log->addPost($data);
                    $tran = array();

                    $tran["paying_user"] = $this->Auth->user()["username"];
                    $tran["logs_id"] = $log_id;
                    $tran["client_id"] = $person_data["Payment"]["data_id"];
                    $this->Transaction->addPost($tran);

                    $a = $this->Payment->updateAll(array(
                        'Payment.category' => $category,
                        "Payment.counter_credit" => "Payment.counter_credit+'$interval'",
                               "Payment.credit" => 0), array('Payment.id' => $id));


                  }else{

                    $data["data"] = "Կարգավիճակը փոխվեց Անջատված";
                    $log_id = $this->Transaction_log->addPost($data);
                    $tran = array();

                    $tran["paying_user"] = $this->Auth->user()["username"];
                    $tran["logs_id"] = $log_id;
                    $tran["client_id"] = $person_data["Payment"]["data_id"];
                    $this->Transaction->addPost($tran);

                    $a = $this->Payment->updateAll(array(
                        'Payment.category' => $category,
                        "Payment.counter_credit" => "Payment.counter_credit+'$interval'",
                               "Payment.credit" => 0), array('Payment.id' => $id));


                  }
              }elseif($category ==4){
                      $person_data = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
                $credit_date = $person_data["Payment"]["credit_date"];
                $category = 4;
                $datetime2 = new DateTime($credit_date);
                $datetime1 = new DateTime();

                $interval = $datetime2->diff($datetime1);
                $interval = $interval->format('%R%a');

                  if($interval >= 0 && $person_data["Payment"]["category"] != 0){

                    $data["data"] = "Կարգավիճակը փոխվեց Հրաժարված";
                    $log_id = $this->Transaction_log->addPost($data);
                    $tran = array();

                    $tran["paying_user"] = $this->Auth->user()["username"];
                    $tran["logs_id"] = $log_id;
                     $tran["balance_change"] = (int)-$price;
                    $tran["client_id"] = $person_data["Payment"]["data_id"];
                    $this->Transaction->addPost($tran);

                    $a = $this->Payment->updateAll(array(
                        'Payment.category' => $category,
                        'Payment.balance' => 0,
                        "Payment.counter_credit" => 0,
                         "Payment.credit" => 0), array('Payment.id' => $id));


                  }else{

                   $data["data"] = "Հրաժարվեց վերադարցրինք $price դրամ";
                    $log_id = $this->Transaction_log->addPost($data);
                    $tran = array();

                    $tran["paying_user"] = $this->Auth->user()["username"];
                    $tran["logs_id"] = $log_id;
                    $tran["balance_change"] = (int)-$price;
                    $tran["client_id"] = $person_data["Payment"]["data_id"];
                    $this->Transaction->addPost($tran);

                    $a = $this->Payment->updateAll(array(
                        'Payment.category' => $category,
                        'Payment.balance' => 0,
                        "Payment.counter_credit" => 0,
                        "Payment.credit" => 0), array('Payment.id' => $id));


                  }
              }
                $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.id"=>$id)));
                  $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
                  echo json_encode($payment);

                 die();


        }
  //payent bi id and price
        if (isset($_POST["id"]) && isset($_POST["type"])) {

            $type = $_POST["type"];
            $id = (int)$_POST["id"]["1"];

            if ($id) {

                $person = $this->Payment->find("first", array("conditions" => array("Payment.data_id" => $id)));

                $tech = $this->Technical_data->find("first", array("conditions" => array("Technical_data.id" => $id)));

                if($person["Payment"]["pers_pay"]):
                    $service_id = (int)$tech["Technical_data"]["service_id"];
                    $tarif_price = (int)$person["Payment"]["pers_pay"];
                else:
                    $service_id = (int)$tech["Technical_data"]["service_id"];

                    $tariff = $this->Service_name->find("first",
                            array("conditions" => array("Service_name.id" => $service_id)));
                    $tarif_price = (int)$tariff["Service_name"]["price"]; //E
                endif;




                $payday = $person["Payment"]["payday"]; //A
                $balance = (int)$person["Payment"]["balance"]; //B
                $category = (int)$person["Payment"]["category"]; //C
                $balance_change = (int)$_POST["id"]["0"]; //D
                $credit_date = $person["Payment"]["credit_date"]; //F

                $credit = (int)$person["Payment"]["credit"]; //G
                $counter_credit = (int)$person["Payment"]["counter_credit"];
                date_default_timezone_set('Etc/GMT-4');
                $thisdate = date("Y-m-d H:i:s");

                ////K
                // croni mej grel functia vor anjateluc credit counter@ sarqi crediti chapov
                // anjateluc credit_Counter@ darnuma hashvarkvac oreri qanakov
                // credit avelacneluc uxaki crediti orer@ avelacnel popoxakan orov category -n sarqel aktive payday@ sarqel crediti tvac orerov
                // cankacac jamanak vcharum katareluc helnuma partqi qanakov orer@

                if ($category == 2 && $credit == 0) {

                    if ($balance_change == $tarif_price) {
                        $payday = date("Y-m-d H:i:s", strtotime($payday . "+ 1 month - $counter_credit day"));
                        $credit = 0;
                        $counter_credit = 0;
                        $credit_date = $payday;
                    }elseif ($balance_change > $tarif_price) {
                        if ($balance + $balance_change % $tarif_price >= $tarif_price) {

                            $month = intval($balance_change / $tarif_price) + intval(($balance + $balance_change % $tarif_price) / $tarif_price);
                            $payday = $payday = date("Y-m-d H:i:s", strtotime($payday . "+ $month month - $counter_credit day"));
                            $balance = ($balance + $balance_change % $tarif_price) % $tarif_price;
                            $credit = 0;
                            $counter_credit = 0;
                            $credit_date = $payday;
                        } elseif ($balance + $balance_change % $tarif_price < $tarif_price) {

                            $month = intval($balance_change / $tarif_price);
                            $payday = $payday = date("Y-m-d H:i:s", strtotime($payday . "+ $month month - $counter_credit day"));
                            $balance = $balance + $balance_change % $tarif_price;
                            $credit = 0;
                            $counter_credit = 0;
                             $credit_date = $payday;
                        }
                    }elseif ($balance_change < $tarif_price) {
                        if (($balance + $balance_change) >= $tarif_price) {

                            $month = intval(($balance + $balance_change) / $tarif_price);
                            $payday = $payday = date("Y-m-d H:i:s", strtotime($payday . "+ $month month - $counter_credit day"));
                            $balance = ($balance + $balance_change) % $tarif_price;
                             $counter_credit = 0;
                             $credit_date = $payday;
                        } elseif (($balance + $balance_change) < $tarif_price) {
                            $balance = $balance + $balance_change;
                        }
                    }
                } elseif ($category == 2 && $credit > 0) {

                    $datetime2 = new DateTime($credit_date);
                    $datetime1 = new DateTime();
                    $interval = $datetime2->diff($datetime1);
                    $interval = intval($interval->format('%R%a'));

                    $credit = (int)$credit;

                    if ($interval < $credit) {

                        $interval = intval($interval);
                        $change_day = intval($interval + $counter_credit);

                        if ($balance_change == $tarif_price) {

                            $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ 1 month - $change_day day"));
                            $credit = 0;
                            $counter_credit = 0;
                            $credit_date = $payday;
                        }
                        if ($balance_change > $tarif_price) {
                            if ($balance + $balance_change % $tarif_price >= $tarif_price) {

                                $month = intval($balance_change / $tarif_price) + intval(($balance + $balance_change % $tarif_price) / $tarif_price);
                                $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month - $change_day day"));
                                $balance = ($balance + $balance_change % $tarif_price) % $tarif_price;
                                $credit = 0;
                                $counter_credit = 0;
                                $credit_date = $payday;
                            } elseif ($balance + $balance_change % $tarif_price < $tarif_price) {

                                $month = intval($balance_change / $tarif_price);
                                $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month - $change_day day"));
                                $balance = $balance + $balance_change % $tarif_price;
                                $credit = 0;
                                $counter_credit = 0;
                                $credit_date = $payday;
                            }
                        }
                        if ($balance_change < $tarif_price) {

                            if (($balance + $balance_change) >= $tarif_price) {

                                $month = intval(($balance + $balance_change) / $tarif_price);
                                $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month -$change_day day"));
                                $balance = ($balance + $balance_change) % $tarif_price;
                                $credit = 0;
                                $counter_credit = 0;
                                $credit_date = $payday;
                            } elseif (($balance + $balance_change) < $tarif_price) {
                                $balance = $balance + $balance_change;
                            }
                        }


                    } elseif ($interval >= $credit) {

                        $counter_credit = (int)$counter_credit;
                        $change_day = intval($credit + $counter_credit);

                        if ($balance_change == $tarif_price) {
                            $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ 1 month - $change_day day"));
                            $credit = 0;
                            $counter_credit = 0;
                            $counter_credit = (int)$counter_credit;
                            $credit_date = $payday;
                        }elseif ($balance_change > $tarif_price) {

                            if ($balance + $balance_change % $tarif_price >= $tarif_price) {

                                $month = intval($balance_change / $tarif_price) + intval(($balance + $balance_change % $tarif_price) / $tarif_price);

                                $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month - $change_day day"));

                                $balance = ($balance + $balance_change % $tarif_price) % $tarif_price;
                                $credit = 0;
                                $counter_credit = 0;
                                $credit_date = $payday;
                            } elseif ($balance + $balance_change % $tarif_price < $tarif_price) {
                                $change_day = $credit-$counter_credit;
                                $month = intval($balance_change / $tarif_price);
                                $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month -$change_day day"));
                                $balance = $balance + $balance_change % $tarif_price;
                                $credit = 0;
                                $credit_date = $payday;
                                $counter_credit = 0;
                            }
                        }elseif ($balance_change < $tarif_price) {

                            if (($balance + $balance_change) >= $tarif_price) {

                                $month = intval(($balance + $balance_change) / $tarif_price);
                                $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month -$change_day day"));
                                $balance = ($balance + $balance_change) % $tarif_price;
                                $credit = 0;
                                $counter_credit = 0;
                                $credit_date = $payday;
                            } elseif (($balance + $balance_change) < $tarif_price) {
                                $balance = $balance + $balance_change;
                            }
                        }
                    }
                } elseif ($category == 0 || $category == 4) {
                     $category == 0;
                    if ($balance_change == $tarif_price) {
                        $counter_credit = (int)$counter_credit;
                       if($counter_credit >= 0):
                        $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ 1 month - $counter_credit day"));
                      else:
                        $payday = date("Y-m-d H:i:s", strtotime($payday . "+ 1 month"));
                      endif;
                        if($payday<$thisdate):
                            $datetime2 = new DateTime($payday);
                            $datetime1 = new DateTime();
                            $interval1 = $datetime2->diff($datetime1);
                            $interval1 = (int)$interval1->format('%R%a');
                            $category = 0;
                            $credit=0;
                            $counter_credit = 0;
                            $credit_date = $payday;
                        else:
                            $category = 2;
                            $credit=0;
                            $credit_date = $payday;
                            $counter_credit=0;
                        endif;

                    }
                    if ($balance_change > $tarif_price) {

                        if ($balance + $balance_change % $tarif_price >= $tarif_price) {

                            $month = intval($balance_change / $tarif_price) + intval(($balance + $balance_change % $tarif_price) / $tarif_price);
                            $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month - $counter_credit day"));

                            $balance = ($balance + $balance_change % $tarif_price) % $tarif_price;
                            if($payday<$thisdate):
                               $datetime2 = new DateTime($payday);
                               $datetime1 = new DateTime();
                               $interval1 = $datetime2->diff($datetime1);
                               $interval1 = (int)$interval1->format('%R%a');
                               $category = 0;
                               $credit=0;
                               $counter_credit = $interval1;
                               $credit_date = $payday;
                           else:
                               $category = 2;
                               $credit=0;
                               $counter_credit = $thisdate;
                               $counter_credit=0;
                           endif;
                        } elseif ($balance + $balance_change % $tarif_price < $tarif_price) {
                            $balance = $balance + $balance_change % $tarif_price;
                            $month = intval($balance_change / $tarif_price);
                            $payday = $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month - $counter_credit day"));
                            if($payday<$thisdate):
                                $datetime2 = new DateTime($payday);
                                $datetime1 = new DateTime();
                                $interval1 = $datetime2->diff($datetime1);
                                $interval1 = (int)$interval1->format('%R%a');
                                $category = 0;
                                $credit=0;
                                $counter_credit = $interval1;
                                $credit_date = $payday;
                            else:
                                $category = 2;
                                $credit=0;
                               $credit_date = $payday;
                                $counter_credit=0;
                            endif;
                        }
                    }
                    if ($balance_change < $tarif_price) {

                        if (($balance + $balance_change) >= $tarif_price) {
                            $month = intval(($balance + $balance_change) / $tarif_price);
                            $payday = date("Y-m-d H:i:s", strtotime($thisdate . "+ $month month - $counter_credit day"));
                            $balance = ($balance + $balance_change) % $tarif_price;
                            if($payday<$thisdate):
                                $datetime2 = new DateTime($payday);
                                $datetime1 = new DateTime();
                                $interval1 = $datetime2->diff($datetime1);
                                $interval1 = (int)$interval1->format('%R%a');
                                $category = 0;
                                $credit=0;
                                $counter_credit = $interval1;
                                $credit_date = $payday;
                            else:
                                $category = 2;
                                $credit=0;
                                $credit_date = $payday;
                                $counter_credit=0;
                            endif;
                        } elseif (($balance + $balance_change) < $tarif_price) {
                            $balance = $balance + $balance_change;
                        }

                    }
                }

                $user = $this->Session->read("Auth.User.username");

                $this->Payment->updateAll(array(
                    "Payment.counter_credit" => "'$counter_credit'",
                    "Payment.balance" => "'$balance'",
                    "Payment.credit_date" => "'$credit_date'",
                    "Payment.category" => "'$category'",
                    "Payment.credit" => "'$credit'",
                    "Payment.payday" => "'$payday'"), array('Payment.data_id' => $id));
                $data["data"] = "վճարվեց " . $balance_change . " դրամ $type";
                $log_id = $this->Transaction_log->addPost($data);
                $tran = array();
                $tran["balance_change"] = $balance_change;
                $tran["paying_user"] = $user;
                $tran["logs_id"] = $log_id;
                if($service_id):
                    $tran["service_id"] = $service_id;
                endif;
                $tran["type"] = $type;
                $tran["client_id"] = $id;
                $this->Transaction->addPost($tran);
                  $payment["payment"] = $this->Payment->find("first",array("conditions"=>array("Payment.data_id"=>$id)));
                  $payment["def_credit"] = $this->credit->find("first",array("conditions"=>array("credit.id"=>1)));
                  echo json_encode($payment);
                die();
            }
            die();
        }

        die();
    }

    public function edit_payment() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];

            $client_p = $this->Transaction->find("all", array(
                "joins"=>array(array(
                    "table"=>"transaction_logs",
                    "alias"=>"log",
                    "type"=>"left",
                    "conditions"=>array("log.id = Transaction.logs_id")
                  )),
                "conditions" => array("Transaction.client_id" => $id),
                "fields"=>array("Transaction.balance_change,Transaction.logs_id,"
                            . "Transaction.id,Transaction.paying_user,Transaction.created,"
                            . "Transaction.client_id,Transaction.type,log.data"),
                'order' => array('Transaction.created' => 'desc'),
                "limit 10"));

            echo json_encode($client_p);
            die();

        }
        die();
    }

    public function technical_data() {
        if (isset($_POST["l"])) {
            $product = $_POST["l"];
            $insert = array();
            $insert_log = array();
            $team_user = $product["4"];
            $species = $product["2"];
            $prod_id = $product["1"];
            $client_id = $product["3"];
            $quantity = $product["0"]; //qanak@
            $insert["client_id"] = $client_id;
            $insert["team_user"] = $team_user;
            $insert["product_id"] = $prod_id;
            $insert["species"] = $species;
            $insert["quantity"] = $quantity;
            $species = trim($species);
            $team_user = trim($team_user);
            $prod_id = trim($prod_id);

            $minus = $this->written_item->find("first", array("conditions" => array(
                    "written_item.username" => $team_user,
                    "written_item.product_id" => $prod_id,
                    "written_item.species" => $species,
            )));

            if ($minus && $minus["written_item"]["quantity"] >= $quantity) {

                $true = $this->Estate_user->find("first", array("conditions" => array(
                        "Estate_user.product_id" => $prod_id, "Estate_user.species" => $species, "Estate_user.client_id" => $client_id, "Estate_user.team_user" => $team_user)));
                $q = $minus["written_item"]["quantity"] - $quantity;
                $insert_log["id"] = $minus["written_item"]["id"];
                $insert_log["username"] = $minus["written_item"]["username"];
                $insert_log["quantity"] = $q;
                $k = $this->written_item->save($insert_log);

                if ($true) {
                    $insert["id"] = $true["Estate_user"]["id"];
                    $insert["quantity"] = $true["Estate_user"]["quantity"] + $quantity;
                    $this->Estate_user->save($insert);
                    echo "yes";
                    die();
                } else {
                    $this->Estate_user->save($insert);
                    echo "yes";
                    die();
                }
            } else {
                echo  'ստուգեք ճշտությունը';
                die();
            }
        }
        $service_name = array();
        $data = array();
        $data_id = $this->Session->read("new_user");
        $city = $this->Adress->find("first", array(
            "fields" => array("Adress.city"),
            "conditions" => array("Adress.adresses_id" => $data_id)));
        $station = $this->Station->find("all", array("conditions" => array("Station.station_region" => $city["Adress"]["city"])));
        if ($station) {
            $this->set("station", $station);
        }
        if ($data_id) {
            $city = $this->Adress->find("first", array("conditions" => array("Adress.adresses_id" => $data_id)));
            $city = $city["Adress"]["city"];
        }
        $service_name["service_name"] = $this->Service_name->find("all");
        if ($service_name["service_name"]) {
            $this->set("service_name", $service_name["service_name"]);
        }
        $datas = $data;
        if (isset($this->request->data['Person'])) {
            $insertpost = array();
            $technical_data = array();
            $data = $this->request->data['Person'];
            if ($city == "Արմավիր") {
                $x = "10.20.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.20.0.0/29";
                    $p = "10200000";
                }
            }
            if ($city == "Արարատ") {
                $x = "10.21.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.21.0.0/29";
                    $p = "10210000";
                }
            }
             if ($city == "Վայոց Ձոր") {
                $x = "10.22.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.22.0.0/29";
                    $p = "10220000";
                }
            }
              if ($city == "Սյունիք") {
                $x = "10.23.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.23.0.0/29";
                    $p = "10230000";
                }
            }
             if ($city == "Կոտայք") {
                $x = "10.24.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.24.0.0/29";
                    $p = "10240000";
                }
            }
              if ($city == "Արագածոտն") {
                $x = "10.25.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.25.0.0/29";
                    $p = "10250000";
                }
            }
           if ($city == "Շիրակ") {
                $x = "10.26.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.26.0.0/29";
                    $p = "10260000";
                }
            }
             if ($city == "Լոռի") {
                $x = "10.27.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.27.0.0/29";
                    $p = "10270000";
                }
            }
            if ($city == "Տավուշ") {
                $x = "10.28.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.28.0.0/29";
                    $p = "10280000";
                }
            }
            if ($city == "Գեղարքունիք") {
                $x = "10.29.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.29.0.0/29";
                    $p = "10290000";
                }
            }if ($city == "Երևան") {
                $x = "10.30.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.30.0.0/29";
                    $p = "10300000";
                }
            }
            $technical_data["username"] = $data["username"];
            $technical_data["password"] = $data["password"];
            $technical_data["station"] = $data["station"];
            $technical_data["ip_int"] = (int) $p;

            $technical_data["con_type"] = $data["con_type"];
            $data["modem"];

            if ($data["modem"]) {
                $technical_data["modem"] = $data["modem"];
            } else {
                $technical_data["modem"] = "";
            }

            if ($data["ap"]) {
                $technical_data["ap"] = $data["ap"];
            } else {
                $technical_data["ap"] = "ap";
            }
            $technical_data["server_id"] = 1;
            $technical_data["vlan"] = $data["vlan"];
            $technical_data["ip_range"] = $ip;
            $technical_data["data_id"] = (int) $data_id;
            $technical_data["active"] = 1;

            $station = $this->Station->find("first", array("conditions" => array("Station.station_name" => $data["station"])));

            $technical_data["station_id"] = (int) $station["Station"]["id"];
            $service_name = $this->Service_name->find("first", array("conditions" => array("Service_name.service_name" => $data["service"])));

            if ($service_name) {
                $technical_data["service_id"] = (int) $service_name["Service_name"]["id"];
                //  "ssh control@" . $row["modem"] . " -p 22000 -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no /ip firewall address-list add list=disabled address=" . $row["ip_range"] . "";
                $transaction = array();
                $trans_log = array();
                $inset_pay = array();

                $id = $this->Technical_data->addPost($technical_data);
                $unical_id = $id*21;
                $this->Technical_data->query("UPDATE `technical_data` SET `unical_id`='$unical_id' WHERE `id`='$id'");
                $this->Person->updateAll(array("Person.active" => "'1'"), array('Person.id' => $data_id));
                $credit_date = "0";
                date_default_timezone_set('Etc/GMT-4');
                $thisdate = date("Y-m-d H:i:s");
                $last_date = date("Y-m-d H:i:s", strtotime($thisdate . '+5 day'));
                $inset_pay["Payment"]["balance"] = 0;
                $inset_pay["Payment"]["category"] = 2;
                $inset_pay["Payment"]["credit"] = "0";
                $inset_pay["Payment"]["payday"] = $thisdate;
                $inset_pay["Payment"]["credit_date"] = $thisdate;
                $inset_pay["Payment"]["data_id"] = $id;
                $inset_pay["Payment"]["no_credit"] = 0;
                $id_pay = $this->Payment->addPost($inset_pay);

                $trans_log["data"] = "Ակտիվացված է";
                $log_id = $this->Transaction_log->addPost($trans_log);
                $transaction["client_id"] = $id;
                $transaction["diabled_date"] = "5";
                $transaction["active_service"] = 2;
                $transaction["logs_id"] = $log_id;
                $this->Transaction->addPost($transaction);
            } else {
                return $this->redirect(array('action' => 'search'));
            }

            return $this->redirect(array('action' => 'search'));
            if ($id) {
                // $insertpost[""];
            } else {
                $this->Session->setFlash(
                        __('The user could not be saved. Please, try again.')
                );
                return $this->redirect(array('controller' => 'Realtimes', 'action' => 'search'));
            }
        }
    }

    public function ip_range($city) {
        if ($city == "Արմավիր") {
                $x = "10.20.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.20.0.0/29";
                    $p = "10200000";
                }
            }
            if ($city == "Արարատ") {
                $x = "10.21.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.21.0.0/29";
                    $p = "10210000";
                }
            }
            if ($city == "Վայոց Ձոր") {
                $x = "10.22.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.22.0.0/29";
                    $p = "10220000";
                }
            }
            if ($city == "Սյունիք") {
                $x = "10.23.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.23.0.0/29";
                    $p = "10230000";
                }
            }
            if ($city == "Կոտայք") {
                $x = "10.24.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.24.0.0/29";
                    $p = "10240000";
                }
            }
            if ($city == "Արագածոտն") {
                $x = "10.25.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.25.0.0/29";
                    $p = "10250000";
                }
            }
            if ($city == "Շիրակ") {
                $x = "10.26.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.26.0.0/29";
                    $p = "10260000";
                }
            }
            if ($city == "Լոռի") {
                $x = "10.27.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.27.0.0/29";
                    $p = "10270000";
                }
            }
            if ($city == "Տավուշ") {
                $x = "10.28.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.28.0.0/29";
                    $p = "10280000";
                }
            }
            if ($city == "Գեղարքունիք") {
                $x = "10.29.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.29.0.0/29";
                    $p = "10290000";
                }
            }if ($city == "Երևան") {
                $x = "10.30.";
                $ip = $this->Technical_data->find('first', array(
                    "order" => array("ip_int" => 'desc'),
                    'conditions' => array('Technical_data.ip_range LIKE' => '%' . $x . '%')
                ));
                if ($ip) {
                    $ip = $ip["Technical_data"]["ip_range"];
                    $ip = substr($ip, strlen($x));
                    $c = strpos($ip, ".");
                    $y = substr($ip, 0, -(strlen($ip) - $c));
                    $z = substr($ip, strlen($y) + 1, -3);
                    if ($z != 248) {
                        $z = $z + 8;
                    } else {
                        $z = 0;
                        $y = $y + 1;
                    }
                    $ip = $x . $y . "." . $z . "/29";
                    $p = $x . $y . ".";
                    if ((int) $z < 10) {

                        $z = '00' . (int) $z;
                    } elseif ((int) $z > 10 && (int) $z < 100) {
                        $z = '0' . (int) $z;
                    } else {

                    }
                    $p = $p . $z;

                    $p = str_replace('.', '', $p);
                } else {
                    $ip = "10.30.0.0/29";
                    $p = "10300000";
                }
            }
        $technical_data["ip_int"] = (int) $p;
        $technical_data["ip_range"] = $ip;
        return $technical_data;
    }

    public function telephone($tel) {

        $tel = $this->Telefon->find("all", array(
            'conditions' => array('OR' => array(
                    "Telefon.telefon LIKE" => "%" . $tel . "%",
                    "Telefon.tel2 LIKE" => "%" . $tel . "%",
                    "Telefon.tel1 LIKE" => "%" . $tel . "%"))));

        $id = "";
        if ($tel) {
            foreach ($tel as $value) {
                if (!is_null($value["Telefon"]["tel_id"]))
                    $id .= "'" . $value["Telefon"]["tel_id"] . "',";
            }
            $id = trim($id, ",");
            $id = "(" . $id . ")";

            return $id;
        }
    }

    public function login_search($login) {
        ///login search
        $id = "";
        $login = $this->Technical_data->find("all", array("conditions" => array("Technical_data.username LIKE" => '%' . $login . '%')));
        if ($login) {
            foreach ($login as $value) {
                if (!is_null($value["Technical_data"]["data_id"]))
                    $id .= "'" . $value["Technical_data"]["data_id"] . "',";
            }
            $id = trim($id, ",");
            $id = "(" . $id . ")";

            return $id;
        }
    }

    //on page in connectors "miacumner"
    public function lastname_fir($t) {
        $post_ids = "";
        $t = trim($t);
        $pos_pr = strpos($t, " ");
        $pos_pre = strrpos($t, " ");
        $search = array();
        $search["0"] = substr($t, 0, $pos_pr);
        $search["1"] = substr($t, $pos_pre + 1);

        //var_dump($search);
        $value_f = $this->Person->find("all", array("conditions" =>
            array("Person.lastname LIKE" => '%' . $search["1"] . '%', "Person.firstname LIKE" => '%' . $search["0"] . '%', 'Person.active ' => 0)));
        $value_l = $this->Person->find("all", array("conditions" =>
            array("Person.lastname LIKE" => '%' . $search["0"] . '%', "Person.firstname LIKE" => '%' . $search["1"] . '%', 'Person.active ' => 0)));
        if ($value_f) {
            foreach ($value_f as $value) {
                if (!is_null($value["Person"]["id"]))
                    $post_ids .= "'" . $value["Person"]["id"] . "',";
            }
            if ($post_ids) {
                $post_ids = trim($post_ids, ",");
                $post_ids = "(" . $post_ids . ")";
                $posts = $this->Person->profile($post_ids);

                $post = $this->Team->find("all", array("conditions" => array("Team.role" => "")));
                if ($post) {

                    $this->set("mexanik", $post);
                }
                if ($posts) {

                    $this->set("value", $posts);
                }
            }
        } elseif ($value_l) {

            if ($value_l) {
                foreach ($value_l as $value) {
                    if (!is_null($value["Person"]["id"]))
                        $post_ids .= "'" . $value["Person"]["id"] . "',";
                }
                if ($post_ids) {
                    $post_ids = trim($post_ids, ",");
                    $post_ids = "(" . $post_ids . ")";
                    $posts = $this->Person->profile($post_ids);

                    $post = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար")));
                    if ($post) {
                        $this->set("mexanik", $post);
                    }
                    if ($posts) {
                        $this->set("value", $posts);
                    }
                }
            }
        }
    }

    public function firstname($result) {
        $ids = "";

        $person = $this->Person->find("all", array(
            'conditions' => array('OR' => array(
                    "Person.lastname LIKE" => "%" . $result . "%",
                    "Person.firstname LIKE" => "%" . $result . "%"), 'Person.active ' => 0)));
       
        if ($person) {
            foreach ($person as $value) {
                if (!is_null($value["Person"]["id"]))
                    $ids .= "'" . $value["Person"]["id"] . "',";
            }

            if ($ids) {

                $ids = trim($ids, ",");
                $ids = "(" . $ids . ")";
                $sort = "id";
                $direction  = "desc";
                $people = $this->Person->profile($ids,$sort,$direction);

                $post = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար")));
                if ($post) {

                    $this->set("mexanik", $post);
                }
                if ($people) {

                    $this->set('value', $people);
                }
            }
        }
    }
    public function con_ajax(){
        if(isset($_POST["limit"]) && isset($_POST["uri"])){
            $limit = (int)$_POST["limit"];
            $uri = $_POST["uri"];
           
            $id = "";
            $a = strpos($uri, "realtimes/connectors");
                if($uri == "/realtimes/connectors"):

               $person = $this->Person->find('all', array(
                    "conditions" => array("Person.active = 0 order by id desc limit " . $limit . "," . 50 . ""))
                );
                $sort = "id";
                $direction = "desc";
                elseif($uri):
                    $sort = strpos($uri,"sort:");
                    $direction = strpos($uri,"/direction:");

                    $sort = substr($uri, $sort+5,-(strlen($uri)- $direction));
                    $direction = substr($uri, $direction + 11);
                    $person = $this->Person->find('all', array(
                                           "conditions" => array("Person.active = 0 order by `Person`.`$sort` $direction limit " . $limit . "," . 50 . "")));
            endif;

            if ($person) {
                foreach ($person as $value) {
                    $id .= "'" . $value["Person"]["id"] . "',";
                }
                $id = trim($id, ",");
                $id = "(" . $id . ")";
                $people = $this->Person->profile($id,$sort,$direction);
                $mexanik = $this->Team->find("all", array("fields" => "username", "conditions" => array("Team.role" => "աշխ. ղեկավար")));
                $this->set("value", $people);
                $this->set("mexanik", $mexanik);
                $this->set("i", $limit);
            }
        }
    }
    public function connectors() {



        if (isset($_POST["delete_people"])) {
            $id = $_POST["delete_people"];

            $person = $this->Person->find("first", array("conditons" => array('Person.id' => $id)));
            $adress = $this->Adress->find("first", array("conditons" => array('Adress.adresses_id' => $id)));
            $village = $this->Village->find("first", array("conditons" => array('Village.id' => $adress["Adress"]["village_id"])));
            $street = $this->Street->find("first", array("conditons" => array('Street.id' => $adress["Adress"]["street_id"])));
            $tel = $this->Telefon->find("first", array("conditons" => array('Telefon.tel_id' => $id)));
            $insert = array();

            $insert["histori"]["firstname"] = $person["Person"]["firstname"];
            $insert["histori"]["lastname"] = $person["Person"]["lastname"];
            $insert["histori"]["adress"] = $adress["Adress"]["city"] . ","
                    . $village["Village"]["village_name"] . "," . $street["Street"]["street_name"] . "," . $adress["Adress"]["home"];
            $insert["histori"]["telefon"] = $tel["Telefon"]["telefon"];
            $insert["histori"]["comment"] = $person["Person"]["comment"];

            $a = $this->histori->save($insert);

            if ($a) {
                $this->Person->delete($id);
                die();
            }
            die();
        }

        $id = "";
            if($_SERVER['REQUEST_URI'] === "/realtimes/connectors"):
                $person = $this->Person->find('all', array(
                                           "conditions" => array("Person.active = 0 order by id desc Limit 0,50")));
                    $sort = "id";
                    $direction = "desc";
                    $this->set("direction","none");
                elseif(strpos($_SERVER['REQUEST_URI'],"sort")):
                    $sort = strpos($_SERVER['REQUEST_URI'],"sort:");
                    $direction = strpos($_SERVER['REQUEST_URI'],"/direction:");
                    $sort = substr($_SERVER['REQUEST_URI'], $sort+5,-(strlen($_SERVER['REQUEST_URI'])-$direction));
                    $direction = substr($_SERVER['REQUEST_URI'], $direction + 11);
                    if($direction == 'asc'):
                        $this->set("direction","desc");
                        else:
                        $this->set("direction","asc");
                    endif;
                    $person = $this->Person->find('all', array(
                                           "conditions" => array("Person.active = 0 order by `Person`.`$sort` $direction Limit 0,50")));
             endif;

        if (isset($person)) {
            foreach ($person as $value) {
                $id .= "'" . $value["Person"]["id"] . "',";
            }
            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $people = $this->Person->profile($id,$sort,$direction);
            $mexanik = $this->Team->find("all", array("fields" => "username", "conditions" => array("Team.role" => "աշխ. ղեկավար")));
            $this->set("value", $people);
            $this->set("mexanik", $mexanik);
        }
        if (isset($_POST["search_con"])) {
            $people = $_POST["search_con"];
            $t = $people;
            $t = trim($t);
            $result = $people;
          
            if (strpos($t, " ")) {

                $t = trim($t);
                $pos_pr = strpos($t, " ");
                $pos_pre = strrpos($t, " ");

                if ($pos_pr && $pos_pre) {
                    $this->lastname_fir($t);
                } else {
                    $this->firstname($t);
                }
            } elseif (is_numeric($result)) {
                $id = $this->telephone($result);

                if ($id) {

                    $posts = $this->Person->profile($id);

                    $post = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար")));
                    if ($post) {

                        $this->set("mexanik", $post);
                    }
                    if ($posts) {

                        $this->set("value", $posts);
                    }
                }
            } else {
                
                $this->firstname($t);
            }
        }
        $insertpost = array();
        if (isset($_POST["con_person"]) && isset($_POST["id"])) {
            $con = array();
            $con["con_person"] = $_POST["con_person"];
            $con["id"] = $_POST["id"];
            $this->Person->save($con);
            return $this->redirect(array('controller' => 'realtimes', 'action' => 'connectors'));
        }
        if (isset($this->request->data['Person']) && isset($this->request->data['Person']['leg'])) {
            
            $insertpost = array();
            $insertcity = array();
            $inserttel = array();
            $insert = array();
            $data = $this->request->data['Person'];
            $insertpost['firstname'] = $data['firstname'];
            $insertpost['lastname'] = $data['lastname'];
            $insertpost['comment'] = $data['comment'];
            $insertpost['change_legal'] = $data['leg'];
            $insertpost['active'] = 0;
            $insertpost['auth_user'] = $this->Session->read("Auth.User.username");
            $village_name = $this->Village->find("all", array(
                    "conditions" => array("Village.village_name" => $data["village"])));
           
           if ($village_name) {
                $insertcity["village_id"] = $village_name["0"]["Village"]["id"];
                $insertpost["desc"] = $village_name["0"]["Village"]["desc"];

           }
               $person_id = $this->Person->addPost($insertpost);
            $insertcity['city'] = $data['city'];
            if ($person_id) {

                if ($data["leg"] == 0) {
                    $insert["company_name"] = $data["company_name"];
                    $insert["type_company"] = $data["type"];
                    $insert["person_id"] = $person_id;
                    $this->Legal_person->addPost($insert);
                }
                if ($data["comment"]) {
                    $insertcity['comment'] = $data['comment'];
                }

                $street_name = $this->Street->find("all", array(
                    "conditions" => array("Street.street_name" => $data["street"])));

                if ($street_name) {
                    $insertcity["street_id"] = $street_name["0"]["Street"]["id"];
                } else {
                    $insertstreet["street_name"] = $data["street"];
                    $id = $this->Street->addPost($insertstreet);
                    if ($id) {
                        $insertcity["street_id"] = $id;
                    }
                }
                if ($data['home']) {
                    $insertcity['home'] = $data['home'];
                }
                $insertcity['adresses_id'] = $person_id;
                $this->Adress->addPost($insertcity);
                if (isset($data["telefons"]) || isset($data["telefonss"]) && $person_id) {
                    $tel = $data["telefon"];
                    $inserttel["telefon"] = $tel;
                    $inserttel["tel_name"] = $data["tel_name"];
                    $inserttel["tel_id"] = $person_id;
                    $inserttel["tel1"] = $data["telefons"];
                    $inserttel["tel2"] = $data["telefonss"];
                    $k = $this->Telefon->addPost($inserttel);
                } else {
                    $inserttel["telefon"] = $data["telefon"];
                    $inserttel["tel_name"] = $data["tel_name"];
                    $inserttel["tel_id"] = $person_id;
                    $this->Telefon->addPost($inserttel);
                }
                header('Location: http://newop.realtime.am/realtimes/connectors ');
             
                exit;
            }
        }


        if (isset($this->request->data["Search"]) && !empty($this->request->data["Search"])) {
            $searchpost = $this->request->data["Search"];
            //$searchpost);
            if (strlen($searchpost["product"]) != 0) {
                strlen($searchpost["product"]);
            }
        }
    }

    public function station() {
        if (isset($_POST["station"])) {
            $station_name = $_POST["station"];

            $station = $this->Station->find("all", array("conditions" =>
                array("Station.station_name LIKE" => $station_name . "%"),
                "fields" => array("Station.station_name"),
                "limit" => 10));
            echo json_encode($station);
            die();
        } else {
            die();
        }
    }

    public function convertor() {


        function csv_to_array($filename = '', $delimiter = ',') {
            if (!file_exists($filename) || !is_readable($filename))
                return FALSE;

            $header = NULL;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    if (!$header)
                        $header = $row;
                    else {
                        $count = min(count($header), count($row));
                        $data[] = array_combine(array_slice($header, 0, $count), array_slice($row, 0, $count));
                        echo "<pre>";
                    }
                }
                fclose($handle);
            }
            return $data;
        }

        $data = csv_to_array('json/mrgavet.csv');

        foreach ($data as $value) {
            $sql = "INSERT INTO gps (gps_id, gps) values ";
            $data_id = $this->Technical_data->find("first", array("fields" => array("data_id"), "conditions" => array("Technical_data.username" => trim($value["Name"]))));


            $data_id = (int) $data_id["Technical_data"]["data_id"];
            $gps = $value["Longitude"] . "," . $value["Latitude"];

            $valuesArr[] = "('$data_id', '$gps')";
        }
        $sql .= implode(',', $valuesArr);
//$this->Gps->query($sql);

        var_dump($sql);

        die();
    }

    public function disable() {
        if (isset($_POST["ping"])) {
            $data = $_POST["ping"];
            //data["1"] -modem
            //data["0"] - ip_rande]
            $disable = "ssh control@" . $data["1"] . " -p 22000 -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no /ip firewall address-list add list=disabled address=" . $data["0"] . "";
            exec($disable, $c);
            var_dump($c);
            die();
        }
    }

    public function ping() {
        if (isset($_POST["ping"])) {
            $data = $_POST["ping"];
            die();
            //data["1"] -modem
            //data["0"] - ip_range
            $ping = "ping -c 1 google.com -s 1472";
            exec($ping, $c);
            var_dump($c);
            die();
            $value = $c["2"];
            $loss = strpos($value, "loss");
            $min = strpos($value, "min");
            $max = strpos($value, "max");
            $avg = strpos($value, "avg");

            $loss = substr($value, $loss + 5, -(strlen($value) - $min + 1));
            $max_rtt = substr($value, $max + 8);
            $avg_rtt = substr($value, $avg + 8, -(strlen($value) - $max + 1));
            echo $loss . "(" . $avg_rtt . ")" . $max_rtt;
            die();
            //echo $value;
        }
    }

    public function cre_person() {
        $date = date("Y-m-d");
        $a = $this->Person->find("all", array("conditions" => array("Person.modified LIKE" => "" . $date . "%", "Person.active=1")));
        $this->set("value", $a);
    }

    //search page in all

    public function search() {

        $credit_default = $this->credit->find("all");
        $this->set("credit_default",(int)$credit_default["0"]["credit"]["credit"]);
        $team = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար"), "fields" => array("Team.username", "Team.firstname", "Team.lastname")));
        $this->set("team", $team);
        if (isset($this->request->data['Person'])) {
            $insert_log = array();
            $insertgps = array();
            $insertpost = array();
            $insertcity = array();
            $inserttel = array();
            $insert = array();
            $tech = array();
            $data = $this->request->data['Person'];
            
            
            
            $insertpost['id'] = $data["id"];
           
            $insertpost['firstname'] = $data['firstname'];
            $insertpost['lastname'] = $data['lastname'];
           
            if (isset($this->request->data['Person']["pasport_seria"])) {
                $insertpost['pasport_seria'] = $data['pasport_seria'];
                $insertpost['add_pasport_time'] = $data['add_pasport_time'];
                $insertpost['by_whom'] = $data['by_whom'];
                $insertpost['email'] = $data['email'];
            }
            $date = date("Y-m-d");
            $insert["created"] = $date;
            $insertpost['auth_user'] = $this->Session->read("Auth.User.username");
            if (isset($data["comment"])) {
                $insertpost["comment"] = $data["comment"];
            }

            $person_id = $this->Person->addPost($insertpost);

            if ($person_id) {
                $a_id = $this->Adress->find("first", array(
                    "conditions" => array("Adress.adresses_id" => $person_id),
                    "fields" => array("Adress.id"),
                ));
                $insertcity['city'] = $data['city'];

                if (isset($data["company_name"])) {

                    $id = $this->Legal_person->find("first", array(
                        "conditions" => array("Legal_person.person_id" => $person_id),
                        "fields" => array("Legal_person.id"),
                    ));
                    if ($id) {
                        $id_legal = $this->legal_data->find("first", array("conditions" => array("legal_data.data_id" => $person_id)));
                        if (!$id_legal) {
                            $insertlegal["data_id"] = $person_id;

                            if (isset($data["telefon1"])) {
                                $insertlegal["tel"] = $data["telefon1"];
                            }
                            if (isset($data["firstname1"])) {
                                $insertlegal["name"] = $data["firstname1"] . $data["lastname1"];
                            }
                            if (isset($data["position1"]))
                                $insertlegal["pos"] = $data["position1"];
                            if (isset($data["telefon2"]))
                                $insertlegal["tel1"] = $data["telefon2"];
                            if (isset($data["firstname2"]))
                                $insertlegal["name1"] = $data["firstname2"] . $data["lastname2"];
                            if (isset($data["position2"]))
                                $insertlegal["pos1"] = $data["position2"];
                            if (isset($data["telefon3"]))
                                $insertlegal["tel2"] = $data["telefon3"];
                            if (isset($data["firstname3"]))
                                $insertlegal["name2"] = $data["firstname3"] . $data["lastname3"];
                            if (isset($data["position3"]))
                                $insertlegal["pos2"] = $data["position3"];

                            $a = $this->legal_data->save($insertlegal);
                        }
                        $insert["id"] = $id["Legal_person"]["id"];
                       
                        if(isset($data["company_name"])):
                            $insert["company_name"] = $data["company_name"];   
                        endif;
                        if(isset($data["type"])):
                            $insert["type_company"] = $data["type"];
                        endif;
                        if(isset($data["tax"])){
                            $insert["tax"] = $data["tax"];
                        }
                        if(isset($data["position"])):
                            $insert["position"] = $data["position"];
                        endif;
                        if(isset($data["name_bank"])):
                            $insert["name_bank"] = $data["name_bank"];
                        endif;
                        if(isset($data["type_bank"])):
                               $insert["type_bank"] = $data["type_bank"];
                        endif;
                        if(isset($data["account"])):
                            $insert["account"] = $data["account"];
                        endif;
                        $insert["person_id"] = $person_id;
                        $this->Legal_person->addPost($insert);
                    }
                }

                $village_name = $this->Village->find("all", array(
                    "conditions" => array("Village.village_name" => $data["village"])));
                if ($village_name) {
                    $insertcity["village_id"] = $village_name["0"]["Village"]["id"];
                }
                $street_name = $this->Street->find("all", array(
                    "conditions" => array("Street.street_name" => $data["street"])));

                if ($street_name) {
                    $insertcity["street_id"] = $street_name["0"]["Street"]["id"];
                } else {
                    $insertstreet["street_name"] = $data["street"];
                    $id = $this->Street->addPost($insertstreet);
                    if ($id) {
                        $insertcity["street_id"] = $id;
                    }
                }
                if ($data['home']) {
                    $insertcity['home'] = $data['home'];
                }

                $insertcity['id'] = $a_id["Adress"]["id"];

                $a = $this->Technical_data->find("first", array("conditions" => array("Technical_data.data_id" => $person_id, "Technical_data.ip_int" => 0),
                    "fields" => array("Technical_data.ip_range,Technical_data.id")));

                if ($a) {

                    $id_tech = $a["Technical_data"]["id"];
                    $tech = $this->ip_range($insertcity['city']);
                    $ip_range = $tech["ip_range"];
                    $ip_int = $tech["ip_int"];
                    $a = $this->Technical_data->updateAll(array('Technical_data.ip_range' => "'$ip_range'",
                        'Technical_data.ip_int' => "'$ip_int'",), array('Technical_data.id' => $id_tech));
                }
                $insertcity['adresses_id'] = $person_id;
                $this->Adress->addPost($insertcity);
                $gps = $this->Gps->find("first", array("conditions" => array("Gps.gps_id" => $person_id)));
                if ($gps) {
                    $insertgps['id'] = $gps["Gps"]["id"];
                    $gps_pos = strpos($data['gps'], ",");
                    
                    $lon = substr($data['gps'], $gps_pos + 1);
                    $lan = substr($data['gps'], 0, $gps_pos);
                    $lon = trim($lon);
                    $lan = trim($lan);
                    $a = (int)substr($lon, 0,2);
                    $b = (int)substr($lan, 0,2);
                
                      
                        
                     if ($a > $b) {
                        $data['gps'] = $lon . ", " . $lan;
                    } elseif ($lon < $lan) {
                        $data['gps'] = $lan . ", " . $lon;
                    }
                    $insertgps['gps'] = $data['gps'];
                    $insertgps['gps_id'] = $person_id;
                  
                  
                   
                } else {
                     $gps_pos = strpos($data['gps'], ",");
                    $lon = substr($data['gps'], $gps_pos + 1);
                    $lan = substr($data['gps'], 0, $gps_pos);
                    $a = (int)substr($lon, 0,2);
                    $b = (int)substr($lan, 0,2);
                    if ($a > $b) {
                        $data['gps'] = $lon . ", " . $lan;
                    } elseif ($lon < $lan) {
                        $data['gps'] = $lan . ", " . $lon;
                    }

                    $insertgps['gps_id'] = $person_id;
                    $insertgps['gps'] = $data['gps'];
                }

                $a = $this->Gps->addPost($insertgps);
                $tel1 = null;
                $tel2 = null;
                $telefon = null;
                if(isset($data["telefonss"]))
                    $tel2 = $data["telefonss"];
                if(isset($data["telefon"]))
                $telefon = $data["telefon"];
                if(isset($data["telefons"]))
                $tel1 = $data["telefons"];
                 
              
                  
                if(isset($tel_name)){
                    $tel_name = $data["tel_name"];
                }else{
                    $tel_name = '';
                }
              
                if($telefon){
               $this->Telefon->updateAll(array('Telefon.telefon' => "'$telefon'",
                    'Telefon.tel1' => "'$tel1'",'Telefon.tel2' => "'$tel2'",
                    'Telefon.tel_name' => "'$tel_name'",), array('Telefon.tel_id' => $person_id));
                }
                $set_id = $person_id;
            }
        }
        $product = $this->Product_name->find("all");
        $this->set("product", $product);

        //request search data in page search or Get[id] in jquery page search.js

        if (isset($_GET['id']) || isset($_GET['tel_id']) || isset($_GET['data_id']) || isset($this->request->params["named"]["id"]) || isset($person_id)) {

            $legal_id = "";
            $id = "";
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            if (isset($_GET['data_id'])) {
                $id = $_GET['data_id'];
            }
            if (isset($_GET['tel_id'])) {
                $id = $_GET['tel_id'];
            }
            if (isset($person_id)) {
                $id = $person_id;
            }
            if ($id) {
                $id = trim($id, ",");
                $id = "(" . $id . ")";
                $posts = $this->Person->getPostsFiles($id);
                $post = $this->Person->technical($id);

                if ($post) {
                    $this->set('username', $post);
                }
                if ($posts) {
                    $this->set('values', $posts);
                }
            }
        }
        if (isset($_GET["se"])) {

            $result = $_GET["se"];

            $subject = $result;
            $pattern = '/^%/';

            preg_match($pattern, substr($subject, 3), $matches, PREG_OFFSET_CAPTURE);
            
          
           if (is_numeric($result) && strlen($result) >= 6) {

                $post_ids = "";
                $legal_posts_id = "";
                $unic_id = (int)substr($result,0, 2);
                if($unic_id ===0){
                    $unic_id = (int)substr($result,2);
                    $id = $this->Technical_data->find("all",array("conditions"=>array("Technical_data.unical_id"=>$unic_id)));
                    if ($id) {
                    foreach ($id as $value) {
                                if (!is_null($value["Technical_data"]["data_id"]))
                                    $post_ids .= "'" . $value["Technical_data"]["data_id"] . "',";
                            }
                            if ($post_ids) {
                                $post_ids = trim($post_ids, ",");
                                $post_ids = "(" . $post_ids . ")";
                                $posts = $this->Person->getPostsFilesActive($post_ids);
                                $post = $this->Person->technical($post_ids);

                                if ($post) {
                                    $this->set('username', $post);
                                }
                                if ($posts) {
                                    $this->set('values', $posts);
                                }
                            }

                        } else {
     
                        }
                   
                }else{
                $id = $this->Telefon->find("all", array(
                    "conditions" => array("OR"=>array(
                                    "Telefon.telefon LIKE" => "%" . $result . "%",
                                    " Telefon.tel1 LIKE" => "%" . $result . "%", 
                                    " Telefon.tel2 LIKE" => "%" . $result . "%" 
                                        )), 'limit' => 10,));
                

                if ($id) {
                    foreach ($id as $value) {
                        if (!is_null($value["Telefon"]["tel_id"]))
                            $post_ids .= "'" . $value["Telefon"]["tel_id"] . "',";
                    }
                    if ($post_ids) {
                        $post_ids = trim($post_ids, ",");
                        $post_ids = "(" . $post_ids . ")";
                        $posts = $this->Person->getPostsFilesActive($post_ids);
                        $post = $this->Person->technical($post_ids);

                        if ($post) {
                            $this->set('username', $post);
                        }
                        if ($posts) {
                            $this->set('values', $posts);
                        }
                    }
                
                } else {
//
                }
                }
            }else{
                 $arr = explode(" ",$result);
                 $post_ids = "";

                    foreach ($arr as $value) {
                            $post_ids .= "'" . $value . "',";
                    }

                    $post_ids = trim($post_ids, ",");
                    $post_ids = "(" . $post_ids . ")";

                    $posts = $this->Person->getPostsFiles($post_ids);

                    $post = $this->Person->technical($post_ids);
                    if ($post) {
                        $this->set('username', $post);
                    }
                    if ($posts) {
                        $this->set('values', $posts);
                    }
            }
           
//            if (preg_match("/^[a-zA-Z0-9-_]+$/", $result) == 1 && !is_numeric($result)) {
//
//                $tech = $this->Technical_data->find("all", array(
//                     "fields"=>array("Technical_data.data_id"),
//                    "conditions" => array("Technical_data.username LIKE" => "%" . $result . "%"),
//                     'limit' =>10,
//                   ));
//
//                if ($tech) {
//                    $post_ids = "";
//
//                    foreach ($tech as $value) {
//
//                        if (!is_null($value["Technical_data"]["data_id"]))
//                            $post_ids .= "'" . $value["Technical_data"]["data_id"] . "',";
//                    }
//
//                    $post_ids = trim($post_ids, ",");
//                    $post_ids = "(" . $post_ids . ")";
//
//                    $posts = $this->Person->getPostsFiles($post_ids);
//
//                    $post = $this->Person->technical($post_ids);
//
//                    if ($post) {
//                        $this->set('username', $post);
//                    }
//                    if ($posts) {
//                        $this->set('values', $posts);
//                    }
//                }
//            } elseif (strlen($result) <= 3 || $matches) {
//                return $this->redirect(array(
//                            'controller' => 'realtimes', 'action' => 'search'));
//                die();
//            } elseif (filter_var($result, FILTER_VALIDATE_IP) || strpos($result, "10.2") === 0) {
//
//                $post_ids = "";
//                $legal_posts_id = "";
//                $id = $this->Technical_data->find('all', array(
//                       "fields"=>array("Technical_data.data_id"),
//                    'conditions' => array('OR' => array(
//                            'Technical_data.modem LIKE' => '%' . $result . '',
//                            'Technical_data.ip_range LIKE' => '%' . $result . ''),
//                         ),
//                    'limit' =>10
//                ));
//                if ($id) {
//                    foreach ($id as $value) {
//                        if (!is_null($value["Technical_data"]["data_id"]))
//                            $post_ids .= "'" . $value["Technical_data"]["data_id"] . "',";
//                    }
//                    if ($post_ids) {
//
//
//                        $post_ids = trim($post_ids, ",");
//                        $post_ids = "(" . $post_ids . ")";
//
//                        $posts = $this->Person->getPostsFiles($post_ids);
//                        $post = $this->Person->technical($post_ids);
//
//                        if ($post) {
//                            $this->set('username', $post);
//                        }
//                        if ($posts) {
//                            $this->set('values', $posts);
//                        }
//                    }
//                } else {
//                    return $this->redirect(array(
//                                'controller' => 'realtimes', 'action' => 'search'));
//                }
//            } elseif (is_numeric($result) && strlen($result) >= 6) {
//
//                $post_ids = "";
//                $legal_posts_id = "";
//                $id = $this->Telefon->find("all", array(
//                    "conditions" => array("Telefon.telefon LIKE" => "%" . $result . "%"), 'limit' => 10,));
//
//                if ($id) {
//                    foreach ($id as $value) {
//                        if (!is_null($value["Telefon"]["tel_id"]))
//                            $post_ids .= "'" . $value["Telefon"]["tel_id"] . "',";
//                    }
//                    if ($post_ids) {
//                        $post_ids = trim($post_ids, ",");
//                        $post_ids = "(" . $post_ids . ")";
//                        $posts = $this->Person->getPostsFilesActive($post_ids);
//                        $post = $this->Person->technical($post_ids);
//
//                        if ($post) {
//                            $this->set('username', $post);
//                        }
//                        if ($posts) {
//                            $this->set('values', $posts);
//                        }
//                    }
//                } else {
////                    return $this->redirect(array(
////                                'controller' => 'realtimes', 'action' => 'search'));
////                    die();
//                }
//            } elseif (!is_numeric($result) && !filter_var($result, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
//
//                $post_ids = "";
//                $village_id = "";
//                $ids = "";
////                $village = $this->Village->find("all", array(
////                    'conditions' => array('OR' => array(
////                            "Village.village_name LIKE" => "" . $result . "%"))));//villages search in comment
////
////                $person = $this->Person->find("all", array(
////                    'conditions' => array('OR' => array(
////                            "Person.lastname LIKE" => "%" . $result . "%",
////                            "Person.firstname LIKE" => "%" . $result . "%"))));
////                foreach ($id as $value) {
////                        if (!is_null($value["Telefon"]["tel_id"]))
////                            $post_ids .= "'" . $value["Telefon"]["tel_id"] . "',";
////                    }
////                    if ($post_ids) {
////                        $post_ids = trim($post_ids, ",");
////                        $post_ids = "(" . $post_ids . ")";
////                        $posts = $this->Person->getPostsFiles($post_ids);
////
////                        if ($posts) {
////                            $this->set('values', $posts);
////                        }
////                    }
//                $t = $result;
//                if (strpos($t, " ")) {
//
//                    $t = trim($t);
//                    $pos_pr = strpos($t, " ");
//                    $pos_pre = strrpos($t, " ");
//                    $search = array();
//                    $search["0"] = substr($t, 0, $pos_pr);
//                    $search["1"] = substr($t, $pos_pre + 1);
//                    //var_dump($search);
//                    $value_f = $this->Person->find("all", array("conditions" =>
//                        array("Person.lastname LIKE" => '%' . $search["1"] . '%', "Person.firstname LIKE" => '%' . $search["0"] . '%', 'Person.active ' => 1), 'limit' => 10,));
//
//                    if ($value_f) {
//                        foreach ($value_f as $value) {
//                            if (!is_null($value["Person"]["id"]))
//                                $post_ids .= "'" . $value["Person"]["id"] . "',";
//                        }
//                        if ($post_ids) {
//                            $post_ids = trim($post_ids, ",");
//                            $post_ids = "(" . $post_ids . ")";
//                            $posts = $this->Person->getPostsFiles($post_ids);
//
//                            $post = $this->Person->technical($post_ids);
//
//                            if ($post) {
//                                $this->set('username', $post);
//                            }
//                            if ($posts) {
//                                $this->set('values', $posts);
//                            }
//                        }
//                    }
//                    $value_l = $this->Person->find("all", array("conditions" =>
//                        array("Person.lastname LIKE" => '%' . $search["0"] . '%', "Person.firstname LIKE" => '%' . $search["1"] . '%', 'Person.active ' => 1), 'limit' => 10,));
//                    if ($value_l) {
//                        foreach ($value_l as $value) {
//                            if (!is_null($value["Person"]["id"]))
//                                $post_ids .= "'" . $value["Person"]["id"] . "',";
//                        }
//                        if ($post_ids) {
//                            $post_ids = trim($post_ids, ",");
//                            $post_ids = "(" . $post_ids . ")";
//                            $posts = $this->Person->getPostsFiles($post_ids);
//                            $post = $this->Person->technical($post_ids);
//
//                            if ($post) {
//                                $this->set('username', $post);
//                            }
//                            if ($posts) {
//                                $this->set('values', $posts);
//                            }
//                        }
//                    }
//                } else {
//                    $person = $this->Person->find("all", array(
//                        'conditions' => array('OR' => array(
//                                "Person.lastname LIKE" => "%" . $result . "%",
//                                "Person.firstname LIKE" => "%" . $result . "%"), 'Person.active ' => 1), 'limit' => 10,));
//                    if ($person) {
//                        foreach ($person as $value) {
//                            if (!is_null($value["Person"]["id"]))
//                                $ids .= "'" . $value["Person"]["id"] . "',";
//                        }
//                        if ($ids) {
//
//                            $ids = trim($ids, ",");
//                            $ids = "(" . $ids . ")";
//                            $postss = $this->Person->getPostsFiles($ids);
//                            $post = $this->Person->technical($ids);
//
//                            if ($post) {
//
//                                $this->set('username', $post);
//                            }
//                            if ($postss) {
//
//                                $this->set('values', $postss);
//                            }
//                        }
//                    }
//                }
//
////                if ($village) {//villages search in comment
////                    foreach ($village as $value) {
////                        if (!is_null($value["Village"]["id"]))
////                            $id = $value["Village"]["id"];
////                    }
////                    if ($id) {
////                        $village_ids = $this->Adress->find("all", array(
////                            "fields" => array("Adress.village_id", "Adress.adresses_id"),
////                            "conditions" => array("Adress.village_id" => $id)));
////
////                        if ($village_ids) {
////                            foreach ($village_ids as $value) {
////                                $post_ids .= "'" . $value["Adress"]["adresses_id"] . "',";
////                            }
////
////                            if ($post_ids) {
////                                $post_ids = trim($post_ids, ",");
////                                $post_ids = "(" . $post_ids . ")";
////                                $posts = $this->Person->getPostsFiles($post_ids);
////                                if ($posts) {
////                                    $this->set('values', $posts);
////                                }
////                            }
////                        }
////                    }
//                //}
//            }
        }
    }

}
