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
