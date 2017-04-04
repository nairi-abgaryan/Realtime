<?php

App::uses('AppController', 'Controller');

class ToolsController extends AppController
{
    public $helpers = array('Html', 'Form', 'Session');

    public $uses = array(
        "Team", "warehouse", "written_item", "role",
        "calendar", "Station", "Server", "Product_name", "product_count",
        "User", "Realtime", "Client", "Person", "Transaction_log",
        "Estate_user", "Estate_user", "Gps", "Adress", "Service",
        "Technical_data", "Telefon", "Legal_person", "written_log", "url", "Cron",
        "Problem", "permission", "Service_name", 'Problem', 'wastreles', "page", "user_role",
        "User_permission", "Village", "Street", "Transaction", "provider", "black_list",
        "product_category", "user_role,user_perm", "pay_center"
    );

    public function index()
    {

    }

    /**
     * List Problem order by fields
     */
    public function listProblems($created, $updated, $worker)
    {
        if ($worker == '0'):
            $worker = "";
        else:
            $worker = "AND Problem.pro_person = '$worker' ";
        endif;

        $obj = $this->Problem->find("all", array(
            "joins" => array(
                array(
                    "table" => "technical_data",
                    "alias" => "tech",
                    "type" => "Right",
                    "conditions" => array(
                        "tech.id = Problem.user_id"
                    ),
                ),
            ),
            "conditions" => array(
                "Problem.created >= '$created' AND Problem.modified <= '$updated 23:59:59.999' $worker"
            ),
            "fields" => array(
                "tech.username",
                "tech.data_id",
                "Problem.id",
                "Problem.pro_person",
                "Problem.created",
                "Problem.modified"
            ),
            'order' => array('Problem.created DESC'),
            "limit" => 1000
        ));
        $this->set("problems", $obj);
    }

    /**
     * List Connection order by fields
     */
    public function listConnection($created, $updated, $worker)
    {
        if ($worker == '0'):
            $worker = "";
        else:
            $worker = "AND Person.con_person = '$worker' ";
        endif;

        $obj = $this->Person->find("all", array(
            "joins" => array(
                array(
                    "table" => "technical_data",
                    "alias" => "tech",
                    "type" => "Right",
                    "conditions" => array(
                        "tech.data_id = Person.id"
                    ),
                ),
            ),
            "conditions" => array(
                "Person.created >= '$created' AND Person.modified <= '$updated 23:59:59.999' $worker"
            ),
            "fields" => array(
                "tech.username",
                "tech.data_id",
                "Person.id",
                "Person.con_person",
                "Person.created",
                "Person.modified"
            ),
            'order' => array('Person.created DESC'),
            "limit" => 1000
        ));
        $this->set("obj", $obj);
    }
}
