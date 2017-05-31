<?php
 session_start();
if (empty($_SESSION['passWord'])) 
   {
           header("Location: login.php");
   }
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:123456789ha@localhost:7474') 
    ->build();

$SearchFor = $_SESSION['userName'];
$ID = $_GET['x'];

    
     $result = $client->run("match (o: Others) where ID(o) = ".$_GET["x"]."  set o.Count1 = o.Count1 - 1 ;");
     // Take of one of the available products.

     $result2 = $client->run("Match (u: User {Name : '".$_SESSION['userName']."'}) Match (o:Others) where ID(o) =  ".$_GET["x"]."  create (u)-[r:purchase {Purchase_At : TIMESTAMP()}]->(o);");

   header("Location: purchaseList.php");

 ?>