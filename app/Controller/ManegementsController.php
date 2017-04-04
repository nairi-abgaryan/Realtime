<?php

//SELECT `firstname`, GROUP_CONCAT(`by_whom`) as `by` FROM `people` GROUP BY `firstname` hasel em grupirovkeqin mekel smsi texin 
App::uses('AppController', 'Controller');

class ManegementsController extends AppController
{

    public $helpers = array('Html', 'Form', 'Session');
    public $uses = array(
        "Team", "warehouse", "written_item", "role",
        "calendar", "Station", "Server", "Product_name", "product_count",
        "User", "Realtime", "Client", "Person", "Transaction_log",
        "Estate_user", "Estate_user", "Gps", "Adress", "Service",
        "Technical_data", "Telefon", "Legal_person", "written_log", "url", "Cron",
        "Problem", "permission", "Service_name", 'Problem', 'wastreles', "page", "user_role",
        "User_permission", "Village", "Street", "Transaction", "provider", "black_list", "product_category", "user_role,user_perm", "pay_center"
    );


    public $components = array(
        'Cookie',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'realtimes', 'action' => 'search'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authError' => 'You must be logged in to view this page.',
            'loginError' => 'Invalid Username or Password entered, please try again.'
        ));

    public function used_jobs()
    {

    }

    public function view_center()
    {
        if (isset($_POST["center"])):
            $region = $_POST["center"];
            $a = $this->pay_center->query("SELECT * from pay_centers as p "
                . "left join villages as v on v.id=p.village_id "
                . "where v.region_name='$region'");
            echo json_encode($a);
            die();
        endif;
        if (isset($_POST["edit_values"])) {
            $post = $_POST["edit_values"];
            $id = $post["2"];
            $name = $post["0"];
            $phone = $post["1"];
            $region = $post["3"];

            $p = $this->pay_center->query("UPDATE `pay_centers` SET `center_name`='$name', `phone`='$phone' WHERE `id`='$id'");

            $a = $this->pay_center->query("SELECT * from pay_centers as p "
                . "left join villages as v on v.id=p.village_id "
                . "where v.region_name='$region'");
            echo json_encode($a);
            die();

            die();
        }
        if (isset($_POST["delete_values"])) {
            $id = $_POST["delete_values"]["0"];
            $region = $_POST["delete_values"]["1"];


            $this->pay_center->delete($id);
            $a = $this->pay_center->query("SELECT * from pay_centers as p "
                . "left join villages as v on v.id=p.village_id "
                . "where v.region_name='$region'");
            echo json_encode($a);
            die();
        }
        if (isset($_POST["add_center"])) {
            $insert = array();
            $village = $_POST["add_center"]["2"];
            $region = $_POST["add_center"]["3"];
            $village = $this->Village->find("first", array("conditions" => array("Village.village_name" => $village, "Village.region_name" => $region)));
            $insert["center_name"] = $_POST["add_center"]["0"];
            $insert["phone"] = $_POST["add_center"]["1"];
            $insert["village_id"] = $village["Village"]["id"];
            $this->pay_center->save($insert);
            $a = $this->pay_center->query("SELECT * from pay_centers as p "
                . "left join villages as v on v.id=p.village_id "
                . "where v.region_name='$region'");
            echo json_encode($a);
            die();
        }
    }

    public function edit_countw()
    {

        if (isset($_POST["value"]) && isset($_POST["id"])):
            $value = $_POST["value"];
            $id = $_POST["id"];

            $this->product_count->read(null, $id);

            $this->product_count->set(array(
                'count' => (int)$value,
            ));
            $a = $this->product_count->save();
            echo $a["product_count"]["count"];
            die();
        endif;
        die();
    }

    public function edit_countu()
    {

        if (isset($_POST["value"]) && isset($_POST["id"])):
            $value = $_POST["value"];
            $id = $_POST["id"];


            $this->written_item->read(null, $id);

            $this->written_item->set(array(
                'quantity' => (int)$value,
            ));
            $a = $this->written_item->save();
            echo $a["written_item"]["quantity"];
            die();
        endif;
        die();
    }

    public function add_access()
    {
        if (isset($_POST["add_access"])) {
            $a = $_POST["add_access"];
            $count = count($a);
            $p;
            for ($i = 0; $i < $count; $i = $i + 3) {
                $role = $a[$i];
                $page = $a[$i + 1];
                $perm = $a[$i + 2];
                $p = $this->permission->find("first", array("conditions" => array("permission.role" => $role, "permission.page" => $page)));
                if ($p) {
                    $p = $this->permission->query("UPDATE `permissions` SET `role`=$role, `page`=$page, "
                        . "`perm`=$perm WHERE `role`='$role' and page='$page'");
                } else {
                    $this->permission->query("INSERT INTO `realtimes`.`permissions` (`role`, `page`, `perm`) VALUES ( '$role', '$page', $perm)");
                }
            }
            if ($p) {
                echo 1;
            } else {
            }
            die();

        }
        if (isset($_POST["role"])) {
            $role["role"] = $_POST["role"];
            $id = $this->user_role->addPost($role);
            $page = $this->permission->query("SELECT id FROM realtimes.pages");
            $insert = array();
            $i = 0;
            foreach ($page as $value) {
                $i++;
                $insert[$i]["page"] = $value["pages"]["id"];
                $insert[$i]["role"] = $id;
                $insert[$i]["perm"] = 0;
            }

            if (is_array($insert)) {

                $sql = "INSERT INTO permissions (role, page, perm) values ";

                $valuesArr = array();
                foreach ($insert as $row) {

                    $R_ID = (int)$row['page'];
                    $email = (int)$row['role'];
                    $name = (int)$row['perm'];
                    $valuesArr[] = "('$email', '$R_ID', '$name')";
                }

                $sql .= implode(',', $valuesArr);

                $a = $this->permission->query($sql);
                if ($a) {
                    echo 1;
                }
            }
            die();
        }
        if (isset($_POST["post_page"])) {
            $a = $this->page->find("all");
            echo json_encode($a);
            die();
        }

        die();
    }

    public function access()
    {

        $a["roles"] = $this->user_role->query("SELECT * FROM realtimes.user_roles");
        $a["all"] = $this->page->query("SELECT * FROM pages as page  left join permissions as perm on perm.page=page.id");
        echo json_encode($a);
        die();
    }

    public function maps_2()
    {

    }

    public function station_map()
    {

        if (isset($_POST["station_ip"])) {

            $station_ip = $_POST["station_ip"];

            $id = "";

            $station_name = $this->Station->find("first", array("conditions" => array("Station.station_ip" => trim($station_ip))));

            $data_id["center"] = $station_name["Station"]["station_gps"];

            $station_name = $station_name["Station"]["station_name"];
            $data_id["client"] = $this->Technical_data->find("all", array(
                "conditions" => array("Technical_data.station" => $station_name),
                "fields" => array("Technical_data.data_id")));

            foreach ($data_id["client"] as $value) {
                if (!is_null($value["Technical_data"]["data_id"]))
                    $id .= "'" . $value["Technical_data"]["data_id"] . "',";
            }
            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $modem_gps["client"] = $this->Gps->gps_search($id);
            $modem_gps["center"] = $data_id["center"];
            echo json_encode($modem_gps);
            die();
        }
        die();
    }

    public function persons_day()
    {
        if (isset($_POST["default_credit"])):
            $a = $this->Cron->find("first");
            echo $a["Cron"]["cron_credit"];
            die();
        endif;
        if (isset($_POST["change_credit"])):
            $day = $_POST["change_credit"];
            $days = array();
            $days["id"] = 1;
            $days["cron_credit"] = (int)$day;

            $a = $this->Cron->save($days);

            if ($a) {
                echo 1;
            } else {
                echo 0;
            }
            die();
        endif;
        if (isset($_POST["date_history"])) {
            $date = $_POST["date_history"];

            $team = $this->Transaction->find("all", array("joins" => array(
                array(
                    "table" => "technical_data",
                    "alias" => "tech",
                    "type" => "Left",
                    "conditions" => array("tech.id = Transaction.client_id")
                ),
                array(
                    "table" => "service_names",
                    "alias" => "service_names",
                    "type" => "Left",
                    "conditions" => array("service_names.id = Transaction.service_id")
                ),

            ),
                "conditions" => array("Transaction.created between '$date' and '$date 23:59:59' "
                    . "and Transaction.balance_change is not null and Transaction.service_id is not null"),
                "fields" => array("tech.username,Transaction.created,Transaction.balance_change,"
                    . "Transaction.paying_user,Transaction.type,service_names.service_name")));
            echo json_encode($team);
            die();
        }
        if (isset($_POST["day"])) {
            $day = (int)$_POST["day"];


            $date = date("Y-m-d H:i:s");

            $date1 = date('Y-m-d H:i:s', strtotime($date . ' + ' . $day . ' days'));

            $b = $this->Person->days($date, $date1);
            echo json_encode($b, JSON_UNESCAPED_UNICODE);
            die();
        }
        if (isset($_POST["no_credit"])) {


            $b = $this->Person->no_credit();
            echo json_encode($b, JSON_UNESCAPED_UNICODE);

            die();
        }
        if (isset($_POST["all_client"])) {
            $day = (int)$_POST["all_client"];
            $b = $this->Person->client();
            echo json_encode($b);
            die();
        }
        if (isset($_POST["client_category"]) && isset($_POST["select_category"]) && isset($_POST["page"])) {
            $client_category = (int)$_POST["client_category"];
            $select_category = (int)$_POST["select_category"];
            $page = (int)$_POST["page"];
            $b = $this->Person->dis_view($client_category, $select_category, $page);
            echo json_encode($b);
            die();
        }
        if (isset($_POST["client"])) {
            $value = (int)$_POST["client"];
            $b = $this->Person->client($value);
            echo json_encode($b);
            die();
        }
        if (isset($_POST["active_client"])) {
            $day = (int)$_POST["active_client"];

            $b = $this->Person->active_client();
            echo json_encode($b);
            die();
        }
        if (isset($_POST["stoped_client"])) {
            $day = (int)$_POST["stoped_client"];
            $b = $this->Person->stoped_client();
            echo json_encode($b);
            die();
        }
        if (isset($_POST["pay_debt"])) {
            $day = (int)$_POST["pay_debt"];
            $day_two = (int)$_POST["day_two"];
            $b = $this->Person->pay_debt($day, $day_two);
            echo json_encode($b, JSON_UNESCAPED_UNICODE);
            die();
        }
        if (isset($_POST["pay_credit"])) {
            $pay_credit = $_POST["pay_credit"];
            $pay_start = (int)$pay_credit["0"];
            $pay_end = (int)$pay_credit["1"];

            $pay_category = $pay_credit["2"];
            $date = date("Y-m-d");

            if ($pay_end != '') {
                $date_end = date("Y-m-d", strtotime($date . "- $pay_end day"));
            } else {
                $date_end = date("Y-m-d", strtotime($date . "- 5 month"));
            }
            if ($pay_start != '') {
                $date_start = date("Y-m-d", strtotime($date . "- $pay_start day"));
            } else {
                $date_start = date("Y-m-d");
            }


            $b = $this->Person->pay_credit($date_start, $date_end, $pay_category, $pay_start, $pay_end);

            echo json_encode($b, JSON_UNESCAPED_UNICODE);
            die();
        }
        if (isset($_POST["pay_not_credit"])) {

            $day = (int)$_POST["pay_not_credit"];


            $date = date("Y-m-d");
            $date1 = date("Y-m-d", strtotime($date . "+ $day day"));
//          $date1 = date('Y-m-d', strtotime($date. ' +  days'));

            $b = $this->Person->days_not_credit($date, $date1);
            echo json_encode($b, JSON_UNESCAPED_UNICODE);

            die();
        }
        die();
    }

    public function auth()
    {
        if (isset($_POST["CAKEPHP"])) {
            $a = setcookie("CAKEPHP", '', time() + (10 * 365 * 24 * 60 * 60), "");

            die();
        }
    }

    public function black_list()
    {
        if (isset($_POST["list"])) {
            $black_list = $this->black_list->find("all", array("conditions" => array("black_list.count" => 2)));

            $id = "";
            foreach ($black_list as $value) {
                $id .= "'" . $value["black_list"]["profile_id"] . "',";
            }

            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $result = $this->Problem->black_list($id);

            echo json_encode($result);
            die();
        }
    }

    public function perm($controller, $action, $role)
    {
        $page = $this->perm = $this->page->query("SELECT perm FROM realtimes.pages as page "
            . "left join permissions as perm "
            . "on perm.page=page.id "
            . "where page.page_controller='$controller' and page_name='$action' and role='$role'");
        if (count($page) != 0) {

            if (!$page["0"]["perm"]["perm"]) {
                $page = $this->perm = $this->page->query("SELECT * FROM realtimes.pages as page "
                    . "left join permissions as perm "
                    . "on perm.page=page.id "
                    . "where page.page_controller='$controller' and perm='1' and role='$role' limit 1");
                if (count($page) != 0 && $page["0"]["perm"]["perm"]) {
                    return $this->redirect(array('action' => $page["0"]["page"]["page_name"], 'controller' => $page["0"]["page"]["page_controller"]));
                } else {
                    $page = $this->perm = $this->page->query("SELECT * FROM realtimes.pages as page "
                        . "left join permissions as perm "
                        . "on perm.page=page.id "
                        . "where perm='1' and role='$role' limit 1");

                    if (count($page) != 0 && $page["0"]["perm"]["perm"]) {
                        return $this->redirect(array('action' => $page["0"]["page"]["page_name"], 'controller' => $page["0"]["page"]["page_controller"]));
                    } else {
                        return $this->redirect(array('action' => 'logout', 'controller' => 'users'));
                    }
                }
            } else {

            }
        } else if (count($page) == 0) {

        }
    }

    // only allow the login controllers only
    public function beforeFilter()
    {

        $this->Auth->allow('login');
        $this->set('logged_in', $this->Auth->loggedIn());
        $this->set('current_user', $this->Auth->user());
        $this->Auth->user();
        $this->Cookie->name = 'baker_id';
        $this->Cookie->time = 3600;  // or '1 hour'
        $this->Cookie->path = '/bakers/preferences/';
        $this->Cookie->domain = 'example.com';
        $this->Cookie->secure = true;  // i.e. only sent if using secure HTTPS
        $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
        $this->Cookie->httpOnly = true;
        $this->Cookie->type('aes');
        $role = $this->Auth->user()["role"];
        $controller = $this->request->params['controller'];
        $action = $this->request->params['action'];
        $this->perm($controller, $action, $role);
//        $column = $_SERVER["REQUEST_URI"];
//        $pos = strpos( $column,"s/");
//        $columns = substr($column, $pos+2);
//        $controller  = substr($column, 1,$pos);
//        $url = $this->page->find("first",array("conditions"=>array("page.page_name"=>$columns)));
//
//        $pos = strpos( $column,"s/");
//        $columns = substr($column, $pos+2);
//        $controller  = substr($column, 1,$pos);
//        $url = $this->page->find("first",array("conditions"=>array("page.page_name"=>$columns)));
//       
//        if(count($url)!=0){
//         $url_id = $url["page"]["id"];
//        $a = $this->permission->find("first",array("conditions"=>
//                    array("permission.role"=>$role,"`permission`.`page`" =>$url_id)));
//            
//        if(count($a) !== 0 &&  $a["permission"]["perm"] == true){
//           
//        }else{
//                $c = $this->permission->query("SELECT * FROM realtimes.permissions as perm "
//                    . "left join pages as page "
//                    . "on page.id=perm.page "
//                    . "where perm=1 and page_controller='$controller' "
//                    . "and role =".$role." limit 1");
//          
//                if( count($c)!=0 ){
//                    $action  =$c["0"]["page"]["page_name"];
//                    return $this->redirect(array('controller' => "$controller", 'action' => $action));
//                }else {
//                     $a = $this->permission->query("SELECT * FROM realtimes.permissions as perm "
//                    . "left join pages as page "
//                    . "on page.id=perm.page "
//                    . "where perm=1 "
//                    . "and role =".$role." limit 1");
//         
//                     if(count($a)!=0){
//                            $con  = $a["0"]["page"]["page_controller"];
//                            $action  = $a["0"]["page"]["page_name"];
//                            return $this->redirect(array('controller' => "$con", 'action' => $action));
//                     }
//                }
//            }
//        }
    }

    public function isAuthorized($user)
    {
        // Here is where we should verify the role and give access based on role

        return true;
    }

    public function manegement()
    {

    }

    public function add_service()
    {
        if (isset($_POST["add_service"])) {
            $service_name = array();
            $service_name["service_name"] = $_POST["add_service"]["0"];
            $a = $this->Service->save($service_name);
            die();
        }
        if (isset($_POST["view_service"])) {
            $value = $this->Service->find("all");
            $value = json_encode($value);
            echo $value;
            die();
        }
    }

    public function add_server()
    {
        if (isset($_POST["add_server"])) {
            $value = $_POST["add_server"];
            $insert_server = array();
            // $valu[0] -մարզ $value[1]-անուն $value["2]-ip//
            $insert_server["server_region"] = $value["0"];
            $insert_server["server_name"] = $value["1"];
            $insert_server["server_ip"] = $value["2"];
            $a = $this->Server->save($insert_server);

            die();
        }
        if (isset($_POST["view_server"])) {
            $server = $this->Server->find("all");
            $value = json_encode($server);
            echo $value;
            die();
        }
        if (isset($_POST["delete_server"])) {
            $id = $_POST["delete_server"];
            $this->Server->delete($id);
            die();
        }
        if (isset($_POST["edit_server"])) {
            $value = $_POST["edit_server"];
            $editinsert = array();
            //[0] -region;[1]-name [2] -ip [3] -id
            $editinsert["id"] = $value["3"];
            $editinsert["server_region"] = $value["0"];
            $editinsert["server_name"] = $value["1"];
            $editinsert["server_ip"] = $value["2"];
            $a = $this->Server->save($editinsert);
            die();
        }
    }

    public function add_tariff()
    {

        if (isset($_POST["add_tariffs"])) {

            $arr = $_POST["add_tariffs"];
            $update = array();
            $update["service_name"] = $arr["0"];
            $update["price"] = $arr["1"];
            $update["speed"] = $arr["2"];
            $a = $this->Service_name->save($update);
            var_dump($a);
            die();
        }
        if (isset($_POST["edit_tariff"])) {
            $arr = $_POST["edit_tariff"];
            $update = array();
            $id = $arr["3"];
            $service_name = $arr["0"];
            $price = $arr["1"];
            $speed = $arr["2"];
            $a = $this->Service_name->query("UPDATE `realtimes`.`service_names` SET "
                . "`service_name`='$service_name',"
                . "`price`='$price',"
                . "`speed`='$speed' WHERE `id`='$id';");
            var_dump($a);
            die();
        }
        if (isset($_POST["view_tariff"])) {
            $service_name["serice_name"] = $this->Service_name->find("all");
            $array = array();
            $role = $this->Auth->user()["role"];
            if ($role == "1") {
                foreach ($service_name["serice_name"] as $value) {
                    $counter_id = $value["Service_name"]["id"];
                    $a = $this->Technical_data->find("count", array("conditions" => array("Technical_data.service_id" => $counter_id)));
                    if (!is_null($a)):
                        $array[$counter_id] = $a;
                    else:
                        $array[$counter_id] = 0;
                    endif;


                }
            } else {
                $array = 0;
            }

            $service_name["count"] = $array;
            $value = json_encode($service_name);
            echo $value;
            die();
        }
        if (isset($_POST["delete_id"])) {
            $id = $_POST["delete_id"];
            $a = $this->Service_name->delete($id);
            var_dump($a);
            die();
            die();
        }
        if (isset($_POST["add_station"])) {

            $value = $_POST["add_station"];
            $insertstation = array();
            if (isset($value["11"]) && !empty($value["11"])) {
                $insertstation["id"] = (int)$value["11"];
            }


            $village = $this->Village->find("first",
                array("conditions" => array("Village.village_name" => $value["0"])));
            if ($village && !empty($village)) {
                $insertstation["station_village_id"] = $village["Village"]["id"];
            }

            $user = $this->Technical_data->find("first", array("conditions" => array("Technical_data.username" => $value["4"])));
            if ($user && !empty($user)) {
                $insertstation["station_user_id"] = $user["Technical_data"]["id"];
            }
            $station_name = $this->Station->find("first", array("conditions" => array("Station.station_name" => $value["6"])));
            if ($user && !empty($user)) {
                $insertstation["station_neighbour_id"] = $station_name["Station"]["id"];
            }
            $insertstation["station_region"] = $value["10"];
            $insertstation["price"] = $value["10"];
            $insertstation["station_name"] = $value["1"];
            $insertstation["station_price"] = $value["5"];
            $insertstation["station_type"] = $value["8"];
            $insertstation["station_gps"] = $value["3"];
            $insertstation["station_ip"] = $value["2"];
            $insertstation["station_property"] = $value["10"];

            $a = $this->Station->save($insertstation);
            if ($a):
                var_dump($a);
            else:
                return false;
            endif;
            die();
        }
        if (isset($_POST["edit_station"])) {
            $value = $_POST["edit_station"];
            $editinsert = array();
            //[0] -region;[1]-name [2] -ip [3] -id
            $editinsert["id"] = $value["4"];
            $editinsert["station_region"] = $value["0"];
            $editinsert["station_name"] = $value["1"];
            $editinsert["station_gps"] = $value["2"];
            $editinsert["station_ip"] = $value["3"];
            $a = $this->Station->save($editinsert);
            var_dump($a);
            die();
        }
        if (isset($_POST["view_station"])) {
            $value = $_POST["view_station"];
            $Station = $this->Service->search_station($value);
            $value = json_encode($Station);
            echo $value;
            die();
        }
        if (isset($_POST["delete_station"])) {
            $id = $_POST["delete_station"];
            $this->Station->delete($id);
            die();
        }
    }

    public function Tools_ware()
    {
        if (isset($_POST["date"])) {

            $date = $_POST["date"];


            $username = $date["3"];
            $prod_name = $date["4"];
            if ($prod_name != '1') {
                $prod_name = trim($prod_name);
                $query1 = "and written_log.product_name ='" . $prod_name . "'";
            } else {
                $query1 = "and written_log.id>1";
            }
            if ($username != '1') {
                $query = "and written_log.username ='" . $username . "'";
            } else {
                $query = "and written_log.id>0";
            }
            $date1 = $date["1"];
            $date2 = $date["2"];
            $logins["logs"] = $this->written_log->find("all", array(
                'conditions' => array("written_log.created BETWEEN '$date1' AND '$date2 23:59:59.999' $query $query1"),
                "order" => array("written_log.product_name")
            ));

            echo json_encode($logins);
            die();
        }
        if (isset($_POST["prod"])) {
            $prod_name = $this->Product_name->find("all");
            echo json_encode($prod_name);
        }
        die();
    }

    public function TeamTools()
    {
        if (isset($_POST["all_team"])) {
            $Team = $this->Team->find("all", array("fields" => array("Team.username"), "conditions" => array("Team.role" => "աշխ. ղեկավար")));
            echo json_encode($Team);
            die();
        }
        if (isset($_POST["date"])) {

            $date = $_POST["date"];


            if ($date["3"] == '1') {
                $query = "Technical_data.id>1";

            } else {
                $team_user = $date["3"];
                $query = "estate.team_user='" . $team_user . "'";
            }
            $date1 = $date["1"];
            $date2 = $date["2"];
            $query_team = "SELECT person.con_person,person.created,Technical_data.id,Technical_data.username,Technical_data.created,estate.id,estate.product_id,estate.team_user,"
                . "estate.species,estate.auth_user,estate.user_id,estate.quantity,estate.created,prod_name.id,prod_name.product_name
                                FROM realtimes.people as person 
                                left join technical_data  as Technical_data 
                                on Technical_data.data_id=person.id
                                left join estate_users as estate 
                                on estate.user_id=Technical_data.id
                                left join product_names as prod_name
                                on prod_name.id = estate.product_id
                                where Technical_data.created BETWEEN '$date1 00:00:00.599' AND '$date2 23:59:59.999'
                                 and $query  ";
            $logins["tech"] = $this->Person->query($query_team);
            echo json_encode($logins);
            die();
        }
        die();
    }


    public function calendar()
    {
        if (isset($_GET["id"])) {

            $event = $this->Team->find("all", array("conditions" => array("Team.username" => $_GET["id"])));
            $username = $_GET["id"];

            $event = [];
            $this->set("username", $username);
        }
        if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["count"]) && isset($_POST["title"]) && isset($_POST["color"]) && isset($_POST["username"])) {
            $posts = array();
            $start = $_POST["start"];
            $count = $_POST["count"];
            $end = $_POST["end"];
            $title = $_POST["title"];
            $username = $_POST["username"];
            $color = $_POST["color"];
            $end = str_replace(" (Caucasus Standard Time)", "", $end);
            $start = str_replace(" (Caucasus Standard Time)", "", $start);

            date_default_timezone_set('Etc/GMT-4');

            $end = date('Y-m-d h:i:s', strtotime($end)); // echoes '2016-03-14 05:00:00'
            $start = date('Y-m-d h:i:s', strtotime($start)); // echoes '2016-03-14 05:00:00'

            $posts["end"] = $end;
            $posts["title"] = $title;
            $posts["username"] = $username;
            $posts["color"] = $color;
            $posts["start"] = $start;
            $posts["count"] = $count;

            $this->calendar->save($posts);

            $date = str_replace(" (Caucasus Standard Time)", "", $start);

            $dates = date('Y-m-01', strtotime($date));
            $time = strtotime($date);
            $final = date("Y-m-01", strtotime("+1 month", $time));
            $a = $this->calendar->find("all", array(
                "conditions" => array("calendar.username" => $username, "calendar.start>='$dates' and calendar.start<='$final'"),
                "fields" => "calendar.count"));

            $count = 0;
            foreach ($a as $value) {
                $count += (int)$value["calendar"]["count"];

            }
            echo $count;
            die();
        }
        if (isset($_POST["month"]) && isset($_POST["username"])) {

            $username = $_POST["username"];

            $event = [];
            $a = $this->calendar->find("all", array(
                "conditions" => array("calendar.username" => $username, "calendar.title is NOT NULL"),
                "fields" => "calendar.title,calendar.end,calendar.start,calendar.color,calendar.count"));

            foreach ($a as $value) {
                $value["calendar"]["title"] = $value["calendar"]["title"] . ' - ' . $value["calendar"]["count"];

                array_push($event, $value["calendar"]);
            }

            echo json_encode($event);
            die();
        }
        if (isset($_POST["date"]) && isset($_POST["user"])) {
            $username = $_POST["user"];
            $date = str_replace(" (Caucasus Standard Time)", "", $_POST["date"]);

            $dates = date('Y-m-01', strtotime($date));
            $time = strtotime($date);
            $final = date("Y-m-01", strtotime("+1 month", $time));
            $a = $this->calendar->find("all", array(
                "conditions" => array("calendar.username" => $username, "calendar.start>='$dates' and calendar.start<='$final'"),
                "fields" => "calendar.count"));
            $count = 0;
            foreach ($a as $value) {
                $count += (int)$value["calendar"]["count"];

            }
            echo $count;
            die();
            echo json_encode($event);
            die();
        }

    }


    public function village()
    {
        if (isset($_POST['q']) && isset($_POST["city_val"])) {
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
    }

    public function service()
    {

    }

    public function person()
    {
        $service_name = array();
        $service_name["service_name"] = $this->Service_name->find("all");
        $this->set("service_name", $service_name["service_name"]);
        if (isset($_POST["end"])) {

            $id = "";
            $id = $_POST["end"];

            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $people = $this->Person->profile($id);
            if ($people) {
                $this->set("people", $people);
            }
        }

//        if ($this->Session->read("id")) {

//        }
//        if (isset($_POST("id_e"))) {
//            $id = "";
//            $id = $this->Session->read("id_e");
//            $id = trim($id, ",");
//            $id = "(" . $id . ")";
//            $people = $this->Person->profile($id);
//            if ($people) {
//                $this->set("edit", $people);
//            }
//        }
    }

    public function edit_con()
    {
        if (isset($this->request->data["Person"])) {
            $data = $this->request->data["Person"];

            $id = $data["id"];
            $comment = $data["comment"];
            $firstname = $data["firstname"];
            $lastname = $data["lastname"];
            $telefon = $data["telefon"];
            $tel1 = $data["telefons"];
            $tel2 = $data["telefonss"];
            $tel_name = $data["tel_name"];

            $id_exist = $this->Telefon->find("first", array("conditions" => array("Telefon.tel_id" => $id)));
            if ($id_exist) {
                $this->Telefon->updateAll(array('Telefon.telefon' => "'$telefon'",
                    'Telefon.tel1' => "'$tel1'",
                    'Telefon.tel2' => "'$tel2'",
                    'Telefon.tel_name' => "'$tel_name'",), array('Telefon.tel_id' => $id));
            } else {
                $this->Telefon->query("INSERT INTO `realtimes`.`telefons` ( `tel_id`, `tel1`, `tel2`, `telefon`, `tel_name`) 
                    VALUES ($id, '$tel1', '$tel2', '$telefon', '$tel_name');
");
            }
            $village_name = $this->Village->find("all", array(
                "conditions" => array("Village.village_name" => $data["village"])));
            if ($village_name) {
                $village_id = $village_name["0"]["Village"]["id"];
            } else {
                $this->Session->setFlash(
                    __('գյուղի անունը սխալ է.')
                );
                return $this->redirect(array('controller' => 'realtimes', 'action' => 'connectors'));
            }
            $street_name = $this->Street->find("all", array(
                "conditions" => array("Street.street_name" => $data["street"])));

            if ($street_name) {
                $street_id = $street_name["0"]["Street"]["id"];
            } else {
                $insertstreet = array();
                $insertstreet["street_name"] = $data["street"];
                $id = $this->Street->addPost($insertstreet);
                if ($id) {
                    $street_id = $id;
                }
            }
            if ($data['home']) {
                $insertcity['home'] = $data['home'];
            }

            $city = $data["city"];
            $home = $data["home"];
            $this->Adress->updateAll(array('Adress.city' => "'$city'",
                'Adress.village_id' => "'$village_id'",
                'Adress.street_id' => "'$street_id'",
                'Adress.home' => "'$home'",), array('Adress.adresses_id' => $id));
            $this->Person->updateAll(array('Person.lastname' => "'$lastname'", 'Person.comment' => "'$comment'",
                'Person.firstname' => "'$firstname'",), array('Person.id' => $id));
            if (isset($data["type"])) {

                $update = array();
                $this->Person->updateAll(array('Person.lastname' => "'$lastname'",
                    'Person.firstname' => "'$firstname'", 'Person.comment' => "'$comment'"), array('Person.id' => $id));
                $company_name = $data["company_name"];
                $type = $data["type"];
                $tax = $data["tax"];
                $position = $data["position"];
                $name_bank = $data["name_bank"];
                $type_bank = $data["type_bank"];
                $account = $data["account"];

                $this->Legal_person->updateAll(array('Legal_person.company_name' => "'$company_name'",
                    'Legal_person.type_company' => "'$type'",
                    'Legal_person.tax' => "'$tax'",
                    'Legal_person.position' => "'$position'",
                    'Legal_person.name_bank' => "'$name_bank'",
                    'Legal_person.type_bank' => "'$type_bank'",
                    'Legal_person.account' => "'$account'",), array('Legal_person.person_id' => $id));
            }
            return $this->redirect(array('controller' => 'realtimes', 'action' => 'connectors'));
        }
        if (isset($_POST["id_e"])) {

            $id = "";
            $id = $_POST["id_e"];
            $id = trim($id, ",");
            $id = "(" . $id . ")";
            $people = $this->Person->profile($id);
            if ($people) {
                $this->set("edit", $people);
            }
        }
    }

    public function provider()
    {
        if (isset($_POST["provider_find"])) {
            $value = $_POST["provider_find"];

            $pro = $this->provider->find("all", array("conditions" => array("provider.provider_name LIKE" => "%" . $value . "%")));
            echo json_encode($pro);
            die();
        }
        if (isset($_POST["edit_prov"])) {
            $edit_prov = $_POST["edit_prov"];

            $insert = array();
            foreach ($edit_prov as $key => $value) {
                $insert["id"] = $edit_prov["1"];
                $insert["legal_type"] = $edit_prov["0"];
                $insert["provider_name"] = $edit_prov["2"];
                $insert["adress"] = $edit_prov["3"];
                $insert["telefon"] = $edit_prov["4"];
                $insert["bank_name"] = $edit_prov["5"];
                $insert["account"] = $edit_prov["6"];
            }
            $a = $this->provider->save($insert);
            die();
        }
        if (isset($_POST["delete_prov"])) {
            $id = $_POST["delete_prov"];
            $this->provider->query("DELETE FROM `realtimes`.`providers` WHERE `id`='$id'");
            die();
        }
        if (isset($_POST["provider"])) {
            $pro = $this->provider->find("all");
            echo json_encode($pro);
            die();
        }
        if (isset($_POST["product_category"])) {
            $prod_cat = $this->product_category->find("all");
            echo json_encode($prod_cat);
            die();
        }
        if (isset($_POST["provider_name"])) {
            $pro = $this->provider->find("all", array("conditions" => array('provider.id!=100'), "fields" => array("provider.provider_name")));
            echo json_encode($pro);
            die();
        }
        if (isset($_POST["edit_profile"])) {
            $edit = $_POST["edit_profile"];
            $json = $this->provider->find("first", array("conditions" => array("provider.id" => $edit)));
            echo json_encode($json);
            die();
        }
        if (isset($_POST["update_profile"])) {
            $update = $_POST["update_profile"];

            $firstname = $update["0"];
            $lastname = $update["1"];
            $username = $update["2"];
            $adress = $update["3"];
            $telefon = $update["4"];
            $bank_name = $update["6"];
            $id = $update["5"];
            $a = $this->provider->updateAll(array('provider.account' => "'$firstname'",
                'provider.legal_type' => "'$lastname'",
                'provider.provider_name' => "'$username'",
                'provider.adress' => "'$adress'",
                'provider.telefon' => "'$telefon'",
                'provider.bank_name' => "'$bank_name'"), array('provider.id' => $id));

            die();
        }
        die();
    }

    public function add_realtime()
    {
        if (isset($_POST["data_r"])) {
            $data = $_POST["data_r"];

            $id["prod_id"] = $_POST["id"];
            $id["data"] = $data;

            $this->Session->write($id);
            $name = array();
            $species = array();
            $count = count($data);
            for ($i = 0; $i < $count; $i = $i + 3) {
                $name[$i] = $data[$i];
            }
            for ($i = 1; $i < $count; $i = $i + 3) {
                $species[$i] = $data[$i];
            }

            $a = $this->product_count->find("all", array("conditions" => array("product_count.product_name" => $name,
                "product_count.species" => $species)));
            $b["product_array"] = $a;
            $this->Session->delete("product_array");
            $this->Session->write($b);
            echo json_encode($a);
            die();
        }
        die();
    }

    public function creat()
    {

        if (isset($_POST["prod_all"]) && isset($_POST["name_prod"]) && isset($_POST["space_name"])) {
            $array = array();


            $array = $_POST["prod_all"];

            $space_name = $_POST["space_name"];
            $name_prod = $_POST["name_prod"] . " Realtime";

            $name1 = array();
            $name2 = array();
            $count = array();
            $count_now = array();
            $produt_count = array();
            $product_realtime = '';
            $prod_name = array();
            $prod_counts = array();
            $ware = array();

            foreach ($array as $value) {

                if ($value) {

                    $pos_name = strpos($value, "/");
                    $pos_space = strpos($value, ":");
                    $pos_count = strpos($value, ";");
                    $count_now_pos = strpos($value, "|");
                    $length = strlen($value);
                    $name_str = substr($value, 0, $pos_name);
                    $product_str = substr($value, 0, $pos_count);
                    $product_realtime = $product_str . "++" . $product_realtime;

                    $name2_str = substr($value, $pos_name + 1, -($length - $pos_space));
                    $count_str = substr($value, $pos_space + 1, -($length - $pos_count));
                    $count_now_str = substr($value, $pos_count + 1, -($length - $count_now_pos));
                    $count_now_str = (float)$count_now_str;
                    $count_str1 = substr($value, $count_now_pos + 1);
                    $values = $this->product_count->find('first', array(
                        'conditions' => array(
                            "product_count.product_name" => $name_str,
                            "product_count.species" => $name2_str,
                        )
                    ));

                    $count_i = (float)$count_now_str;
                    $id_i = $values["product_count"]["id"];

                    $a = $this->product_count->updateAll(array('product_count.count' => "'$count_i'",
                    ), array('product_count.id' => $id_i));
                }
            }
            $prod_name["product_name"] = $name_prod;

            $name = $this->Product_name->find('first', array("conditions" => array("Product_name.product_name" => $name_prod,
                "Product_name.product_realtime !=''")));
            if (!$name) {
                $prod_name["product_realtime"] = $product_realtime;
                $prod_id = $this->Product_name->addPost($prod_name);
                $ware["product_id"] = $prod_id;
            } else {
                $ware["product_id"] = $name["Product_name"]["id"];
            }
            $written_logs = array();
            $written_logs["quantity"] = $count_str1;
            $written_logs["species"] = $space_name;
            $written_logs["product_name"] = $name_prod;
            $written_logs["data"] = $product_realtime;
            $logs_id = $this->written_log->add_logs($written_logs);

            $prod_counts["species"] = $space_name;
            $prod_counts["product_name"] = $name_prod;
            $prod_counts["written_logs"] = $logs_id;
            $prod_counts["count"] = (float)$count_str1;
            $prod_counts["product_realtime"] = $product_realtime;
            $space = $this->product_count->find("first", array("conditions" => array("product_count.product_name" => $name_prod, "product_count.species" => $space_name)));

            if ($space) {
                $prod_counts["count"] = $space["product_count"]["count"] + (float)$count_str1;
                $prod_counts["id"] = $space["product_count"]["id"];
                $k = $this->product_count->save($prod_counts);
            } else {
                $k = $this->product_count->save($prod_counts);
            }


            $ware["species"] = $space_name;
            $ware["quantity"] = (float)$count_str1;
            $ware["provider_id"] = 101;

            $k = $this->warehouse->save($ware);
            if ($a) {
                echo $prod_id;
            }
            die();


            die();
        }
        die();
    }

    public function add_ware()
    {
        if (isset($_POST["prod_name"]) && isset($_POST["prod_space"]) && isset($_POST["count"]) && isset($_POST["provider"])) {////SARQEL LOGER@ CHISHT
            $insert = array();
            $product = array();
            $change = array();
            $warehouse["species"] = trim($_POST["prod_space"]);
            $warehouse["product_name"] = trim($_POST["prod_name"]);
            $warehouse["quantity"] = $_POST["count"];
            $warehouse["provider_name"] = trim($_POST["provider"]);
            $warehouse["category_name"] = trim($_POST["product_category"]);
            $prod_cat = $this->product_category->find("all");

            $product = $this->Product_name->find("first", array("conditions" => array(
                "Product_name.product_name" => $warehouse["product_name"])));
            $provider = $this->provider->find("first", array("conditions" => array(
                "provider.provider_name" => $warehouse["provider_name"])));

            $prod_count = $this->product_count->find("first", array("conditions" => array("product_count.species" => $warehouse["species"],
                "product_count.product_name" => $warehouse["product_name"])));

            if ($prod_count) {
                $change = $prod_count["product_count"]["count"] + $warehouse["quantity"];
                $id = $prod_count["product_count"]["id"];
                $this->product_count->updateAll(array('product_count.count' => "'$change'"), array('product_count.id' => $id));
            } else {
                $change["count"] = $warehouse["quantity"];
                $change["species"] = $warehouse["species"];
                $change["product_name"] = $warehouse["product_name"];
                $this->product_count->save($change);
            }
            if ($product && $provider) {
                $product["species"] = $warehouse["species"];
                $product["quantity"] = $warehouse["quantity"];
                $product["product_id"] = $product["Product_name"]["id"];
                $product["provider_id"] = $provider["provider"]["id"];
                $a = $this->warehouse->add_tool($product);

                if ($a) {
                    $this->Session->setFlash(__('Ձեր գրած ապրանքը պահպանված է պահեստում'));
                }

                die();
            } elseif (!$product && $provider) {
                $insert["species"] = $warehouse["species"];
                $insert["quantity"] = $warehouse["quantity"];
                $insert["provider_id"] = $provider["provider"]["id"];
                $category["category_name"] = $warehouse["category_name"];
                foreach ($prod_cat as $value) {
                    if ($value["product_category"]["category_name"] == $warehouse["category_name"]) {
                        $id_cat = $value["product_category"]["id"];
                    }
                }
                $product["category"] = $id_cat;
                $product["product_name"] = $warehouse["product_name"];

                $product_id = $this->Product_name->addPost($product);
                $insert["product_id"] = $product_id;
                $a = $this->warehouse->add_tool($insert);
                if ($a) {
                    $this->Session->setFlash(__('Ձեր գրած ապրանքը պահպանված է պահեստում'));
                } else {
                    $this->Session->setFlash(__('ստուգեք ճշտությունը'));
                }
                echo $product_id;
                die();
            } elseif ($product && !$provider) {
                $product["id"] = $product["Product_name"]["id"];
                $product["species"] = $warehouse["species"];
                $product["quantity"] = $warehouse["quantity"];
                $product["product_id"] = $product["provider_name"]["id"];
                $prov["provider_name"] = $warehouse["provider_name"];
                $prov_id = $this->provider->addPost($prov);
                $product["provider_id"] = $prov_id;
                $a = $this->warehouse->add_tool($product);
                if ($a) {
                    $this->Session->setFlash(__('Ձեր գրած ապրանքը պահպանված է պահեստում'));
                }
            } elseif (!$product && !$provider) {
                $product["id"] = $product["Product_name"]["id"];
                $product["species"] = $warehouse["species"];
                $product["quantity"] = $warehouse["quantity"];
                foreach ($prod_cat as $value) {
                    if ($value["product_category"]["category_name"] == $warehouse["category_name"]) {
                        $id_cat = $value["product_category"]["id"];
                    }
                }
                $insert["category"] = $id_cat;
                $insert["product_name"] = $warehouse["product_name"];
                $insert["category"] = $id_cat;
                $product_id = $this->Product_name->addPost($insert);

                $product["product_id"] = $product_id;
                $prov["provider_name"] = $warehouse["provider_name"];
                $prov_id = $this->provider->addPost($prov);
                $product["provider_id"] = $prov_id;
                $a = $this->warehouse->add_tool($product);
                echo $product_id;
                die();
            }
            die();
        }
        die();
    }

    public function team()
    {

        $category = $this->role->find("all", array('order' => 'role.order'));
        $this->set("role", $category);
        if (isset($_POST["edit_profile"])) {
            $edit = $_POST["edit_profile"];
            $json = $this->Team->find("first", array("conditions" => array("Team.username" => $edit)));
            echo json_encode($json);
            die();
        }


        if (isset($_POST["all"])) {
            $k = $_POST["all"];
            $category = (int)$_POST["category"];

            $c = $this->Product_name->find("all", array("conditions" => array("Product_name.category" => $category)));
            $id = "";
            if ($c) {
                foreach ($c as $value) {
                    $id .= "'" . $value["Product_name"]["id"] . "',";
                }

                $id = trim($id, ",");
                $id = "(" . $id . ")";

                $team = $this->written_item->find("all", array("joins" => array(
                    array(
                        "table" => "product_names",
                        "alias" => "product_name",
                        "type" => "Left",
                        "conditions" => array("product_name.id = written_item.product_id")

                    ),

                ),
                    "conditions" => array("written_item.username" => $k, "written_item.quantity != 0", "written_item.product_id IN " . $id . ""),
                    "fields" => array("written_item.username,written_item.species,written_item.created,written_item.product_id,written_item.quantity,written_item.id,product_name.product_name", "product_name.id", "product_name.product_realtime", "product_name.category"),
                ));


                $res = $team;

                echo json_encode($res);
                die();
            }
            die();
        }

        if (isset($_POST["update_profile"])) {
            $update = $_POST["update_profile"];

            $firstname = $update["0"];
            $lastname = $update["1"];
            $username = $update["2"];
            $adress = $update["3"];
            $telefon = $update["4"];
            $role = $update["5"];
            $id = $update["6"];

            $a = $this->Team->updateAll(array('Team.firstname' => "'$firstname'",
                'Team.lastname' => "'$lastname'",
                'Team.username' => "'$username'",
                'Team.adress' => "'$adress'",
                'Team.telefon' => "'$telefon'",
                'Team.role' => "'$role'"), array('Team.id' => $id));

            die();
        }
        if (isset($_POST["delete_role"]) && isset($_POST["data"])) {
            $id = $_POST["delete_role"];
            $data = $_POST["data"];
            $a = $this->Team->find("first", array("conditions" => array("Team.role" => $data)));

            if ($a) {
                echo 1;
                die();
            } else {
                $delete_element = array("id" => $id);
                $a = $this->role->deleteAll($delete_element);
                die();
            }
        }
        if (isset($_POST["category"]) && isset($_POST["value"]) && isset($_POST["username"]) && isset($_POST["change_user"]) && isset($_POST["product_name"]) && isset($_POST["spacies"]) && isset($_POST["quantity"])) {
            $username = $_POST["username"];
            $change_user = $_POST["change_user"];
            $product_id = (int)$_POST["product_name"];

            $spacies = trim($_POST["spacies"]);
            $auth_user = $data["auth_user"] = $this->Auth->user()["username"];
            $value = $_POST["value"];
            $quantity = $_POST["quantity"];
            $query1 = $this->written_item->find("first", array("conditions" =>
                array("written_item.username" => $username,
                    "written_item.species" => $spacies,
                    "written_item.product_id" => $product_id)));
            $count1 = $query1["written_item"]["quantity"] - $quantity;
            $id1 = $query1["written_item"]["id"];
            $product = $this->Product_name->find("first", array("conditions" => array("Product_name.id" => $product_id)));

            if ($change_user !== 'null' && $value == 1) {

                $query = $this->written_item->find("first", array("conditions" =>
                    array("written_item.username" => $change_user,
                        "written_item.species" => $spacies,
                        "written_item.product_id" => $product_id)));


                if ($query && $query1) {


                    $id = $query["written_item"]["id"];
                    $count = $query["written_item"]["quantity"] + $quantity;
                    $count1 = $query1["written_item"]["quantity"] - $quantity;
                    $quantity_log = $quantity;
                    $quantity = $quantity + $count;
                    $insert = array();
                    $data = array();
                    $data["data"] = $username . "ը" . "տվել է " . $quantity_log . "" . " քանակի" . $spacies . "" . " տեսակի" . $product_id;
                    $data["username"] = $change_user;
                    $data["username1"] = $username;
                    $data["count"] = $quantity;
                    $data["species"] = $spacies;
                    $data["quantity"] = $quantity_log;
                    $data["auth_user"] = $auth_user;
                    $data["product_name"] = $product["Product_name"]["product_name"];
                    $logs_id = $this->written_log->add_logs($data);
                    $a = $this->written_item->updateAll(array('written_item.quantity' => "'$count'"), array('written_item.id' => $id));
                    $b = $this->written_item->updateAll(array('written_item.quantity' => "'$count1'"), array('written_item.id' => $id1));

                } else {
                    $count1 = $query1["written_item"]["quantity"] - $quantity;

                    $b = $this->written_item->updateAll(array('written_item.quantity' => "'$count1'"), array('written_item.id' => $id1));

                    $insert = array();
                    $data = array();
                    $data["data"] = $username . "ը" . "տվել է " . $quantity . "" . " քանակի" . $spacies . "" . " տեսակի" . $product_id;
                    $data["username"] = $change_user;
                    $data["count"] = $quantity;
                    $data["species"] = $spacies;
                    $data["product_name"] = $product["Product_name"]["product_name"];
                    $data["quantity"] = $quantity;
                    $data["auth_user"] = $auth_user;
                    $logs_id = $this->written_log->add_logs($data);
                    $insert["written_item"]["username"] = $change_user;
                    $insert["written_item"]["quantity"] = $quantity;
                    $insert["written_item"]["product_id"] = $product_id;
                    $insert["written_item"]["species"] = $spacies;
                    $insert["written_item"]["logs_id"] = $logs_id;
                    $a = $this->written_item->add_logs($insert);

                }
            } elseif ($value == 2) {

                $b = $this->written_item->updateAll(array('written_item.quantity' => "'$count1'"), array('written_item.id' => $id1));
                $insert = array();
                $data = array();
                $data["data"] = $username . "ի" . "տվել է " . $quantity . "" . " քանակի" . $spacies . "" . " տեսակի,,գնացել է՝ խոտան";
                $data["username"] = $change_user;

                $data["count"] = $quantity;
                $data["species"] = $spacies;
                $data["product_name"] = $product["Product_name"]["product_name"];
                $data["quantity"] = $quantity;
                $data["auth_user"] = $auth_user;
                $logs_id = $this->written_log->add_logs($data);
                $insert["wastreles"]["username"] = $username;
                $insert["wastreles"]["quantity"] = $quantity;
                $insert["wastreles"]["product_id"] = $product_id;
                $insert["wastreles"]["product_name"] = $product["Product_name"]["product_name"];
                $insert["wastreles"]["species"] = $spacies;
                $a = $this->wastreles->save($insert);


            } elseif ($value == 3) {

                $b = $this->written_item->updateAll(array('written_item.quantity' => "'$count1'"), array('written_item.id' => $id1));
                $insert = array();
                $data = array();
                $data["data"] = $username . "ից" . "տվել է " . $quantity . "" . " քանակի" . $spacies . "" . " տեսակի,,գնացել է՝ Պահեստ";
                $data["username"] = $change_user;
                $data["count"] = $quantity;
                $data["species"] = $spacies;
                $data["product_name"] = $product["Product_name"]["product_name"];
                $data["quantity"] = $quantity;
                $data["auth_user"] = $auth_user;
                $logs_id = $this->written_log->add_logs($data);
                $prod_count = $this->product_count->find("first", array("conditions" => array("product_count.species" => $spacies,
                    "product_count.product_name" => $product["Product_name"]["product_name"])));

                if ($prod_count) {
                    $change = $prod_count["product_count"]["count"] + $quantity;
                    $id = $prod_count["product_count"]["id"];
                    $this->product_count->updateAll(array('product_count.count' => "'$change'"), array('product_count.id' => $id));
                } else {
                    $change["count"] = $quantity;
                    $change["species"] = $spacies;
                    $change["product_name"] = $product["product_name"]["product_name"];
                    $this->product_count->save($change);
                }

            }

            $category = (int)$_POST["category"];

            $c = $this->Product_name->find("all", array("conditions" => array("Product_name.category" => $category)));
            $id = "";
            if ($c) {
                foreach ($c as $value) {
                    $id .= "'" . $value["Product_name"]["id"] . "',";
                }

                $id = trim($id, ",");
                $id = "(" . $id . ")";

                $team = $this->written_item->find("all",
                    array("joins" => array(
                        array(
                            "table" => "product_names",
                            "alias" => "product_name",
                            "type" => "Left",
                            "conditions" => array("product_name.id = written_item.product_id")
                        ),
                    ),
                        "conditions" => array("written_item.username" => $username, "written_item.quantity != 0", "written_item.product_id IN " . $id . ""),
                        "fields" => array("written_item.username,written_item.species,"
                            . "written_item.created,written_item.product_id,"
                            . "written_item.quantity,written_item.id,"
                            . "product_name.product_name", "product_name.id",
                            "product_name.product_realtime", "product_name.category"),
                    ));


                $res = $team;
                // var_dump($team);
                echo json_encode($team);
                die();
            }
            die();
        }
        if (isset($_POST["team"])) {
            $username = $_POST["team"];

            $team = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար", "Team.username!='$username'"), "fields" => array("Team.username", "Team.firstname", "Team.lastname")));

            echo json_encode($team);
            die();
        }
        if (isset($this->request->data["Team"])) {
            $insert = array();
            $team = $this->request->data["Team"];
            $file = $this->request->data['Team']['image'];
            $id = $team["id"];
            $username = $team["username"];
            $chat = 1;
            $sex = $team["sex"];
            $firstname = $team["firstname"];
            $lastname = $team["lastname"];
            $telefon1 = $team["telefon1"];
            $telefon2 = $team["telefon2"];
            if (isset($team["date"]))
                $date = $team["date"];
            if (isset($team["email"]))
                $email = $team["email"];

            $password = '123456';
            $role = $team["role"];
            $archive = 2;
            if ($id != "") {
                $adress = $team["adresses"];
                if ($file["size"] != 0) {
                    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
                    $name = md5(microtime() . $file['name']) . "." . $ext;
                    move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/img/' . $name);
                    $a = $this->Team->query("UPDATE `realtimes`.`teams` 
                     SET  `firstname`='$firstname',`role`='$role',
                    `lastname`='$lastname', `username`='$username', `password`='$password',
                    `adress`='$adress', `telefon1`='$telefon1', `telefon2`='$telefon2', 
                    `image_name`='$name', `sex`=$sex, `email`='$email',
                    `date`='$date',`created`=`created`,`chat`='$chat' WHERE `id`=$id;
                        ");

                    if ($a) {
                        $this->Session->setFlash(__('Փոփոխությունը կատարված է!'));
                    } else {
                        $this->Session->setFlash(__('Փոփոխությունը կատարված է!'));
                    }
                } else {
                    if ($team["sex"] == 1) {
                        $image_name = "txa.jpg";
                    } else {
                        $image_name = "axchik.jpg";
                    }

                    $a = $this->Team->query("UPDATE `realtimes`.`teams` 
                     SET  `firstname`='$firstname',`role`='$role',
                    `lastname`='$lastname', `username`='$username', `password`='$password',
                    `adress`='$adress', `telefon1`='$telefon1', `telefon2`='$telefon2', 
                    `image_name`='$image_name', `sex`=$sex, `email`='$email',
                    `date`='$date',`created`=`created`,`chat`='$chat' WHERE `id`=$id;
                        ");

                    if ($a) {
                        $this->Session->setFlash(__('Փոփոխությունը կատարված է!'));
                    } else {
                        $this->Session->setFlash(__('Փոփոխությունը կատարված է!'));
                    }
                }
            } else {

                if ($file["size"] != 0) {
                    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
                    $name = md5(microtime() . $file['name']) . "." . $ext;
                    move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/img/' . $name);

                    $email = $team["email"];
                    if ($team["city"] == 'Երևան') {
                        $adress = $team["city"] . ',' . $team["street"] . ',' . $team["home"];
                    } else {
                        $adress = $team["city"] . ',' . $team["village"] . ',' . $team["street"] . ',' . $team["home"];
                    }

                    $a = $this->Team->query("INSERT INTO `realtimes`.`teams` (`firstname`, `lastname`, `username`, `password`, `adress`, `telefon1`, `telefon2`, `role`, `image_name`, `sex`, `email`, `date`, `archive`, `chat`)"
                        . " VALUES ('$firstname', '$lastname', '$username', '$password',"
                        . " '$adress', '$telefon1', '$telefon2', '$role', '$name', $sex, "
                        . "'$email', '$date', $archive, '1');");
                    if ($a) {
                        $this->Session->setFlash(__('Նոր աշխատողը ավելացված է!'));
                    } else {
                        $this->Session->setFlash(__('Նոր աշխատողը ավելացված է!'));
                    }
                } else {

                    if ($team["city"] == 'Երևան') {
                        $adress = $team["city"] . ',' . $team["street"] . ',' . $team["home"];
                    } else {
                        $adress = $team["city"] . ',' . $team["village"] . ',' . $team["street"] . ',' . $team["home"];
                    }

                    if ($team["sex"] == 1) {
                        $image_name = "txa.jpg";
                    } else {
                        $image_name = "axchik.jpg";
                    }
                    $a = $this->Team->query("INSERT INTO `realtimes`.`teams` (`firstname`, `lastname`, `username`, `password`, `adress`, `telefon1`, `telefon2`, `role`, `image_name`, `sex`, `email`, `date`, `archive`, `chat`)"
                        . " VALUES ('$firstname', '$lastname', '$username', '$password',"
                        . " '$adress', '$telefon1', '$telefon2', '$role', '$image_name', $sex, "
                        . "'$email', '$date', $archive, '1');");

                    if ($a) {
                        $this->Session->setFlash(__('Նոր աշխատողը ավելացված է!'));
                    } else {
                        $this->Session->setFlash(__('Նոր աշխատողը ավելացված է!'));
                    }
                }
            }
        }
        if (isset($_POST["add_role"])) {
            $role = array();
            $a = $this->role->find("all", array("conditions" => array("role.category" => $_POST["add_role"])));
            if ($a) {
                return $this->redirect(array('action' => 'tools'));
            } else {
                $role["category"] = $_POST["add_role"];
                $true = $this->role->add_role($role);
                if ($true) {
                    return $this->redirect(array('action' => 'tools'));
                }
            }
        }
        if (isset($_POST["id"]) && isset($_POST["change_elemet"])) {
            $id = $_POST["id"];
            $element = $_POST["change_elemet"];
            $a = $this->role->updateAll(array('role.category' => "'$element'"), array('role.id' => $id));
        }
        if (isset($_POST["datas"])) {
            $data_r = $_POST["datas"];
            $data_r = trim($data_r);
            $result = $this->Team->find("all", array("conditions" => array("Team.role" => $data_r, "Team.archive != 1"), "order" => array("Team.firstname")));

            $res = json_encode($result);
            echo $res;
            die();
        }
    }

    public function user()
    {
        if (isset($_POST["user"])) {
            $user = $_POST["user"];
            $this->Team->archive($user);
            echo(user);
            die();

        }
    }

    public function warehouse()
    {

        $category = $this->role->find("all", array('order' => 'role.order'));
        $this->set("role", $category);


        if (isset($_POST["legal"]) && isset($_POST["provider_name"])) {
            $provider = array();
            $provider["legal_type"] = $_POST["legal"];
            $provider["adress"] = $_POST["adress"];
            $provider["provider_name"] = $_POST["provider_name"];
            $provider["telefon"] = $_POST["telefon"];
            $provider["bank_name"] = $_POST["bank_name"];
            $provider["account"] = $_POST["account"];
            if ($provider["provider_name"] != "" && $provider["legal_type"]) {
                $a = $this->provider->save($provider);
            }
        }
        if (isset($_POST["team"])) {
            $team = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար"), "fields" => array("Team.username", "Team.firstname", "Team.lastname")));

            echo json_encode($team);
            die();
        }
        if (isset($_POST["wastreles"])) {

            $wastreles = $this->wastreles->find("all");
            echo json_encode($wastreles);
            die();
        }


        $prov = $this->provider->find("all", array("fields" => array("provider_name")));

        $this->set("prov", $prov);
        $prod_cat = $this->product_category->find("all");

        if ($prod_cat) {
            $this->set("prod_cat", $prod_cat);
        }
        if (isset($_POST["product"]) && isset($_POST["name"])) {
            $name = $_POST["name"];
            $name_p = $_POST["product"];

            $val = $this->Product_name->find("first", array("conditions" => array("Product_name.product_name" => $name_p)));
            $ids = $val["Product_name"]["id"];
            $warehouse = $this->warehouse->find("all", array("conditions" => array("warehouse.product_id" => $ids, "warehouse.species" => $name)));
            $id = "";
            if ($warehouse) {
                foreach ($warehouse as $value) {
                    $id .= "'" . $value["warehouse"]["id"] . "',";
                }
                $id = trim($id, ",");
                $id = "(" . $id . ")";

                $warehouse = $this->provider->group_prod($id);

                $data = json_encode($warehouse);
                echo $data;
                die();
            } else {
                die();
            }
        }
        if (isset($_POST["product_w"])) {
            $name = $_POST["product_w"];
            $ware = $this->product_count->find("all", array("conditions" => array("product_count.product_name" => $name),
                'order' => array('product_count.product_name'),));
            $data = json_encode($ware);
            echo $data;
            die();
        }
        if (isset($_POST["product_we"])) {
            $id = $_POST["product_we"];

            $ware = $this->wastreles->find("all", array("conditions" => array("wastreles.product_id" => $id)));
            $data = json_encode($ware);
            echo $data;
            die();
        }
        if (isset($_POST["product_k"])) {
            $id = $_POST["product_k"];

            $ware = $this->product_count->find("all", array("conditions" => array("product_count.id" => $id)));
            $data = json_encode($ware);
            echo $data;
            die();
        }
        $menu_product = $this->Product_name->find("all", array("order" => array("Product_name.product_name")));
        foreach ($menu_product as $value) {

        }
        $delete = $this->warehouse->find("first", array("conditions" => array("warehouse.quantity" => 0)));
//      
//        if($delete){
//          
//            $this->warehouse->deleteAll($delete["warehouse"]["id"]);
//        }  
        $this->set("menu_product", $menu_product);
        $name = $this->Team->find("all", array("fields" => array("Team.username")));
        $this->set("name", $name);

        if (isset($this->request->data["add_creat_product"]["add"])) {
            $data = $this->request->data["add_creat_product"];
            $save = array();
            $now_prod = $this->Session->read("product_array");
            $change_array = $this->Session->read("data");

            $prod_id = $this->Session->read("prod_id");
            $prod = $this->product_count->find("first", array("conditions" => array("product_count.id" => $prod_id)));
            $count = $prod["product_count"]["count"];
            $count = (float)$count + (float)$data["quantity"];
            $this->product_count->updateAll(array('product_count.count' => "'$count'"), array('product_count.id' => $prod_id));
            $k = count($change_array);

            for ($l = 0; $l < $k; $l = $l + 3) {
                $save["name" . $l] = $change_array[$l];
                $save["space" . $l] = $change_array[$l + 1];
                $save["count" . $l] = $change_array[$l + 2];

            }

            foreach ($now_prod as $value) {
                for ($i = 0; $i < (int)$k; $i = $i + 3) {
                    if (trim($value["product_count"]["product_name"]) === trim($save["name" . $i]) && trim($value["product_count"]["species"]) === trim($save["space" . $i])) {
                        $id = $value["product_count"]["id"];
                        $count_new = (float)$value["product_count"]["count"] - (float)$data["quantity"] * (float)$save["count" . $i];
                        var_dump($count_new);

                        $a = $this->product_count->updateAll(array('product_count.count' => "'$count_new'"), array('product_count.id' => $id));
                        if ($a) {
                            break 1;
                        }
                    }
                }
            }
            $this->redirect(array("action" => "tools"));

            //  $this->product_count->
        }
        if (isset($this->request->data["tools"]["wastreles_out"])) {
            $insert = array();
            $product = array();
            $change = array();

            $warehouse = $this->request->data["tools"];
            $warehouse["product_name"] = trim($warehouse["product_name"]);
            $warehouse["species"] = trim($warehouse["species"]);

            $product = $this->Product_name->find("first", array("conditions" => array(
                "Product_name.product_name" => $warehouse["product_name"])));

            $prod_count = $this->product_count->find("first", array("conditions" => array("product_count.species" => $warehouse["species"],
                "product_count.product_name" => $warehouse["product_name"])));

            $wastr = $this->wastreles->find("first", array("conditions" => array("wastreles.id" => $warehouse["wastreles_out"])));

            if ($wastr["wastreles"]["quantity"] < $warehouse["quantity"]) {
                $this->Session->setFlash(__('Խոտանում չկա այդքան ապրանք ստուգեք Ձեր գրած թիվը'));
                $this->redirect(array("action" => "tools"));
            }
            $count1 = $wastr["wastreles"]["quantity"] - $warehouse["quantity"];

            if ($count1 == 0) {
                $b = $this->wastreles->delete($warehouse["wastreles_out"]);
            }
            $b = $this->wastreles->updateAll(array('wastreles.quantity' => "'$count1'"), array('wastreles.id' => $warehouse["wastreles_out"]));
            if ($prod_count) {
                $change = $prod_count["product_count"]["count"] + $warehouse["quantity"];
                $id = $prod_count["product_count"]["id"];
                $this->product_count->updateAll(array('product_count.count' => "'$change'"), array('product_count.id' => $id));
            } else {
                $change["count"] = $warehouse["quantity"];
                $change["species"] = $warehouse["species"];
                $change["product_name"] = $warehouse["product_name"];
                $this->product_count->save($change);
            }
            if ($product) {
                $product["species"] = $warehouse["species"];
                $product["quantity"] = $warehouse["quantity"];
                $product["product_id"] = $product["Product_name"]["id"];
                $product["provider_id"] = 100;
                $a = $this->warehouse->add_tool($product);

                if ($a) {
                    $this->Session->setFlash(__('Ձեր գրած ապրանքը պահպանված է պահեստում!'));
                }

            }
            header('Location: http://newop.realtime.am/manegements/warehouse');
            exit;
        };

        if (isset($this->request->data["tools"]["username"])) {
            $insert = array();
            $data = array();
            $logs = array();
            $warehouse = $this->request->data["tools"];

            $prod_name = $this->Product_name->find("first", array("conditions" => array(
                "Product_name.product_name" => $warehouse["product_name"])));

//          $product = $this->warehouse->find("first", array("conditions" => array(
//                    "warehouse.product_id" => $prod_name["product_name"]["product_id"],
//                    "warehouse.species" => $warehouse["species"])));
            $prod_count = $this->product_count->find("first", array("conditions" => array(
                "product_count.product_name" => $warehouse["product_name"],
                "product_count.species" => $warehouse["species"])));

            $product_log = $this->written_item->find("first", array("conditions" => array(
                "written_item.username" => $warehouse["username"],
                "written_item.product_id" => $prod_name["Product_name"]["id"],
                "written_item.species" => $warehouse["species"]))); //haselem @nde vor pti mutq anem baza popoxutyunner@ hashvem amen mardu ogtagorcc@ amsva mej ,,,hima srch em anum vor stugem ete mard ka tenc u uni tenc apran gumavi voch te sarqvi noric

            if ($warehouse["username"]) {
                if ($prod_count["product_count"]["count"] >= $warehouse["quantity"]) {
                    if ($product_log) {
                        $data["data"] = $warehouse["username"] . " ին " . "պահեստից տրվել է " . $warehouse["quantity"] . "" . " քանակի" . $warehouse["species"] . "" . " տեսակի" . $warehouse["product_name"];
                        $data["username"] = $warehouse["username"];
                        $data["quantity"] = $warehouse["quantity"];
                        $data["species"] = $warehouse["species"];
                        $data["auth_user"] = $this->Auth->user()["username"];

                        $data["product_name"] = $warehouse["product_name"];

                        $this->written_log->add_logs($data);

                        $insert["quantity"] = $prod_count["product_count"]["count"] - $warehouse["quantity"];
                        $this->product_count->updateAll(array('product_count.count' => $insert["quantity"]), array('product_count.id' => $prod_count["product_count"]["id"]));
                        $quentity = $product_log["written_item"]["quantity"] + $warehouse["quantity"];
                        $this->written_item->updateAll(array('written_item.quantity' => $quentity), array('written_item.id' => $product_log["written_item"]["id"]));

                        $this->Session->setFlash(__('ապրանքը տրվել է տվյալ աշխատողին'));
                        header('Location: http://newop.realtime.am/manegements/warehouse');
                        exit;
                    } else {

                        $data["data"] = $warehouse["username"] . " ին " . "պահեստից տրվել է " . $warehouse["quantity"] . "" . " քանակի " . $warehouse["species"] . "" . " տեսակի " . $warehouse["product_name"];
                        $data["username"] = $warehouse["username"];
                        $data["quantity"] = $warehouse["quantity"];
                        $data["species"] = $warehouse["species"];
                        $data["auth_user"] = $this->Auth->user()["username"];
                        $data["product_name"] = $warehouse["product_name"];
                        $a = $this->written_log->add_logs($data);

                        $insert["quantity"] = $prod_count["product_count"]["count"] - $warehouse["quantity"];
                        $this->product_count->updateAll(array('product_count.count' => $insert["quantity"]), array('product_count.id' => $prod_count["product_count"]["id"]));
                        $logs["username"] = $warehouse["username"];
                        $logs["logs_id"] = $a;
                        $logs["quantity"] = $warehouse["quantity"];
                        $logs["species"] = $warehouse["species"];
                        $logs["product_id"] = $prod_name["Product_name"]["id"];
                        $a = $this->written_item->add_logs($logs);
                        $this->Session->setFlash(__('ապրանքի փոփոխությունը կատարված է'));
                        header('Location: http://newop.realtime.am/manegements/warehouse');
                        exit;

                    }
                } else {
                    $this->Session->setFlash(__('Ձեր պահեստում չկա այդքան քանակի ապրանք խնդրում ենք ստուգել պահեստը'));

                }
            } else {
                $this->Session->setFlash(__('Նշեք օգտատիրոջ մուտքանունը'));

            }
        }
    }

    public function tools()
    {

        $category = $this->role->find("all", array('order' => 'role.order'));
        $this->set("role", $category);


        if (isset($_POST["team"])) {
            $team = $this->Team->find("all", array("conditions" => array("Team.role" => "աշխ. ղեկավար"), "fields" => array("Team.username", "Team.firstname", "Team.lastname")));

            echo json_encode($team);
            die();
        }


        $a = $this->Service_name->find("all");
        $this->set("inet", $a);


        $prov = $this->provider->find("all", array("fields" => array("provider_name")));

        $this->set("prov", $prov);
        $prod_cat = $this->product_category->find("all");
    }

    public function bookkeeper()
    {

    }

    public function product_name()
    {
        $menu_product = array();
        $menu_product["prod_name"] = $this->Product_name->find("all");
        $menu_product["prod_count"] = $this->product_count->find("all");
        echo json_encode($menu_product);
        die();
    }

    public function bookkeepers()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $data_person = $this->Person->find('first', array(
                "conditions" => array("Person.id" => $id)));
            $this->set("client", $data_person);
            if (isset($this->request->data["fees"]) && $this->request->is("post")) {
                $data = $this->request->data["fees"];
                $insert_tra = array();

                $service = $this->Service->find("first", array(
                    "conditions" => array("Service.service_id" => $id)));
                $service_name = $this->Service_name->find("first", array(
                    "conditions" => array("Service_name.id" => $service["Service"]["service_name_id"])));
                $date = $this->Transaction->find();
                $lastCreated = $this->Transaction->find('first', array(
                    'order' => array('Transaction.created' => 'desc')
                ));

                date_default_timezone_set('Etc/GMT-4');
                $last_date = date("Y-m-d", strtotime($lastCreated["Transaction"]["created"] . '+1 month'));
                $date = date("Y-m-d");
                $ping = $this->Technical_data->find("first", array('conditions' => array("Technical_data.data_id" => $id)));
                $insert_log["data"] = $data_person["Person"]["firstname"] . "" . "duq vcharel eq ays or@" . " " . time() . ", " . $data["money"] . " dram";
                $id_tr = $this->Transaction_log->addPost($insert_log);
                $insert_transaction["client_id"] = $id;
                $insert_transaction["logs_id"] = $id_tr;
                $person_id = $id;
                $insert_transaction["service_id"] = $service_name["Service_name"]["id"];


                if ($last_date <= $date) {
                    if ($data["money"] >= $service_name["Service_name"]["price"]) {
                        $balance = $data["money"] - $service_name["Service_name"]["price"] + $data_person["Person"]["balance"];
                        $insert_transaction["balance_type"] = "ADD";
                        $insert_transaction["balance_change"] = $data["money"];
                        $balance = array('id' => $person_id, 'balance' => $balance);
                        $this->Person->save($balance);
                        if ($balance >= 0) {

                            $enable = "ssh control@" . $ping["Technical_data"]["modem"] . " -p 22000 -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no /ip firewall address-list remove numbers=[find address=" . $ping["Technical_data"]["ip_range"] . "]";
                            exec($enable, $a);
                            $this->Session->setFlash('bajanordi internet@ miacvac e');
                        } else {
                            var_dump($balance);
                            die();
                        }
                    }
                    if ($data["money"] < $service_name["Service_name"]["price"]) {
                        $balance = $data["money"] - $service_name["Service_name"]["price"] + $data_person["Person"]["balance"];
                        $insert_transaction["balance_type"] = "DEBT";
                        $insert_transaction["balance_change"] = $data["money"];
                        $balance = array('id' => $person_id, 'balance' => $balance);
                        $this->Person->save($balance);
                        if ($balance < 0) {
                            $disable = "ssh control@" . $ping["Technical_data"]["modem"] . " -p 22000 -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no /ip firewall address-list add list=disabled address=" . $ping["Technical_data"]["ip_range"] . "";
                            exec($disable, $c);
                            $this->Session->setFlash('bajanordi internet@ anjatvac e');
                        } else {
                            $enable = "ssh control@" . $ping["Technical_data"]["modem"] . " -p 22000 -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no /ip firewall address-list remove numbers=[find address=" . $ping["Technical_data"]["ip_range"] . "]";
                            exec($enable, $a);
                            var_dump("bajanordi internet@");
                            $this->Session->setFlash('bajanordi internet@ miacvac e');
                        }
                    }
                } else {
                    $balance = $data["money"] + $data_person["Person"]["balance"];
                    $insert_transaction["balance_type"] = "ADD";
                    $insert_transaction["balance_change"] = $data["money"];
                    $balance = array('id' => $person_id, 'balance' => $balance);
                    $this->Person->save($balance);
                    if ($balance >= 0) {
                        $enable = "ssh control@" . $ping["Technical_data"]["modem"] . " -p 22000 -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no /ip firewall address-list remove numbers=[find address=" . $ping["Technical_data"]["ip_range"] . "]";
                        exec($enable, $a);
                        $this->Session->setFlash('bajanordi internet@ miacvac e ');
                    }
                }


                $data = $this->Transaction->addPost($insert_transaction);
                if ($data)
                    return $this->redirect(array('controller' => 'Realtimes', 'action' => 'search'));
            }
        }
    }

}
