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
   <?php
     echo '<table style="width:100%;">';
    echo '<tr>';
     echo '<th>';
     $pic =  "shoes/".$_GET["x"].".jpg";
        echo ' <img src='.$pic.' alt="Mountain View" ;" ></th>';
    
    
    $result = $client->run("Match (a:Shoes) where ID(a) = ".$_GET["x"]." Return a.colour, a.Size1, a.Size2, a.Size3, a.Count1, a.Count2, a.Count3, a.Lace, a.Leather, a.Price");

      foreach($result -> getRecords() as $record)
        {
            $Colour = $record->value('a.colour')."";
            $Size1  = $record->value('a.Size1')."";
            $Size2  = $record->value('a.Size2')."";
            $Size3  = $record->value('a.Size3')."";
            $Count1 = $record->value('a.Count1');
            $Count2 = $record->value('a.Count2');
            $Count3 = $record->value('a.Count3');            
            $Lace   = $record->value('a.Lace')."";  
            $Leather= $record->value('a.Leather')."";
            $Price= $record->value('a.Price')."";  
         }
    
    
    echo '<th>';
     echo '<h2><span>'.$_GET["y"].'</span></h2>';
  echo '<h3><span>Description: </span></h3>';
  echo '<p>Colour: '.$Colour.'</p>';
  echo '<p>Price : '.$Price.'</p>';
  echo '<p>Made from Leather: '.$Leather.'</p>';
  echo '<p>Has a Lace   : '.$Lace.'</p>';
  if($Count1 > 1 || $Count2 > 1 || $Count3 > 1)
  {
    echo '<p>Available In Stock: Yes</p></br>';
  echo '</th><th></br></br>';
      
// Purchasing shoe producs   
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (is_null($_POST["size"]))
    {
      ?>
        <script type="text/javascript">
        alert("Please Select Size");
        </script>
    <?php
    }
   else
    {
    $ChoosenSizeCounter = $_POST["size"];
     $result = $client->run("match (a: Shoes) where ID(a) = ".$_GET["x"]."  set a.".$ChoosenSizeCounter." = a.".$ChoosenSizeCounter."-1;");
        
    $result2 = $client->run("Match (u: User {Name : '".$_SESSION['userName']."'}) Match (s:Shoes) where ID(s) =  ".$_GET["x"]."  create (u)-[r:purchase {Purchase_At : TIMESTAMP()}]->(s);");

    // For Recomendation Purposes, adding 3 points to "interested" relationship (3 points for Purchase)
    $result3 = $client->run("Match (u: User {Name : '".$_SESSION['userName']."'}) Match (s:Shoes) where ID(s) =  ".$_GET["x"]."  
                             Merge (u)-[r:interested]->(s)
                             On create set r.rate = 3
                             On match set r.rate = r.rate + 3;");  
        

        
     ?>  
        <script type="text/javascript">
        alert("Thank you For choosing BestChoice \n We promise to send you your item as soon as possible");
        </script>
    <?php
        header("Refresh:0");
    }
 }

  echo  '<form action="" method="Post">' ; 
    echo '<p>Please Select a Size</p>';
  echo '<table style="height:60%" class = "purchase">'; 
  echo '<tr>';
  echo '<th>';
  echo '<input type="radio" name="size" value="Count1"> Size: '.$Size1.'';
      echo '<p>Available No </br></br> '.$Count1.'</p></th><th>';
  echo '<input type="radio" name="size" value="Count2"> Size: '.$Size2.'';
      echo '<p>Available No </br></br> '.$Count2.'</p></th></tr><tr><th>';
  echo '<input type="radio" name="size" value="Count3"> Size: '.$Size3.'';
      echo '<p>Available No </br></br> '.$Count3.'</th><th>';
?>
  <input id="myRadio" type="radio" onclick="myFunction()"> Size: 11<p>Not Available</br></br> 0</p></th></tr>
 <script>
    window.onload=function myFunction() {
        document.getElementById("myRadio").disabled = true;
    }
    </script>
<?php
      
  echo '</table></br>';
echo '<input type="submit" value="Buy" class="specbutt" style="vertical-align:middle" >';     
    
    echo '</th>';
   echo '</form>';
    echo '</th>';
      echo '</tr>'; 
    echo '<tr>'; 
      
  }
    else
  {
     echo '<p>Sorry Out of Stock</p></br>';
  }
    
  
// Recommendations , Last level , "You may Also Like"
    
    $IDsArray = array();
    $CatesArray = array();
    $Cates2Array = array();
    $PriceArray = array();
    
    
 // Recommend a polish products if the shoe made of leather, the recommended polish product has to be the same colour of the shoe.
    
    $result = $client->run(" Match(s: Shoes ) match (o:Others {Product : 'Polish'}) where ID(s) = ".$_GET["x"]." and  s.Leather = 'True' and s.colour = o.colour  Return ID(o), o.Price, o.colour;");

     $i = 0;

      foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(o)')."";
            $PriceArray[$i] = $record->value('o.Price')."";
            $CatesArray[$i] = "polish";
            $Cates2Array[$i] = $record->value('o.colour')."";
        $i++;
         }
    
     // Recommend a brush product if the shoe made of leather.
    
    $result = $client->run(" Match(s: Shoes ) match (o:Others {Product : 'Brush'}) where ID(s) = ".$_GET["x"]." and  s.Leather = 'True'  Return o.Price, ID(o);");

      foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(o)')."";
            $PriceArray[$i] = $record->value('o.Price')."";
            $CatesArray[$i] = "brush";
            $Cates2Array[$i] = "Premium";
         $i++;
         }
    
         // Recommend a WaterProof Spray product if the shoe made of canvas or anything but leather.
    
    $result = $client->run("Match(s: Shoes ) match (o:Others {Product : 'WaterProof'}) where ID(s) = ".$_GET["x"]." and  s.Leather = 'False'  Return ID(o), o.Price, o.colour;");
    
      foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(o)')."";
            $PriceArray[$i] = $record->value('o.Price')."";
            $CatesArray[$i] = "spray";
            $Cates2Array[$i] = "WaterProof";
        $i++;
         }
    
    // Recommend collection of different Laces styles if the shoe has lace originally.
    
    $result = $client->run("Match(s: Shoes ) match (o:Others {Product : 'Lace'}) where ID(s) = ".$_GET["x"]." and  s.Lace = 'True'  Return ID(o), o.Price, o.colour;");
    
      foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(o)')."";
            $PriceArray[$i] = $record->value('o.Price')."";
            $CatesArray[$i] = "lace";
            $Cates2Array[$i] = $record->value('o.colour')."";
        $i++;
         }
    
    
    $resultArray = onDTo2D($IDsArray, 4);
    $resultArray2 = onDTo2D($CatesArray, 4);
    $resultArray4 = onDTo2D($Cates2Array, 4);
    $resultArray3 = onDTo2D($PriceArray, 4);
    
 echo '<table style="width:100%">';
 echo '<h2><span>You may Also Like</span></h2>';
    $rows = count($resultArray);
     for ($row = 0; $row < $rows; $row++) {
      echo '<tr>';
     $cols = count($resultArray[$row]);
     for($column = 0; $column < $cols; $column++ ) {
         

        $pic = "shoes/".$resultArray[$row][$column]."";
        $cat = $resultArray2[$row][$column];
        $cat2 = $resultArray4[$row][$column];
        $price = $resultArray3[$row][$column];
         $path  = 'purchaseOtherProducts.php?x='.$resultArray[$row][$column];
          
        echo 
       '<th> 
       <h2><span>'.$cat2." ".$cat.', '.$price.' £'.'</span></h2>
       <img src="'.$pic.'" alt="Mountain View" style="width:100%;height:100%;" > 
       <a class="specbutt" style="vertical-align:middle" href="'.$path.'">
       <span>Buy</span></a>
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
    
// For Reccommendation purposes
    
     // Connect this user with the colour of the viewd or the purchased shoe
    $result = $client->run("Match (s: FavouriteColour {colourIs : '".$Colour."'})
                            Match (u: User {Name : '".$_SESSION['userName']."'})
                            Merge (u)-[r:favourit_colour]->(s)
                            On match set r.counter = r.counter + 1
                            On Create set r.counter = 1;");
    
    //Set [View] relationship between the user and the product or increase the counter if viewed before
        $result2 = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (s:Shoes) where ID(s) = ".$_GET["x"]."
                                Merge (u)-[r:view]->(s)
                                On create set r.counter = 1, r.lastUpdateTime = TIMESTAMP()
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP();");
    
    //Adding 1 points to "interested" relationship (1 points for each view)
    $result3 = $client->run("Match (u: User {Name : '".$_SESSION['userName']."'}) Match (s:Shoes) where ID(s) =  ".$_GET["x"]."  
                             Merge (u)-[r:interested]->(s)
                             On create set r.rate = 1
                             On match set r.rate = r.rate + 1;");  

    ?>

    
</main>
</body>
</html>