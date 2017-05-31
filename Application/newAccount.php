 <?php
session_start();
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:123456789ha@localhost:7474') 
    ->build();

 $name  = $_POST["username"];
 $pass  = $_POST["password"];
 $age   = $_POST["age"];
 $card  = $_POST["card"];
 $gender= $_POST["gender"];

 $result = $client->run("Create (a: User {Name : '".$name."', Age : '".$age."', Password :                              '".$pass."', Gender : '".$gender."', Card : '".$card."'});");

	header( 'Location: login.php' );
?>