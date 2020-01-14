<?php


namespace App\Controller;
use App\Model\Db;
use Exception;

class ImportController
{
    private $jsonData;

    public function __construct($jsonData)
    {
        $this->jsonData=$jsonData;
    }

    public  function ImpoertData(){
        $db=new Db();
        $db->empityAll();


        foreach($this->jsonData as $data){

            $employeeId=$db->importEmployee($data['employee_name'],$data['employee_mail']);
            $event_nameId=$db->importEventName($data['event_id'],$data['event_name']);
            $event_detailId=$db->importEventDetail($data['event_id'],$data['participation_fee'],$data['version'],$data['event_date']);
            $participationId=$db->importParticipation($event_detailId,$employeeId,$data['participation_id']);
        }


    }
}
