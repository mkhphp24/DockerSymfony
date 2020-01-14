<?php


namespace App\Controller;

use App\Model\Db;
use Exception;

class SearchController
{

    public  function returnData($dataSearch){
        $db=new Db();
        $check=$db->bindDtatSearch($dataSearch);

        if ($check) {
            return $check;
        }
        else   {throw new Exception("Cannot fetch data due to an error");}

    }
}
