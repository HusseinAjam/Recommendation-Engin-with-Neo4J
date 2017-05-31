<!DOCTYPE html>
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
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type  ="text/css" href="myStyle.css"/>

<style>

</style>

<body>
<ul class = "TopMenu">
  <li><a class ="BestChoice">BestChoice</a></li>
    <?php
    
     if (!empty($_SESSION['userName']))
     {
         $x = 'Hi '.$_SESSION['userName'];
       echo '<li><a class ="BestChoice">'.$x.'</a></li>';  
       echo '<li><a class ="BestChoice" href = "distroy.php">Log off</a></li>';  
     }
    
    ?>
  <li><a href="contact.html" class ="normalList" >Contact Us</a></li>
  <li><a href="WishList.php" class ="normalList">Wish List</a></li>
  <li><a href="purchaseList.php" class ="normalList">Purchase List</a></li>
  <li><a href="profile.php" class ="normalList">My Profile</a></li>
  <li><a href="index.php" class ="normalList">Home</a></li>
</ul>
    <main>
        </br></br>
    <h2><span>Your Purchse List</span></h2>
         <?php
     $IDsArray = array();
      $PriceArray = array();
     //$Dates = array();
     $UserName = $_SESSION['userName'];
    
    // Find all purchased shoes.
        $result = $client->run("Match (u: User {Name : '".$UserName."'}) Match (s:Shoes) match (u)-[r:purchase]->(s) return s.Price, ID(s), r.Purchase_At;");
         $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(s)')."";
            $PriceArray[$i] = $record->value('s.Price')."";
          //  echo  $record->value('r.Purchase_At').""; 
            $i++;
         }
    
        // Find all purchased Other Products EX: Lace, polish, ....
        $result = $client->run("Match (u: User {Name : '".$UserName."'}) Match (o:Others) match (u)-[r:purchase]->(o) return o.Price, ID(o), r.Purchase_At;");
        
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(o)')."";
            $PriceArray[$i] = $record->value('o.Price')."";
             $i++;
         }
    
        
        
     $resultArray = onDTo2D($IDsArray, 4);
     $resultArray3 = onDTo2D($PriceArray, 4);
    // $resultArray4 = onDTo2D($Dates, 4);
    echo '<table style="width:100%">';

    $rows = count($resultArray);
     for ($row = 0; $row < $rows; $row++) {
      echo '<tr>';
     $cols = count($resultArray[$row]);
     for($column = 0; $column < $cols; $column++ ) {
    
        $pic = "shoes/".$resultArray[$row][$column]."";
        $price = $resultArray3[$row][$column];
         //$dateing = new DateTime('@'.$resultArray4[$row][$column]);  
       //  echo $resultArray4[$row][$column];
         
         //$tempo = '@'.'1482189240165';
        // $dateing = new DateTime($tempo);
         
        echo 
       '<th> 
       <h2><span>Purchased For : '.$price.' £'.'</span></h2>
        <img src="'.$pic.'" alt="Mountain View" style="width:100%;height:100%;" > 
          </th>';
           
       }
      echo '</tr>';
      }
    echo '</table>';
    
    
    
    function onDTo2D ($array, $col_count=2){
    
	$result = false;
	if(!empty($array) && is_array($array)){
		$row_count = ceil( count($array) / $col_count);
		$pointer = 0;
		for($row=0; $row < $row_count; $row++) {
			for($col=0; $col < $col_count; ++$col){
				if(isset($array[$pointer])) {
					$result[$row][$col] = $array[$pointer];
					$pointer++;
				}
			}
		}
	}
	return $result;
}
    
    ?>
        
    </main>
    </body>
</html>

