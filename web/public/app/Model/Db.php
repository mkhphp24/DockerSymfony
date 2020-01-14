<?php

namespace App\Model;


class Db
{
    protected $pdo;
    protected $employee_tabel;
    protected $event_detail_tabel;
    protected $event_name_tabel;
    protected $participation_tabel;

    protected $stmt;
    protected $bind = [];
    protected $fetchType = 'fetchAll';
    protected $fetchMode = \PDO::FETCH_OBJ;

    public function __construct()
    {
        $config = require __DIR__ . '/../config.php';
        try {
            $this->pdo = new \PDO("mysql:host={$config['db']['host']};dbname={$config['db']['database']}",$config['db']['username'] , $config['db']['password']);
            $this->pdo->prepare("ALTER TABLE event_detail AUTO_INCREMENT=1")->execute();
            $this->pdo->prepare("ALTER TABLE employee AUTO_INCREMENT=1")->execute();
            $this->pdo->prepare("ALTER TABLE event_name AUTO_INCREMENT=1")->execute();
            $this->pdo->prepare("ALTER TABLE participation AUTO_INCREMENT=1")->execute();

            $this->employee_tabel=$config['db']['employee_tabel'];
            $this->event_detail_tabel=$config['db']['event_detail_tabel'];
            $this->event_name_tabel=$config['db']['event_name_tabel'];
            $this->participation_tabel=$config['db']['participation_tabel'];


        } catch (\Exception $e) {
            die('Error : ' . $e->getMessage());
        }
    }


    /**
     * @return array
     */
    public function bindDtat(){
        $sql="SELECT p.id, m.employee_name, m.employee_mail,en.id,en.event_name,e.participation_fee,e.version ,e.event_date 
        FROM ".$this->participation_tabel." p 
        INNER JOIN ".$this->employee_tabel." m ON p.employee_id = m.id 
        INNER JOIN ".$this->event_detail_tabel." e ON p.event_id=e.id 
        INNER JOIN ".$this->event_name_tabel." en ON e.event_id=en.id order BY p.id  ";
      //  var_dump($sql);
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
		$result =  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $result;
    }

    /**
     * @param $searchData
     * @return array
     */
    public function bindDtatSearch($searchData){
        //var_dump($searchData);
        $where="";
        if($searchData['em_name']!="") $where.=" AND m.employee_name like '".$searchData['em_name']."%' ";
        if($searchData['ev_name']!="") $where.=" AND en.event_name like '".$searchData['ev_name']."%' ";
        if($searchData['ev_date']!="") $where.=" AND e.event_date like '".$searchData['ev_date']."%' ";


        $sql="SELECT p.id, m.employee_name, m.employee_mail,en.id,en.event_name,e.participation_fee,e.version ,e.event_date 
        FROM ".$this->participation_tabel." p 
        INNER JOIN ".$this->employee_tabel." m ON p.employee_id = m.id 
        INNER JOIN ".$this->event_detail_tabel." e ON p.event_id=e.id 
        INNER JOIN ".$this->event_name_tabel." en ON e.event_id=en.id where 1 $where order BY p.id  ";
//
  //  var_dump($sql);
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $result =  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }


    //=====================================

    /**
     * @param $name
     * @param $email
     * @param $tabel
     * @return string
     */
    public function importEmployee($name,$email)
    {

        $sql="INSERT INTO ".$this->employee_tabel." (`employee_name`, `employee_mail`) VALUES ('$name','$email' )";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $emId=$this->pdo->lastInsertId();

        if($this->stmt->errorCode()==='23000') {
            $sql="SELECT id FROM ".$this->employee_tabel." WHERE `employee_mail`='$email' ";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $emId=$this->stmt->fetch()['id'];

        }

        return  $emId;
    }
    //=======================================

    /**
     * @param $name
     * @param $tabel
     * @return string
     */
    public function  importEventName($id,$name){

        $sql="INSERT INTO ".$this->event_name_tabel." (`id`,`event_name`) VALUES ('$id','$name')";
        //var_dump($sql);
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        return $this->pdo->lastInsertId();


    }
    //=======================================

    /**
     * @param $event_id
     * @param $participation_fee
     * @param $version
     * @param $event_date
     * @param $tabel
     * @return string
     */
    public function importEventDetail($event_id,$participation_fee,$version,$event_date)
    {


        $sql="INSERT INTO ".$this->event_detail_tabel."
        (`event_id` ,`participation_fee`, `version`, `event_date`) VALUES 
        ('$event_id','$participation_fee','$version','$event_date' )";
        //var_dump($sql);

        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        return $this->pdo->lastInsertId();
    }
    //=======================================

    /**
     * @param $event_id
     * @param $employee_id
     * @param $id
     * @param $tabel
     * @return string
     */
    public function importParticipation($event_id,$employee_id,$id)
    {


        $sql="INSERT INTO ".$this->participation_tabel."
        (`event_id`, `employee_id`, `id`) VALUES 
        ('$event_id','$employee_id','$id' )";
       // var_dump($sql);

        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        return $this->pdo->lastInsertId();
    }

    /**
     * @param $tabel
     */
    public function empity($tabel){
        $sql="TRUNCATE `$tabel` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }

    public function empityAll(){
        $this->empity($this->employee_tabel);
        $this->empity($this->event_name_tabel);
        $this->empity($this->event_detail_tabel);
        $this->empity($this->participation_tabel);
    }
}
