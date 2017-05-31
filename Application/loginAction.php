 <?php
session_start();
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:123456789ha@localhost:7474') 
    ->build();

  $result = $client->run("Match (u : User)Where u.Name ='".$_POST["uname"]."' and u.Password = '".$_POST["pwd"]."' Return u.Name ;");

      foreach($result -> getRecords() as $record)
        {
             if(!is_null($record->value('u.Name')))
            {
                $_SESSION['userName'] = $_POST["uname"];
                $_SESSION['passWord'] = $_POST["pwd"];
                 header( 'Location: index.php' );
                exit;
            } 
         }
                header( 'Location:login.php' );

?>