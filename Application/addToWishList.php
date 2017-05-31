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

     
      $result = $client->run("Match (u: User {Name : '".$SearchFor."'}) Match (s:Shoes) match (u)-[r:wish]->(s) where ID(s) = ".$ID." return u.Name ;");
 
    $temp = null;
      foreach($result -> getRecords() as $record)
        {
        $temp = $record->value('u.Name')."";
       }

            
            if(is_null ($temp))
            {
             $result2 = $client->run("Match (u: User {Name : '".$SearchFor."'})Match (s:Shoes) where ID(s) = ".$ID." Create (u)-[r:wish {Added_at: TIMESTAMP()}]->(s);");
                
           // For Recomendation Purposes, adding 2 points to "interested" relationship (2 points for Wish)
            $result3 = $client->run("Match (u: User {Name : '".$SearchFor."'}) Match (s:Shoes) where ID(s) =  ".$ID."  
                                     Merge (u)-[r:interested]->(s)
                                     On create set r.rate = 2
                                     On match set r.rate = r.rate + 2;");  
                
             }
         header("Location: WishList.php");

 ?>