<?php
namespace GGChat\includes;

use PDO;

class Dbh
{

    public function __construct()
    {
        
    }
    public function getDbh()
    {
        $dsn = 'pgsql:dbname=GGchat;host=127.0.0.1';
        $user = 'postgres';
        $password = 'Polock1234';
        $dbh = new PDO($dsn, $user, $password);
        $conn = pg_pconnect("host=127.0.0.1 port=5432 dbname=GGchat user=postgres password=Polock1234");
            return $dbh;
    }

}
