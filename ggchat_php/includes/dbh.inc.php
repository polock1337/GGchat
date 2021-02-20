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
        $dsn = 'pgsql:dbname=ggchat;host=localhost';
        $user = 'postgres';
        $password = 'Polock1234';
        $dbh = new PDO($dsn, $user, $password);
        $conn = pg_pconnect("host=localhost port=5432 dbname=ggchat user=postgres password=Polock1234");
        return $dbh;
    }

}
