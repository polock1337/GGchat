<?php

use PDO;

class Dbh
{

    public function __construct()
    {
        
    }
    public function getDbh()
    {
        $dsn = 'pgsql:dbname=ggchat;host=127.0.0.1';
        $user = 'postgres';
        $password = 'pol5050';
        $dbh = new PDO($dsn, $user, $password);
        $conn = pg_pconnect("host=127.0.0.1 port=5432 dbname=ggchat user=postgres password=pol5050");
            return $dbh;
    }

}


class UpdateListeSalonRedis{
    
    
    $DbhObject = new Dbh();
    
    $dbh = $DbhObject->getDbh();
    
    $MESSAGE_SQL_SALON = "SELECT * FROM public.groupe;";
    
    $requeteSalon = $dbh->prepare($MESSAGE_SQL_SALON);
    $requeteSalon->execute();
    $listeSalon = $requeteSalon->fetchAll();
    
    return $listeSalon;
}
    

    $listeSalon = UpdateListeSalonRedis();


    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    $redis->set'listeSalons',$listeSalon, 60);

?>