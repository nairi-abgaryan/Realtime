<?php

App::uses('AppController', 'Controller');

class OnlinesController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    public $uses = array(
        "warehouse", "warehouse", "written_item", "Comment", "Station", "Server",
        "User", "Realtime", "Team", "Client", "Person", "Transaction_log",
        "Estate_user", "Estate_user", "Gps", "Adress", "Service", "Payment",
        "Technical_data", "Telefon", "Legal_person", "online", "histori",
        "Problem", "Permission", "Service_name", 'Problem', 'Product_name',
        "User_permission", "Village", "Street", "Transaction", "sxal_username","Cron"
    );

    public function permission() {
        
        if (isset($_POST["user"])) {
            $user = $_POST["user"];
           
            $role = $this->User->find("first", array(
                "conditions" => array("User.username" => $user),
                "fields" => array("User.role")));
            if($role){
                $perm = $this->User_permission->find("first", array("conditions" => array("User_permission.role" => $role["User"]["role"])));
                if($perm){
                    echo json_encode($perm);
                }
                else{
                    echo 0;
                }
            }
            else{
                echo 0;
            }
           
            die();
        }
        die();
    }
    public function paybook(){
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
    }
    public function cron(){  
        
        $default_credit = (int)$this->Cron->find("first")["Cron"]["cron_credit"];
        $thisdate = date("Y-m-d");
      
        $dis_credit = date("Y-m-d", strtotime($thisdate . "- $default_credit day"));
        if($thisdate == date('Y-m-d', strtotime('first sunday', strtotime("".$thisdate." - 7 day")))){
            
                $query = "UPDATE payments as Payment SET Payment.payday = DATE_ADD(Payment.payday , INTERVAL 1 DAY),"
                        . "Payment.counter_credit = Payment.counter_credit+1 "
                        . "WHERE Payment.payday BETWEEN '$dis_credit' AND '$dis_credit 23:59:59.999' AND Payment.no_credit=0 "
                        . "AND Payment.credit=0 AND Payment.category=2 ";
                $this->Payment->query($query);
                $query_nocredit = "UPDATE payments as Payment  SET Payment.payday = DATE_ADD(Payment.payday , INTERVAL 1 DAY),"
                    . "Payment.counter_credit = Payment.counter_credit+1 "
                    . "WHERE Payment.payday BETWEEN '$thisdate' AND '$thisdate 23:59:59.999' AND Payment.no_credit=1 "
                    . "AND Payment.category=2 ";
                $this->Payment->query($query_nocredit);
                $query_credit = "UPDATE payments as Payment SET Payment.payday = DATE_ADD(Payment.payday , INTERVAL 1 DAY),"
                     . "Payment.counter_credit = Payment.counter_credit+1 "
                     . "WHERE Payment.payday BETWEEN '$thisdate' AND '$thisdate 23:59:59.999' AND Payment.no_credit=0 AND Payment.credit>0 "
                     . "AND Payment.category=2";
                $this->Payment->query($query_credit);
                die();
        }else{
        $fp = fopen('json/'.$thisdate.'counter.json', 'w');
        fwrite($fp,json_encode($default_credit));
        fclose($fp);
        $dis["credit_default"] = $this->Payment->find("all",array(
              "joins"=>array(
                                        array(
                                            "table" => "technical_data",
                                            "alias"=>"tech",
                                            "type" => "Left",
                                            "conditions" => array("tech.id = Payment.data_id"),
                                        ),
                                       
                                    ),
            "conditions"=>array(
                "Payment.payday BETWEEN '$dis_credit' AND '$dis_credit 23:59:59.999'",
                "Payment.no_credit"=>0,
                "Payment.credit"=>0,
                "Payment.category=2 "
                ."AND (Payment.pers_pay <> 0 OR `Payment`.`pers_pay` is null)"),
            "fields"=>array(
                "Payment.payday,tech.username",
                "Payment.data_id,Payment.category",
                "Payment.credit,Payment.credit_date",
                "Payment.counter_credit","Payment.created,Payment.pers_pay,Payment.status,Payment.payday_now,Payment.no_credit")));
      
      
        $dis["no_credit"] = $this->Payment->find("all",array(
                "joins"=>array(
                                array(
                                    "table" => "technical_data",
                                    "alias"=>"tech",
                                    "type" => "Left",
                                    "conditions" => array("tech.id = Payment.data_id"),
                                    ),
                                ),
                "conditions"=>array(
                "Payment.payday "
                ."BETWEEN '$thisdate' AND '$thisdate 23:59:59.999'",
                "Payment.no_credit"=>1,
                "Payment.category=2"),
                 "fields"=>array(
                "Payment.payday,tech.username",
                "Payment.data_id,Payment.category",
                "Payment.credit,Payment.credit_date",
                "Payment.counter_credit","Payment.created,Payment.pers_pay,Payment.status,Payment.payday_now,Payment.no_credit")));
       
        $dis["credit"] = $this->Payment->find("all",array(
                "joins"=>array(
                                        array(
                                            "table" => "technical_data",
                                            "alias"=>"tech",
                                            "type" => "Left",
                                            "conditions" => array("tech.id = Payment.data_id"),
                                        ),
                                       
                                    ),
                "conditions"=>array(
                "Payment.payday "
                ."BETWEEN '$thisdate' AND '$thisdate 23:59:59.999'",
                "Payment.credit>0",
                "Payment.no_credit"=>0,
                "Payment.category=2 ",
                "(Payment.pers_pay <> 0 OR `Payment`.`pers_pay` is null) "),
                "fields"=>array(
                "Payment.payday,tech.username",
                "Payment.data_id,Payment.category",
                "Payment.credit,Payment.credit_date",
                "Payment.counter_credit","Payment.created,Payment.pers_pay,Payment.status,Payment.payday_now,Payment.no_credit")));
     
       $disss["suspended"] = $this->Payment->find("all",array("conditions"=>array("Payment.category"=>1)));
     
       $query_suspended = "UPDATE payments as Payment SET "
               . "Payment.payday = DATE_ADD(Payment.payday , INTERVAL 1 DAY), "
               . "Payment.credit_date = DATE_ADD(Payment.credit_date, INTERVAL 1 DAY), "
               . "Payment.payday_now = DATE_ADD(Payment.payday_now, INTERVAL 1 DAY) "
               . "WHERE Payment.category=1";
      
        $this->Payment->query($query_suspended);
        $query = "UPDATE payments as Payment SET Payment.category=0,"
               . "Payment.counter_credit=Payment.counter_credit+$default_credit "
               . "WHERE Payment.payday BETWEEN '$dis_credit' AND '$dis_credit 23:59:59.999' AND Payment.no_credit=0 "
               . "AND Payment.credit=0 AND Payment.category=2 AND (Payment.pers_pay <> 0 OR `Payment`.`pers_pay` is null)";
        
        $this->Payment->query($query);
        $query_nocredit = "UPDATE payments as Payment SET Payment.category=0 "
               . "WHERE Payment.payday BETWEEN '$thisdate' AND '$thisdate 23:59:59.999' AND Payment.no_credit=1 "
               . "AND Payment.category=2";
        $this->Payment->query($query_nocredit);
//        $query_credit = "UPDATE payments as Payment SET Payment.category=0,"
//                . "Payment.counter_credit = Payment.counter_credit+Payment.credit+$default_credit,Payment.credit=0 "
//                . "WHERE Payment.payday BETWEEN '$dis_credit' AND '$dis_credit 23:59:59.999' AND Payment.no_credit=0 AND Payment.credit=0 AND Payment.counter_credit=0 "
//                . "AND Payment.category=2";
//        $this->Payment->query($query_credit);
        $query_credits = "UPDATE payments as Payment SET Payment.category=0,"
                . "Payment.counter_credit = Payment.counter_credit+Payment.credit,Payment.credit=0 "
                . "WHERE Payment.payday BETWEEN '$thisdate' AND '$thisdate 23:59:59.999' "
                . "AND Payment.no_credit=0 AND Payment.credit>0 AND Payment.counter_credit>0 "
                . "AND Payment.category=2 AND (Payment.pers_pay <> 0 OR `Payment`.`pers_pay` is null)";
        $this->Payment->query($query_credits);
        $fp = fopen("json/".$thisdate.".json", 'w');
        fwrite($fp,json_encode($dis));
        fclose($fp);
       
        $fp = fopen('json/suspended.json', 'w');
        fwrite($fp, json_encode($disss["suspended"]));
        fclose($fp);
        $fp = fopen('json/credit.json', 'w');
        fwrite($fp, json_encode($dis["credit"]));
        fclose($fp);
        $fp = fopen('json/no_credit.json', 'w');
        fwrite($fp, json_encode($dis["no_credit"]));
        fclose($fp);
        $fp = fopen('json/credit_default.json', 'w');
        fwrite($fp, json_encode($dis["credit_default"]));
        fclose($fp);
        die();
    }
    }
    public function kml(){
        $kml_client = $this->Gps->find("all");
        echo json_encode($kml_client);
        die();
    }
    public function index(){
        die();
    }
}
