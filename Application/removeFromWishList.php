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
$ID = $_GET['id'];

     
      $result = $client->run("Match (u: User {Name : '".$SearchFor."'}) Match (s:Shoes) match (u)-[r:wish]->(s) where ID(s) = ".$ID." delete r ;");
 
   header("Location: WishList.php");

 ?>