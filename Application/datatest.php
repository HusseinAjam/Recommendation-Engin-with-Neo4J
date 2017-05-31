<?php
require_once 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;

$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:123456789ha@localhost:7474') 
     ->build();


$Type = "Woman";
$SearchFor = "Fashion";

        $result = $client->run("MATCH (n:Shoes), (b:Type {typeIs : '".$Type."'})
                                MATCH (n)-[r:has_type]->(b) RETURN ID(n);");

         foreach($result -> getRecords() as $record)
        {
            echo $record->value('ID(n)')."";
        }


$finalArr1 = array();
$str = "Hello*world. It's a beautiful day.";
$finalArr1 = explode("*",$str);

echo $finalArr1[1];

?>


