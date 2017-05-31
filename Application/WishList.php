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
    <h2><span>Your Wish List</span></h2>
         <?php
     $IDsArray = array();
      $PriceArray = array();
     $UserName = $_SESSION['userName'];
        $result = $client->run("Match (u: User {Name : '".$UserName."'}) Match (s:Shoes) match (u)-[r:wish]->(s) return s.Price, ID(s);");
         $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(s)')."";
            $PriceArray[$i] = $record->value('s.Price')."";

            $i++;
         }
    
    
        
        
     $resultArray = onDTo2D($IDsArray, 4);
     $resultArray3 = onDTo2D($PriceArray, 4);
    echo '<table style="width:100%">';

    $rows = count($resultArray);
     for ($row = 0; $row < $rows; $row++) {
      echo '<tr>';
     $cols = count($resultArray[$row]);
     for($column = 0; $column < $cols; $column++ ) {
    
        $pic = "shoes/".$resultArray[$row][$column]."";
        $price = $resultArray3[$row][$column];
        $path2  = 'removeFromWishList.php?id='.$resultArray[$row][$column];
         
        echo 
       '<th> 
       <h2><span>'.$price.' £'.'</span></h2>
       <img src="'.$pic.'" alt="Mountain View" style="width:100%;height:100%;" > 
        <a class="specbutt2" style="vertical-align:middle" href="'.$path2.'">
       <span>Remove Item From Wish List</span></a>
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

