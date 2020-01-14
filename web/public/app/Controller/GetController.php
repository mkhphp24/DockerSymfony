<?php


namespace App\Controller;
use App\Model\Db;
use Exception;
class GetController
{

    public function __construct()
    {

    }

    public  function returnData(){
        $db=new Db();
        $check=$db->bindDtat();

        if ($check) {
            return $check;
        }
        else   {throw new Exception("Cannot fetch data due to an error");}


    }
}
