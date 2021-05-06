<?php   

class Database {
    private $host = "localhost";

    // private $user = "igslonli_sysdev";
    // private $password = "b1yaya@habaG";
    // private $dbName = "igslonli_samsys_db";

    //---- local ----
    private $user = "root";
    private $password = "";
    private $dbName = "suppliesmngt_db";


    protected function dbconnect(){
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
    
}